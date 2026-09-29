<?php
session_start();
require '../DBconnect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_GET['id'] ?? 0;

// Fetch user data
$stmt = $conn->prepare("SELECT ID, name, username, CGPA, skill, experience, department, status FROM user WHERE ID=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $cgpa = $_POST['cgpa'];
    $skill = $_POST['skill'];
    $experience = $_POST['experience'];
    $department = $_POST['department'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE user SET name=?, username=?, CGPA=?, skill=?, experience=?, department=?, status=? WHERE ID=?");
    $stmt->bind_param("ssdsiisi", $name, $username, $cgpa, $skill, $experience, $department, $status, $user_id);
    $stmt->execute();

    header("Location: view_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="form-box">
    <h2>Edit User</h2>
    <form method="POST">
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        <input type="number" step="0.01" name="cgpa" value="<?= $user['CGPA'] ?>">
        <input type="text" name="skill" value="<?= htmlspecialchars($user['skill']) ?>">
        <input type="number" name="experience" value="<?= $user['experience'] ?>">
        <input type="text" name="department" value="<?= htmlspecialchars($user['department']) ?>">
        <select name="status">
            <option value="ONGOING" <?= $user['status']=='ONGOING'?'selected':'' ?>>ONGOING</option>
            <option value="GRADUATED" <?= $user['status']=='GRADUATED'?'selected':'' ?>>GRADUATED</option>
        </select>
        <button type="submit">Update User</button>
    </form>
    <a href="view_users.php">Back</a>
</div>
</body>
</html>
