<?php

// Connection variables 
$host = "woolimdb.cwrhgdxss63r.us-east-1.rds.amazonaws.com"; // MySQL host name eg. localhost
$user = "jiyeonoh"; // MySQL user. eg. root ( if your on localserver)
$password = "dhdh8520"; // MySQL user password  (if password is not set for your root user then keep it empty )
$database = "woolimdb"; // MySQL Database name




// Connect to MySQL Database 
$db = mysqli_connect($host, $user, $password) or die("Could not connect to database");

// Select MySQL Database 
mysqli_select_db($db, $database);

?>