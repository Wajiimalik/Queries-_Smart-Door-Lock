<?php

$result = array();

if ( isset($_POST['MAC']) && isset($_POST['PIN']) && isset($_POST['TS']) ) {


        //exec("gpio mode 0 out");

         $MAC = $_POST['MAC'];
         $IN_PIN = $_POST['PIN'];
         $TS = $_POST['TS'];


        // include db connect class
        require_once __DIR__ . '/db_connect.php';

        // connecting to db
        $db = new DB_CONNECT();

        //userid
        $res0 = mysql_query("SELECT Phone_ID,User_ID FROM `PHONE` WHERE MAC_Address = '$MAC';");
        $row0 = mysql_fetch_array($res0);

        $Phone_ID = $row0["Phone_ID"];
        $User_ID = $row0["User_ID"];


        //devnameid
        $res1 = mysql_query("SELECT Device_Name_ID FROM `USER` WHERE User_ID = '$User_ID';");
        $row1 = mysql_fetch_array($res1);
        //echo $row1["Question_1"];

        $Dev_Name_ID = $row1["Device_Name_ID"];


        //fianlly getting pin
        $res= mysql_query("SELECT PIN_Code FROM `DEVICE_NAME` WHERE Name_ID = '$Dev_Name_ID';");


 //conds
        if (!$Dev_Name_ID) {
            echo "Could not successfully get id from user table" . mysql_error();
            exit;
        }

        if (!$res) {
            echo "Could not successfully run pin code query" . mysql_error();
            exit;
        }

        $row = mysql_fetch_array($res);

        //conds
        if( is_null( $row["PIN_Code"] ) )
        {
                $PIN= "Not Found A1!";
        }
        else
        {
                $PIN = $row["PIN_Code"];
        }

        if($PIN == $IN_PIN)
        {
                //exec("gpio write 0 1");// pin 0 in wiring pi is gpio 17
                //sleep(2);
                //exec("gpio write 0 0");

                array_push($result,
                        array
                        (
                                "result" => "Door Unlocked!"
                        ) );

                $abc =mysql_query("INSERT INTO ACTION(Time_Marked, Phone_ID) VALUES('$TS', '$Phone_ID');");

        }


        }
        else
        {
                //exec("gpio write 0 0");

                array_push($result,
                        array
                        (
                                "result" => "Invalid PIN Code!"
                        ) );
        }



header('Content-Type: application/json');

echo json_encode( array("result"=>$result) );

?>

