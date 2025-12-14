<?php
include "../db.php";
session_start();

// role and session validare
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
if ($_SESSION['user_role'] != "admin") {
    header("Location: ../dashboard.php");
    exit;
}

// fetch all products
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching products: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products | Admin Dashboard</title>
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: "Poppins", Arial, sans-serif;
        }
        body {
            background-color: #f5f7fa;
            color: #333;
        }

        /* Sidebar */
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
            padding: 40px;
        }
        h2 {
            color: #008b8b;
            font-size: 2rem;
            margin-bottom: 25px;
        }

        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        thead {
            background-color: #008b8b;
            color: white;
        }
        th, td {
            text-align: center;
            padding: 14px 16px;
            border-bottom: 1px solid #e0e0e0;
        }
        img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }

        
        .action-btn {
            display: inline-block;
            padding: 8px 14px;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            cursor: pointer;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }
        .edit {
            background-color: #4caf50;
        }
        .edit:hover {
            background-color: #3d8b40;
        }
        .delete {
            background-color: #e74c3c;
        }
        .delete:hover {
            background-color: #c0392b;
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
            table {
                font-size: 0.9rem;
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
        <h2>All Products</h2>

        <table>
            <thead>
                <tr>
                    <th>Product Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>₹<?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['stock']); ?></td>
                    <td><img src="../image/<?php echo htmlspecialchars($row['image']); ?>" alt="Product"></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td>
                        <a class="action-btn edit" href="updateproduct.php?product_id=<?php echo $row['id']; ?>">Edit</a>
                    </td>
                    <td>
                        <a class="action-btn delete" href="deleteproduct.php?product_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
