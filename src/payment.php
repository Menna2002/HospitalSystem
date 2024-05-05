<?php
include 'db_conn.php';

if(isset($_POST['username'])){
    $username = $_POST['username'];
    
    // Get patient ID
    $get_p_id_query = "SELECT P_id FROM patient WHERE username ='$username'";
    $result = mysqli_query($conn, $get_p_id_query);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $P_id = $row['P_id'];
        
        // Check if a bill already exists for the patient
        $check_existing_bill_query = "SELECT * FROM bill WHERE P_id = '$P_id'";
        $result_existing_bill = mysqli_query($conn, $check_existing_bill_query);
        if(mysqli_num_rows($result_existing_bill) == 0) {
            // If no bill exists, insert a new bill record with placeholders for total amount and checkout date
            $insert_bill_query = "INSERT INTO bill (P_id, total_amount, checkout_date) VALUES ('$P_id', 0, NULL)";
            if(mysqli_query($conn, $insert_bill_query)) {
                // Get the newly inserted bill ID
                $new_bill_id = mysqli_insert_id($conn);
            } else {
                // Handle error if bill insertion fails
                header("Location: bill.php?error=Failed to create new bill");
                exit();
            }
        } else {
            // If bill already exists, fetch the bill ID
            $row_existing_bill = mysqli_fetch_assoc($result_existing_bill);
            $new_bill_id = $row_existing_bill['b_id'];
        }
        
        // Calculate days stayed
        $current_date = date('Y-m-d');
        $get_entry_date_query = "SELECT entry_date FROM resident_patient WHERE RP_id = '$P_id'";
        $result_entry_date = mysqli_query($conn, $get_entry_date_query);
        if(mysqli_num_rows($result_entry_date) > 0) {
            $row_entry_date = mysqli_fetch_assoc($result_entry_date);
            $entry_date = $row_entry_date['entry_date'];        
            $days_stayed = floor((strtotime($current_date) - strtotime($entry_date)) / (60 * 60 * 24));
        } 
        
        // Get room price
        $get_room_price_query = "SELECT room_price FROM room WHERE num IN (SELECT RoomNum FROM resident_patient WHERE RP_id = '$P_id')";
        $result_room_price = mysqli_query($conn, $get_room_price_query);
        if(mysqli_num_rows($result_room_price) > 0) {
            $row_room_price = mysqli_fetch_assoc($result_room_price);
            $room_price = $row_room_price['room_price'];
        }
        
        // Calculate total room price
        $total_room_price = $days_stayed * $room_price;
        
        // Get total treatment price
        $get_total_treatment_price_query = "SELECT SUM(price) AS total_price FROM treatment WHERE P_id = '$P_id'";
        $result_total_treatment_price = mysqli_query($conn, $get_total_treatment_price_query);
        $row_total_treatment_price = mysqli_fetch_assoc($result_total_treatment_price);
        $total_treatment_price = $row_total_treatment_price['total_price'];
        
        // Check if the patient has an appointment
        $appointment_price = 0;
        $check_appointment_query = "SELECT * FROM app_patient WHERE AP_id = '$P_id'";
        $result_appointment = mysqli_query($conn, $check_appointment_query);
        if(mysqli_num_rows($result_appointment) > 0) {
            // If patient has an appointment, add $50 to total bill
            $appointment_price = 50;
        }
        
        // Calculate the total bill amount including room price, treatment prices, and appointment price
        $total_bill = $total_room_price + $total_treatment_price + $appointment_price;
        
        // Update bill total amount and checkout date
        $checkout_date = date('Y-m-d H:i:s');
        $update_bill_query = "UPDATE bill SET total_amount = '$total_bill', checkout_date = '$checkout_date' WHERE b_id = '$new_bill_id' AND checkout_date IS NULL";
        if(mysqli_query($conn, $update_bill_query)) {
            // Update leave date and availability in resident_patient
            $update_res_patient_query = "UPDATE resident_patient SET leave_date = '$checkout_date' WHERE RP_id = '$P_id'";
            mysqli_query($conn, $update_res_patient_query);
            
            // Update room availability and reset nurse and doctor IDs
            $update_room_query = "UPDATE room SET availability = 'Y', n_id = NULL, w_id = NULL WHERE num IN (SELECT RoomNum FROM resident_patient WHERE RP_id = '$P_id')";
            mysqli_query($conn, $update_room_query);
            
            // Redirect with success message
            header('Location: bill.php?alert=Payment completed successfully');
            exit();
        } else {
            // Handle error if bill update fails
            header("Location: bill.php?error=Failed to update bill");
            exit();
        }
    } else {
        // Handle error if patient ID not found
        header("Location: bill.php?error=Patient ID not found");
        exit();
    }
} else {
    // Handle error if username not set
    header("Location: bill.php?error=Username not provided");
    exit();
}
?>
