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

// Retrieve email from the Users table
$email = $_SESSION['email'];

if (isset($_POST['income-category']) && isset($_POST['income'])) {
    $incomeCategory = $_POST['income-category'];
    $income = $_POST['income'];
    $additionalIncomeTypes = $_POST['additional-income-type'];
    $additionalIncomeAmounts = $_POST['additional-income-amount'];

    // Insert income data into the 'Income' table
    $incomeSql = "INSERT INTO income (email, income_type, income, date) VALUES (?, ?, ?, CURDATE())";
    $incomeStmt = $conn->prepare($incomeSql);

    if ($incomeStmt) {
        $incomeStmt->bind_param("ssd", $email, $incomeCategory, $income);

        if ($incomeStmt->execute()) {
            echo "Income data inserted successfully!<br>";

            // Insert additional income data into the 'Income' table
            if (!empty($additionalIncomeTypes)) {
                for ($i = 0; $i < count($additionalIncomeTypes); $i++) {
                    $incomeStmt->bind_param("ssd", $email, $additionalIncomeTypes[$i], $additionalIncomeAmounts[$i]);
                    $incomeStmt->execute();
                }
                echo "Additional income data inserted successfully!<br>";
            } else {
                echo "No additional income data provided.<br>";
            }
        } else {
            echo "Error: " . $incomeStmt->error;
        }
    } else {
        echo "Error: Unable to prepare the statement.";
    }

    $incomeStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Entry</title>
    <link rel="shortcut icon" href="logo.png">
    <style>
        /* Reset some default styles */
        body, h1, h2, p, ul, li {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

        /* Top bar styles */
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

        /* Form container styles */
        .income-form {
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

        .income-form h2 {
            margin: 0 0 20px;
            text-align: center;
        }

        /* Basic input styles */
        .income-form label {
            display: block;
            margin-bottom: 5px;
        }

        .income-form input[type="text"], .income-form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .income-form input[type="text"]:hover, .income-form input[type="number"]:hover {
            border-color: #45a049;
            box-shadow: 0px 0px 10px blue;
        }

         
        /* Additional income field styles */
        .additional-income-field {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Add button styles */
        .add-income-button {
            background-color: #6F7378;
            border: none;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
            padding: 5px 10px;
            margin-top: 5px;
            transition: background-color 0.3s;
        }

        .add-income-button:hover {
            background-color: #ABB0B8;
        }
        .submit
        {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        </style>
    <!-- Meta tags, title, and styles go here... -->
   
</head>
<body>
    
    <div class="top-bar">
        <a href="myWeb.php" class="back-arrow" style="margin-left: -90%;">&#8592;  Back</a>
    </div>
    <div class="income-form">
        <h2>Income Entry</h2>
        <?php if (!isset($_POST['income-category'])) { ?>
        <form action="income.php" method="post">
            <label for="income-category">Income Type</label>
            <input type="text" id="income-category" name="income-category" required>

            <label for="income">Income</label>
            <input type="number" id="income" name="income" required>

            <div id="additional-income-fields">
                <!-- Additional income fields will be dynamically added here -->
            </div>

            <button type="button" class="add-income-button" id="add-income"> &#43;Add Income</button>
            <button type="submit" class ="submit">Submit</button>
        </form>
        <?php } else { ?>
        <p>Income data submitted successfully!</p>
        <?php } ?>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addIncomeButton = document.getElementById("add-income");
            const additionalIncomeFields = document.getElementById("additional-income-fields");

            addIncomeButton.addEventListener("click", function() {
                const newIncomeField = document.createElement("div");
                newIncomeField.classList.add("additional-income-field");

                const incomeTypeLabel = document.createElement("label");
                incomeTypeLabel.textContent = "Type of Income";
                const incomeTypeInput = document.createElement("input");
                incomeTypeInput.type = "text";
                incomeTypeInput.name = "additional-income-type[]";
                incomeTypeInput.required = true;

                const incomeAmountLabel = document.createElement("label");
                incomeAmountLabel.textContent = "Income";
                const incomeAmountInput = document.createElement("input");
                incomeAmountInput.type = "number";
                incomeAmountInput.name = "additional-income-amount[]";
                incomeAmountInput.required = true;

                newIncomeField.appendChild(incomeTypeLabel);
                newIncomeField.appendChild(incomeTypeInput);
                newIncomeField.appendChild(incomeAmountLabel);
                newIncomeField.appendChild(incomeAmountInput);

                additionalIncomeFields.appendChild(newIncomeField);
            });
        });
    </script>
</body>

</html>
