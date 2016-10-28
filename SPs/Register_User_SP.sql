use db_DOOR_LOCK;

DELIMITER $$

/* Now start the procedure code */
CREATE PROCEDURE register_user_sp 
(
	IN F_Name VARCHAR(35),
	IN L_Name VARCHAR(35),
	IN Country VARCHAR(35),
	IN City VARCHAR(35),
	IN Email VARCHAR(255),
	IN Alt_Email VARCHAR(255),
	IN Username VARCHAR(20),
	IN PW VARCHAR(20),
	IN Token VARCHAR(255),
	IN SecQ1 VARCHAR(255),
	IN SecQ2 VARCHAR(255),
	IN SecA1 VARCHAR(25),
	IN SecA2 VARCHAR(25),
	IN Pin_Code VARCHAR(10),
	IN Door_Name VARCHAR(30),
	IN Door_Desc VARCHAR(255),
	IN Phone_MAC_Addr VARCHAR(40)
)

BEGIN  

 	 INSERT INTO `PASSWORDS`( Email_Address, Alt_Email_Address, Username, PW, Token ) VALUES( Email, Alt_Email, Username, PW, Token );
 	 SET @current_pw_id = LAST_INSERT_ID();

	 INSERT INTO `SECURITY_QUESTION`( Question_1, Question_2, Answer_1, Answer_2  ) VALUES( SecQ1, SecQ2, SecA1, SecA2 );
	 SET @current_secq_id = LAST_INSERT_ID();

	 INSERT INTO `DEVICE_NAME`( Name, Description, PIN_Code, Device_ID ) VALUES( Door_Name, Door_Desc, Pin_Code, 1 );
	 SET @current_dev_name_id= LAST_INSERT_ID();

	 INSERT INTO `USER`( FName, LName, City, Country, Password_ID, Sec_Ques_ID, Device_Name_ID ) VALUES( F_Name, L_Name, City, Country, @current_pw_id, @current_secq_id, @current_dev_name_id );
	 SET @current_user_id= LAST_INSERT_ID();

	 INSERT INTO `PHONE`( MAC_Address, User_ID, Device_ID ) VALUES( Phone_MAC_Addr, @current_user_id, 1 );

/* whole procedure ends with the custom delimiter */
END$$

/* Finally, reset the delimiter to the default ; */
DELIMITER ;