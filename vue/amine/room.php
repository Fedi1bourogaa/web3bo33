<?php 
include('roomform.php');
include('config1.php');


?> 					 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SUNRISE HOTEL</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://localhost/web3bo33/vue/backoffice">MAIN MENU </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="active-menu" href="room.php"><i class="fa fa-pencil-square-o"></i> Room Management</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">ADD ROOM</h1>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Add Room</div>
                            <div class="panel-body">
                                <form method="POST" action="roomform.php">
                                    <input type="text" name="room_num" placeholder="Room Number" required>
                                    <select name="room_type" required>
                                        <option value="SIMPLE">SIMPLE</option>
                                        <option value="DOUBLE">DOUBLE</option>
                                        <option value="TRIPLE">TRIPLE</option>
                                    </select>
                                    <input type="text" name="room_status" placeholder="Room Status" required>
                                    <input type="text" name="id_res" placeholder="Reservation ID" required>
                                    <button type="submit">Add Room</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Feature -->
                <div class="row">
                    <div class="col-md-12">
                        <form method="GET" action="room.php" class="form-inline">
                            <div class="form-group">
                                <input type="text" name="search_room" class="form-control" placeholder="Search by Room Number">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
                <br>

                <!-- Display all rooms -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Room List</div>
                            <div class="panel-body">
                                <?php
                                $search_condition = "";
                                if (isset($_GET['search_room']) && !empty($_GET['search_room'])) {
                                    $search_room = mysqli_real_escape_string($conn, $_GET['search_room']);
                                    $search_condition = "WHERE room.roomNum LIKE '%$search_room%'";
                                }

                                $query = "
                                    SELECT room.idRoom, room.roomNum, room.type, room.status, room.idRes, reservation.firstName 
                                    FROM room 
                                    LEFT JOIN reservation ON room.idRes = reservation.idRes
                                    $search_condition";
                                $result = mysqli_query($conn, $query);

                                if (!$result) {
                                    die("Query failed: " . mysqli_error($conn));
                                }

                                if (mysqli_num_rows($result) > 0): ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Room Number</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Reservation ID</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['roomNum'] . "</td>";
                                                echo "<td>" . $row['type'] . "</td>";
                                                echo "<td>" . $row['status'] . "</td>";
                                                echo "<td>" . ($row['firstName'] ?? 'No Reservation') . "</td>";
                                                echo "<td>
                                                        <a href='edit_room.php?idRoom=" . $row['idRoom'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                                        <a href='delete_room.php?idRoom=" . $row['idRoom'] . "' class='btn btn-danger btn-sm'>Delete</a>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No rooms found matching the search criteria.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
</body>
</html>
