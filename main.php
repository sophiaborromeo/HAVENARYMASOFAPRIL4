<?php
session_start();
$loggedIn = isset($_SESSION['users']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Havenarym</title>
    <link rel="stylesheet" href="styles.css">

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
                        <a href="useraccountdetails.php">Account Details</a>
                        <a href="usertransactions.php">Current Transactions</a>
                        <a href="userrecords.php">Records</a>
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
    
    <header id="home" class="front">
        <h1>Welcome to Havenarym</h1>
        <p>Find the best products at the best prices!</p>
        <a href="products.php" class="btn">Shop Now</a>
    </header>

    <section style="background-color: #2D1300; color: white; padding: 20px;">
    <h2 style="color: white;">Featured Products</h2>
    <div style="display: flex; justify-content: space-between;">
        <div style="flex: 1;">
            <img src="images/shoes.jpg" width="250px" height="250px">
            <h3>Zanea Heels</h3>
        </div>
        <div style="flex: 1;">
            <img src="images/watch.jpg" width="250px" height="250px">
            <h3>Michael Kors Watch</h3>
        </div>
        <div style="flex: 1;">
            <img src="images/bag.jpg" width="250px" height="250px">
            <h3>Calvin Klein Bag</h3>
        </div>
        <div style="flex: 1;">
            <img src="images/dress.jpg" width="250px" height="250px">
            <h3>Silk Dress</h3>
        </div>
    </div>
</section>




    
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Havenarym. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
