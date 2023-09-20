<?php
require_once 'includes/db.php';

function hideCreditCardNumber($cardNumber) {
    if ($cardNumber === null) {
        return 'N/A'; // Handle the case when the card number is null
    }

    $length = strlen($cardNumber);
    $hiddenPart = str_repeat('*', max($length - 4, 0)); // Ensure $times is not negative
    $visiblePart = substr($cardNumber, -4);

    return $hiddenPart . $visiblePart;
}

session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    echo '<script src="js/not_logged_in.js">
        </script>';
    //header("Location: index.php");
    exit();
}

// Ensure that the session variables are set correctly
$user_id = $_SESSION['user_id'];

// Fetch the user's credit card details from the database
$stmt = $conn->prepare("SELECT card_number, valid_till FROM credit_cards WHERE user_id = ?");
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
if (!$stmt->bind_param("i", $user_id)) {
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
}
$stmt->execute();
$result = $stmt->get_result();
$card = $result->fetch_assoc();
$stmt->close();

// Check if a card record was found for the user
if ($card) {
    $card_number = $card['card_number'];
    $valid_till = $card['valid_till'];
} else {
    // Handle the case where no card record was found
    $card_number = "No card on record";
    $valid_till = "N/A";
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/hover.css">
    <link rel="stylesheet" href="css/links.css">
</head>
<body>
    <center><h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1><br>
    <h2>Your Credit Card Details:</h2>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Credit Card Details</title>
    <link rel="stylesheet" href="css/creditcard.css">
    <link rel="stylesheet" href="css/hover.css">
    <link rel="stylesheet" href="css/links.css">
</head>
<body>
    <div class="container">
        <header>
            <span class="logo">
                <img src="images/mastercard.jpg" alt="" />
                <h5>Master Card</h5>
            </span>
            <img src="images/chip.jpg" alt="" class="chip" />
        </header>

        <div class="card-details">
            <div class="name-number">
                <h6>Card Number</h6>
                <h5 class="number"><?php echo $card_number; ?></h5>
                <h5 class="name"><?php echo $_SESSION['username']; ?></h5>
            </div>
            <div class="valid-date">
                <h6>Valid Till</h6>
                <h5><?php echo $valid_till; ?></h5>
            </div>
        </div>
    </div>
</body>
</html>



    <button class="hover-button"><a href="logout.php">Logout</a></button>

</body>
</html>
