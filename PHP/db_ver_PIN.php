<?php
//http://localhost/db_ver_secA.php?MAC=abc
// array for JSON response
$result = array();

// check for required fields
if ( isset($_POST['MAC']) ) {

    $MAC = $_POST['MAC'];  
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	//userid
	$res0 = mysql_query("SELECT User_ID FROM `PHONE` WHERE MAC_Address = '$MAC';");  
	$row0 = mysql_fetch_array($res0);

	$User_ID = $row0["User_ID"];


	//secqid
	$res1 = mysql_query("SELECT Device_Name_ID FROM `USER` WHERE User_ID = '$User_ID';");  
	$row1 = mysql_fetch_array($res1);
    	//echo $row1["Question_1"];

	$Dev_Name_ID = $row1["Device_Name_ID"];


	//get ans query
	$res= mysql_query("SELECT PIN_Code FROM `DEVICE_NAME` WHERE Name_ID = '$Dev_Name_ID';");

	//conds
	if (!$Dev_Name_ID) {
    	echo "Could not successfully get id from user table" . mysql_error();
    	exit;
	}

	if (!$res) {
    	echo "Could not successfully run sec1, sec2 query from secq table" . mysql_error();
    	exit;
	}

	$row = mysql_fetch_array($res);

	//conds
	if( is_null( $row["PIN_Code"] ) )
	{
		$PIN= "Not Found A1!";
	}
	else
	{
		$PIN = $row["PIN_Code"];
	}


//final result
array_push($result,
	array
	(
		"PIN_Code" => $PIN
	) );	
}

header('Content-Type: application/json');


echo json_encode( array("result"=>$result) );

?>