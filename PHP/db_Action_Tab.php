<?php
//http://localhost/db_Action_Tab.php
// array for JSON response
$result = array();


	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();

	//doorstatus
	$res = mysql_query("SELECT ACTION.Time_Marked, USER.FName FROM ACTION INNER JOIN PHONE ON PHONE.Phone_ID=ACTION.Phone_ID INNER JOIN USER ON PHONE.User_ID=USER.User_ID ORDER BY ACTION.Time_Marked DESC LIMIT 10;");  

	//$row = mysql_fetch_array($res);

	//$Door_Status = $row["Status"];

	

	if (!$res) {
    	echo "Could not successfully run status door query from dev table" . mysql_error();
    	exit;
	}

	while($row = mysql_fetch_array($res))
	{           
		$NAME = $row[1];
		$TS = $row[0];

		$OUT = $NAME . " has unlocked the door at " . $TS;
		array_push($result,
			array(
			"Action" => $OUT
			));
	}


header('Content-Type: application/json');


echo json_encode( array("result"=>$result) );

?>