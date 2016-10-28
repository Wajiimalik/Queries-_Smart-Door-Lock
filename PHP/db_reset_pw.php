<?php
// array for JSON response
$response = array();
 
// check for required fields
if ( isset($_POST['New_Password']) && isset($_POST['MAC']) )
{
    $New_Password = $_POST['New_Password'];
    $MAC = isset($_POST['MAC']);
 
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

    $PW_ID = $row1["User_ID"];
  

    // mysql update cols
   $result = mysql_query("UPDATE `PASSWORDS` SET PW='$New_Password' WHERE Password_ID = '$PW_ID'; ");


   //conds
    if ($result) 
    {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Insertion successful!";
 
        // echoing JSON response
        echo json_encode($response);
    } 
    else 
    {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
 
        // echoing JSON response
        echo json_encode($response);
    }
} 
else 
{
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>