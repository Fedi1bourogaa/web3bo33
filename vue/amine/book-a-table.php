<?php
// Include the config file to connect to the database
include 'C:\xampp\htdocs\web3bo33\model\config1.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize and assign form inputs to variables
    $firstName = mysqli_real_escape_string($conn, $_POST['name']);
    $lastName = ''; // Assuming you may want to ask for last name in the future, can be left empty for now
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($conn, $_POST['phone']);
    $checkInDate = mysqli_real_escape_string($conn, $_POST['check_in']);
    $checkOutDate = mysqli_real_escape_string($conn, $_POST['check_out']);
    $roomType = mysqli_real_escape_string($conn, $_POST['room_type']); // New field for room type

    // Insert the data into the reservation table
    $sql = "INSERT INTO reservation (firstName, lastName, email, phoneNum, checkInDate, checkOutDate, roomType)
            VALUES ('$firstName', '$lastName', '$email', '$phoneNum', '$checkInDate', '$checkOutDate', '$roomType')";

    // Execute query without redirection or alerts
    mysqli_query($conn, $sql);

    // Close the database connection
    mysqli_close($conn);
}
?>