<?php
include "db.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = "user";

    $sql = "INSERT INTO user(name, email, password, phone, address, role)
            VALUES('$name', '$email', '$password', '$phone', '$address', '$role')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "<script>alert('Error: {$conn->error}');</script>";
    } else {
        echo "<script>alert('Registered successfully! Redirecting to login...'); 
        window.location.href = 'login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #84fab0, #8fd3f4);
            overflow: hidden;
        }

        .container {
            background: #fff;
            padding: 40px 50px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 380px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 26px;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
            position: relative;
        }

        h2::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: #00bfa6;
            border-radius: 2px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }

        input:focus, textarea:focus {
            border-color: #00bfa6;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(0, 191, 166, 0.4);
        }

        textarea {
            resize: none;
            height: 80px;
        }

        .button {
            background: linear-gradient(135deg, #00bfa6, #00a2ff);
            color: white;
            font-weight: bold;
            border: none;
            padding: 12px;
            cursor: pointer;
            border-radius: 10px;
            font-size: 16px;
            transition: 0.3s ease;
        }

        .button:hover {
            background: linear-gradient(135deg, #00a2ff, #00bfa6);
            transform: scale(1.05);
        }

        .shoplink {
            display: inline-block;
            text-decoration: none;
            background: #4caf50;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            transition: 0.3s;
            margin-top: 15px;
        }

        .shoplink:hover {
            background: #3e8e41;
            transform: scale(1.05);
        }

        .login-text {
            margin-top: 20px;
            color: #555;
            font-size: 14px;
        }

        .login-text a {
            color: #00bfa6;
            text-decoration: none;
            font-weight: bold;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        <form action="register.php" method="post">
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="text" name="phone" placeholder="Enter your phone number" required>
            <textarea name="address" placeholder="Enter your address" required></textarea>
            <input class="button" type="submit" value="Sign Up" name="submit">
        </form>
        <a class="shoplink" href="index.php">🏬 Go to Shop</a>
        <p class="login-text">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
