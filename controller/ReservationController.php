<?php
class ReservationController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $date = $_POST['date'] ?? '';
            $time = $_POST['time'] ?? '';
            $guests = $_POST['guests'] ?? '';

            if ($this->model->makeReservation($name, $email, $date, $time, $guests)) {
                include '../vue/reservation.php';
            }
        } else {
            include '../vue/reservation.php';
        }
    }
}
?>