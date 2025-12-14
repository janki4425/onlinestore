<?php
session_start();
include "db.php";

// Err
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check user login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// del req
if (isset($_GET['delete'])) {
    $order_id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM single_order WHERE id = $order_id AND user_id = $user_id";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: myorders.php?msg=deleted");
        exit();
    } else {
        die("Error deleting order: " . mysqli_error($conn));
    }
}

// fetch only current user orders
$sql = "
    SELECT 
        so.id AS order_id,
        p.name AS product_name,
        p.image AS product_image,
        p.price AS product_price,
        so.product_quantity,
        so.total_amount
    FROM single_order AS so
    JOIN products AS p ON so.product_id = p.id
    WHERE so.user_id = $user_id
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
    <title>My Orders</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #f4f7f6;
            padding: 30px;
        }

        h2 {
            font-size: 24px;
            color: #004d4d;
            text-align: center;
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

        .success-msg {
            text-align: center;
            color: green;
            margin-bottom: 15px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #008b8b;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-link:hover {
            background-color: #006666;
        }
    </style>
</head>
<body>

    <a href="index.php" class="back-link">⬅ Back to Home</a>

    <h2>My Orders</h2>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') { ?>
        <p class="success-msg">Order deleted successfully!</p>
    <?php } ?>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
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
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td>
                        <img class="product-img" src="image/<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product">
                    </td>
                    <td>₹<?php echo htmlspecialchars($row['product_price']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_quantity']); ?></td>
                    <td>₹<?php echo htmlspecialchars($row['total_amount']); ?></td>
                    <td>
                        <a href="myorders.php?delete=<?php echo $row['order_id']; ?>" onclick="return confirm('Are you sure you want to delete this order?')">
                            <button class="delete-btn">🗑 Delete</button>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="no-orders">You haven’t placed any orders yet.</p>
    <?php } ?>

</body>
</html>
