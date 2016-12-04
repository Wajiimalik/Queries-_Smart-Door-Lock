<?php
//http://localhost/db_Status_Tab.php?MAC=C4:3A:BE:53:F5:D1
// array for JSON response
$result = array();

// check for required fields
if ( isset($_POST['MAC']) ) {

    $MAC = $_POST['MAC'];  
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	//doorstatus
	$res = mysql_query("SELECT Status FROM `DEVICE`;");  
	$row = mysql_fetch_array($res);

	$Door_Status = $row["Status"];

	

	if (!$res) {
    	echo "Could not successfully run status door query from dev table" . mysql_error();
    	exit;
	}

	array_push($result,
		array
		(
			"Status" => $Door_Status
		) );

}
header('Content-Type: application/json');


echo json_encode( array("result"=>$result) );

?>