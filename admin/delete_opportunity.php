<?php
session_start();
require '../DBconnect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $opportunity_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM opportunity WHERE OPPORTUNITY_ID = ?");
    $stmt->bind_param("i", $opportunity_id);
    $stmt->execute();
}

header("Location: view_opportunities.php");
exit();
