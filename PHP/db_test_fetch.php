<?php

// array for JSON response
$result = array();

// check for required fields
if (isset($_GET['Email'])) {

    $Email = $_GET['Email'];       
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	// mysql inserting a new rowwasa
	$sql_query = sprintf("SELECT Email_Address FROM PASSWORDS WHERE Email_Address = %s", $Email ); 
	$res = mysqli_query($db->connection, $sql_query);  


	while($row = mysqli_fetch_array($res)){                 
	array_push($result,
		array(
		'Email'=>$row[0]
		));
	}		
}

header('Content-Type: application/json');

echo json_encode(array("result"=>$result));

?>