<?php
session_start();
include "db.php";

// redirect user
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    
    $user_id = intval($_SESSION['user_id']);
    $product_id = intval($_POST['product_id']);
    $product_quantity = intval($_POST['product_quantity']);
    $price = floatval($_POST['product_price']);

    //validate quantity
    if ($product_quantity <= 0) {
        die("<h3 style='color:red;text-align:center;margin-top:50px;'>Invalid quantity selected.</h3>");
    }

    $total_amount = $product_quantity * $price;

    // check if product exist and stock is sufficient
    $check_sql = "SELECT stock FROM products WHERE id = $product_id";
    $check_result = mysqli_query($conn, $check_sql);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $product = mysqli_fetch_assoc($check_result);

        if ($product['stock'] < $product_quantity) {
            die("<h3 style='color:red;text-align:center;margin-top:50px;'>Not enough stock available.</h3>");
        }

        //  insert order
        $insert_sql = "INSERT INTO single_order (user_id, product_id, product_quantity, total_amount)
                       VALUES ($user_id, $product_id, $product_quantity, $total_amount)";
        $insert_result = mysqli_query($conn, $insert_sql);

        if (!$insert_result) {
            die("<h3 style='color:red;text-align:center;margin-top:50px;'>Error inserting order: " . mysqli_error($conn) . "</h3>");
        }

        //  update stock
        $update_sql = "UPDATE products 
                       SET stock = stock - $product_quantity 
                       WHERE id = $product_id";
        $update_result = mysqli_query($conn, $update_sql);

        if (!$update_result) {
            die("<h3 style='color:red;text-align:center;margin-top:50px;'>Error updating stock: " . mysqli_error($conn) . "</h3>");
        }

        // msg
        echo "
            <div style='
                font-family: Arial, sans-serif;
                text-align: center;
                margin-top: 80px;
                background: #f4f6f8;
                padding: 40px;
                border-radius: 10px;
                width: 60%;
                margin-left: auto;
                margin-right: auto;
                box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
            '>
                <h2 style='color: darkgreen;'>✅ Order placed successfully!</h2>
                <p style='font-size: 18px; margin-top: 10px;'>Total Amount: <strong>₹$total_amount</strong></p>
                <a href='index.php' 
                    style='display:inline-block; 
                           margin-top:20px; 
                           padding:10px 25px; 
                           background:darkcyan; 
                           color:white; 
                           text-decoration:none; 
                           border-radius:5px;'>
                    🛒 Buy More
                </a>
                <a href='myorders.php' 
                    style='display:inline-block; 
                           margin-top:20px; 
                           margin-left:10px; 
                           padding:10px 25px; 
                           background:#4CAF50; 
                           color:white; 
                           text-decoration:none; 
                           border-radius:5px;'>
                    📦 View My Orders
                </a>
            </div>
        ";

    } else {
        die("<h3 style='color:red;text-align:center;margin-top:50px;'>Invalid product ID.</h3>");
    }
} else {
    header("Location: index.php");
    exit();
}
?>
