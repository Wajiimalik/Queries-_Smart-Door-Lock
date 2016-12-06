<?php
	//Getting the message 
	$message = 'You have a visitor';
	//$message = 'Intruder Alert';
	$reg_token2=array('efbd6bv5i1Y:APA91bGkncYywaV8_2cVyZ8lMml_vLLKp0xWuZ0A6Kkst1NZWhM0E_4UTzqH_4AvlTV4HaHRiBw8lCefEE5zfqu4dTdtVszxx2QNyBCk36POkfL2eJmFtwcU6I3Fyg3KJo-tNWmu_pYU');
	
	$reg_token1 = array('fwxl5nbItF4:APA91bEgmsezRf5Lb9VtDCmKYytLAIVzSwkakyJ9bLIFxh9uLAofbxmYD7YGm6UN0Eo92PrkUV6fXN7HMBAFiaq68OBZE7IfWblAE9vvn9FTkXxsMbxS1sOmT4oHY_fiSIA6uXDAeFiH');
	$api_key = "AIzaSyCANWKzS2PqTBRDP0_BW5O58zzP_tPKTLg";
	
	//$regTokens = array('dS1VrnYLye8:APA91bHr_QqRbuaF3JNo1lfMeSq8dBK1Kwtm6BAVgDs3xWJAMli_nvqkXfQTMW_KtnIyrKwHWbxHgxwUpODMbLoDAZkzGUA8fJk2uY0xpi-4D1StzU5n3ULb1JqOzNAxP_kdxSesfpVy');
	
	//$regTokens=array_merge($reg_token2,$reg_token1);
	
	$regTokens = array('fwxl5nbItF4:APA91bEgmsezRf5Lb9VtDCmKYytLAIVzSwkakyJ9bLIFxh9uLAofbxmYD7YGm6UN0Eo92PrkUV6fXN7HMBAFiaq68OBZE7IfWblAE9vvn9FTkXxsMbxS1sOmT4oHY_fiSIA6uXDAeFiH');
	//these tokens have to be retrieved from database
	
	//Creating a message array 
	$msg = array
	(
		'message' => $message
	);
	
	//Creating a new array fields and adding the msg array and registration token array here 
	
	$fields = array
	(
		'registration_ids' 	=> $regTokens,
		'data'			=> $msg
	);
	
	//Adding the api key in one more array header 
	$headers = array
	(
		'Authorization: key=' . $api_key,
		'Content-Type: application/json'
	); 
	
	//Using curl to perform http request 
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	
	//Getting the result 
	$result = curl_exec( $ch );
	curl_close( $ch );
	
	//Decoding json from result 
	$res = json_decode($result);

	
	//Getting value from success 
	$flag = $res->success;
	
	//if success is 1 means message is sent 
	if($flag)
	{
		echo "<strong>Cool!</strong> Message sent successfully check your device...";
	}
	else
	{
		echo "<strong>Oops!</strong> Could not send message check API Key and Token...";
	}
	