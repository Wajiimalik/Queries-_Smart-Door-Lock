<?php

// array for JSON response
$result = array();

// check for required fields
if (isset($_GET['Name_Id'])) {

    $Name_Id_Door = $_GET['Name_Id'];       
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	// mysql inserting a new rowwasa
	$sql_query = sprintf("select Name_Id, Name, Description, PIN_Code from device_name where Name_Id = %s", $Name_Id_Door ); 
	$res = mysqli_query($db->connection, $sql_query);  


	while($row = mysqli_fetch_array($res)){                 
	array_push($result,
		array(
		'id'=>$row[0],
		'name'=>$row[1],
		'description'=>$row[2],
		'pin_code'=>$row[3]

		));
	}		
}


header('Content-Type: application/json');

echo json_encode(array("result"=>$result));

?>