<?php

$con=mysqli_connect("woolimdb.cwrhgdxss63r.us-east-1.rds.amazonaws.com", "jiyeonoh", "dhdh8520", "woolimdb");

if(mysqli_connect_errno($con)) {

    echo "Failed to connect to MySQL : " . mysqli_connect_error();
}

mysqli_set_charset($con,"utf8");

$res = mysqli_query($con, "select * from users");

$result = array();

while($row = mysqli_fetch_array($res)) {
    array_push($result, array('first_name'=>$row[1], 'last_name'=>$row[2], 'info'=>$row[6], 'times'=>$row[7]));
}

echo json_encode(array("result"=>$result));

mysqli_close($con);

?>
