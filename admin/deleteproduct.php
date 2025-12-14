<?php
session_start();
include "../db.php";

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] == "admin") {
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            $sql = "DELETE FROM products WHERE id='$product_id'";
            $result = mysqli_query($conn, $sql);

            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Delete Product | Admin Panel</title>
                <style>
                    body {
                        font-family: 'Segoe UI', Arial, sans-serif;
                        background-color: #f2f7f7;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                    }
                    .container {
                        background: white;
                        padding: 40px 60px;
                        border-radius: 12px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                        text-align: center;
                        width: 400px;
                    }
                    h2 {
                        color: darkcyan;
                        margin-bottom: 20px;
                    }
                    p {
                        font-size: 18px;
                        margin-bottom: 30px;
                    }
                    .error {
                        color: red;
                        font-weight: bold;
                    }
                    a {
                        display: inline-block;
                        padding: 10px 20px;
                        background: darkcyan;
                        color: white;
                        text-decoration: none;
                        border-radius: 6px;
                        font-size: 16px;
                        transition: background 0.3s;
                    }
                    a:hover {
                        background: teal;
                    }
                </style>
            </head>
            <body>
                <div class='container'>";

            if (!$result) {
                echo "<h2 class='error'> Error deleting product!</h2>
                      <p>Database Error: {$conn->error}</p>
                      <a href='displayproduct.php'>🔙 Go Back</a>";
            } else {
                echo "<h2> Product Deleted Successfully!</h2>
                      <p>The product has been removed from the store.</p>
                      <a href='displayproduct.php'>🔙 Go Back</a>";
            }

            echo "</div></body></html>";
        }
    } else {
        echo "<div style='text-align:center; margin-top:100px; font-family:Arial;'>
                <h3 style='color:red;'>You are not authorized to access this page!</h3>
                <a href='../user/dashboard.php' 
                   style='background:darkcyan; color:white; padding:10px 20px; text-decoration:none; border-radius:6px;'>
                   Go to User Dashboard
                </a>
              </div>";
    }
} else {
    header('Location: ../index.php');
    exit();
}
?>
