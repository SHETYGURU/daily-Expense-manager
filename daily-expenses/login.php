<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daily_expense";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, redirect to home.php
            $_SESSION['user_id'] = $row['id'];
            header("Location: home2.php");
            exit();
        } else {
            $error_message = "Incorrect email or password.";
        }
    } else {
        $error_message = "User not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="shortcut icon" href="logo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .logo {
            display: block;
            margin: 0 auto;
            max-width: 100px;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .container {
            background-color: #ffffff;
            border: 1px solid blue ;
           
            padding: 20px;
           
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
        }
        form {
            text-align: center;
            padding: 10%;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="email"]:hover,
        input[type="password"]:hover {
            border-color: #45a049;
            box-shadow: 0px 0px 5px blue;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s;
            margin-top: 10%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .register-button {
            display: block;
            text-align: center;
            margin-top: 10px;
            padding: 10px 20px;
            color: white;
            background-color: blueviolet;
            border: none;
            border-radius: 3px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .register-button:hover {
            background-color: darkviolet;
        }
    </style>

</head>
<body>
    <div>
        <img class="logo" src="logo.png" alt="Logo">
    </div>
    <div class="container">
        <form method="post" action="">
            <h2>Sign In</h2>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <input type="submit" name="signin" value="Sign In">
        </form>
        <a class="register-button" href="signup.php">Register an account</a>
        <?php
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>
