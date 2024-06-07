
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $newCategory = $_POST['new-category'];
    $amount = $_POST['amount'];
    $expenseDate = $_POST['expense-date'];
    $payee = $_POST['payee'];
    $description = $_POST['description'];

    // Insert data into the database
    $sql = "INSERT INTO expenses (category, new_category, amount, expense_date, payee, description)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsss", $category, $newCategory, $amount, $expenseDate, $payee, $description);
    if ($stmt->execute()) {
        echo "Expense data inserted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Entry</title>
    <link rel="shortcut icon" href="logo.png">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        
        .top-bar {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        
        .top-bar a {
            color: #fff;
            text-decoration: none;
        }
        
        .expense-form {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            width: 80%;
            max-width: 400px;
            border: 1px solid blue;
            padding: 5%;
        }
        
        .expense-form h2 {
            margin: 0 0 20px;
            text-align: center;
        }
        
        .expense-form label {
            display: block;
            margin-bottom: 5px;
        }
        
        .expense-form select, .expense-form input[type="number"], .expense-form input[type="text"], .expense-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .expense-form input[type="number"]:hover, .expense-form input[type="text"]:hover, .expense-form textarea:hover {

        border-color: #45a049;
            box-shadow: 0px 0px 10px blue;
        }
        
        .expense-form button {
            background-color: #4CAF50;
            border: none;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            margin-left:40%;
            margin-top: 5%;
        }
        
        .expense-form button:hover {
            background-color: #45a049;
        }

        .calendar-icon {
            display: inline-block;
            margin-left: 5px;
            cursor: pointer;
        }
        
    </style>
    <!-- Meta tags, title, and styles go here... -->
</head>
<body>
<div class="top-bar">
        <a href="myWeb.php" class="back-arrow" style="margin-left:-90%">&#8592; Back</a>
    </div>
    <div class="expense-form">
        <h2>Expense Entry</h2>
        <form action="expense.php" method="post">
            <label for="category">Category</label>
            <select id="category" name="category">
                <option value="groceries">Groceries</option>
                <option value="utilities">Utilities</option>
                <option value="entertainment">Entertainment</option>
                <option value="other">Other</option>
            </select>
            
            <div id="new-category-div" style="display: none;">
                <label for="new-category">New Category</label>
                <input type="text" id="new-category" name="new-category">
            </div>
            
            <label for="amount">Amount</label>
            <input type="number" id="amount" name="amount" required>
            <label for="calender">Date</label>
            <span class="calendar-icon">&#128197;</span>
            <input type="date" id="expense-date" name="expense-date" required><br>
           
           
            
            <span class="calendar-icon"></span>
           
            <label for="payee">Payee</label>
            <input type="text" id="payee" name="payee" required>
            
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"></textarea>
            
            <button type="submit">Submit</button>
        </form>
    </div>
    
    <script>
        const categorySelect = document.getElementById('category');
        const newCategoryDiv = document.getElementById('new-category-div');
        
        categorySelect.addEventListener('change', function() {
            if (categorySelect.value === 'other') {
                newCategoryDiv.style.display = 'block';
            } else {
                newCategoryDiv.style.display = 'none';
            }
        });
    </script>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $category = $_POST['category'];
        $newCategory = $_POST['new-category'];
        $amount = $_POST['amount'];
        $payee = $_POST['payee'];
        $description = $_POST['description'];
        
        // Perform necessary operations with the form data
        // For now, let's just print the data
        echo "<div class='expense-form'>";
        echo "<h2>Submitted Data</h2>";
        echo "<p><strong>Category:</strong> $category</p>";
        if ($category === 'other') {
            echo "<p><strong>New Category:</strong> $newCategory</p>";
        }
        echo "<p><strong>Amount:</strong> $amount</p>";
        echo "<p><strong>Payee:</strong> $payee</p>";
        echo "<p><strong>Description:</strong> $description</p>";
        echo "</div>";
    }
    ?>
</body>
</html>
