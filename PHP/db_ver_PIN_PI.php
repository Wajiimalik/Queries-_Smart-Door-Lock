<?php
//http://localhost/db_ver_PIN_PI.php?MAC=C4:3A:BE:53:F5:D1&PIN=1313

// check for required fields
if ( isset($_GET['MAC']) && isset($_GET['PIN']) ) {

    $MAC = $_GET['MAC'];  
    $IN_PIN = $_GET['PIN'];  
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	//userid
	$res0 = mysql_query("SELECT User_ID FROM `PHONE` WHERE MAC_Address = '$MAC';");  
	$row0 = mysql_fetch_array($res0);

	$User_ID = $row0["User_ID"];


	//devnameid
	$res1 = mysql_query("SELECT Device_Name_ID FROM `USER` WHERE User_ID = '$User_ID';");  
	$row1 = mysql_fetch_array($res1);
    	//echo $row1["Question_1"];

	$Dev_Name_ID = $row1["Device_Name_ID"];


	//fianlly getting pin
	$res= mysql_query("SELECT PIN_Code FROM `DEVICE_NAME` WHERE Name_ID = '$Dev_Name_ID';");

	//conds
	if (!$Dev_Name_ID) {
    	echo "Could not successfully get id from user table" . mysql_error();
    	exit;
	}

	if (!$res) {
    	echo "Could not successfully run pin code query" . mysql_error();
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

	if($PIN == $IN_PIN)
	{
		$result=1;
	}
	else
	{
		$result=0;
	}
	echo $result;
}

?>