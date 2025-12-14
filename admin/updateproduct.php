<?php
include "../db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['user_role'] !== "admin") {
    header("Location: ../dashboard.php");
    exit;
}

$sql1 = "SELECT * FROM categories";
$result1 = mysqli_query($conn, $sql1);

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $sql2 = "SELECT * FROM products WHERE id = '$product_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
}

if (isset($_POST['submit'])) {
    $product_id = $_GET['product_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_name = $_POST['category_name'];

    // handle image upload
    $image = $_FILES['image']['name'];
    if ($image) {
        $temp_location = $_FILES['image']['tmp_name'];
        $upload_location = "../image/";
        move_uploaded_file($temp_location, $upload_location . $image);
    } else {
        $image = $row2['image']; 
    }

 // update
    $sql_update = "UPDATE products 
                   SET name = '$name', 
                       description = '$description',
                       price = '$price',
                       stock = '$stock',
                       image = '$image',
                       category_name = '$category_name'
                   WHERE id = '$product_id'";

    $result_update = mysqli_query($conn, $sql_update);

    if ($result_update) {
        header("Location: displayproduct.php");
        exit;
    } else {
        echo "Error updating product: {$conn->error}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: "Poppins", Arial, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
        }

      
        .dashboard_sidebar {
            position: fixed;
            top: 0; left: 0;
            background-color: #008b8b;
            width: 220px;
            height: 100vh;
            padding-top: 30px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
        }
        .dashboard_sidebar ul { list-style: none; }
        .dashboard_sidebar ul li { text-align: center; margin-bottom: 15px; }
        .dashboard_sidebar ul li a {
            text-decoration: none; display: block;
            color: white; font-size: 1.1rem; font-weight: 500;
            padding: 12px 0; border-radius: 5px; transition: 0.3s;
        }
        .dashboard_sidebar ul li a:hover { background-color: #007070; }

        
        .dashboard_main {
            margin-left: 260px;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        form {
            background: #ffffff;
            padding: 40px 50px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
        }

        form h2 {
            text-align: center;
            color: darkcyan;
            margin-bottom: 25px;
            font-size: 24px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 20px;
            border: 1.5px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: darkcyan;
            box-shadow: 0 0 6px rgba(0,139,139,0.3);
        }

        textarea {
            resize: none;
            height: 100px;
        }

        .file-input {
            margin-bottom: 20px;
        }

        img {
            width: 140px;
            height: 140px;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 15px;
            display: block;
        }

        .category {
            font-size: 16px;
            margin-bottom: 10px;
            color: #444;
        }

        .button {
            width: 100%;
            background-color: darkcyan;
            color: white;
            border: none;
            padding: 14px 0;
            border-radius: 10px;
            cursor: pointer;
            font-size: 17px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: teal;
        }

        @media (max-width: 700px) {
            .dashboard_main {
                margin-left: 0;
                padding: 20px;
            }

            form {
                width: 100%;
                padding: 30px;
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
        <form action="updateproduct.php?product_id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
            <h2>✏️ Update Product</h2>

            <input type="text" name="name" value="<?php echo htmlspecialchars($row2['name']); ?>" required placeholder="Enter product name">

            <textarea name="description" required placeholder="Enter product description"><?php echo htmlspecialchars($row2['description']); ?></textarea>

            <input type="number" name="price" value="<?php echo htmlspecialchars($row2['price']); ?>" required placeholder="Enter product price">

            <input type="number" name="stock" value="<?php echo htmlspecialchars($row2['stock']); ?>" required placeholder="Enter stock quantity">

            <div class="file-input">
                <img src="../image/<?php echo htmlspecialchars($row2['image']); ?>" alt="Product Image">
                <input type="file" name="image">
            </div>

            <div class="category">
                <strong>Current Category:</strong> <?php echo htmlspecialchars($row2['category_name']); ?>
            </div>

            <select name="category_name" required>
                <?php mysqli_data_seek($result1, 0); while ($row = mysqli_fetch_assoc($result1)) { ?>
                    <option value="<?php echo $row['name']; ?>" 
                        <?php if ($row['name'] == $row2['category_name']) echo "selected"; ?>>
                        <?php echo $row['name']; ?>
                    </option>
                <?php } ?>
            </select>

            <input class="button" type="submit" name="submit" value="Update Product">
        </form>
    </div>
</body>
</html>
