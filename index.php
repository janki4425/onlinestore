<?php 
session_start();
include "db.php";

//  fetch products 
if (isset($_GET['category_name'])) {
    $category_name = mysqli_real_escape_string($conn, $_GET['category_name']);
    $sql_product_category = "SELECT * FROM products WHERE category_name='$category_name' AND stock > 0";
} else {
    $sql_product_category = "SELECT * FROM products WHERE stock > 0";
}
$result_product_category = mysqli_query($conn, $sql_product_category);

// fecth all categorie
$sql_category = "SELECT * FROM categories";
$result_category = mysqli_query($conn, $sql_category);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopEase | Online Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            background-color: #f7f9fc;
            color: #333;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: darkcyan;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 40px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            z-index: 10;
        }

        .header a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
        }

        .header ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        .header li a:hover {
            color: #ffeb3b;
        }

        /* Main */
        .main {
            margin-top: 120px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
            padding: 20px;
            margin-bottom: 100px;
        }

        .product {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            max-width: 300px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        }

        .product img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .product h2 {
            font-size: 20px;
            color: darkcyan;
            margin-bottom: 10px;
        }

        .product p {
            font-size: 16px;
            margin: 5px 0;
        }

        .product form {
            margin-top: 12px;
        }

        .product input[type="number"] {
            width: 70px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            text-align: center;
            margin-right: 10px;
        }

        .product input[type="submit"],
        .product a {
            display: inline-block;
            background-color: darkcyan;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .product input[type="submit"]:hover,
        .product a:hover {
            background-color: teal;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: darkcyan;
            color: white;
            text-align: center;
            padding: 18px;
            font-size: 16px;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }

        /* Responsive */
        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                padding: 20px;
            }

            .header ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }

            .main {
                margin-top: 180px;
            }
        }
    </style>
</head>
<body>

    
    <header class="header">
        <a href="index.php" style="font-size: 22px; font-weight: bold;">🛍️ ShopEase</a>
        <ul>
            <?php while ($row_category = mysqli_fetch_assoc($result_category)) { ?>
                <li>
                    <a href="index.php?category_name=<?php echo urlencode($row_category['name']); ?>">
                        <?php echo htmlspecialchars($row_category['name']); ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <ul>
            <?php if (!isset($_SESSION['user_id'])) { ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Signup</a></li>
            <?php } else { ?>
                <li><a href="dashboard.php">Dashboard</a></li>
            <?php } ?>
        </ul>
    </header>

 
    <main class="main">
        <?php 
        if (mysqli_num_rows($result_product_category) > 0) {
            while ($row_product_category = mysqli_fetch_assoc($result_product_category)) { ?>
                <div class="product">
                    <img src="image/<?php echo htmlspecialchars($row_product_category['image']); ?>" alt="Product Image">
                    <h2><?php echo htmlspecialchars($row_product_category['name']); ?></h2>
                    <p><?php echo htmlspecialchars($row_product_category['description']); ?></p>
                    <p><strong>Stock:</strong> <?php echo $row_product_category['stock']; ?></p>
                    <p><strong>Price:</strong> ₹<?php echo $row_product_category['price']; ?></p>

                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <form action="singleorder.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $row_product_category['id']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $row_product_category['price']; ?>">
                            <input type="number" name="product_quantity" min="1" max="<?php echo $row_product_category['stock']; ?>" required>
                            <input type="submit" name="submit" value="Buy Now">
                        </form>
                    <?php } else { ?>
                        <a href="login.php">Buy Now</a>
                    <?php } ?>
                </div>
        <?php 
            }
        } else {
            echo "<h3 style='text-align:center; color:gray;'>No products found in this category.</h3>";
        }
        ?>
    </main>

  
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> ShopEase — Your Trusted Online Shopping Destination</p>
    </footer>

</body>
</html>
