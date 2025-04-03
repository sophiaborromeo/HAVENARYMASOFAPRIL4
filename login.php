<?php 
session_start();
include 'dbaseconnection.php';

$searchErr = '';
$username = isset($_POST['username']) ? $_POST['username'] : ''; // Retain username

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];

    $sql = "SELECT username, password, userlevel FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['users'] = $row;

        if ($_SESSION['users']['userlevel'] == 3) {
            header('Location: http://localhost/havenarym/main.php');
            exit();
        } else if ($_SESSION['users']['userlevel'] == 2){
            header('Location: http://localhost/havenarym/admin.php');
            exit();
        } else {
            header('Location: http://localhost/havenarym/superadmin.php');
            exit();
        }
    } else {
        $searchErr = "User account does not exist!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Havenarym</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="havenarym">
            <a href="main.php">Havenarym</a>
        </div>
    </nav>
    
    <section class="login-section">
        <div class="login-box">
            <h2>Welcome Back</h2>
            <p>Please log in to continue.</p>
            <form action="login.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <input type="checkbox" id="show-password"> Show Password

                <button type="submit" class="btn">Login</button>
            </form>

            <?php if (!empty($searchErr)) { echo "<p style='color:red;'>$searchErr</p>"; } ?>

            <p class="signup-link">Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </section>

    <script>
        document.getElementById('show-password').addEventListener('change', function() {
            var passwordField = document.getElementById('password');
            if (this.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        });
    </script>
</body>
</html>
