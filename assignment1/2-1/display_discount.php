
<?php
// To store the error messages
$product_description = '';
$list_price = '';
$discount_percent = '';
$error_message = ''; 

// Initialize sales tax variables
$sales_tax_rate = 0.08; // 8%
$sales_tax = 0.0;
$sales_total = 0.0;

//check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_description = filter_input(INPUT_POST, 'product_description');
    $list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);
    $discount_percent = filter_input(INPUT_POST, 'discount_percent', FILTER_VALIDATE_FLOAT);
    
    //validate product_description
    if (empty($product_description)){
        $error_message .="Product description is required.<br>";
    }
    
    //validate list price
    if ($list_price === false || $list_price <= 0){
        $error_message .= "Please enter a valid number or list price greater than 0. <br>";
    }
    
    //validate discount percent
    if ($discount_percent === false || $discount_percent < 0 || $discount_percent > 100){
        $error_message .= "Please enter a valid discount. <br>";
    }    
    // if no errors
    if (empty($error_message)){
        $discount = $list_price * $discount_percent * .01;
        $discount_price = $list_price - $discount;
    }
}   
    // ADD 8% sales tax
    $sales_tax_rate = 0.08;
    $sales_tax = $discount_price * $sales_tax_rate;
    $sales_total = $discount_price + $sales_tax;
    
    $list_price_f = "$".number_format($list_price, 2);
    $discount_percent_f = $discount_percent."%";
    $discount_f = "$".number_format($discount, 2);
    $discount_price_f = "$".number_format($discount_price, 2);
    $sales_tax_rate_f = "$".number_format($sales_tax_rate, 2);
    $sales_tax_f = "$".number_format($sales_tax, 2);
    $sales_total_f = "$".number_format($sales_total, 2);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<main>
        <h1>Product Discount Calculator</h1>

        <!-- Display Error Messages (if any) -->
        <?php if (!empty($error_message)): ?>
            <div class="error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Display the Results if No Errors -->
        <?php if (empty($error_message) && $_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <label>Product Description:</label>
            <span><?php echo htmlspecialchars($product_description); ?></span><br>

            <label>List Price:</label>
            <span><?php echo $list_price_f; ?></span><br>

            <label>Discount Percent:</label>
            <span><?php echo $discount_percent_f; ?></span><br>

            <label>Discount Amount:</label>
            <span><?php echo $discount_f; ?></span><br>

            <label>Discount Price:</label>
            <span><?php echo $discount_price_f; ?></span><br>
            
            <label>Sales Tax:</label>
            <span><?php echo "8%"; ?></span><br>

            <label>Sales Tax Amount:</label>
            <span><?php echo $sales_tax_f; ?></span><br>

            <label>Total Cost:</label>
            <span><?php echo $sales_total_f; ?></span><br>
        <?php endif; ?>

    </main>
</body>
</html>