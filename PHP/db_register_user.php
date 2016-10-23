<?php
// array for JSON response
$response = array();
 
// check for required fields
if ( isset($_POST['F_Name']) && isset($_POST['L_Name']) && isset($_POST['Country']) && isset($_POST['City']) && isset($_POST['Email']) && isset($_POST['Alt_Email']) && isset($_POST['Username']) && isset($_POST['PW']) && isset($_POST['SecQ1']) && isset($_POST['SecQ2']) && isset($_POST['SecA1']) && isset($_POST['SecA2']) && isset($_POST['Pin_Code']) && isset($_POST['Door_Name']) && isset($_POST['Door_Desc']) && isset($_POST['Phone_MAC_Addr']) && isset($_POST['Phone_IP_Public']) && isset($_POST['Phone_IP_Local']) )
{
    $F_Name = $_POST['F_Name'];
    $L_Name = $_POST['L_Name'];
    $Country = $_POST['Country'];
    $City = $_POST['City'];

    $Email = $_POST['Email'];
    $Alt_Email = $_POST['Alt_Email'];
    $Username = $_POST['Username'];
    $PW = $_POST['PW'];

    $SecQ1 = $_POST['SecQ1'];
    $SecQ2 = $_POST['SecQ2'];
    $SecA1 = $_POST['SecA1'];
    $SecA2 = $_POST['SecA2'];

    $Pin_Code = $_POST['Pin_Code'];
    $Door_Name = $_POST['Door_Name'];
    $Door_Desc = $_POST['Door_Desc'];

    $Phone_MAC_Addr = $_POST['Phone_MAC_Addr'];
    $Phone_IP_Public = $_POST['Phone_IP_Public'];
    $Phone_IP_Local = $_POST['Phone_IP_Local'];
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
  
    // mysql inserting a new row
   $result = mysql_query("CALL register_user_sp('$F_Name', '$L_Name', '$Country', '$City', '$Email', '$Alt_Email', '$Username', '$PW', '$SecQ1', '$SecQ2', '$SecA1', '$SecA2', '$Pin_Code', '$Door_Name', '$Door_Desc', '$Phone_MAC_Addr', '$Phone_IP_Public', '$Phone_IP_Local'); ");

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