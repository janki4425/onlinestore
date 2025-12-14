<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] != "admin") {
        header("location:../dashboard.php");
        exit;
    }
} else {
    header("location:../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Online Shopping</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", Arial, sans-serif;
        }
        body {
            background-color: #f5f7fa;
            color: #333;
        }
        /* Sidebar */
        .dashboard_sidebar {
            position: fixed;
            top: 0;
            left: 0;
            background-color: #008b8b;
            width: 220px;
            height: 100vh;
            padding-top: 30px;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
        }
        .dashboard_sidebar ul {
            list-style: none;
        }
        .dashboard_sidebar ul li {
            text-align: center;
            margin-bottom: 15px;
        }
        .dashboard_sidebar ul li a {
            text-decoration: none;
            display: block;
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
            padding: 12px 0;
            border-radius: 5px;
            transition: 0.3s;
        }
        .dashboard_sidebar ul li a:hover {
            background-color: #007070;
        }

        /* Main Section */
        .dashboard_main {
            margin-left: 250px;
            padding: 40px;
        }
        .dashboard_main h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #008b8b;
        }
        .dashboard_main p {
            line-height: 1.7;
            font-size: 1.05rem;
            color: #444;
            margin-bottom: 20px;
        }
        .info_cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            background-color: white;
            padding: 20px;
            flex: 1 1 250px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            color: #008b8b;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        .card p {
            font-size: 0.95rem;
            color: #555;
        }

        @media(max-width: 768px){
            .dashboard_sidebar {
                width: 100%;
                height: auto;
                position: relative;
                box-shadow: none;
            }
            .dashboard_main {
                margin-left: 0;
                padding: 20px;
            }
            .info_cards {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard_sidebar">
        <ul>
            <li><a href="addproduct.php">➕ Add Product</a></li>
            <li><a href="displayproduct.php">📦 View Products</a></li>
            <li><a href="vieworders.php">🛒 View Orders</a></li>
            <li><a href="../logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="dashboard_main">
        <h1>Welcome, Admin 👋</h1>
        <p>
            This is your <strong>Admin Dashboard</strong> — the control center of your online shopping platform.  
            From here, you can manage all aspects of your store including products, orders, and users.
        </p>
        <p>
            As an administrator, you can add new products to the store, update existing listings, monitor inventory,
            and review customer orders in real-time. Keeping product data updated and responding to orders quickly
            ensures a smooth shopping experience for your customers.
        </p>

        <div class="info_cards">
            <div class="card">
                <h3>🛍 Manage Products</h3>
                <p>Add, edit, or remove products from your online catalog. Keep your inventory updated to reflect stock levels and pricing accurately.</p>
            </div>

            <div class="card">
                <h3>📦 View Orders</h3>
                <p>Track customer orders, view purchase details, and manage shipping or delivery updates efficiently.</p>
            </div>

            <div class="card">
                <h3>💰 Sales Insights</h3>
                <p>Review total sales, most popular products, and revenue performance to make informed business decisions.</p>
            </div>

            <div class="card">
                <h3>👥 Customer Management</h3>
                <p>Maintain a record of registered users, ensuring smooth communication and support for returning customers.</p>
            </div>
        </div>
    </div>
</body>
</html>
