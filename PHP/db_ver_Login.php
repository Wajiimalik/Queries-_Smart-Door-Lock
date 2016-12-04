<?php
//http://localhost/db_ver_Login.php?MAC=C4:3A:BE:53:F5:D1
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


	//pwid
	$res1 = mysql_query("SELECT Password_ID FROM `USER` WHERE User_ID = '$User_ID';");  
	$row1 = mysql_fetch_array($res1);
    	//echo $row1["Question_1"];

	$Password_ID = $row1["Password_ID"];


	//get ans query
	$res= mysql_query("SELECT Email_Address, Username, PW FROM `PASSWORDS` WHERE Password_ID = '$Password_ID';");

	//conds
	if (!$Password_ID) {
    	echo "Could not successfully get id from pw table" . mysql_error();
    	exit;
	}

	if (!$res) {
    	echo "Could not successfully run login query from pw table" . mysql_error();
    	exit;
	}

	$row = mysql_fetch_array($res);

	//conds
	if( is_null( $row["Email_Address"] ) )
	{
		$Email = "Not Found Email!";
	}
	else
	{
		$Email = $row["Email_Address"];
	}

	if( is_null( $row["Username"] ) )
	{
		$Username = "Not Found Username!";
	}
	else
	{
		$Username = $row["Username"];
	}

	if( is_null( $row["PW"] ) )
	{
		$PW = "Not Found PW!";
	}
	else
	{
		$PW = $row["PW"];
	}


//final result
array_push($result,
	array
	(
		"Email_Address" => $Email,
		"Username" => $Username,
		"PW" => $PW
	) );	
}

header('Content-Type: application/json');


echo json_encode( array("result"=>$result) );

?>