<?php
require("includes/common.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['e-mail'];
    $password = $_POST['password'];

    // Debugging: Displaying the received email and password
    echo "Received Email: $email<br>";
    echo "Received Password: $password<br>";

    // Basic validation to check if email and password are not empty
    if (empty($email) || empty($password)) {
        echo "Email or Password is empty<br>";
        header('location: login.php?error=Email and Password are required');
        exit();
    }

    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);
    $password = MD5($password);

    // Debugging: Displaying sanitized email and hashed password
    echo "Sanitized Email: $email<br>";
    echo "Hashed Password: $password<br>";

    // Check the database for the email and password
    $query = "SELECT id, email FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($con));
    }

    $num = mysqli_num_rows($result);

    // Debugging: Displaying number of rows found
    echo "Number of rows found: $num<br>";

    if ($num == 0) {
        $error = "<span class='red'>Please enter correct E-mail id and Password</span>";
        echo $error;
        // Commenting out the header redirect for debugging purposes
        // header('location: login.php?error=' . urlencode($error));
    } else {
        $row = mysqli_fetch_array($result);
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_id'] = $row['id'];

        // Debugging: Displaying session variables
        echo "Session variables set:<br>";
        echo "Email: " . $_SESSION['email'] . "<br>";
        echo "User ID: " . $_SESSION['user_id'] . "<br>";

        // Commenting out the header redirect for debugging purposes
         header('location: products.php');
    }
} else {
    header('location: login.php');
}
?>


