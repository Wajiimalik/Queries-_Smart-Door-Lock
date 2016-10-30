<?php
//http://localhost/db_Door_Info.php?MAC=C4:3A:BE:53:F5:D1
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
	$res = mysql_query("SELECT Status FROM `DEVICE`;");  
	$row = mysql_fetch_array($res);

	$Door_Status = $row["Status"];

	//userid
	$res0 = mysql_query("SELECT User_ID FROM `PHONE` WHERE MAC_Address = '$MAC';");  
	$row0 = mysql_fetch_array($res0);

	$User_ID = $row0["User_ID"];

	//devnameid
	$res1 = mysql_query("SELECT Device_Name_ID FROM `USER` WHERE User_ID = '$User_ID';");  
	$row1 = mysql_fetch_array($res1);

	$Dev_Name_ID = $row1["Device_Name_ID"];

	//doorname and desc
	$res2 = mysql_query("SELECT Name, Description FROM `DEVICE_NAME` WHERE Name_ID = '$Dev_Name_ID';");  
	$row2 = mysql_fetch_array($res2);

	$Door_Name = $row2["Name"];
	$Door_Desc = $row2["Description"];


	//featuresnames and ids
	$res3 = mysql_query("SELECT FEATURE.Name FROM `FEATURE` INNER JOIN `User_Feature` ON FEATURE.Feature_ID=User_Feature.Feature_ID WHERE User_Feature.User_ID='$User_ID';");

	//conds
	if (!$User_ID) {
    	echo "Could not successfully get id from user table" . mysql_error();
    	exit;
	}

	if (!$Dev_Name_ID) {
    	echo "Could not successfully get id from dev name table" . mysql_error();
    	exit;
	}

	if (!$res) {
    	echo "Could not successfully run status door query from dev table" . mysql_error();
    	exit;
	}

	if (!$res1) {
    	echo "Could not successfully run name, desc query from dev name table" . mysql_error();
    	exit;
	}

	if (!$res2) {
    	echo "Could not successfully run featuresids query from user_feature table" . mysql_error();
    	exit;
	}

	if (!$res3) {
    	echo "Could not successfully run join query of features names from feature table" . mysql_error();
    	exit;
	}


	while($row3 = mysql_fetch_array($res3))
	{                 
		array_push($result,
			array(
			"Feature Name" => $row3[0]
			));
	}

	array_push($result,
		array
		(
			"Door Status" => $Door_Status
		) );

	array_push($result,
		array
		(
			"Door_Name" => $Door_Name
		) );

	array_push($result,
		array
		(
			"Door Description" => $Door_Desc
		) );	


}
header('Content-Type: application/json');


echo json_encode( array("result"=>$result) );

?>