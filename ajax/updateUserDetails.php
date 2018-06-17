<?php
// include Database connection file
include("db_connection.php");

// check request
if(isset($_POST))
{
    // get values
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $buttonon = $_POST['buttonon']; 
    $buttonoff = $_POST['buttonoff']; 
    $info = $_POST['info']; 
    $ptime = $_POST['ptime']; 

    // Updaste User details
    $query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', buttonon = '$buttonon', buttonoff= '$buttonoff',info= '$info',times= '$ptime' WHERE id = '$id'";
    if (!$result = mysqli_query($db,$query)) {
        exit(mysqli_error());
    }
}