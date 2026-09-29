<?php
session_start();
require '../DBconnect.php';

if (!isset($_SESSION['company_id'])) {
    header("Location: ../login.php");
    exit();
}

$success = $error = "";
$company_id = $_SESSION['company_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $deadline = $_POST['deadline'] ?: NULL;
    $req_cgpa = $_POST['req_cgpa'] ?: NULL;
    $experience = $_POST['experience'] ?: 0;
    $location = $_POST['location'] ?: NULL;
    $duration = $_POST['duration'] ?: NULL;
    $stipend = $_POST['stipend'] ?: NULL;
    $salary = $_POST['salary'] ?: NULL;
    $type = $_POST['type'];

    $sql = "INSERT INTO opportunity 
        (TITLE, DEADLINE, REQ_CGPA, EXPERIENCE, LOCATION, DURATION, STIPEND, SALARY, TYPE, COMPANY_ID)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssdisddssi",
        $title,
        $deadline,
        $req_cgpa,
        $experience,
        $location,
        $duration,
        $stipend,
        $salary,
        $type,
        $company_id
    );

    if ($stmt->execute()) {
        $success = "Job opportunity posted successfully!";
    } else {
        $error = "Error posting job: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Post Job Opportunity</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="form-box">
    <h2>Post a New Opportunity</h2>

    <?php if(!empty($success)) echo "<p style='color:green'>$success</p>"; ?>
    <?php if(!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="title" placeholder="Job Title" required>
        <input type="date" name="deadline" placeholder="Deadline">
        <input type="number" step="0.01" name="req_cgpa" placeholder="Required CGPA">
        <input type="number" name="experience" placeholder="Experience (Years)" value="0">
        <input type="text" name="location" placeholder="Location">
        <input type="text" name="duration" placeholder="Duration">
        <input type="number" step="0.01" name="stipend" placeholder="Stipend">
        <input type="number" step="0.01" name="salary" placeholder="Salary">
        <select name="type" required>
            <option value="JOB">JOB</option>
            <option value="INTERNSHIP">INTERNSHIP</option>
        </select>
        <button type="submit">Post Opportunity</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
