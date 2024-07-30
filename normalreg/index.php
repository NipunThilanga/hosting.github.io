<!DOCTYPE html>
<html>
<head>
    <title>Login and Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-container {
            display: none;
        }
        .form-container.active {
            display: block;
        }
        .toggle-btn {
            cursor: pointer;
            padding: 10px;
            width: 50%;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px 8px 0 0;
            outline: none;
        }
        .toggle-btn.active {
            background: #0056b3;
        }
        .btn-group {
            display: flex;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label {
            margin-bottom: 5px;
        }
        form input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form input[type="submit"] {
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s;
        }
        form input[type="submit"]:hover {
            background: #0056b3;
        }
        .message {
            margin-top: 20px;
            font-size: 14px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="btn-group">
            <button class="toggle-btn active" onclick="showForm('login', this)">Login</button>
            <button class="toggle-btn" onclick="showForm('register', this)">Register</button>
        </div>

        <div id="login" class="form-container active">
            <h2>Login</h2>
            <form action="index.php" method="post" id="loginForm">
                <label>Email:</label>
                <input type="email" name="login_email" required>
                
                <label>Password:</label>
                <input type="password" name="login_password" required>
                
                <input type="submit" name="login" value="Login">
            </form>
        </div>

        <div id="register" class="form-container">
            <h2>Register</h2>
            <form action="index.php" method="post">
                <label>Name:</label>
                <input type="text" name="name" required>
                
                <label>Email:</label>
                <input type="email" name="email" required>
                
                <label>Password:</label>
                <input type="password" name="password" required>
                
                <input type="submit" name="register" value="Register">
            </form>
        </div>

        <div class="message">
            <?php
            session_start();

            // Connect to MySQL
            $conn = mysqli_connect("localhost", "root", "", "signup");

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Process registration form data when submitted
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

            // Process login form data when submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
                $email = $_POST['login_email'];
                $password = $_POST['login_password'];

                // Fetch user data from database
                $sql = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if (password_verify($password, $row['password'])) {
                        $_SESSION['email'] = $email; // Initialize session
                        echo "<script>window.location.href='file:///E:/CeytramCompany_ProjectLst11/CeytramCompany_Project/index.html';</script>";
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
        </div>
    </div>

    <script>
        function showForm(formId, btn) {
            document.querySelectorAll('.form-container').forEach(function(form) {
                form.classList.remove('active');
            });
            document.querySelectorAll('.toggle-btn').forEach(function(button) {
                button.classList.remove('active');
            });
            document.getElementById(formId).classList.add('active');
            btn.classList.add('active');
        }
    </script>
</body>
</html>
