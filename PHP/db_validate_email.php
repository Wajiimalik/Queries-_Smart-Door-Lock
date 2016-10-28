<?php
//http://localhost/db_validate_email.php?Email=h@g.com
// array for JSON response
//$result = array();

// check for required fields
if (isset($_GET['Email'])) {

    $Email = $_GET['Email'];       
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	// mysql inserting a new rowwasa
	$result = mysql_query("SELECT Email_Address FROM `PASSWORDS` WHERE Email_Address = '$Email';");  

	if (!$result) {
    	echo "Could not successfully run query from DB: " . mysql_error();
    	exit;
	}

	//if (mysql_num_rows($result) == 0) {
    //	echo "No rows found, nothing to print so am exiting";
    //	exit;
	//}

	$row = mysql_fetch_array($result);
    echo $row["Email_Address"];

    if ($row["Email_Address"] <> $Email) {
    	echo "Not found!";
    	exit;
	}
	
}

header('Content-Type: application/json');

//echo json_encode(array("result"=>$row));

?>