<?php
require 'DBconnect.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $company_name=$_POST['company_name']; 
    $username=$_POST['username'];
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
    $location=$_POST['location']; 
    $industry=$_POST['industry'];

    $check=$conn->prepare("SELECT username FROM `user` WHERE username=? UNION SELECT username FROM company WHERE username=?");
    $check->bind_param("ss",$username,$username); $check->execute(); $check->store_result();

    if($check->num_rows>0) $error="Username exists";
    else {
        $sql="INSERT INTO company(company_name,username,password,location,industry) VALUES(?,?,?,?,?)";
        $stmt=$conn->prepare($sql); $stmt->bind_param("sssss",$company_name,$username,$password,$location,$industry); $stmt->execute();
        $success="Company created successfully";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Create Company</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="form-box">
<h2>Create Company</h2>
<?php if(!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
<?php if(!empty($success)) echo "<p style='color:green'>$success</p>"; ?>
<form method="POST">
<input type="text" name="company_name" placeholder="Company Name" required>
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<input type="text" name="location" placeholder="Location" required>
<input type="text" name="industry" placeholder="Industry" required>
<button type="submit">Create Company</button>
</form>
<a href="login.php">Back to Login</a>
</div>
</body>
</html>
