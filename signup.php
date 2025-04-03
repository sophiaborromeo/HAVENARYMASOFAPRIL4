<?php
session_start();
include 'dbaseconnection.php'; 

$signupErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact_number']); 
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password !== $confirm_password) {
        $signupErr = "Passwords do not match!";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $signupErr = "Username or email already exists!";
        } else {
            $sql = "INSERT INTO users (username, email, contact, password, userlevel) VALUES ('$username', '$email', '$contact', '$password', 2)";

            if ($conn->query($sql) === TRUE) {
                header("Location: login.php"); 
                exit();
            } else {
                $signupErr = "Error: " . $conn->error;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Havenarym</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <nav class="navbar">
        <div class="havenarym">
            <a href="main.php">Havenarym</a>
        </div>
    </nav>

    <section class="signup-section">
        <div class="signup-box">
            <h2>Create an Account</h2>
            <p>Join us and start shopping today!</p>
            <form action="signup.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>

                <label for="contact-number">Contact Number</label>
                <input type="text" id="contact-number" name="contact_number" value="<?php echo isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number']) : ''; ?>" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>

                <button type="submit" class="btn">Sign Up</button>
            </form>


            <?php if (!empty($signupErr)) { echo "<p style='color:red;'>$signupErr</p>"; } ?>

            <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>
        </div>
    </section>

</body>
</html>
