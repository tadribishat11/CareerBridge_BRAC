<?php
session_start();
require '../DBconnect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$company_id = $_GET['id'] ?? 0;

// Fetch company
$stmt = $conn->prepare("SELECT company_name, username, location, industry FROM company WHERE company_id=?");
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
$company = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = $_POST['company_name'];
    $username = $_POST['username'];
    $location = $_POST['location'];
    $industry = $_POST['industry'];

    $stmt = $conn->prepare("UPDATE company SET company_name=?, username=?, location=?, industry=? WHERE company_id=?");
    $stmt->bind_param("ssssi", $company_name, $username, $location, $industry, $company_id);
    $stmt->execute();

    header("Location: view_companies.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Company</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="form-box">
    <h2>Edit Company</h2>
    <form method="POST">
        <input type="text" name="company_name" value="<?= htmlspecialchars($company['company_name']) ?>" required>
        <input type="text" name="username" value="<?= htmlspecialchars($company['username']) ?>" required>
        <input type="text" name="location" value="<?= htmlspecialchars($company['location']) ?>">
        <input type="text" name="industry" value="<?= htmlspecialchars($company['industry']) ?>">
        <button type="submit">Update Company</button>
    </form>
    <a href="view_companies.php">Back</a>
</div>
</body>
</html>
