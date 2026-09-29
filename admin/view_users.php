<?php
session_start();
require '../DBconnect.php';
if (!isset($_SESSION['admin_id'])) { header("Location: ../login.php"); exit(); }

$user_result = $conn->query("SELECT ID AS user_id, name, username, CGPA, skill, experience, department, status FROM user ORDER BY ID DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
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
    <h2>All Users</h2>
    <a class="back-link" href="dashboard.php">Back to Dashboard</a>

    <?php if($user_result->num_rows==0): ?>
        <p>No users found.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Username</th><th>CGPA</th><th>Skill</th><th>Experience</th><th>Department</th><th>Status</th><th>Actions</th>
        </tr>
        <?php while($row=$user_result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['user_id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= $row['CGPA'] ?></td>
            <td><?= htmlspecialchars($row['skill']) ?></td>
            <td><?= $row['experience'] ?></td>
            <td><?= htmlspecialchars($row['department']) ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a class="button" href="edit_user.php?id=<?= $row['user_id'] ?>">Edit</a>
                <a class="button delete-button" href="delete_user.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>
</div>
</body>
</html>
