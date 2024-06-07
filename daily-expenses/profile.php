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

// Initialize variables to store user data
$user = [];

// Fetch user data from the database
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    
    // Prepare and execute SQL query to fetch user data
    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        } else {
            echo "No user found with email: " . $email;
        }
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
</head>
<body>

    <div class="container">
        <h1>User Profile</h1>
        <div class="profile">
            <form action="update_profile.php" method="post">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo isset($user['firstname']) ? $user['firstname'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo isset($user['lastname']) ? $user['lastname'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="currency">Currency:</label>
                    <input type="text" id="currency" name="currency" value="<?php echo isset($user['currency']) ? $user['currency'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
                </div>
                <button type="submit" class="btn">Save</button>
            </form>
        </div>
    </div>

</body>
</html>
