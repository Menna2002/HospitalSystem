<?php 
    session_start();
    include "db_conn.php";
    if (!isset($_SESSION['username']) && !isset($_SESSION['s_id'])) {   ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="./img/hospital-building.ico" type="image/x-icon">
    <title>Home</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center"
    style="min-height: 100vh">
        <form class="border shadow p-3 rounded" action="check_login.php" method="post" style="width: 450px;">
            <h1 class="text-center p-3">LOGIN</h1>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                <?=$_GET['error']?>
			</div>
			<?php } ?>
		<div class="mb-3">
            <label for="username"class="form-label">User name</label>
            <input type="text" class="form-control" name="username" id="username" required>
		</div>
		<div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
		</div>
		<div class="mb-1">
            <label class="form-label">Select User Type:</label>
		</div>
		<select class="form-select mb-3" name="role" aria-label="Default select example" required>
			<option selected value="user">User</option>
			<option value="admin">Admin</option>
		</select>
		<button type="submit" class="btn btn-primary">LOGIN</button>
		</form>
    </div>
</body>
</html>
<?php }else{
	header("Location: home.php");
} ?>