<?php
//http://localhost/db_validate_phone_mac.php?MAC=C4:3A:BE:53:F5:D1
// array for JSON response
$result = array();

// check for required fields
if (isset($_GET['MAC'])) {

    $MAC = $_GET['MAC'];       
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	// mysql inserting a new rowwasa
	$result = mysql_query("SELECT MAC_Address FROM `PHONE` WHERE MAC_Address = '$MAC'");  

	if (!$result) {
    	echo "Could not successfully run query from DB: ";
    	exit;
	}

	//if (mysql_num_rows($result) == 0) {
    //	echo "No rows found, nothing to print so am exiting";
    //	exit;
	//}

	$row = mysql_fetch_array($result);
    echo $row["MAC_Address"];
	
}

header('Content-Type: application/json');

//echo json_encode(array("result"=>$row));

?>