<?php 
session_start();
include 'dbaseconnection.php';

$totalProductsQuery = "SELECT COUNT(*) as total FROM products";
$totalProductsResult = $conn->query($totalProductsQuery);
$totalProducts = $totalProductsResult->fetch_assoc()['total'];

$totalUsersQuery = "SELECT COUNT(*) as total FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total'];

$totalOrdersQuery = "SELECT COUNT(*) as total FROM orders";
$totalOrdersResult = $conn->query($totalOrdersQuery);
$totalOrders = $totalOrdersResult->fetch_assoc()['total'];
?>
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .stat-card {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            flex: 1;
            margin: 0 10px;
            text-align: center;
        }

        .stat-card h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .stat-card p {
            font-size: 18px;
            color: #666;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="havenarym">
            <a href="superadmin.php">Havenarym</a>
        </div>
    </nav>

    <div class="admin-container">
        <aside class="sidebar">
            <ul>
                <li><a href="superadmin.php">Dashboard</a></li>
                <li><a href="supermanageproducts.php">Manage Products</a></li>
                <li><a href="superorders.php">Orders</a></li>
                <li><a href="superusers.php">Admins and Users</a></li>
                <button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button>
            </ul>
        </aside>

        <main class="admin-content">
            <h1>Welcome, Super Admin</h1>
            <p>Manage your shop efficiently from here.</p>

            <div class="stats">
                <div class="stat-card">
                    <h2>Total Products</h2>
                    <p><?php echo $totalProducts; ?></p>
                </div>
                <div class="stat-card">
                    <h2>Total Users</h2>
                    <p><?php echo $totalUsers; ?></p>
                </div>
                <div class="stat-card">
                    <h2>Total Orders</h2>
                    <p><?php echo $totalOrders; ?></p>
                </div>
            </div>
        </main>
    </div>

</body>
</html>