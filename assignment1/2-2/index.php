<?php 
    // Initialize variables
    $investment = '';
    $interest_rate = '';
    $years = '';
    $error_message = '';
    $future_value = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the data from the form
        $investment = filter_input(INPUT_POST, 'investment', FILTER_VALIDATE_FLOAT);
        $interest_rate = filter_input(INPUT_POST, 'interest_rate', FILTER_VALIDATE_FLOAT);
        $years = filter_input(INPUT_POST, 'years', FILTER_VALIDATE_INT);

        // Validate investment
        if ($investment === FALSE) {
            $error_message .= 'Investment must be a valid number.<br>'; 
        } else if ($investment <= 0) {
            $error_message .= 'Investment must be greater than zero.<br>'; 
        } 
        
        // Validate interest rate
        if ($interest_rate === FALSE)  {
            $error_message .= 'Interest rate must be a valid number.<br>'; 
        } else if ($interest_rate <= 0) {
            $error_message .= 'Interest rate must be greater than zero.<br>'; 
        } else if ($interest_rate > 15) {
            $error_message .= 'Interest rate must be less than or equal to 15.<br>';
        }
        
        // Validate years
        if ($years === FALSE) {
            $error_message .= 'Years must be a valid whole number.<br>';
        } else if ($years <= 0) {
            $error_message .= 'Years must be greater than zero.<br>';
        } else if ($years > 30) {
            $error_message .= 'Years must be less than 31.<br>';
        } 

        // If there are no errors, calculate the future value
        if (empty($error_message)) {
            $future_value = $investment;
            for ($i = 1; $i <= $years; $i++) {
                $future_value += $future_value * $interest_rate * 0.01;
            }

             // Format the values
             $investment_f = '$'.number_format($investment, 2);
             $yearly_rate_f = $interest_rate.'%';
             $yearly_f = $interest_rate.'%';
             $years_f = $years.'';
             $future_value_f = '$'.number_format($future_value, 2);
 
             // Clear the form values
             $investment = '';
             $interest_rate = '';
             $years = '';
         } else {
             // Set default formatted values if there's an error
             $investment_f = '';
             $yearly_rate_f = '';
             $years_f = '';
             $future_value_f = '';
         }
     }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
        <h1>Future Value Calculator</h1>
        <form action="index.php" method="post">
            <div id="data">
                <label>Investment Amount:</label>
                <input type="text" name="investment" value="<?php echo htmlspecialchars($investment); ?>"><br>
                
                <label>Yearly Interest Rate:</label>
                <input type="text" name="interest_rate" value="<?php echo htmlspecialchars($interest_rate); ?>"><br>
                
                <label>Number of Years:</label>
                <input type="text" name="years" value="<?php echo htmlspecialchars($years); ?>"><br>
            </div>

            <div id="buttons">
                <label>&nbsp;</label>
                <input type="submit" value="Calculate"><br>
            </div>
        </form>

        <?php if (!empty($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>

        <?php if (empty($error_message) && !empty($future_value)) { ?>
            <div id="results">
                <h2>Results</h2>
                <label>Investment Amount:</label>
                <span><?php echo htmlspecialchars($investment_f); ?></span><br />
                
                <label>Yearly Interest Rate:</label>
                <span><?php echo htmlspecialchars($yearly_rate_f); ?></span><br />
                
                <label>Number of Years:</label>
                <span><?php echo htmlspecialchars($years_f); ?></span><br />
                
                <label>Future Value:</label>
                <span><?php echo htmlspecialchars($future_value_f); ?></span><br />
                
                <p>This calculation was done on <?php echo date('m/d/Y'); ?>.</p>
            </div>
        <?php } ?>
    </main>
</body>
</html>
