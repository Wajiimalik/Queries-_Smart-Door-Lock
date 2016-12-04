<?php
//http://localhost/db_validate_alt_email.php?AltEmail=g@g.com
// array for JSON response
$result = array();

// check for required fields
if (isset($_POST['AltEmail'])) {

    $AltEmail = $_POST['AltEmail'];       
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	// mysql inserting a new rowwasa
	$result = mysql_query("SELECT Alt_Email_Address FROM `PASSWORDS` WHERE Alt_Email_Address = '$AltEmail'");  

	if (!$result) {
    	echo "Could not successfully run query from DB: " . mysql_error();
    	exit;
	}
	
	//if (mysql_num_rows($result) == 0) {
    //	echo "No rows found, nothing to print so am exiting";
    //	exit;
	//}

	$row = mysql_fetch_array($result);
    echo $row["Alt_Email_Address"];

    if ($row["Alt_Email_Address"] <> $AltEmail) {
    	echo "Not found!";
    	exit;
	}
	
}

header('Content-Type: application/json');

//echo json_encode(array("result"=>$row));

?>