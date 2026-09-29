<?php
session_start();
require '../DBconnect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$opportunity_id = $_GET['id'] ?? 0;

// Fetch opportunity data
$stmt = $conn->prepare("SELECT * FROM opportunity WHERE OPPORTUNITY_ID=?");
$stmt->bind_param("i", $opportunity_id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $stipend = $_POST['stipend'];
    $deadline = $_POST['deadline'];
    $duration = $_POST['duration'];
    $req_cgpa = $_POST['req_cgpa'];
    $experience = $_POST['experience'];

    $stmt = $conn->prepare("UPDATE opportunity SET TITLE=?, TYPE=?, LOCATION=?, SALARY=?, STIPEND=?, DEADLINE=?, DURATION=?, REQ_CGPA=?, EXPERIENCE=? WHERE OPPORTUNITY_ID=?");
    $stmt->bind_param("ssddiisddi", $title, $type, $location, $salary, $stipend, $deadline, $duration, $req_cgpa, $experience, $opportunity_id);
    $stmt->execute();

    header("Location: view_opportunities.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Opportunity</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="form-box">
    <h2>Edit Opportunity</h2>
    <form method="POST">
        <input type="text" name="title" value="<?= htmlspecialchars($job['TITLE']) ?>" required>
        <select name="type" required>
            <option value="JOB" <?= $job['TYPE']=='JOB'?'selected':'' ?>>JOB</option>
            <option value="INTERNSHIP" <?= $job['TYPE']=='INTERNSHIP'?'selected':'' ?>>INTERNSHIP</option>
        </select>
        <input type="text" name="location" value="<?= htmlspecialchars($job['LOCATION']) ?>">
        <input type="number" step="0.01" name="salary" value="<?= $job['SALARY'] ?>">
        <input type="number" step="0.01" name="stipend" value="<?= $job['STIPEND'] ?>">
        <input type="date" name="deadline" value="<?= $job['DEADLINE'] ?>">
        <input type="text" name="duration" value="<?= htmlspecialchars($job['DURATION']) ?>">
        <input type="number" step="0.01" name="req_cgpa" value="<?= $job['REQ_CGPA'] ?>">
        <input type="number" name="experience" value="<?= $job['EXPERIENCE'] ?>">
        <button type="submit">Update Opportunity</button>
    </form>
    <a href="view_opportunities.php">Back</a>
</div>
</body>
</html>
