<?php 
session_start();
include 'dbaseconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_order'])) {
        $total = $_POST['total'];
        $username = $_POST['username'];
        $stats = $_POST['stats'];
        $transdate = $_POST['transdate'];
        $method = $_POST['method'];

        $sql = "INSERT INTO orders (total, username, stats, transdate, method) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $total, $username, $stats, $transdate, $method);
        $stmt->execute();
    } elseif (isset($_POST['update_order'])) {
        $orderID = $_POST['orderID'];
        $total = $_POST['total'];
        $username = $_POST['username'];
        $stats = $_POST['stats'];
        $transdate = $_POST['transdate'];
        $method = $_POST['method'];

        $sql = "UPDATE orders SET total=?, username=?, stats=?, transdate=?, method=? WHERE orderID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssi", $total, $username, $stats, $transdate, $method, $orderID);
        $stmt->execute();
    } elseif (isset($_POST['archive_order'])) {
        $orderID = $_POST['orderID'];
        $sql = "UPDATE orders SET stats = 'archived' WHERE orderID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM orders WHERE stats != 'archived'"; 
$result = $conn->query($sql);

$sql_archived = "SELECT * FROM orders WHERE stats = 'archived'";
$result_archived = $conn->query($sql_archived);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Orders</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="havenarym">
            <a href="superadmin.php">Havenarym</a>
        </div>
        <div class="nav-links">
            <a href="#add-order-section">Add Order</a>
            <a href="#update-orders-section">Manage Orders</a>
            <a href="#archived-orders-section">Archived Orders</a>
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
            <h1>Manage Orders</h1>

            <div id="add-order-section">
                <h2>Add Order</h2>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Total</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Transaction Date</th>
                            <th>Payment Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <form method="POST">
                        <tr>
                            <td><input type="number" name="total" placeholder="Total" required></td>
                            <td><input type="text" name="username" placeholder="Username" required></td>
                            <td><input type="text" name="stats" placeholder="Status" required></td>
                            <td><input type="date" name="transdate" placeholder="Transaction Date" required></td>
                            <td><input type="text" name="method" placeholder="Payment Method" required></td>
                            <td><button type="submit" name="add_order" class="btn">Add Order</button></td>
                        </tr>
                    </form>
                </table>
            </div>

            <div id="update-orders-section">
                <h2>Existing Orders</h2>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Transaction Date</th>
                            <th>Payment Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['orderID']; ?></td>

                            <form method="POST" style="display:inline;">
                                <td><input type="number" name="total" value="<?php echo $row['total']; ?>" required></td>
                                <td><input type="text" name="username" value="<?php echo $row['username']; ?>" required></td>
                                <td><input type="text" name="stats" value="<?php echo $row['stats']; ?>" required></td>
                                <td><input type="date" name="transdate" value="<?php echo $row['transdate']; ?>" required></td>
                                <td><input type="text" name="method" value="<?php echo $row['method']; ?>" required></td>
                                <td>
                                    <input type="hidden" name="orderID" value="<?php echo $row['orderID']; ?>">
                                    <button type="submit" name="update_order" class="btn">Update</button>
                                    <button type="submit" name="archive_order" class="btn btn-warning">Archive</button>
                                </td>
                            </form>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="archived-orders-section">
                <h2>Archived Orders</h2>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Transaction Date</th>
                            <th>Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_archived = $result_archived->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row_archived['orderID']; ?></td>
                            <td><?php echo $row_archived['total']; ?></td>
                            <td><?php echo $row_archived['username']; ?></td>
                            <td><?php echo $row_archived['stats']; ?></td>
                            <td><?php echo $row_archived['transdate']; ?></td>
                            <td><?php echo $row_archived['method']; ?></td>
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
