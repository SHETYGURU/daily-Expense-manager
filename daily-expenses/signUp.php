

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

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $currency = $_POST['currency'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    // Validate input (you can add more validation as needed)
    if ($password !== $repeatPassword) {
        echo "Passwords do not match.";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare statement
        $stmt = $conn->prepare("INSERT INTO users (email, firstName, lastName, currency, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $firstName, $lastName, $currency, $hashedPassword);

        // Execute statement
        if ($stmt->execute()) {
            echo "User registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="shortcut icon" href="logo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header h1 {
            color: white;
        }

        .logo {
            display: block;
            margin: 0 auto;
            max-width: 100px;
        }

        form {
            width: 300px;
            margin: 0 auto;
            border: 1px solid blue;
            padding: 7%;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:hover,
        input[type="email"]:hover,
        input[type="password"]:hover {
            border-color: #45a049;
            box-shadow: 0px 0px 5px blue;
        }

        input[type="submit"] {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
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

    <div class="context">
        <form method="post" action="" style="position:relative;">
            <h2 style="text-align: center;">Create an account</h2>
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" required>

            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" required>

            <label for="currency">Currency:</label>
            <select name="currency" required>
            <option value="د.إ">Arab Emirates Dirham (AED)</option>
    <option value="؋">Afghan Afghani (AFN)</option>
    <option value="Lek">Albanian Lek (ALL)</option>
    <option value="$">US Dollar (USD)</option>
    <option value="€">Euro (EUR)</option>
    <option value="£">British Pound (GBP)</option>
    <option value="₼">Azerbaijani Manat (AZN)</option>
    <option value="BHD">Bahraini Dinar (BHD)</option>
    <option value="৳">Bangladeshi Taka (BDT)</option>
    <option value="BZ$">Belize Dollar (BZD)</option>
    <option value="BMD">Bermudian Dollar (BMD)</option>
    <option value="BTN">Bhutanese Ngultrum (BTN)</option>
    <option value="Bs.">Bolivian Boliviano (BOB)</option>
    <option value="R$">Brazilian Real (BRL)</option>
    <option value="BND">Brunei Dollar (BND)</option>
    <option value="BGN">Bulgarian Lev (BGN)</option>
    <option value="៛">Cambodian Riel (KHR)</option>
    <option value="CAD">Canadian Dollar (CAD)</option>
    <option value="CLP">Chilean Peso (CLP)</option>
    <option value="¥">Chinese Yuan (CNY)</option>
    <option value="COP">Colombian Peso (COP)</option>
    <option value="₡">Costa Rican Colón (CRC)</option>
    <option value="HRK">Croatian Kuna (HRK)</option>
    <option value="CZK">Czech Koruna (CZK)</option>
    <option value="DKK">Danish Krone (DKK)</option>
    <option value="RD$">Dominican Peso (DOP)</option>
    <option value="EGP">Egyptian Pound (EGP)</option>
    <option value="ERN">Eritrean Nakfa (ERN)</option>
    <option value="ETB">Ethiopian Birr (ETB)</option>
    <option value="€">Euro (EUR)</option>
    <option value="FJD">Fijian Dollar (FJD)</option>
    <option value="GEL">Georgian Lari (GEL)</option>
    <option value="GHS">Ghanaian Cedi (GHS)</option>
    <option value="GTQ">Guatemalan Quetzal (GTQ)</option>
    <option value="HNL">Honduran Lempira (HNL)</option>
    <option value="HK$">Hong Kong Dollar (HKD)</option>
    <option value="HUF">Hungarian Forint (HUF)</option>
    <option value="ISK">Icelandic Króna (ISK)</option>
    <option value="₹">Indian Rupee (INR)</option>
                <!-- Add more currencies as needed -->
            </select>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="repeatPassword">Repeat Password:</label>
            <input type="password" name="repeatPassword" required>

            <input type="submit" name="signup" value="Sign Up" style="margin-left:35%;margin-top:10%">
            <a class="register-button" href="login.php">Already have an account</a>
        </form>
    </div>
</body>

</html>
