<?php
	if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']))
	{
		// include Database connection file 
		include("db_connection.php");

		// get values 
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$buttonon = $_POST['buttonon'];
		$buttonoff = $_POST['buttonoff']; 
		$info = $_POST['info']; 
		$ptime = $_POST['ptime']; 
		

		$query = "INSERT INTO users(first_name, last_name, email, buttonon, buttonoff, info, times) VALUES('$first_name', '$last_name', '$email','$buttonon','$buttonoff','$info','$ptime')";
		if (!$result = mysqli_query($db, $query)) {
	        exit(mysqli_error());
	    }
	    echo "1 Record Added!";
	}
?>