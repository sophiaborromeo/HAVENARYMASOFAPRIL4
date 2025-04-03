<?php
session_start();
$loggedIn = isset($_SESSION['users']);
include 'dbaseconnection.php';

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Havenarym</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            background-color: #e3d2bc;
            border-radius: 8px;
        }

        .product-card {
            width: 300px;
            height: 550px;
            margin-top: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            position: relative;
            box-sizing: border-box;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }

        .product-price {
            margin-top: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #311E0F;
        }

        .btn {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #555;
        }

        .product-description {
            display: none;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #555;
            text-align: left;
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
            <li>
                <?php if ($loggedIn): ?>
                    <li class="dropdown">
                        <a href="#">👩🏻‍🦳 ▼</a>
                        <div class="dropdown-content">
                            <a href="accountdetails.php">Account Details</a>
                            <a href="transactions.php">Current Transactions</a>
                            <a href="records.php">Records</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li><a href="login.php">👩🏻‍🦳</a></li>
                <?php endif; ?>
            </li>
            <li><a href="cart.html" id="cart-btn">🛒</a></li>
        </ul>
    </nav>

    <section id="products">
        <h2>Our Products</h2>
        <p>Check out our amazing collection.</p>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="product-list">
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="product-card">
                        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>" class="product-image">
                        <h3 class="product-name"><?php echo htmlspecialchars($product['productName']); ?></h3>
                        <p class="product-price">₱<?php echo number_format($product['price'], 2); ?></p>
                        <div class="product-description">
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        </div>

                        <a href="productdetails.php?id=<?php echo $product['productID']; ?>" class="btn">View More</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No products available at the moment.</p>
        <?php endif; ?>
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
