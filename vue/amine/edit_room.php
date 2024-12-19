<?php
include('config1.php');

// Check if the room ID is provided in the query string
if (isset($_GET['idRoom'])) {
    $room_id = $_GET['idRoom'];

    // Fetch the current room details
    $query = "SELECT * FROM room WHERE idRoom = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
    } else {
        echo "Room not found!";
        exit;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_num = $_POST['room_num'];
    $room_type = $_POST['room_type'];
    $room_status = $_POST['room_status'];
    $id_res = $_POST['id_res'];

    // Update the room details
    $update_query = "UPDATE room SET roomNum = ?, type = ?, status = ?, idRes = ? WHERE idRoom = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssii", $room_num, $room_type, $room_status, $id_res, $room_id);

    if ($update_stmt->execute()) {
        header("Location: room.php");
        exit;
    } else {
        echo "Error updating room: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Room</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
</head>
<body>
<div class="container">
    <h2>Edit Room</h2>
    <form method="POST">
        <div class="form-group">
            <label>Room Number</label>
            <input type="text" name="room_num" value="<?php echo $room['roomNum']; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Room Type</label>
            <select name="room_type" class="form-control" required>
                <option value="SIMPLE" <?php if ($room['type'] == 'SIMPLE') echo 'selected'; ?>>SIMPLE</option>
                <option value="DOUBLE" <?php if ($room['type'] == 'DOUBLE') echo 'selected'; ?>>DOUBLE</option>
                <option value="TRIPLE" <?php if ($room['type'] == 'TRIPLE') echo 'selected'; ?>>TRIPLE</option>
            </select>
        </div>
        <div class="form-group">
            <label>Room Status</label>
            <input type="text" name="room_status" value="<?php echo $room['status']; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Reservation ID</label>
            <input type="text" name="id_res" value="<?php echo $room['idRes']; ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Room</button>
        <a href="room.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
