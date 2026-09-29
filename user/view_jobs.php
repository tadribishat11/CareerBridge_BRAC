<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../DBconnect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Handle Apply button POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_job_id'])) {
    $opportunity_id = $_POST['apply_job_id'];

    // Check if user already applied
    $check = $conn->prepare("SELECT * FROM application WHERE user_id=? AND opportunity_id=?");
    $check->bind_param("ii", $user_id, $opportunity_id);
    $check->execute();
    $res_check = $check->get_result();

    if ($res_check->num_rows > 0) {
        $message = "You have already applied for this job.";
    } else {
        // Insert application
        $stmt = $conn->prepare("INSERT INTO application (user_id, opportunity_id, status) VALUES (?, ?, 'PENDING')");
        $stmt->bind_param("ii", $user_id, $opportunity_id);
        if ($stmt->execute()) {
            $message = "You have successfully applied for the job!";
        } else {
            $message = "Error applying for the job: " . $stmt->error;
        }
    }
}

// Fetch all jobs
$sql = "
SELECT 
    o.OPPORTUNITY_ID,
    o.TITLE,
    o.TYPE,
    o.LOCATION,
    o.SALARY,
    o.STIPEND,
    o.DEADLINE,
    o.DURATION,
    o.REQ_CGPA,
    o.EXPERIENCE,
    c.company_name
FROM opportunity o
JOIN company c ON o.COMPANY_ID = c.company_id
ORDER BY o.OPPORTUNITY_ID DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Jobs</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Add these styles */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        
        .job-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .job-card {
            background: white;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .job-card h3 {
            color: #007bff;
            margin-top: 0;
        }
        
        .job-card form button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Available Jobs</h2>

    <?php if($message): ?>
        <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="job-cards">
        <?php if($result->num_rows === 0): ?>
            <p>No jobs available.</p>
        <?php else: ?>
            <?php while($job = $result->fetch_assoc()): ?>
            <div class="job-card">
                <h3><?= htmlspecialchars($job['TITLE']) ?></h3>
                <p><strong>Company:</strong> <?= htmlspecialchars($job['company_name']) ?></p>
                <p><strong>Type:</strong> <?= $job['TYPE'] ?></p>
                <p><strong>Location:</strong> <?= $job['LOCATION'] ?? 'N/A' ?></p>
                <p><strong>Salary/Stipend:</strong> <?= $job['TYPE'] === 'JOB' ? '৳'.$job['SALARY'] : '৳'.$job['STIPEND'] ?></p>
                <p><strong>Deadline:</strong> <?= $job['DEADLINE'] ?? 'N/A' ?></p>
                <p><strong>Duration:</strong> <?= $job['DURATION'] ?? 'N/A' ?></p>
                <p><strong>Required CGPA:</strong> <?= $job['REQ_CGPA'] ?? 'N/A' ?></p>
                <p><strong>Experience:</strong> <?= $job['EXPERIENCE'] ?> years</p>

                <form method="POST" style="margin-top:10px;">
                    <input type="hidden" name="apply_job_id" value="<?= $job['OPPORTUNITY_ID'] ?>">
                    <button type="submit">Apply</button>
                </form>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
