<?php
session_start();
$loggedIn = isset($_SESSION['users']);
include 'dbaseconnection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Havenarym</title>
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

    <section class="about-us-section">
        <div class="about-us-box">
            <h2>About Havenarym</h2>

            <div class="about-content">
                <img src="images/havenarym.jpg" alt="Havenarym" class="about-img">
                <p>Welcome to Havenarym, your elegant online marketplace designed to bring the best clothing and accessories for you and your family. We specialize in a variety of high-quality products, offering an exceptional shopping experience for all our customers. We value you and your taste as we strive to bring your dreams to reality!</p>
            </div>

            <h3>Our Mission</h3>
            <div class="about-content">
                <p>At Havenarym, we aim to provide a seamless and enjoyable shopping experience. Our platform is designed with the user in mind, ensuring easy navigation, secure transactions, and timely deliveries. We believe in offering a diverse selection of products, catering to every need and taste.</p>
            </div>

            <h3>Our Founder</h3>
            <div class="about-content">
                <p>Havenarym was founded by Myra Borromeo, a passionate entrepreneur dedicated to creating an intuitive and trustworthy eCommerce platform. With a vision to revolutionize the online shopping experience, Myra has worked tirelessly to build a brand that combines style, convenience, and reliability.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Havenarym. All rights reserved.</p>
        </div>
    </footer>

    <style>
        .about-img {
            width: 80%;
            height: auto;
            margin-bottom: 50px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .about-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 40px;
        }

        .about-us-section {
            background: rgba(255, 255, 255, 0.8);
            padding: 50px 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .about-us-box {
            text-align: center;
        }

        .about-us-box h2 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: #311E0F;
            margin-bottom: 20px;
        }

        .about-us-box p {
            font-size: 18px;
            color: #311E0F;
            margin: 0 250px;
        }

        .about-us-box h3 {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            color: #311E0F;
            margin-top: 30px;
        }
    </style>
</body>

</html>
