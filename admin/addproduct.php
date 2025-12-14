<?php
session_start();
include "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
if ($_SESSION['user_role'] != "admin") {
    header("Location: ../dashboard.php");
    exit;
}

// fech categories
$sql1 = "SELECT * FROM categories";
$result1 = mysqli_query($conn, $sql1);
if (!$result1) {
    die("Category query failed: " . $conn->error);
}

//  form submission
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_name = $_POST['category_name'];

    // Image upload
    $image = $_FILES['image']['name'];
    $temp_location = $_FILES['image']['tmp_name'];
    $upload_location = "../image/";

    // validate file type
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed_extensions)) {
        echo "<script>alert('Invalid file type! Please upload an image.');</script>";
    } else {
        $sql = "INSERT INTO products (name, description, price, stock, image, category_name)
                VALUES ('$name', '$description', '$price', '$stock', '$image', '$category_name')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "<script>alert('Error adding product: {$conn->error}');</script>";
        } else {
            move_uploaded_file($temp_location, $upload_location . $image);
            echo "<script>alert('Product added successfully!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Admin Dashboard</title>
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

        
        .dashboard_main {
            margin-left: 250px;
            padding: 50px;
        }
        .dashboard_main h1 {
            color: #008b8b;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        
        .form_container {
            background: white;
            padding: 30px 40px;
            max-width: 700px;
            margin: auto;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }
        .form_container input,
        .form_container textarea,
        .form_container select {
            width: 100%;
            margin: 10px 0;
            padding: 15px;
            font-size: 1rem;
            border: 2px solid #ccc;
            border-radius: 10px;
            transition: 0.3s;
        }
        .form_container input:focus,
        .form_container textarea:focus,
        .form_container select:focus {
            border-color: #008b8b;
            outline: none;
            box-shadow: 0 0 5px rgba(0,139,139,0.3);
        }

        .form_container .button {
            background-color: #008b8b;
            color: white;
            border: none;
            font-size: 1rem;
            padding: 12px 0;
            cursor: pointer;
            border-radius: 10px;
            transition: 0.3s;
        }
        .form_container .button:hover {
            background-color: #006d6d;
        }

        h2 {
            margin-top: 15px;
            color: #444;
        }

        @media (max-width: 768px) {
            .dashboard_sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .dashboard_main {
                margin-left: 0;
                padding: 20px;
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
        <h1>Add New Product</h1>

        <div class="form_container">
            <form action="addproduct.php" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Enter product name" required>
                <textarea name="description" placeholder="Enter product description" rows="4" required></textarea>
                <input type="number" name="price" placeholder="Enter product price" required>
                <input type="number" name="stock" placeholder="Enter stock quantity" required>

                <h2>Upload Product Image</h2>
                <input type="file" name="image" accept="image/*" required>

                <select name="category_name" required>
                    <option value="">Select Category</option>
                    <?php
                    if (mysqli_num_rows($result1) > 0) {
                        while ($row = mysqli_fetch_assoc($result1)) {
                            echo "<option value='{$row['name']}'>{$row['name']}</option>";
                        }
                    } else {
                        echo "<option disabled>No categories available</option>";
                    }
                    ?>
                </select>

                <input class="button" type="submit" name="submit" value="Add Product">
            </form>
        </div>
    </div>
</body>
</html>
