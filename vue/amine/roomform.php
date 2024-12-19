<?php
// Include the config file to connect to the database
include('config1.php');

// Initialize error array
$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize and assign form inputs to variables
    $roomNum = mysqli_real_escape_string($conn, $_POST['room_num']);
    $roomType = mysqli_real_escape_string($conn, $_POST['room_type']);
    $roomStatus = mysqli_real_escape_string($conn, $_POST['room_status']);
    $reservationId = mysqli_real_escape_string($conn, $_POST['id_res']); // Assuming idRes is also being sent in the form

    // Validate inputs
    if (empty($roomNum)) {
        $errors[] = "Le numéro de la chambre est obligatoire.";
    } elseif (!is_numeric($roomNum) || $roomNum <= 0) {
        $errors[] = "Le numéro de la chambre doit être un nombre positif.";
    }

    if (empty($roomType)) {
        $errors[] = "Le type de chambre est obligatoire.";
    }

    if (empty($roomStatus)) {
        $errors[] = "Le statut de la chambre est obligatoire.";
    } elseif (!in_array($roomStatus, ['1', '0'])) {
        $errors[] = "Le statut de la chambre doit être 'libre (1)', 'occupé (0)'.";
    }

    if (empty($reservationId)) {
        $errors[] = "L'ID de réservation est obligatoire.";
    } elseif (!is_numeric($reservationId)) {
        $errors[] = "L'ID de réservation doit être un nombre.";
    }

    // If there are no errors, proceed with database operations
    if (empty($errors)) {
        // Start a transaction to ensure consistent database updates
        mysqli_begin_transaction($conn);

        try {
            // Insert the room data
            $sql_room = "INSERT INTO room(roomNum, type, status, idRes)
                         VALUES ('$roomNum', '$roomType', '$roomStatus', '$reservationId')";
            mysqli_query($conn, $sql_room);

            // Commit the transaction
            mysqli_commit($conn);

            // Optionally close the connection
            mysqli_close($conn);

            // Success message
            header('Location: room.php');
            exit();
        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            mysqli_rollback($conn);

            // Log the error for debugging
            error_log("Database error: " . $e->getMessage());

            // Redirect with error message
            header('Location: room.php?error=1');
            exit();
        }
    }
}
?>

<!-- Display errors in the form -->
<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li style="color: red;"><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
