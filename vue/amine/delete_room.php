<?php
include('config1.php');

// Check if the room ID is provided
if (isset($_GET['idRoom'])) {
    $room_id = $_GET['idRoom'];

    // Validate the room ID
    if (!is_numeric($room_id)) {
        echo "Invalid room ID!";
        exit;
    }

    // Delete the room from the database
    $delete_query = "DELETE FROM room WHERE idRoom = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $room_id);

    if ($stmt->execute()) {
        header("Location: room.php");
        exit;
    } else {
        echo "Error deleting room: " . $stmt->error;
    }
} else {
    echo "No room ID provided!";
}
?>
