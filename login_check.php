<?php
session_start();
require 'DBconnect.php';

$username = $_POST['username'];
$password = $_POST['password'];


// ---------- CHECK COMPANY ----------
$stmt = $conn->prepare("SELECT company_id, company_name, password FROM company WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

if ($company = $res->fetch_assoc()) {
    if (password_verify($password, $company['password'])) {

        $_SESSION['company_id']   = $company['company_id'];
        $_SESSION['company_name'] = $company['company_name'];

        header("Location: company/dashboard.php");
        exit();
    }
}


// ---------- CHECK USER ----------
$stmt = $conn->prepare("SELECT ID as user_id, name, password FROM user WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

if ($user = $res->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['user_id'];  
        $_SESSION['name']    = $user['name'];

        header("Location: user/dashboard.php");
        exit();
    }
}

// ---------- CHECK ADMIN ----------
if ($username === 'admin123' && $password === 'admin@1122') {
   
    $_SESSION['admin_id'] = 1;
    $_SESSION['admin_name'] = 'Tanvir';
    header("Location: admin/dashboard.php");
    exit();
}
else if ($username === 'admin184' && $password === 'admin@184')
{
    $_SESSION['admin_id'] = 2;
    $_SESSION['admin_name'] = 'Tadrib';
    header("Location: admin/dashboard.php");
    exit();
}

// FAILED
header("Location: login.php?error=1");
exit();
