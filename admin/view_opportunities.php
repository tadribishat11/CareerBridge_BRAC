<?php
session_start();
require '../DBconnect.php';
if (!isset($_SESSION['admin_id'])) { header("Location: ../login.php"); exit(); }

$opportunity_result = $conn->query("
SELECT o.OPPORTUNITY_ID, o.TITLE, o.TYPE, o.LOCATION, o.SALARY, o.STIPEND, o.DEADLINE, o.DURATION, o.REQ_CGPA, o.EXPERIENCE, c.company_name
FROM opportunity o
JOIN company c ON o.COMPANY_ID = c.company_id
ORDER BY o.OPPORTUNITY_ID DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Opportunities</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { font-family: Arial; }
        .container { width:95%; max-width:1200px; margin:30px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:10px; text-align:center; }
        th { background:#007bff; color:white; }
        a.back-link { display:inline-block; margin-bottom:15px; color:#007bff; text-decoration:none; }
        a.button { padding:5px 10px; background:#007bff; color:#fff; border-radius:4px; text-decoration:none; margin:2px; }
        a.button:hover { background:#0056b3; }
        a.delete-button { background:#dc3545; }
        a.delete-button:hover { background:#a71d2a; }
    </style>
</head>
<body>
<div class="container">
    <h2>All Opportunities</h2>
    <a class="back-link" href="dashboard.php">Back to Dashboard</a>

    <?php if($opportunity_result->num_rows==0): ?>
        <p>No opportunities found.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>ID</th><th>Title</th><th>Type</th><th>Location</th><th>Salary</th><th>Stipend</th>
            <th>Deadline</th><th>Duration</th><th>Req CGPA</th><th>Experience</th><th>Company</th><th>Actions</th>
        </tr>
        <?php while($row=$opportunity_result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['OPPORTUNITY_ID'] ?></td>
            <td><?= htmlspecialchars($row['TITLE']) ?></td>
            <td><?= $row['TYPE'] ?></td>
            <td><?= htmlspecialchars($row['LOCATION']) ?></td>
            <td><?= $row['SALARY'] ?></td>
            <td><?= $row['STIPEND'] ?></td>
            <td><?= $row['DEADLINE'] ?></td>
            <td><?= htmlspecialchars($row['DURATION']) ?></td>
            <td><?= $row['REQ_CGPA'] ?></td>
            <td><?= $row['EXPERIENCE'] ?></td>
            <td><?= htmlspecialchars($row['company_name']) ?></td>
            <td>
                <a class="button" href="edit_opportunity.php?id=<?= $row['OPPORTUNITY_ID'] ?>">Edit</a>
                <a class="button delete-button" href="delete_opportunity.php?id=<?= $row['OPPORTUNITY_ID'] ?>" onclick="return confirm('Are you sure you want to delete this opportunity?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>
</div>
</body>
</html>
