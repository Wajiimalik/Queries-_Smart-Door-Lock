<?php
//http://localhost/db_test_val.php?Email=h@g.com&Username=abcdefgh&AltEmail=g@g.com

// array for JSON response
$result = array();

// check for required fields
if ( isset($_GET['MAC']) ) {

    $MAC = $_GET['MAC'];

	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	//get mac
	$res = mysql_query("SELECT MAC_Address FROM `PHONE` WHERE MAC_Address = '$MAC'"); 

	//CONDS
	if (!$res) {
    	echo "Could not successfully run mac query from DB" . mysql_error();
    	exit;
	}

	$row = mysql_fetch_array($res);

	//conds
	if( is_null( $row["MAC_Address"] ) )
	{
		$MAC = "Not Found mac!";
	}
	else
	{
		$MAC = $row["MAC_Address"];
	}

//final result
array_push($result,
	array
	(
		"MAC_Address" => $MAC
	) );	
}

header('Content-Type: application/json');


echo json_encode( array("result"=>$result) );

?>