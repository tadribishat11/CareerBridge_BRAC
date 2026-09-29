<?php
session_start();
require '../DBconnect.php';

if (!isset($_SESSION['company_id'])) {
    header("Location: ../login.php");
    exit();
}

$company_id = $_SESSION['company_id'];
$message = "";

// Handle form submission to update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    foreach ($_POST['status'] as $application_id => $status) {
        $stmt = $conn->prepare("UPDATE application SET status=? WHERE application_id=?");
        $stmt->bind_param("si", $status, $application_id);
        $stmt->execute();
    }
    $message = "Applicant statuses updated successfully!";
}

// Fetch all applicants
$sql = "
SELECT 
    a.application_id,
    u.name AS user_name,
    u.CGPA,
    u.skill,
    u.experience,
    o.TITLE AS job_title,
    a.status
FROM application a
JOIN user u ON a.user_id = u.ID
JOIN opportunity o ON a.opportunity_id = o.OPPORTUNITY_ID
WHERE o.COMPANY_ID = ?
ORDER BY o.OPPORTUNITY_ID DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Applicants</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .applicants-table { width:100%; border-collapse: collapse; }
        .applicants-table th, .applicants-table td { border:1px solid #ddd; padding:8px; }
        .applicants-table th { background-color:#007bff; color:white; }
        .form-box { width: 95%; margin: 20px auto; padding: 20px; border:1px solid #ddd; border-radius:8px; background:#f9f9f9; }
        button { padding:8px 15px; background:#28a745; color:white; border:none; border-radius:4px; cursor:pointer; }
        button:hover { background:#218838; }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Applicants for Your Jobs</h2>

    <?php if($message): ?>
        <p style="color:green; font-weight:bold;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if($result->num_rows === 0): ?>
        <p>No applicants found.</p>
    <?php else: ?>
    <form method="POST">
        <table class="applicants-table">
            <tr>
                <th>Name</th>
                <th>CGPA</th>
                <th>Skill</th>
                <th>Experience</th>
                <th>Job Applied</th>
                <th>Status</th>
                <th>Accept / Reject</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                    <td><?= $row['CGPA'] ?></td>
                    <td><?= htmlspecialchars($row['skill']) ?></td>
                    <td><?= $row['experience'] ?></td>
                    <td><?= htmlspecialchars($row['job_title']) ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <label>
                            <input type="radio" name="status[<?= $row['application_id'] ?>]" value="ACCEPTED" <?= $row['status'] === 'ACCEPTED' ? 'checked' : '' ?>>
                            Accept
                        </label>
                        <label>
                            <input type="radio" name="status[<?= $row['application_id'] ?>]" value="REJECTED" <?= $row['status'] === 'REJECTED' ? 'checked' : '' ?>>
                            Reject
                        </label>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <button type="submit">Update Status</button>
    </form>
    <?php endif; ?>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
