CREATE DATABASE db_DOOR_LOCK;

USE db_DOOR_LOCK;

CREATE TABLE PASSWORDS
(
	Password_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	Email_Address VARCHAR(255) NOT NULL,
	Alt_Email_Address VARCHAR(255) NOT NULL,
	Username VARCHAR(20) NOT NULL,
	PW VARCHAR(20) NOT NULL,
	Token VARCHAR(255),

	PRIMARY KEY(Password_ID),

	CONSTRAINT uc_PASSWORDS UNIQUE (Email_Address, Alt_Email_Address , Username, Token)
);

CREATE TABLE SECURITY_QUESTION
(
	Sec_Ques_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	Question_1 VARCHAR(255) NOT NULL,
	Question_2 VARCHAR(255) NOT NULL,
	Answer_1 VARCHAR(25) NOT NULL,
	Answer_2 VARCHAR(25) NOT NULL,

	PRIMARY KEY(Sec_Ques_ID)
);

CREATE TABLE DEVICE
(
	Device_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	Status VARCHAR(7) NOT NULL DEFAULT 'Close',

	PRIMARY KEY(Device_ID),

	CONSTRAINT chk_DEVICE CHECK ( Status in('Close', 'Open'))
);

CREATE TABLE DEVICE_NAME
(
	Name_ID TINYINT(1) NOT NULL AUTO_INCREMENT,

	Name VARCHAR(30) NOT NULL,
	Description VARCHAR(255),
	PIN_Code VARCHAR(10) NOT NULL,
	Device_ID TINYINT(1) NOT NULL,

	PRIMARY KEY(Name_ID),

	FOREIGN KEY (Device_ID) REFERENCES DEVICE(Device_ID)
);
	 
CREATE TABLE USER 
(
	User_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	FName VARCHAR(35) NOT NULL,
	LName VARCHAR(35) NOT NULL,
	Image MEDIUMBLOB,
	City VARCHAR(35) NOT NULL,
	Country VARCHAR(35) NOT NULL,
	Privilege TINYINT(1) NOT NULL DEFAULT 1,
	Num_of_Doors TINYINT(1) NOT NULL DEFAULT 1,

	Password_ID TINYINT(1) NOT NULL,
	Sec_Ques_ID TINYINT(1) NOT NULL,
	Device_Name_ID TINYINT(1) NOT NULL,

	PRIMARY KEY(User_ID),

	FOREIGN KEY (Password_ID) REFERENCES PASSWORDS(Password_ID),
	FOREIGN KEY (Sec_Ques_ID) REFERENCES SECURITY_QUESTION(Sec_Ques_ID),
	FOREIGN KEY (Device_Name_ID) REFERENCES DEVICE_NAME(Name_ID),

	CHECK (Privilege>0 AND Privilege<3),

	CONSTRAINT uc_USER UNIQUE (Password_ID, Sec_Ques_ID)
);

CREATE TABLE PHONE 
(
	Phone_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	MAC_Address VARCHAR(45) NOT NULL,

	User_ID TINYINT(1) NOT NULL,
	Device_ID TINYINT(1) NOT NULL,

	PRIMARY KEY(Phone_ID),

	FOREIGN KEY (User_ID) REFERENCES USER(User_ID),
	FOREIGN KEY (Device_ID) REFERENCES DEVICE(Device_ID),

	UNIQUE (MAC_Address)
);

CREATE TABLE PORT
(
	Port_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	Port_Color VARCHAR(15) NOT NULL,

	PRIMARY KEY(Port_ID),

	UNIQUE (Port_Color)
);

CREATE TABLE FEATURE
(
	Feature_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	Name VARCHAR(20) NOT NULL,

	Port_ID TINYINT(1) NOT NULL,
	Device_ID TINYINT(1) NOT NULL,

	PRIMARY KEY(Feature_ID),

	FOREIGN KEY (Port_ID) REFERENCES PORT(Port_ID),
	FOREIGN KEY (Device_ID) REFERENCES DEVICE(Device_ID),

	CONSTRAINT chk_FEATURE CHECK (Name in ('Camera', 'Bell Ring', 'Door Knock', 'Lock Tamper', 'Human Detector', 'Obstacle Detector') ),

	CONSTRAINT uc_FEATURE UNIQUE (Name, Port_ID)
);

CREATE TABLE User_Feature (
	UF_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	Status VARCHAR(10) NOT NULL DEFAULT 'Absent',
		 
	User_ID TINYINT(1) NOT NULL,
	Feature_ID TINYINT(1) NOT NULL,

	PRIMARY KEY(UF_ID),
	
	FOREIGN KEY(User_ID) REFERENCES User(User_ID),
	FOREIGN KEY(Feature_ID) REFERENCES FEATURE(Feature_ID),

	CONSTRAINT chk_FEATURE CHECK( Status in ('Present', 'Absent') )
);

CREATE TABLE ACTION
(
	Action_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	Action_Name VARCHAR(10) NOT NULL,
	Time_Marked TIMESTAMP NOT NULL,

	Phone_ID TINYINT(1) NOT NULL,

	PRIMARY KEY(Action_ID),
	FOREIGN KEY (Phone_ID) REFERENCES PHONE(Phone_ID),

	CHECK (Action_Name in ('Unlock') ),

	UNIQUE (Time_Marked)
);

CREATE TABLE ACTIVITY
(
	Activity_ID TINYINT(1) NOT NULL AUTO_INCREMENT,
	Activity_Name VARCHAR(20) NOT NULL,
	Visitor_Image MEDIUMBLOB NOT NULL,
	Time_Marked TIMESTAMP NOT NULL,

	Action_ID TINYINT(1),
	Device_ID TINYINT(1) NOT NULL,

	PRIMARY KEY(Activity_ID),
	FOREIGN KEY (Action_ID) REFERENCES ACTION(Action_ID),
	FOREIGN KEY (Device_ID) REFERENCES DEVICE(Device_ID),

	CHECK (Activity_Name in ('Visitor', 'Intruder')),

	CONSTRAINT uc_ACTIVITY UNIQUE (Activity_Name, Time_Marked, Action_ID)
);

INSERT INTO `DEVICE`( Status ) VALUES( 'Close' );

INSERT INTO PORT(Port_Color) VALUES('Blue');
INSERT INTO PORT(Port_Color) VALUES('Yellow');
INSERT INTO PORT(Port_Color) VALUES('Green');
INSERT INTO PORT(Port_Color) VALUES('Red');
INSERT INTO PORT(Port_Color) VALUES('Orange');
INSERT INTO PORT(Port_Color) VALUES('Purple');

INSERT INTO FEATURE( Name, Port_ID, Device_ID ) VALUES( 'Camera', 1, 1 );
INSERT INTO FEATURE( Name, Port_ID, Device_ID ) VALUES( 'Bell Ring', 2, 1 );
INSERT INTO FEATURE( Name, Port_ID, Device_ID ) VALUES( 'Door Knock', 3, 1 );
INSERT INTO FEATURE( Name, Port_ID, Device_ID ) VALUES( 'Lock Tamper', 4, 1 );
INSERT INTO FEATURE( Name, Port_ID, Device_ID ) VALUES( 'Human Detector', 5, 1 );
INSERT INTO FEATURE( Name, Port_ID, Device_ID ) VALUES( 'Obstacle Detector', 6, 1 );