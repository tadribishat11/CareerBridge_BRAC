<?php
session_start();
require '../DBconnect.php';

// Admin check
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$message = "";

// ================= HANDLE SAVE =================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $application_id = (int)$_POST['application_id'];
    $skill = (float)$_POST['skill_match'];
    $exp   = (float)$_POST['exp_match'];

    // overall probability
    $overall = ($skill * 0.6) + ($exp * 0.4);

    // check if record exists
    $check = $conn->prepare(
        "SELECT ANALYSIS_ID FROM probability_analysis WHERE APPLICATION_ID=?"
    );
    $check->bind_param("i", $application_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {

        // UPDATE
        $stmt = $conn->prepare(
            "UPDATE probability_analysis
             SET SKILL_MATCH_PERCENTAGE=?,
                 EXPERIENCE_MATCH_PERCENTAGE=?,
                 OVERALL_PROBABILITY_SCORE=?
             WHERE APPLICATION_ID=?"
        );
        $stmt->bind_param("dddi", $skill, $exp, $overall, $application_id);

    } else {

        // INSERT
        $stmt = $conn->prepare(
            "INSERT INTO probability_analysis
            (APPLICATION_ID, SKILL_MATCH_PERCENTAGE, EXPERIENCE_MATCH_PERCENTAGE, OVERALL_PROBABILITY_SCORE)
            VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iddd", $application_id, $skill, $exp, $overall);
    }

    if ($stmt->execute()) {
        $message = "Probability updated successfully!";
    } else {
        $message = "Database error: " . $stmt->error;
    }
}

// ================= FETCH APPLICATIONS =================
$sql = "
SELECT 
    a.APPLICATION_ID,
    u.name AS user_name,
    o.TITLE AS job_title,
    p.SKILL_MATCH_PERCENTAGE,
    p.EXPERIENCE_MATCH_PERCENTAGE,
    p.OVERALL_PROBABILITY_SCORE
FROM application a
JOIN user u ON a.USER_ID = u.ID
JOIN opportunity o ON a.OPPORTUNITY_ID = o.OPPORTUNITY_ID
LEFT JOIN probability_analysis p ON a.APPLICATION_ID = p.APPLICATION_ID
ORDER BY a.APPLICATION_ID DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Probability Score</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {font-family: Arial; }
        .container { width:95%; margin:30px auto; background:#fff; padding:20px; border-radius:8px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:10px; text-align:center; }
        th { background:#007bff; color:#fff; }
        input[type=number] { width:70px; padding:5px; }
        button { padding:6px 12px; background:#007bff; color:white; border:none; border-radius:4px; cursor:pointer; }
        button:hover { background:#0056b3; }
        .msg { text-align:center; font-weight:bold; color:green; margin-bottom:10px; }
        a { text-decoration:none; color:#007bff; }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin – Set Probability Scores</h2>
    <a href="dashboard.php">← Back to Dashboard</a>

    <?php if($message): ?>
        <p class="msg"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if($result->num_rows == 0): ?>
        <p>No applications found.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>Application ID</th>
            <th>User</th>
            <th>Job</th>
            <th>Skill %</th>
            <th>Experience %</th>
            <th>Overall %</th>
            <th>Action</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="POST">
                <td><?= $row['APPLICATION_ID'] ?></td>
                <td><?= htmlspecialchars($row['user_name']) ?></td>
                <td><?= htmlspecialchars($row['job_title']) ?></td>

                <td>
                    <input type="number" name="skill_match"
                        value="<?= $row['SKILL_MATCH_PERCENTAGE'] ?? 0 ?>"
                        min="0" max="100" required>
                </td>

                <td>
                    <input type="number" name="exp_match"
                        value="<?= $row['EXPERIENCE_MATCH_PERCENTAGE'] ?? 0 ?>"
                        min="0" max="100" required>
                </td>

                <td>
                    <?= $row['OVERALL_PROBABILITY_SCORE'] ?? '—' ?>
                </td>

                <td>
                    <input type="hidden" name="application_id"
                           value="<?= $row['APPLICATION_ID'] ?>">
                    <button type="submit">Save</button>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>
</div>

</body>
</html>
