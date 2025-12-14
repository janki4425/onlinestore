<?php
session_start();
include "../db.php";

//err
error_reporting(E_ALL);
ini_set('display_errors', 1);

//  chekc admin session
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

//  handle Delte Request
if (isset($_GET['delete'])) {
    $order_id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM single_order WHERE id = $order_id";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: vieworders.php?msg=deleted");
        exit();
    } else {
        die("Error deleting order: " . mysqli_error($conn));
    }
}

// fetch all orders
$sql = "
    SELECT 
        so.id AS order_id,
        p.id AS product_id,
        p.name AS product_name,
        p.image AS product_image,
        p.price AS product_price,
        so.product_quantity,
        so.total_amount
    FROM single_order AS so
    JOIN products AS p ON so.product_id = p.id
    ORDER BY so.id DESC
";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error fetching orders: ' . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            background-color: #f4f7f6;
        }

        .dashboard_sidebar {
            position: fixed;
            top: 0;
            left: 0;
            background-color: #008b8b;
            width: 220px;
            height: 100vh;
            padding-top: 30px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
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

        .main {
            margin-left: 240px;
            padding: 30px;
            width: calc(100% - 240px);
        }

        .main h2 {
            font-size: 24px;
            color: #004d4d;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: #008b8b;
            color: #fff;
        }

        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        img.product-img {
            width: 70px;
            height: 70px;
            border-radius: 6px;
            object-fit: cover;
        }

        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.2s;
        }

        .delete-btn:hover {
            background-color: #e60000;
        }

        .no-orders {
            text-align: center;
            color: #777;
            margin-top: 40px;
            font-size: 18px;
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


    <div class="main">
        <h2>All Orders</h2>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') { ?>
            <p style="color: green;">Order deleted successfully!</p>
        <?php } ?>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td>
                            <img class="product-img" src="../image/<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product">
                        </td>
                        <td>₹<?php echo htmlspecialchars($row['product_price']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_quantity']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['total_amount']); ?></td>
                        <td>
                            <a href="vieworders.php?delete=<?php echo $row['order_id']; ?>" onclick="return confirm('Are you sure you want to delete this order?')">
                                <button class="delete-btn">🗑 Delete</button>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="no-orders">No orders found yet.</p>
        <?php } ?>
    </div>

</body>
</html>
