<?php
session_start();
include "db_conn.php";

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($username)) {
        header("Location: ../index.php?error=User Name is Required");
        exit();
    } elseif (empty($password)) {
        header("Location: ../index.php?error=Password is Required");
        exit();
    } else {
        // Hashing the password
        $password_hashed = md5($password);

        $sql = "SELECT * FROM staff WHERE username='$username' AND password='$password_hashed'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['s_id'] = $row['s_id'];
            $_SESSION['Fname'] = $row['Fname'];
            $_SESSION['Lname'] = $row['Lname'];
            $_SESSION['role'] = $role;
            $_SESSION['AcessData'] = $row['AcessData'];
            
            header("Location: home.php");
            exit();
        } else {
            header("Location: index.php?error=Incorrect Username or Password");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
