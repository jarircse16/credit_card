<?php

function isCreditCardValid($creditCardNumber) {
    // Remove spaces and non-digit characters from the card number
    $creditCardNumber = preg_replace('/\D/', '', $creditCardNumber);

    // Check if the card number is a valid length (typically 13 to 19 digits)
    $cardLength = strlen($creditCardNumber);
    if ($cardLength < 13 || $cardLength > 19) {
        return false;
    }

    // Reverse the card number
    $creditCardNumberReversed = strrev($creditCardNumber);

    // Initialize variables for the Luhn algorithm
    $sum = 0;
    $double = false;

    // Iterate through each digit of the reversed card number
    for ($i = 0; $i < $cardLength; $i++) {
        $digit = (int)$creditCardNumberReversed[$i];

        // Double every second digit
        if ($double) {
            $digit *= 2;

            // If the doubled digit is greater than 9, subtract 9
            if ($digit > 9) {
                $digit -= 9;
            }
        }

        // Add the digit to the sum
        $sum += $digit;

        // Toggle the "double" flag for the next iteration
        $double = !$double;
    }

    // Check if the sum is divisible by 10 (valid Luhn checksum)
    return ($sum % 10 === 0);
}

// Initialize variables
$creditCardNumber = "";
$validityMessage = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $creditCardNumber = $_POST["credit_card_number"];

    // Perform the credit card validity check
    if (isCreditCardValid($creditCardNumber)) {
        $validityMessage = "Credit card is potentially valid.";
    } else {
        $validityMessage = "Credit card is not valid.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Credit Card Validity Check</title>
    <link rel="stylesheet" href="css/hover.css">
    <link rel="stylesheet" href="css/links.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <center><h1>Credit Card Validity Check</h1>
    <form method="post">
        <label for="credit_card_number">Enter Credit Card Number:</label>
        <input type="text" id="credit_card_number" name="credit_card_number" value="<?php echo $creditCardNumber; ?>" required>
        <br><br>
        <button type="submit" class="hover-button" value="Check Validity">Check Validity</button><br><br>
        <button class="hover-button""><a href="index.php">Back to Login</button>
    </form>
    <p><?php echo $validityMessage; ?></p>
</body>
</html>
