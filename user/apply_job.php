<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../DBconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    die("Invalid job request.");
}

$opportunity_id = (int)$_GET['id'];

/* Check duplicate */
$check = $conn->prepare(
    "SELECT APPLICATION_ID FROM application WHERE USER_ID=? AND OPPORTUNITY_ID=?"
);
$check->bind_param("ii", $user_id, $opportunity_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    $message = "You have already applied for this job.";
} 

else {

    /* Insert application */
    $stmt = $conn->prepare(
        "INSERT INTO application (USER_ID, OPPORTUNITY_ID, STATUS, APPLIED_ON)
         VALUES (?, ?, 'PENDING', CURDATE())"
    );
    $stmt->bind_param("ii", $user_id, $opportunity_id);

    if (!$stmt->execute()) {
        die("Application insert failed: " . $stmt->error);
    }

    $application_id = $conn->insert_id;

    /* Insert probability row */
    $stmt2 = $conn->prepare(
        "INSERT INTO probability_analysis (APPLICATION_ID)
         VALUES (?)"
    );
    $stmt2->bind_param("i", $application_id);

    if (!$stmt2->execute()) {
        die("Probability insert failed: " . $stmt2->error);
    }

    $message = "Application submitted successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Apply Job</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="form-box">
<h2>Job Application</h2>
<p><?= $message ?></p>
<a href="view_jobs.php">Back to Jobs</a>
</div>
</body>
</html>