<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" name="register" value="Register">
    </form>

    <?php
    // Connect to MySQL
    $conn = mysqli_connect("localhost", "root", "", "signup");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Process form data when submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Insert data into database
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Close connection
    mysqli_close($conn);
    ?>
</body>
</html>
