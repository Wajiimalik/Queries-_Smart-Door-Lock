<?php
//http://localhost/db_ver_secQ.php?MAC=abc

// array for JSON response
$result = array();

// check for required fields
if ( isset($_GET['MAC']) ) {

    $MAC = $_GET['MAC']; 
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	//userid
	$res0 = mysql_query("SELECT User_ID FROM `PHONE` WHERE MAC_Address = '$MAC';");  
	$row0 = mysql_fetch_array($res0);

	$User_ID = $row0["User_ID"];

	//secqid
	$res1 = mysql_query("SELECT Sec_Ques_ID FROM `USER` WHERE User_ID = '$User_ID';");  
	$row1 = mysql_fetch_array($res1);

	$SecQ_ID = $row1["Sec_Ques_ID"];

	//get qs query
	$res= mysql_query("SELECT Question_1, Question_2 FROM `SECURITY_QUESTION` WHERE Sec_Ques_ID = '$SecQ_ID';");

	//CONDS
	if (!$SecQ_ID) {
    	echo "Could not successfully get id from user table" . mysql_error();
    	exit;
	}

	if (!$res) {
    	echo "Could not successfully run sec1, sec2 query from secq table" . mysql_error();
    	exit;
	}

	$row = mysql_fetch_array($res);

	//CONDS
	if( is_null( $row["Question_1"] ) )
	{
		$Q1 = "Not Found Q1!";
	}
	else
	{
		$Q1 = $row["Question_1"];
	}

	if( is_null( $row["Question_2"] ) )
	{
		$Q2 = "Not Found Q2!";
	}
	else
	{
		$Q2 = $row["Question_2"];
	}

//final result
array_push($result,
	array
	(
		"Question_1" => $Q1,
		"Question_2" => $Q2
	) );	
}

header('Content-Type: application/json');


echo json_encode( array("result"=>$result) );

?>