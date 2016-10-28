<?php
//http://localhost/db_test_val.php?Email=h@g.com&Username=abcdefgh&AltEmail=g@g.com

// array for JSON response
$result = array();

// check for required fields
if ( isset($_GET['Email'])  && isset($_GET['Username']) && isset($_GET['AltEmail'])  ) {

    $Email = $_GET['Email']; 

    $Username =  $_GET['Username'];

    $AltEmail = ($_GET['AltEmail']);
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	// queries
	$result1 = mysql_query("SELECT Email_Address FROM `PASSWORDS` WHERE Email_Address = '$Email';");  
	$result2 = mysql_query("SELECT Username FROM `PASSWORDS` WHERE Username = '$Username';"); 
	$result3 = mysql_query("SELECT Alt_Email_Address FROM `PASSWORDS` WHERE Alt_Email_Address = '$AltEmail';");  

	//conds
	if (!$result1) {
    	echo "Could not successfully run email query from DB" . mysql_error();
    	exit;
	}

	if (!$result2) {
    	echo "Could not successfully run username query from DB" . mysql_error();
    	exit;
	}

	if (!$result3) {
    	echo "Could not successfully run alt-email query from DB" . mysql_error();
    	exit;
	}

	$row1 = mysql_fetch_array($result1);
    	//echo $row1["Email_Address"];

    $row2 = mysql_fetch_array($result2);
    	//echo $row2["Username"];

    $row3 = mysql_fetch_array($result3);
    	//echo $row3["Alt_Email_Address"];

    //conds
	if( is_null( $row1["Email_Address"] ) )
	{
		$Email = "Not Found email!";
	}
	else
	{
		$Email = $row1["Email_Address"];
	}

	if( is_null( $row2["Username"] ) )
	{
		$Username = "Not Found username!";
	}
	else
	{
		$Username = $row2["Username"];
	}

	if( is_null( $row3["Alt_Email_Address"] ) )
	{
		$AltEmail = "Not Found alt-email!";
	}
	else
	{
		$AltEmail = $row3["Alt_Email_Address"];
	}

//final result
array_push($result,
	array
	(
		"Email_Address" => $Email,
		"Username" => $Username,
		"Alt_Email_Address" => $AltEmail
	) );	
}

header('Content-Type: application/json');


echo json_encode( array("result"=>$result) );

?>