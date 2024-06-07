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

// Fetch user data based on session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT firstName, lastName, email, currency FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $email = $row['email'];
        $currency = $row['currency'];
    } else {
        // Handle the case where user data is not found
        echo("details not found ");
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="icon" type="image/x-icon" href="C:\Users\mahalaxmi\Downloads\logo.png">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-size: 16px;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .logo {
            margin-left: 45%;
            margin-bottom: 5%;
            height: 5%;
            width: 5%;
            transform: scale(.06);
            position: relative;
        }

        input[type="button"] {
            background-color: #464646;
            border: none;
            color: white;
            border: 1px white;
            border-radius: 2cm;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 120%;
            margin-top: 0%;
            margin-bottom: 0%;
            margin-left: 40%;
            width: 20%;
            height: 5%;
        }

        input[type="button"]:hover {
            box-shadow: 0px 0px 6px blue;
            transform: scale(1.2);
        }

        .dropbtn {
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            width: 20%;
        }

        .dropbtn:hover, .dropbtn:focus {
            background-color: #eff5f8;
        }

        .main:hover {
            font-size: medium;
        }

        .main1:hover, .main1:focus {
            font-size: medium;
            font: center;
            transform: scale(1);
        }
        
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="mySidebar">
        <button onclick="w3_close()" class="main w3-hover-red w3-hover-text-white">Close &times;</button>
        <a href="#" class="w3-bar-item w3-button w3-hover-green w3-hover-text-white"><?php echo $firstName . ' ' . $lastName; ?></a>
        <a href="#" class="w3-bar-item w3-button w3-hover-blue w3-hover-text-white"><?php echo $currency; ?></a>
        <a href="#" class="w3-bar-item w3-button w3-hover-orange w3-hover-text-white"><?php echo $email; ?></a>
        <p>
            <nav>
                <a>
                    <button class="main w3-hover-GREEN w3-hover-text-white">LOG OUT</button>
                    <br><br>
                    <button class="main w3-hover-red w3-hover-text-white">DELETE ACCOUNT</button>
                </a>
            </nav>
        </p>
    </div>

    <!-- Page Content -->
    <div class="w3-teal">
        <button class="w3-button w3-teal w3-xlarge" onclick="w3_open()">☰</button>
    </div>
    <p class="logo W3-animate-top">
        <a href=""><img src="C:\Users\mahalaxmi\Desktop\web\myweb.php\logo.png" />&times;</a>
    </p><br>
    <div>
        <p class="main">
            <a href="income.php" >
                <input type="button" value="add income" >
            </a>
        </p>
        <p>
            <a href="expense.php" >
                <input type="button" value="add expenses" >
            </a>
        </p>
        <p>
            <a href="page.php" >
                <input type="button" value="view stats" >
            </a>
        </p>
        <p>
            <a href="savings.php" >
                <input type="button" value="savings" >
            </a>
        </p>
    </div>
    <script>
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }
    </script>
</body>
</html>
