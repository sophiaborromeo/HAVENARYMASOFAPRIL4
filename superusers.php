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
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
        $userlevel = $_POST['userlevel']; 

        $sql = "INSERT INTO users (fullname, contact, email, address, username, password, userlevel) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $fullname, $contact, $email, $address, $username, $password, $userlevel);
        $stmt->execute();
    } elseif (isset($_POST['update_user'])) {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $userlevel = $_POST['userlevel']; 

        $sql = "UPDATE users SET fullname=?, contact=?, email=?, address=?, userlevel=? WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $fullname, $contact, $email, $address, $userlevel, $username);
        $stmt->execute();
    } elseif (isset($_POST['archive_user'])) {
        $username = $_POST['username'];
        $sql = "DELETE FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM users";
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
            <a href="superadmin.php">Havenarym</a>
        </div>
        <div class="nav-links">
            <a href="#add-user-section">Add User</a>
            <a href="#update-records-section">Manage Users</a>
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
            <h1>Manage Admins/Users</h1>

            <div id="add-user-section">
                <h2>Add Admin/User</h2>
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
                                <th>User Level</th>
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
                            <td>
                                <select name="userlevel" required>
                                    <option value="1">Superadmin</option>
                                    <option value="2">Admin</option>
                                    <option value="3">User</option>
                                </select>
                            </td>
                            <td><button type="submit" name="add_user" class="btn">Add User</button></td>
                        </tr>
                    </table>
                </form>
            </div>

            <div id="update-records-section">
            <h2>Existing Admins/Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>User Level</th>
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
                                    <select name="userlevel" required>
                                        <option value="1" <?php if ($row['userlevel'] == 1) echo 'selected'; ?>>Superadmin</option>
                                        <option value="2" <?php if ($row['userlevel'] == 2) echo 'selected'; ?>>Admin</option>
                                        <option value="3" <?php if ($row['userlevel'] == 3) echo 'selected'; ?>>User</option>
                                    </select>
                                </td>
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

</body>
</html>

<?php
$conn->close();
?>
