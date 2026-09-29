<?php
session_start();
require '../DBconnect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

/*
 Create probability rows for applications
 that don't have one yet
*/

$sql = "
INSERT INTO probability_analysis
(APPLICATION_ID, SKILL_MATCH_PERCENTAGE, EXPERIENCE_MATCH_PERCENTAGE, OVERALL_PROBABILITY_SCORE)
SELECT a.APPLICATION_ID, 0, 0, 0
FROM application a
LEFT JOIN probability_analysis p 
    ON a.APPLICATION_ID = p.APPLICATION_ID
WHERE p.APPLICATION_ID IS NULL
";


if ($conn->query($sql)) {
    $created = $conn->affected_rows;
} else {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Probability Rows</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { font-family: Arial;  }
        .box {
            width: 500px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
        a { text-decoration:none; color:#007bff; }
    </style>
</head>
<body>

<div class="box">
    <h2>Probability Analysis Sync</h2>
    <p><?= $created ?> probability rows created.</p>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
