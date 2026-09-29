<?php
session_start();
require '../DBconnect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $company_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM company WHERE company_id = ?");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
}

header("Location: view_companies.php");
exit();
