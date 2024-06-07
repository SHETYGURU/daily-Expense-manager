<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense and Income Analysis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Define your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .graph-container {
            margin-top: 20px;
        }
        .details-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Expense and Income Analysis</h1>

        <!-- Interval Selection and Graph Display -->
        <h2>Select Interval and Display Graph</h2>
        <form method="post">
            <label for="interval">Select Interval:</label>
            <select name="interval" id="interval">
                <option value="6_months">Last 6 Months</option>
                <!-- Add other interval options here -->
            </select>
            <input type="submit" name="show_graph" value="Show Graph">
        </form>

        <div class="graph-container">
            <canvas id="expenseIncomeChart" width="400" height="200"></canvas>
        </div>

        <?php
        if (isset($_POST['show_graph'])) {
            // Fetch data and generate graph based on selected interval
            $selectedInterval = $_POST['interval'];
            // Fetch data from the database or prepare mock data
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $incomeData = [20, 25, 30, 35, 40, 45];
            $expenseData = [15, 18, 25, 30, 28, 20];
            
            // Generate and display the graph
            echo '<script>';
            echo 'var ctx = document.getElementById("expenseIncomeChart").getContext("2d");';
            echo 'var chart = new Chart(ctx, {';
            echo '    type: "line",';
            echo '    data: {';
            echo '        labels: ' . json_encode($months) . ',';
            echo '        datasets: [{';
            echo '            label: "Income",';
            echo '            data: ' . json_encode($incomeData) . ',';
            echo '            borderColor: "green",';
            echo '            backgroundColor: "rgba(0, 128, 0, 0.1)",';
            echo '            fill: true';
            echo '        }, {';
            echo '            label: "Expense",';
            echo '            data: ' . json_encode($expenseData) . ',';
            echo '            borderColor: "red",';
            echo '            backgroundColor: "rgba(255, 0, 0, 0.1)",';
            echo '            fill: true';
            echo '        }]';
            echo '    }';
            echo '});';
            echo '</script>';
        }
        ?>

        <!-- Radio Button Selection -->
        <div class="details-container">
    <h2>Select Details by Interval</h2>
    <form method="post">
        <input type="radio" name="interval_type" value="day"> Day
        <input type="radio" name="interval_type" value="month"> Month
        <input type="radio" name="interval_type" value="year"> Year
        <br>
        <?php
        $monthsList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $currentYear = date('Y');
        ?>
        <div id="dateDropdowns">
            <!-- Dropdown menus will be populated here based on selection -->
        </div>
        <input type="submit" name="show_details" value="Show Details">
    </form>

    <?php
    if (isset($_POST['show_details'])) {
        $selectedIntervalType = $_POST['interval_type'];

        // Fetch and display the details based on the selected interval type and values
        if ($selectedIntervalType === 'day') {
            $selectedYear = isset($_POST['year']) ? $_POST['year'] : '';
            $selectedMonth = isset($_POST['month']) ? $_POST['month'] : '';
            $selectedDay = isset($_POST['day']) ? $_POST['day'] : '';
            // Fetch and display details for the selected day
        } elseif ($selectedIntervalType === 'month') {
        $selectedYear = isset($_POST['year']) ? $_POST['year'] : '';
        $selectedMonth = isset($_POST['month']) ? $_POST['month'] : '';

        echo '<h3>Details for ' . ucfirst($selectedIntervalType) . '</h3>';
        echo '<p>Year: ' . $selectedYear . ', Month: ' . $monthsList[$selectedMonth - 1] . '</p>';

        // Fetch expenses for each day of the selected month and calculate total expenses
        $daysInSelectedMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);

        echo '<table>';
        echo '<tr><th>Day</th><th>Total Expenses</th></tr>';
        for ($day = 1; $day <= $daysInSelectedMonth; $day++) {
            // Fetch expenses for the current day of the selected month from your database
            // Calculate the sum of expenses for the current day
            // Replace the following line with your actual code to fetch and calculate expenses
            $totalExpensesForDay = calculateTotalExpensesForDay($selectedYear, $selectedMonth, $day);
            echo '<tr><td>' . $day . '</td><td>' . $totalExpensesForDay . '</td></tr>';
        }
        echo '</table>';
    } 
         elseif ($selectedIntervalType === 'year') {
            $selectedYear = isset($_POST['year']) ? $_POST['year'] : '';
            // Fetch and display details for the selected year
        }

        echo '<h3>Details for ' . ucfirst($selectedIntervalType) . '</h3>';
        // Display the income, expense, and other details
    }
    ?>
</div>

    </div>

    <script>
        const dateDropdowns = document.getElementById('dateDropdowns');
        const yearDropdown = '<select name="year"><option value="">Select Year</option><?php for ($i = $currentYear; $i >= $currentYear - 10; $i--) { echo "<option value=\"$i\">$i</option>"; } ?></select>';
        const monthDropdown = '<select name="month"><option value="">Select Month</option><?php foreach ($monthsList as $key => $value) { echo "<option value=\"" . ($key + 1) . "\">$value</option>"; } ?></select>';
        const dayDropdown = '<select name="day"><option value="">Select Day</option><?php for ($i = 1; $i <= 31; $i++) { echo "<option value=\"$i\">$i</option>"; } ?></select>';

        const intervalTypeRadios = document.querySelectorAll('[name="interval_type"]');
        intervalTypeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                dateDropdowns.innerHTML = '';
                if (radio.value === 'day') {
                    dateDropdowns.innerHTML = yearDropdown + monthDropdown + dayDropdown;
                } else if (radio.value === 'month') {
                    dateDropdowns.innerHTML = yearDropdown + monthDropdown;
                } else if (radio.value === 'year') {
                    dateDropdowns.innerHTML = yearDropdown;
                }
            });
        });
    </script>
</body>
</html>
