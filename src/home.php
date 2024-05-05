<?php 
session_start();
include "db_conn.php";
if (isset($_SESSION['username']) && isset($_SESSION['s_id']) ) {   ?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="./img/hospital-building.ico" type="image/x-icon"></head>
<body>
    <div class="container d-flex justify-content-center align-items-center"style="min-height: 45vh">
        <?php if ($_SESSION['role'] == 'admin' && $_SESSION['AcessData'] == 'Y') {?>
        <!-- For Admin -->
        <div class="card" style="width: 18rem;">
			<div class="card-body text-center">
                <i class='bx bx-user' style='font-size: 5em;'></i>
                <h5 class="card-title">
                <?=$_SESSION['role']?>: <?=$_SESSION['Fname']?>  <?=$_SESSION['Lname']?>
                </h5>
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
			</div>
		</div>
			<div class="p-3">
				<?php include 'staff.php';
                if (mysqli_num_rows($res) > 0) {?>
				<h1 class="display-4 fs-1">Staff</h1>
				<table class="table" style="width: 32rem;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Position</th>
                    </tr>
				</thead>
                <tbody>
				<?php 
				$i =1;
				while ($rows = mysqli_fetch_assoc($res)) {?>
                    <tr>
                        <th scope="row"><?=$i?></th>
                        <td><?=$rows['Fname']?></td>
                        <td><?=$rows['Lname']?></td>
                        <td><?=$rows['Position']?></td>
                    </tr>
				<?php $i++; }?>
			</tbody>
				</table>
				<?php }?>
			</div>
    </div>
    <div class="container d-flex justify-content-center align-items-center"style="min-height: 45vh">
        <div class="card text-center" style="width: 18rem;">
        <i class="bx bxs-user-minus mb-3" style="font-size: 5em;"></i>
			<div class="card-body">
                <h5 class="card-title">Bill creation</h5>
                <a href="checkout.php" class="btn btn-outline-success">checkout</a>
			</div>
        </div>
    </div>
    
    <div class="container d-flex justify-content-center align-items-center"style="min-height: 100vh">
        <?php }elseif ($_SESSION['role'] == 'user') {
                    // For Doctors
                    ?>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <?=$_SESSION['role']?>: <?=$_SESSION['Fname']?> <?=$_SESSION['Lname']?>
                            </h5>
                            <a href="logout.php" class="btn btn-dark">Logout</a>
                        </div>
                    </div>

                    <!-- Display assigned patients and their rooms for doctors -->
                    <div class="p-3">
                        <?php
                        // Fetch doctor's assigned patients
                        $doctor_id = $_SESSION['s_id'];
                        $patients_query = "SELECT * FROM resident_patient WHERE d_id = $doctor_id";
                        $patients_result = mysqli_query($conn, $patients_query);
                        
                        if (mysqli_num_rows($patients_result) > 0) {
                            ?>
                            <h1 class="display-4 fs-1">Your Assigned Patients</h1>
                            <table class="table" style="width: 32rem;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Patient</th>
                                        <th scope="col">Room Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    while ($patient_row = mysqli_fetch_assoc($patients_result)) {
                                        // Fetch patient's room information
                                        $patient_id = $patient_row['RP_id'];
                                        $room_query = "SELECT * FROM resident_patient WHERE RP_id = '$patient_id' ";
                                        $room_result = mysqli_query($conn, $room_query);
                                        $room_row = mysqli_fetch_assoc($room_result);
                                        ?>
                                        <tr>
                                            <?php 
                                            // SQL query to retrieve first names from the Patient table
                                            $sql = "SELECT Fname FROM patient WHERE p_id = '$patient_id'";
                                            // Execute the query
                                            $result = mysqli_query($conn, $sql);
                                            $name_row = mysqli_fetch_assoc($result);
                                            ?>
                                            <th scope="row"><?=$i?></th>
                                            <td><?=$name_row['Fname']?></td>
                                            <td><?=$room_row['RoomNum']?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            echo "You have no assigned patients.";
                        }
                        ?>
                    </div>
                <?php 
                } else {
                    // Redirect to the login page if the user is neither an admin nor a doctor
                    header("Location: index.php");
                } 
                ?>
    </div>
</body>
</html>
<?php }else{
	header("Location: index.php");
} ?>