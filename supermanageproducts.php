<?php 
session_start();
include 'dbaseconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        $productName = $_POST['productName'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $inventory = $_POST['inventory'];

        $sql = "INSERT INTO products (productName, price, category, description, image, inventory) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdsssi", $productName, $price, $category, $description, $image, $inventory);
        $stmt->execute();
    } elseif (isset($_POST['update_product'])) {
        $productID = $_POST['productID'];
        $productName = $_POST['productName'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $inventory = $_POST['inventory'];

        $sql = "UPDATE products SET productName=?, price=?, category=?, description=?, image=?, inventory=? WHERE productID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdssssi", $productName, $price, $category, $description, $image, $inventory, $productID);
        $stmt->execute();
    } elseif (isset($_POST['archive_product'])) {
        $productID = $_POST['productID'];
        $sql = "UPDATE products SET inventory = 0 WHERE productID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productID);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM products WHERE inventory > 0"; 
$activeResult = $conn->query($sql);

$sqlArchived = "SELECT * FROM products WHERE inventory = 0"; 
$archivedResult = $conn->query($sqlArchived);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Products</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        html {
            scroll-behavior: smooth;
        }
        .product-table input, .product-table textarea {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        .product-table td {
            vertical-align: top;
        }
        .product-table th {
            text-align: left;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="havenarym">
            <a href="superadmin.php">Havenarym</a>
        </div>
        <div class="nav-links">
            <a href="#add-product-section">Add Product</a>
            <a href="#manage-products-section">Manage Products</a>
            <a href="#archived-products-section">Archived Products</a>
        </div>
    </nav>

    <div class="admin-container">
        <aside class="sidebar">
            <ul>
                <li><a href="superadmin.php">Dashboard</a></li>
                <li><a href="supermanageproducts.php">Manage Products</a></li>
                <li><a href="superorders.php">Orders</a></li>
                <li><a href="superusers.php">Users</a></li>
                <button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button>
            </ul>
        </aside>

        <main class="admin-content">
            <h1>Manage Products</h1>

            <div id="add-product-section">
                <h2>Add Product</h2>
                <form method="POST">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Image URL</th>
                                <th>Inventory</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tr>
                            <td><input type="text" name="productName" placeholder="Product Name" required></td>
                            <td><input type="number" name="price" placeholder="Price" required step="0.01"></td>
                            <td><input type="text" name="category" placeholder="Category" required></td>
                            <td><textarea name="description" placeholder="Description" required></textarea></td>
                            <td><input type="text" name="image" placeholder="Image URL" required></td>
                            <td><input type="number" name="inventory" placeholder="Inventory" required></td>
                            <td><button type="submit" name="add_product" class="btn">Add Product</button></td>
                        </tr>
                    </table>
                </form>
            </div>

            <div id="manage-products-section">
                <h2>Existing Products</h2>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Inventory</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $activeResult->fetch_assoc()): ?>
                        <tr>
                            <form method="POST" style="display:table-row;">
                                <td><?php echo $row['productID']; ?></td>
                                <td><input type="text" name="productName" value="<?php echo $row['productName']; ?>" required></td>
                                <td><input type="number" name="price" value="<?php echo $row['price']; ?>" required step="0.01"></td>
                                <td><input type="text" name="category" value="<?php echo $row['category']; ?>" required></td>
                                <td><textarea name="description" required><?php echo $row['description']; ?></textarea></td>
                                <td><input type="text" name="image" value="<?php echo $row['image']; ?>" required></td>
                                <td><input type="number" name="inventory" value="<?php echo $row['inventory']; ?>" required></td>
                                <td>
                                    <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
                                    <button type="submit" name="update_product" class="btn">Update</button>
                                    <button type="submit" name="archive_product" class="btn btn-warning">Archive</button>
                                </td>
                            </form>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="archived-products-section">
                <h2>Archived Products</h2>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Inventory</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $archivedResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['productID']; ?></td>
                            <td><?php echo $row['productName']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['image']; ?></td>
                            <td>Archived</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>

<?php
$conn->close();
?>
