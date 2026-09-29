<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-wrapper">

    <!-- Logo -->
    <div class="project-title">
        CareerBridge <span>BRAC</span>
    </div>

    <!-- Login Box -->
    <div class="form-box">
        <h2>Login</h2>
        <form method="POST" action="login_check.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <br>
        <a href="create_user.php">Create User</a> 
        <a href="create_company.php">Create Company</a>  
    </div>

</div>

</body>
</html>

