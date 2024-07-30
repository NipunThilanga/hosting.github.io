<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" name="login" value="Login">
    </form>

    <?php
    session_start();

    // Connect to MySQL
    $conn = mysqli_connect("localhost", "root", "", "signup");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Process login form data when submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Fetch user data from database
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email; // Initialize session
                header("Location: dashboard.php"); // Redirect to dashboard or another secure page
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "User not found!";
        }
    }

    // Close connection
    mysqli_close($conn);
    ?>
</body>
</html>
