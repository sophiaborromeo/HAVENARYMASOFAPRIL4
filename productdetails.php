<?php
session_start();
include 'dbaseconnection.php';

if (isset($_GET['id'])) {
    $productID = $_GET['id'];
    $query = "SELECT * FROM products WHERE productID = $productID";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        echo "Product not found.";
        exit();
    }
} else {
    echo "No product selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['productName']); ?> - Havenarym</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .product-detail-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #e3d2bc;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product-detail-image {
            width: 100%;
            max-width: 500px;
            height: auto;
            object-fit: cover;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .product-name {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .product-price {
            margin-top: 10px;
            font-size: 1.5rem;
            color: #311E0F;
        }

        .product-description {
            margin-top: 20px;
            font-size: 1rem;
            color: #555;
            text-align: left;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
        }

        .btn-back {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn-back:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="havenarym">
            <a href="main.php">Havenarym</a>
        </div>
        <ul class="nav-links">
            <li><a href="products.php">Products</a></li>
            <li><a href="aboutus.php">About</a></li>
            <li><a href="cart.html" id="cart-btn">🛒</a></li>
        </ul>
    </nav>

    <section class="product-detail-container">
    <h2 class="product-name"><?php echo htmlspecialchars($product['productName']); ?></h2>
        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>" class="product-detail-image">
    
        
        <p class="product-price">₱<?php echo number_format($product['price'], 2); ?></p>
        
        <div class="product-description">
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        </div>

        <a href="products.php" class="btn-back">Back to Products</a>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Havenarym. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>

<?php
mysqli_close($conn);
?>
