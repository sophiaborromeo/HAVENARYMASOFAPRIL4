<?php 
session_start();
include 'dbaseconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_user'])) {
        $fullname = $_POST['fullname'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        $sql = "INSERT INTO users (fullname, contact, email, address, username, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $fullname, $contact, $email, $address, $username, $password);
        $stmt->execute();
    } elseif (isset($_POST['update_user'])) {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $sql = "UPDATE users SET fullname=?, contact=?, email=?, address=? WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $fullname, $contact, $email, $address, $username);
        $stmt->execute();
    } elseif (isset($_POST['archive_user'])) {
        $username = $_POST['username'];
        $sql = "DELETE FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM users WHERE userlevel = 3";
$result = $conn->query($sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Users</title>
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
            <a href="admin.php">Havenarym</a>
        </div>
        <div class="nav-links">
            <a href="#add-user-section">Add User</a>
            <a href="#update-records-section">Manage Users</a>
        </div>
    </nav>

    <div class="admin-container">
        <aside class="sidebar">
            <ul>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="adminmanageproducts.php">Manage Products</a></li>
                <li><a href="adminorders.php">Orders</a></li>
                <li><a href="adminusers.php">Users</a></li>
                <button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button>
            </ul>
        </aside>

        <main class="admin-content">
            <h1>Manage Users</h1>

            <div id="add-user-section">
                <h2>Add User</h2>
                <form method="POST">
                    <table>
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tr>
                            <td><input type="text" name="fullname" placeholder="Full Name" required></td>
                            <td><input type="text" name="contact" placeholder="Contact Number" required></td>
                            <td><input type="email" name="email" placeholder="Email" required></td>
                            <td><textarea name="address" placeholder="Address" required></textarea></td>
                            <td><input type="text" name="username" placeholder="Username" required></td>
                            <td><input type="password" name="password" placeholder="Password" required></td>
                            <td><button type="submit" name="add_user" class="btn">Add User</button></td>
                        </tr>
                    </table>
                </form>
            </div>

            <div id="update-records-section">
                <h2>Existing Users</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <form method="POST">
                                    <td><?php echo $row['username']; ?>
                                        <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                                    </td>
                                    <td><input type="text" name="fullname" value="<?php echo $row['fullname']; ?>" required></td>
                                    <td><input type="text" name="contact" value="<?php echo $row['contact']; ?>" required></td>
                                    <td><input type="email" name="email" value="<?php echo $row['email']; ?>" required></td>
                                    <td><textarea name="address" required><?php echo $row['address']; ?></textarea></td>
                                    <td>
                                        <button type="submit" name="update_user" class="btn btn-primary">Update</button>
                                        <button type="submit" name="archive_user" class="btn btn-warning">Archive</button>
                                    </td>
                                </form>
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
