<?php
session_start();
include "config.php";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0)
    {
        $_SESSION['admin']=$username;

        header("Location: admin/dashboard.php");
    }
    else
    {
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Login</title>

<style>

body{
font-family:Arial;
background:#f2f2f2;
}

.login{
width:350px;
margin:100px auto;
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 0 10px gray;
}

input{
width:100%;
padding:10px;
margin-top:10px;
}

button{
width:100%;
padding:10px;
margin-top:15px;
background:green;
color:white;
border:none;
cursor:pointer;
}

</style>

</head>

<body>

<div class="login">

<h2 align="center">Admin Login</h2>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button
name="login">
Login
</button>

</form>

</div>

</body>
</html>