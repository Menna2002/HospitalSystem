<?php 
include 'db_conn.php';

// Check if the username is set in the POST array
if(isset($_POST['username'])){
    // Fetching details of the patient based on the username provided
    $username = $_POST['username'];
    
    // Query to get patient details
    $get_p_id_query = "SELECT P_id, Fname, Lname FROM patient WHERE username ='$username'";
    $result = mysqli_query($conn, $get_p_id_query);
    
    // Check if any row is returned
    if(mysqli_num_rows($result) > 0) {
        // Fetch patient details
        $row = mysqli_fetch_assoc($result);
        $P_id = $row['P_id'];
        $Fname =$row['Fname'];
        $Lname =$row['Lname'];
        
        // Initialize variables for billing
        $days_stayed = 0;
        $room_price = 0;
        $total_treatment_price = 0;
        $appointment_price = 0;
        $total_bill = 0;
        
        // Get the entry date of the resident patient
        $get_entry_date_query = "SELECT entry_date FROM resident_patient WHERE RP_id = '$P_id'";
        $result_entry_date = mysqli_query($conn, $get_entry_date_query);
        if(mysqli_num_rows($result_entry_date) > 0) {
            $row_entry_date = mysqli_fetch_assoc($result_entry_date);
            $current_date = date('Y-m-d'); // Current date in Y-m-d format
            $entry_date = $row_entry_date['entry_date'];        
            $entry_date_only = date('Y-m-d', strtotime($entry_date)); // Extract the date part from the entry date
            $days_stayed = floor((strtotime($current_date) - strtotime($entry_date_only)) / (60 * 60 * 24)); // Calculate the difference in days
        }
        
        // Get the room price
        $get_room_price_query = "SELECT room_price FROM room WHERE num IN (SELECT RoomNum FROM resident_patient WHERE RP_id = '$P_id')";
        $result_room_price = mysqli_query($conn, $get_room_price_query);
        if(mysqli_num_rows($result_room_price) > 0) {
            $row_room_price = mysqli_fetch_assoc($result_room_price);
            $room_price = $row_room_price['room_price'];
        }
        
        // Get the treatment prices
        $get_treatment_price_query = "SELECT SUM(price) AS total_price FROM treatment WHERE P_id = '$P_id'";
        $result_treatment_price = mysqli_query($conn, $get_treatment_price_query);
        if(mysqli_num_rows($result_treatment_price) > 0) {
            $row_treatment_price = mysqli_fetch_assoc($result_treatment_price);
            $total_treatment_price = $row_treatment_price['total_price'];
        }
        
        // Check if the patient has an appointment
        $check_appointment_query = "SELECT * FROM app_patient WHERE AP_id = '$P_id'";
        $result_appointment = mysqli_query($conn, $check_appointment_query);
        if(mysqli_num_rows($result_appointment) > 0) {
            // If patient has an appointment, add $50 to total bill
            $appointment_price = 50;
        }
        
        // Calculate the total bill amount including room price, treatment prices, and appointment price
        $total_bill = ($days_stayed * $room_price) + $total_treatment_price + $appointment_price;
    } else {
        // Redirect if user not found
        header("Location: checkout.php?error=User not found");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="./img/hospital-building.ico" type="image/x-icon">
    <title>Bill</title>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="card text-center m-3" style="width: 18rem;">
        <div class="card-body">
            <i class="bx bxs-user-minus mb-3" style="font-size: 3em;"></i>
            <h6>Bill for patient <?=$Fname ?? ''?> <?=$Lname ?? ''?> </h6>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                <?=$_GET['error']?>
			</div>
			<?php } ?>
            <?php if (isset($_GET['alert'])) { ?>
                <div class="alert alert-success" role="alert">
                <?=$_GET['alert']?>
			</div>
			<?php } ?>
            <div class="m-3">
                <a href="home.php" class="btn btn-outline-primary">Return Home</a>
            </div>
            <div class="mb-3">
                <p>Days Stayed: <?=$days_stayed ?? '' ?></p>
                <p>Room Price: $<?=$room_price ?? ''?></p>
                <p>Treatment Price: $<?=$total_treatment_price ?? ''?></p>
                <p>Appointment Price: $<?=$appointment_price ?? ''?></p>
                <p>Total Bill: $<?=$total_bill ?? '' ?></p>
            </div>
            <form action="payment.php" method="post">
                <input type="hidden" name="username" value="<?= $username ?>">
                <div class="container d-flex justify-content-center">
                    <button type="submit" class="btn btn-outline-success">Confirm Payment</button>
                </div>        
            </form>
        </div>
    </div>
</div>
</body>
</html>
