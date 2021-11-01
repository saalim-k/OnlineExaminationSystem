<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<head>
<style>
	body{
		margin:auto;
	}
	#div1{
		width: auto;
		position: relative;
		top: 10px;
		background:#ddd;
		margin:2%;
		height:auto;
        box-shadow: 0 0 10px white;	
        text-align:center;	
	
	}
	.table{
		width: 100%;
	}
	.tableR
	{
		width:50%;
		margin-left:25%;
	}
	h1{
		text-align:center;
		padding-top:3%;
		padding-bottom:1%;
		
	}
	 #input{
		width:100%;
		padding-top:2%;
		padding-bottom:2%;
		text-align:center;
		font-size:18px;
		background:white;
		
	}
	#header
	{
	    height:107px;
		background:#262626;
		width:100%;
		z-index:12;
		position:fixed;
		top:0;
	}
	#logo
	{
		width:40%;
	    float:left;
	    line-height:100px;
		font-size: 30px;
		color: white;
		letter-spacing: 2px;
	}
	#menu
	{
		 margin: 0;
		 padding: 0;
		 text-align: center;
	}
	#wrapper
	{
		width: 1531px;
		margin: 0 auto;
	}
	.rowH
	{
		color: white;
		background:#262626;
		text-align: center;
		font-size: 25px;
		font-weight:bold;
		padding-top:1%;
		padding-bottom:1%;
		letter-spacing: 2px;
		
	}
	.column{
		width:auto;
		text-align:center;
		height:10px;
		font-weight:bold;
		font-size:20px;
	}
	.columnRegistered
	{
		width:auto;
		text-align:center;
		height:10px;
		font-size:20px;
	}

	.buttonA{
		line-height:40px;
		font-size: 20px;
		font-weight:bold;
		border:black;
		background:white;
        width:auto;
		color: white;
		background:#262626;
		box-shadow: 0 0 10px #ddd;
	}
	.buttonA:hover{
		background:grey;
		color: white;
	}
		.username{
		color:black;
		text-align:right;
		font-size:30px;
	}
	.user{
		margin-top:7%;
		margin-left:75%;
	}
	.acctype{
		color:black;
		text-align:right;
		font-size:30px;
	}
</style>
<meta charset="utf-8"/>
</head>
<?php
session_start();
include("DB.php");
if((isset($_COOKIE["username"])) && (isset($_COOKIE["password"])) && (isset($_COOKIE["AccType"])))
{
	$USERNAME=$_COOKIE["username"];
	$PASSWORD=$_COOKIE["password"];
	$AccType =$_COOKIE["AccType"];
	$_SESSION["User"]=$USERNAME;
	$_SESSION["Pass"]=$PASSWORD;
	$_SESSION["AccType"]=$AccType;
}
if((!isset($_SESSION['User']))&&(!isset($_SESSION['Pass'])) && (!isset($_SESSION['AccType'])))
{
	header("Location:login.php");
}
else if ($_SESSION['AccType']!= 'A')
{
	echo"<h1>You are not an Admin</h1>";
	header("refresh:5;login.php");
}
else
{
?>
<div id= "header">
<div id ="wrapper">
<div id ="logo"><label>ADMIN MANAGEMENT SYSTEM</label></div>
</div>
</div>
<body style="background-color:#bdc3c7">
<div class="user">
<label class="username"><?php echo "Username&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp".$_SESSION['User']."";?></label><br><br>
<label class="acctype"><?php echo 'Account Type&nbsp:&nbsp &nbsp'. yourAcType().'';?></label>
</div>
<div id="div1" class="center">
<h1>REGISTER A NEW TEACHER </h1>
</table>
<h3> All Currently Registered Teachers </h3>
<table border="1" class="table">
<tr class="rowH">
<td>User_ID</td>
<td>First Name</td>
<td>Last Name</td>
<td>Department</td>
<td>Date Of Birth</td>
<td>Phone Number</td>
<td>Email Address</td>
</tr>
<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
$GetAllTeachersQuery = "SELECT People.User_ID , People.F_Name , People.L_Name , Teacher.Dept_ID , People.DOB , People.Phone_Num , People.Email_Add From People INNER JOIN Teacher WHERE People.User_ID=Teacher.User_ID";
$GetAllTeachersExecute = mysqli_query($connect,$GetAllTeachersQuery);
while($Arr1=mysqli_fetch_array($GetAllTeachersExecute))
{
	echo 	'<tr>
				<td class="columnRegistered">'.$Arr1['User_ID'].'</td>
				<td class="columnRegistered">'.$Arr1['F_Name'].'</td>
				<td class="columnRegistered">'.$Arr1['L_Name'].'</td>
				<td class="columnRegistered">'.$Arr1['Dept_ID'].'</td>
				<td class="columnRegistered">'.$Arr1['DOB'].'</td>
				<td class="columnRegistered">'.$Arr1['Phone_Num'].'</td>
				<td class="columnRegistered">'.$Arr1['Email_Add'].'</td>
			</tr>';
}
$GetAllDeptQuery="SELECT Dept_ID FROM Department";
$GetAllDeptExecute=(mysqli_query($connect,$GetAllDeptQuery));
?>
</table>
<?php
if((isset($_REQUEST['Usern']))&&(isset($_REQUEST['Passn'])))
{
	echo "<h2>A new Teacher was registred successfully.</h2>";
	echo "<h3>Their Username is: ". $_REQUEST['Usern'].'</h3>';
	echo "<h3>Their Password is: ". $_REQUEST['Passn'].'</h3>';
}

if(isset($_POST['submit']))
{
	$Uid=trim($_POST['User_id']);
	$User=trim($_POST['Username']);
	$Pass=trim($_POST['Password']);
	$Fn=trim($_POST['Fname']);
	$Ln=trim($_POST['Lname']);
	$dob=trim($_POST['DOB']);
	$Pn=trim($_POST['Pn']);
	$Eadd=trim($_POST['Eadd']);
	$Did=($_POST['Department']);
	$date=strtotime($dob);
	$today = strtotime(date('Y/m/d'));
	if($date>=$today)
		echo "Error. Date of birth cannot be after today";
	else
	{
		$InsertAccQuery="INSERT INTO Account(User_ID,USERNAME,PASSWORD) VALUES('$Uid','$User','$Pass')";
		$InsertPeopleQuery="INSERT INTO People(User_ID,Acc_type,F_Name,L_Name,DOB,Phone_Num,Email_Add)VALUES('$Uid','T','$Fn','$Ln','$dob','$Pn','$Eadd')";
		$InsertTeachQuery="INSERT INTO Teacher(User_ID,Dept_ID)VALUES('$Uid','$Did')";
		$insert1=mysqli_query($connect,$InsertAccQuery);
		$insert2=mysqli_query($connect,$InsertPeopleQuery);
		$insert3=mysqli_query($connect,$InsertTeachQuery);
		if($insert1){
			if($insert2){
				if($insert3){
					header("location:AdminRegNewTeach.php?Usern=$User&Passn=$Pass");
				}
			}
		}
		else{
			echo "<h4>Username or User ID already exists, please try another username or User ID</h4>";
		}
	}
}
?>
<br>
<h3>Enter Details of New Teacher Below and Click Submit to Register </h3>
<table class="tableR">
<tr>
<td class="column">User Id</td>
<td><input type="text" name="User_id" required id="input"></td>
</tr>
<tr>
<td class="column">Username </td>
<td><input type="text" name="Username" required id="input"></td>
</tr>
<tr>
<td class="column">Password</td>
<td><input type="text" name="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required id="input"></td>
</tr>
<tr>
<td class="column">First Name</td>
<td><input type="text" name="Fname" required id="input"></td>
</tr>
<tr>
<td class="column">Last Name</td>
<td><input type="text" name="Lname" required id="input"></td>
</tr>
<tr>
<td class="column">Date Of Birth</td>
<td><input type="date" name="DOB" max="<?php echo date('Y-m-d'); ?>" required id="input"></td>
</tr>
<tr>
<td class="column">Phone Number</td>
<td><input type="text" name="Pn" pattern="^(\+?6?01)[0|1|2|3|4|6|7|8|9]-*[0-9]{7,8}$" title="Example: +60111111111" required id="input"></td>
</tr>
<tr>
<td class="column">Email Address</td>
<td><input type="text" name="Eadd" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please Enter a correct email format. Example: 123@abc.com" required id="input"></td>
</tr>
<tr>
<td class="column">Department</td>
<td><select name = "Department" id="input" >
<?php
while($x=mysqli_fetch_row($GetAllDeptExecute))
{
	echo "<option  value='{$x[0]}'>$x[0]</option>";
}
?>
</tr>
<tr>
<td colspan="2"  class="column"><input type="submit" name="submit" value="Submit" class="buttonA"></td>
</tr>
</table>
</br>
</br>
<input type="button" onclick="window.location = '/Assignment/AdminHome.php'" value = "Back to Home Page" class="buttonA" >
<?php
}
function yourAcType()
{
	if(($_SESSION['AccType'])=='A')
	{
		$you="Admin";
		return $you;
	}
	else if(($_SESSION['AccType'])=='S')
	{
		$you="Student";
		return $you;
	}
	else if(($_SESSION['AccType'])=='T')
	{
		$you="Teacher";
		return $you;
	}
}
?>
</div>

