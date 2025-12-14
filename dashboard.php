<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] != "user") {
        header("location:admin/dashboard.php");
        exit;
    }
} else {
    header("location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Arial, sans-serif;
        }
        body {
            background-color: #f4f6f8;
        }

        
        .dashboard_sidebar {
            position: fixed;
            top: 0;
            left: 0;
            background-color: darkcyan;
            width: 230px;
            height: 100%;
            padding-top: 30px;
            color: white;
        }

        .dashboard_sidebar ul {
            list-style: none;
        }

        .dashboard_sidebar ul li {
            margin: 15px 0;
            padding-left: 25px;
        }

        .dashboard_sidebar ul li a {
            text-decoration: none;
            display: flex;
            align-items: center;
            color: white;
            font-size: 18px; 
            padding: 12px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .dashboard_sidebar ul li a:hover {
            background-color: teal;
        }

        .dashboard_sidebar ul li i {
            font-size: 20px;
            margin-right: 12px;
            width: 25px;
            text-align: center;
        }

       
        .dashboard_main {
            margin-left: 260px;
            padding: 40px;
        }

        .dashboard_main h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .dashboard_main p {
            font-size: 17px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        
        .card_container {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .card {
            background: white;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 25px;
            width: 300px;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: darkcyan;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <div class="dashboard_sidebar">
        <ul>
            <li><a href="myorders.php"><i class="fa-solid fa-box"></i> My Orders</a></li>
          
            <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <div class="dashboard_main">
        <h1>Welcome to Your Dashboard 👋</h1>
        <p>
            Hello <strong><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></strong>,  
            this is your personal dashboard where you can view and manage your activity on our platform.  
            From here, you can check your past orders, manage your account details, and stay updated with new arrivals.
        </p>

        <div class="card_container">
            <div class="card">
                <h3>🛒 My Orders</h3>
                <p>View all your previous and ongoing orders in o
