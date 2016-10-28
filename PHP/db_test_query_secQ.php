<?php

//http://localhost/db_test_query_secQ.php?SecQ1=h@g.com&SecQ2=abcdefgh&SecA1=g@g.com&SecA2=dfjfjj
// array for JSON response
$response = array();
 
// check for required fields
if ( isset($_POST['SecQ1']) && isset($_POST['SecQ2']) && isset($_POST['SecA1']) && isset($_POST['SecA2']) ) {
 
    $SecQ1 = $_POST['SecQ1'];
    $SecQ2 = $_POST['SecQ2'];
    $SecA1 = $_POST['SecA1'];
    $SecA2 = $_POST['SecA2'];
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
 

    // mysql inserting a new row
    $result = mysql_query("INSERT INTO `SECURITY_QUESTION`( Question_1, Question_2, Answer_1, Answer_2  ) VALUES( '$SecQ1', '$SecQ2', '$SecA1', '$SecA2' );");
 
    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Insertion Successful.";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occured!";
 
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>