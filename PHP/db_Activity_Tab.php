<?php
//http://localhost/db_Activity_Tab.php?MAC=C4:3A:BE:53:F5:D1
// array for JSON response
$result = array();

// check for required fields
if ( isset($_GET['MAC']) ) {

    $MAC = $_GET['MAC'];  
	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	//doorstatus
	$res = mysql_query("SELECT Activity_Name, Visitor_Image, Time_Marked FROM `ACTIVITY` ORDER BY Time_Marked DESC LIMIT 3;");  

	//$row = mysql_fetch_array($res);

	//$Door_Status = $row["Status"];

	

	if (!$res) {
    	echo "Could not successfully run status door query from dev table" . mysql_error();
    	exit;
	}

	while($row = mysql_fetch_array($res))
	{                 
		array_push($result,
			array(
			"Activity_Name" => $row[0],
			"Visitor_Image" => $row[1],
			"Time_Marked" => $row[2]
			));
	}

}
header('Content-Type: application/json');


echo json_encode( array("result"=>$result) );

?>s