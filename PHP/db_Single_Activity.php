<?php
//http://localhost/db_Activity_Tab.php
// array for JSON response
$result = array();
// check for required fields

	
	// include db connect class
	require_once __DIR__ . '/db_connect.php';
	// connecting to db
	$db = new DB_CONNECT();
	//doorstatus
	$res = mysql_query("SELECT Activity_Name, Visitor_Image, Time_Marked FROM `ACTIVITY` ORDER BY Time_Marked DESC LIMIT 1;");  
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
			'Visitor_Image' => $row[1]
			));
	}

header('Content-Type: application/json');
echo json_encode( array("result"=>$result) );
?>