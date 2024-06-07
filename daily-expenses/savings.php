<?php
// Initialize database connection (replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daily_expense";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle saving amount submission
if (isset($_POST['save_amount'])) {
    $saving_amount = $_POST['saving_amount'];
    
    // Calculate total income and savings
    $total_income_query = "SELECT SUM(amount) AS total_income FROM income_table";
    $total_income_result = $conn->query($total_income_query);
    $total_income = $total_income_result->fetch_assoc()['total_income'];

    $total_savings_query = "SELECT SUM(amount) AS total_savings FROM savings_table";
    $total_savings_result = $conn->query($total_savings_query);
    $total_savings = $total_savings_result->fetch_assoc()['total_savings'];

    if ($total_income - $total_savings >= $saving_amount) {
        // Insert saving amount into the database
        $insert_saving_query = "INSERT INTO savings_table (amount) VALUES ('$saving_amount')";
        $conn->query($insert_saving_query);
    }
}

// Handle removing savings
if (isset($_POST['remove_amount'])) {
    $remove_amount = $_POST['remove_amount'];

    // Ensure removing amount is valid
    if ($remove_amount > 0) {
        // Insert removed savings to income
        $insert_income_query = "INSERT INTO income_table (amount) VALUES ('$remove_amount')";
        $conn->query($insert_income_query);

        // Delete removed savings from savings_table
        $delete_savings_query = "DELETE FROM savings_table WHERE amount = '$remove_amount' LIMIT 1";
        $conn->query($delete_savings_query);
    }
}

// Calculate total savings till date
$total_savings_query = "SELECT SUM(amount) AS total_savings FROM savings_table";
$total_savings_result = $conn->query($total_savings_query);
$total_savings_till_date = $total_savings_result->fetch_assoc()['total_savings'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Savings Page</title>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f3f3f3;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}

h1 {
    text-align: center;
    margin-top: 0;
    padding-top: 20px;
    color: #333;
}

h2 {
    margin-top: 20px;
    color: #555;
}

form {
    margin-top: 10px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button[type="submit"] {
    display: block;
    margin-top: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

h2.total-savings {
    margin-top: 30px;
    text-align: center;
    color: #555;
}

.remove-section {
    margin-top: 30px;
    text-align: center;
}

.remove-section label {
    font-weight: bold;
    color: #333;
}

.remove-section button[type="submit"] {
    background-color: #f44336;
}

.remove-section button[type="submit"]:hover {
    background-color: #d32f2f;
}

</style>
</head>
<body>
    <div class="container">
        <h1>Savings Page</h1>
        
        <h2>Save Money</h2>
        <form method="post">
            <label for="saving_amount">Enter Saving Amount:</label>
            <input type="number" name="saving_amount" id="saving_amount" required>
            <button type="submit" name="save_amount">Save</button>
        </form>
        
        <h2 class="total-savings">Total Savings Till Date: <?php echo $total_savings_till_date; ?></h2>
        
        <div class="remove-section">
            <h2>Remove Savings</h2>
            <form method="post">
                <label for="remove_amount">Enter Amount to Remove:</label>
                <input type="number" name="remove_amount" id="remove_amount" required>
                <button type="submit" name="remove_amount">Remove</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
