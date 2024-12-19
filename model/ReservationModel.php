<?php

class ReservationModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function addReservation($firstName, $lastName, $email, $phoneNum, $checkInDate, $checkOutDate, $roomType) {
        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare("INSERT INTO elhadhra(firstName, lastName, email, phoneNum, checkInDate, checkOutDate, roomType) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssss', $firstName, $lastName, $email, $phoneNum, $checkInDate, $checkOutDate, $roomType);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
