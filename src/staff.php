<?php  

if (isset($_SESSION['username']) && isset($_SESSION['s_id'])) {
    
    $sql = 'SELECT Fname, Lname, Position FROM staff_position WHERE Position NOT LIKE "Admin" COLLATE utf8mb4_unicode_ci';
    $res = mysqli_query($conn, $sql);
}else{
	header("Location: index.php");
} 