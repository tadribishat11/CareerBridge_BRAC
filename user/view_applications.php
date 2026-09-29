<?php
session_start();
require '../DBconnect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all applications for this user with probability scores
$sql = "
SELECT 
    a.application_id,
    o.TITLE AS job_title,
    o.TYPE,
    c.company_name,
    a.status,
    a.applied_on,
    p.SKILL_MATCH_PERCENTAGE,
    p.EXPERIENCE_MATCH_PERCENTAGE,
    p.OVERALL_PROBABILITY_SCORE
FROM application a
JOIN opportunity o ON a.opportunity_id = o.OPPORTUNITY_ID
JOIN company c ON o.COMPANY_ID = c.company_id
LEFT JOIN probability_analysis p ON a.APPLICATION_ID = p.APPLICATION_ID
WHERE a.user_id = ?
ORDER BY a.applied_on DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Applications</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .applications-table { width:100%; border-collapse: collapse; margin-top:20px; }
        .applications-table th, .applications-table td { border:1px solid #ddd; padding:8px; text-align:center; }
        .applications-table th { background-color:#007bff; color:white; }
        .form-box { width: 95%; margin: 20px auto; padding: 20px; border:1px solid #ddd; border-radius:8px; background:#f9f9f9; }
        .status-PENDING { color: #ff9800; font-weight: bold; }
        .status-ACCEPTED { color: #28a745; font-weight: bold; }
        .status-REJECTED { color: #f44336; font-weight: bold; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
<div class="form-box">
    <h2>My Job Applications</h2>

    <?php if($result->num_rows === 0): ?>
        <p>You have not applied to any jobs yet.</p>
    <?php else: ?>
        <table class="applications-table">
            <tr>
                <th>Job Title</th>
                <th>Type</th>
                <th>Company</th>
                <th>Applied On</th>
                <th>Status</th>
                <th>Skill Match %</th>
                <th>Experience Match %</th>
                <th>Overall Probability %</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['job_title']) ?></td>
                <td><?= $row['TYPE'] ?></td>
                <td><?= htmlspecialchars($row['company_name']) ?></td>
                <td><?= $row['applied_on'] ?></td>
                <td class="status-<?= $row['status'] ?>"><?= $row['status'] ?></td>
                <td><?= $row['SKILL_MATCH_PERCENTAGE'] ?? 0 ?></td>
                <td><?= $row['EXPERIENCE_MATCH_PERCENTAGE'] ?? 0 ?></td>
                <td><?= $row['OVERALL_PROBABILITY_SCORE'] ?? 0 ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
