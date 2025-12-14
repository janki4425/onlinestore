<?php
include "db.php";
session_start();
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql= "select * from user where email = '$email'";
    $result = mysqli_query($conn,$sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        if($row['password'] == $password){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_role'] = $row['role'];
            if($_SESSION['user_role']=="admin"){
                header("Location:admin/dashboard.php");
            }
            else{
                header("Location:index.php");}
                exit();
        }
        else{
            echo "wrong password";
        }
    }
    else{
        echo "go for signup";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #a8edea, #fed6e3);
        }

        .login {
            background-color: #ffffff;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login input {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0;
            border-radius: 12px;
            border: 1px solid #ccc;
            outline: none;
            font-size: 14px;
            transition: 0.3s ease;
        }

        .login input:focus {
            border-color: #6a5acd;
            box-shadow: 0 0 8px rgba(106, 90, 205, 0.4);
        }

        .button {
            background-color: #6a5acd;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 10px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .button:hover {
            background-color: #5a4fcf;
            transform: scale(1.05);
        }

        p {
            margin-top: 15px;
            font-size: 14px;
            color: #333;
        }

        a {
            color: #6a5acd;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        a:hover {
            color: #5a4fcf;
            text-decoration: underline;
        }

       
        @media (max-width: 480px) {
            .login {
                width: 85%;
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input class="button" type="submit" name="submit" value="Login">
            <p>Don’t have an account? <a href="register.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>
