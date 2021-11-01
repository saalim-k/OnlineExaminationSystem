<?php
$connect=mysqli_connect("localhost","root","");
$sql="CREATE DATABASE IF NOT EXISTS Assignment";
$result=mysqli_query($connect,$sql) or die("Bad Create:$sql");
mysqli_select_db($connect,"Assignment");

$sql1="CREATE TABLE IF NOT EXISTS Department(
	Dept_ID VARCHAR(100) NOT NULL UNIQUE,
	Name VARCHAR(100) NOT NULL,
	Description VARCHAR(1000) NOT NULL,
	PRIMARY KEY(Dept_ID)
	)";
$result1=mysqli_query($connect,$sql1) or die("Bad Create:$sql1");

$sql2="CREATE TABLE IF NOT EXISTS Program(
	Prog_ID VARCHAR(100) NOT NULL UNIQUE,
	NAME VARCHAR(100) NOT NULL,
	Description VARCHAR(1000) NOT NULL,
	Dept_ID VARCHAR(100) NOT NULL,
	PRIMARY KEY(Prog_ID),
	FOREIGN KEY (Dept_ID) REFERENCES Department(Dept_ID)
	)";
$result2=mysqli_query($connect,$sql2) or die("Bad Create:$sql2");

$sql3="CREATE TABLE IF NOT EXISTS Course(
	Course_ID VARCHAR(100) NOT NULL UNIQUE,
	NAME VARCHAR(100) NOT NULL,
	Description VARCHAR(1000) NOT NULL,
	Prog_ID VARCHAR(100) NOT NULL,
	PRIMARY KEY(Course_ID),
	FOREIGN KEY (Prog_ID) REFERENCES Program(Prog_ID)
	)";
$result3=mysqli_query($connect,$sql3) or die("Bad Create:$sql3");

$sql4="CREATE TABLE IF NOT EXISTS Account(
	User_ID VARCHAR(100) NOT NULL UNIQUE,
	USERNAME VARCHAR(100) NOT NULL UNIQUE,
	PASSWORD CHAR(40) NOT NULL,
	PRIMARY KEY(User_ID)
	)";

$result4=mysqli_query($connect,$sql4) or die("Bad Create:$sql4");

$sql5="CREATE TABLE IF NOT EXISTS People(
	User_ID VARCHAR(100) NOT NULL UNIQUE,
	Acc_type CHAR(1) NOT NULL ,
	F_Name VARCHAR(100) NOT NULL,
	L_Name VARCHAR(100) NOT NULL,
	DOB VARCHAR(100) NOT NULL,
	Phone_Num VARCHAR(30) NOT NULL,
	Email_Add VARCHAR(100) NOT NULL,
	PRIMARY KEY(User_ID),
	FOREIGN KEY (User_ID) REFERENCES Account(User_ID)
	)";
$result5=mysqli_query($connect,$sql5) or die("Bad Create:$sql5");

$sql6="CREATE TABLE IF NOT EXISTS Student(
	User_ID VARCHAR(100) NOT NULL UNIQUE,
	Prog_ID VARCHAR(10) NOT NULL,
	PRIMARY KEY(User_ID),
	FOREIGN KEY (User_ID) REFERENCES People(User_ID),
	FOREIGN KEY (Prog_ID) REFERENCES Program(Prog_ID)
	)";
$result6=mysqli_query($connect,$sql6) or die("Bad Create:$sql6");

$sql7="CREATE TABLE IF NOT EXISTS Teacher(
	User_ID VARCHAR(100) NOT NULL UNIQUE,
	Dept_ID VARCHAR(10) NOT NULL,
	PRIMARY KEY(User_ID),
	FOREIGN KEY (User_ID) REFERENCES People(User_ID),
	FOREIGN KEY (Dept_ID) REFERENCES Department(Dept_ID)
	)";
$result7=mysqli_query($connect,$sql7) or die("Bad Create:$sql7");

$sql8="CREATE TABLE IF NOT EXISTS Test(
	Test_ID int NOT NULL AUTO_INCREMENT,
	Name VARCHAR(1000) NOT NULL UNIQUE,
	Date VARCHAR(10) NOT NULL,
	Start_time VARCHAR(10) NOT NULL,
	Duration VARCHAR(10) NOT NULL,
	End_time VARCHAR(10) NOT NULL,
	Course_ID VARCHAR(100) NOT NULL,
	User_ID VARCHAR(100) NOT NULL,
	PRIMARY KEY(Test_ID),
	FOREIGN KEY (Course_ID) REFERENCES Course(Course_ID),
	FOREIGN KEY (User_ID) REFERENCES Account(User_ID)
	)";
$result8=mysqli_query($connect,$sql8) or die("Bad Create:$sql8");


$sql9="CREATE TABLE IF NOT EXISTS Questions(
	Test_ID int NOT NULL ,
	Q_No CHAR(10) NOT NULL,
	Q_Marks VARCHAR(10) NOT NULL,
	Q_Desc VARCHAR(1000) NOT NULL,
	Q_Option_A VARCHAR(1000) NOT NULL,
	Q_Option_B VARCHAR(1000) NOT NULL,
	Q_Option_C VARCHAR(1000) NOT NULL,
	Q_Option_D VARCHAR(1000) NOT NULL,
	Q_Correct_Option CHAR(1) NOT NULL,
	PRIMARY KEY(Test_ID,Q_No),
	FOREIGN KEY (Test_ID) REFERENCES Test(Test_ID)
	)";
$result9=mysqli_query($connect,$sql9) or die("Bad Create:$sql9");

$sql10="CREATE TABLE IF NOT EXISTS TestRec(
	User_ID VARCHAR(100) NOT NULL,
	Test_ID int NOT NULL,
	Marks VARCHAR(10) NOT NULL,
	PRIMARY KEY(User_ID,Test_ID),
	FOREIGN KEY (User_ID) REFERENCES Account(User_ID),
	FOREIGN KEY (Test_ID) REFERENCES Test(Test_ID)
	)";
$result10=mysqli_query($connect,$sql10) or die("Bad Create:$sql10");

$sql11="CREATE TABLE IF NOT EXISTS Enrolled(
	Course_ID VARCHAR(100) NOT NULL,
	User_ID VARCHAR(100) NOT NULL,
	PRIMARY KEY(Course_ID,User_ID),
	FOREIGN KEY (Course_ID) REFERENCES Course(Course_ID),
	FOREIGN KEY (USER_ID) REFERENCES Student(User_ID)
	)";
$result11=mysqli_query($connect,$sql11);

$sql12="CREATE TABLE IF NOT EXISTS Teaching(
	Course_ID VARCHAR(100) NOT NULL,
	User_ID VARCHAR(100) NOT NULL,
	PRIMARY KEY(Course_ID,User_ID),
	FOREIGN KEY (Course_ID) REFERENCES Course(Course_ID),
	FOREIGN KEY (User_ID) REFERENCES Teacher(USER_ID)
	)";
$result12=mysqli_query($connect,$sql12);

///Add primary Admin During Creation////
$sql13="SELECT `User_ID` FROM `account` WHERE `User_ID`='Admin'";
$result13=mysqli_query($connect,$sql13);
$numRow=mysqli_num_rows($result13);
if ($numRow==0)
{
	$sql14="INSERT INTO `Account` (
			`User_ID`,`USERNAME`,`PASSWORD`)
			VALUES ('Admin','Admin','Admin')";
	$sql15="INSERT INTO `people` (
			`User_ID`, `Acc_type`, `F_Name`, `L_Name`, `DOB`, `Phone_Num`, `Email_Add`)
			VALUES ('Admin', 'A', 'Admin', 'Admin', '2020-01-01', '000000', '000@000.com')";
	$result14=mysqli_query($connect,$sql14);
	$result15=mysqli_query($connect,$sql15);
}



?>