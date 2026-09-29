<?php
require 'DBconnect.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name']; $username = $_POST['username']; $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $cgpa = $_POST['cgpa']; $skill = $_POST['skill']; $experience = $_POST['experience'];
    $department = $_POST['department']; $status = $_POST['status'];

    $check = $conn->prepare("SELECT username FROM `user` WHERE username=? UNION SELECT username FROM company WHERE username=?");
    $check->bind_param("ss",$username,$username); $check->execute(); $check->store_result();

    if($check->num_rows>0) $error="Username exists";
    else {
        $sql = "INSERT INTO `user`(name,username,password,cgpa,skill,experience,department,status)
                VALUES(?,?,?,?,?,?,?,?)";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("sssdsiss",$name,$username,$password,$cgpa,$skill,$experience,$department,$status);
        $stmt->execute();
        $success="User created successfully";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Create User</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="form-box">
<h2>Create User</h2>
<?php if(!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
<?php if(!empty($success)) echo "<p style='color:green'>$success</p>"; ?>
<form method="POST">
<input type="text" name="name" placeholder="Full Name" required>
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<input type="number" step="0.01" name="cgpa" placeholder="CGPA" required>
<input type="text" name="skill" placeholder="Skill" required>
<input type="number" name="experience" placeholder="Experience (Years)" required>
<input type="text" name="department" placeholder="Department" required>
<select name="status" required>
<option value="ONGOING">Ongoing</option>
<option value="GRADUATED">Graduated</option>
</select>
<button type="submit">Create User</button>
</form>
<a href="login.php">Back to Login</a>
</div>
</body>
</html>
