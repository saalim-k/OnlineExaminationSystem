<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<head>
<style>
	body{
		margin:auto;
	}
	#div1{
		width: auto;
		position: relative;
		top: 20px;
		background:#ddd;
		margin:2%;
		height:auto;
        box-shadow: 0 0 10px white;	
        text-align:center;	
	
	}
	.table{
		background-color:white;
		width: 100%;
		box-shadow: 0 0 2px black;		
	}
	h1{
		text-align:center;
		padding-top:3%;
		padding-bottom:1%;
		
	}
	h3{
		text-align:center;
	}
	
	.hello{
		text-align:left;
		padding-left:5%;
		font-size:50px;
	}
	.center{
		margin-top:25px;
		margin-left:auto;
		margin-right:auto;
		width:40%;
	}
	.button
	{
		justify-content:center;
		margin-top:20px;
		margin-left:30px;
		line-height:60px;
		border: none;
		color: white;
		text-decoration: none;
		font-size: 20px;
		width: auto;
		height: 60px;
		font-weight:bold;
		background:#262626;
	}
	.button:hover{
		background:white;
			color: black;
	}

	.buttonA{
		line-height:40px;
		font-size: 20px;
		font-weight:bold;;
		background:white;
        width:auto;
		border:1px solid black;			
	}
	.buttonA:hover{
		    background:grey;
			color: white;
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
		width:auto;
	    float:left;
	    line-height:100px;
		font-size: 30px;
		color: white;
		letter-spacing: 2px;
		margin-left:0;
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
		.column
	{
		padding-top:1%;
		padding-bottom:1%;
		width:auto;
		height:auto;
		text-align: center;
		font-size: 20px;
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
	header("Location: login.php");
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
<div id ="menu">
<input type="submit" name="Home" value="HOME" class="button"></td>
<input type="submit" name="Gtest" value="GRADED TEST" class="button"></td>
<input type="submit" name="AcMan" value="ACADEMIC MANAGEMENT" class="button"></td>
<input type="submit" name="MyProfile" value="MY PROFILE" class="button"></td>
<input type="submit" name="logout" value="LOG OUT" class="button"></td>
</div>
</div>
</div>
<body style="background-color:#bdc3c7">
<div class="user">
<label class="username"><?php echo "Username&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp".$_SESSION['User']."";?></label><br><br>
<label class="acctype"><?php echo 'Account Type&nbsp:&nbsp &nbsp'. yourAcType().'';?></label>
</div>
<div id="div1" class="center">
<?php
if(isset($_POST['Home']))
{
	header("Location: AdminHome.php");
}
if(isset($_POST['AcMan']))
{
	header("Location: AcMan.php");
}
if(isset($_POST['Gtest']))
{
	header("Location: gradedTests.php");
}
if(isset($_POST['MyProfile']))
{
	header("Location: MyProfile.php");
}
if(isset($_POST['AddAdmin']))
{
	header("Location:RegNewAdmin.php");
}
if(isset($_POST['AddTeacher']))
{
	header("Location: AdminRegNewTeach.php");
}
if(isset($_POST['logout']))
{
	setcookie("username", $_SESSION["User"], time() -100, "/");
	setcookie("password", $_SESSION["Pass"], time()-100,"/");
	setcookie("AccType", $_SESSION["AccType"], time()-100,"/");
	session_destroy();
	header("refresh:0");
	
}
echo"<h1>ALL CURRENTLY REGISTERED STUDENTS</h1>";
$GetAllStudentsQuery = "SELECT People.User_ID , People.F_Name , People.L_Name , Student.Prog_ID , People.DOB , People.Phone_Num , People.Email_Add From People INNER JOIN Student WHERE People.User_ID=Student.User_ID";
$GetAllStudentsExecute = mysqli_query($connect,$GetAllStudentsQuery);
if (mysqli_num_rows($GetAllStudentsExecute)==0)
{
	echo"<h4>There are no students currently registered</h4>";
}
else
{
?>
<table border = "1" class="table">
<tr class="rowH">
<td>User_ID</td>
<td>First Name</td>
<td>Last Name</td>
<td>Program</td>
<td>Date Of Birth</td>
<td>Phone Number</td>
<td>Email Address</td>
<td></td>
</tr>
<?php
while($Arr=mysqli_fetch_array($GetAllStudentsExecute))
{
	echo 	'<tr>
				<td class="column">'.$Arr['User_ID'].'</td>
				<td class="column">'.$Arr['F_Name'].'</td>
				<td class="column">'.$Arr['L_Name'].'</td>
				<td class="column">'.$Arr['Prog_ID'].'</td>
				<td class="column">'.$Arr['DOB'].'</td>
				<td class="column">'.$Arr['Phone_Num'].'</td>
				<td class="column">'.$Arr['Email_Add'].'</td>
				<td class="column"><input type="button" onclick="window.location = \'StudentRecords.php?UID='.$Arr['User_ID'].'\'" value="View Records" class="buttonA"></td>
			</tr>';
}
echo"</table>";
}
echo"<h1> ALL CURRENTLY REGISTERED TEACHERS </h1>";
$GetAllTeachersQuery = "SELECT People.User_ID , People.F_Name , People.L_Name , Teacher.Dept_ID , People.DOB , People.Phone_Num , People.Email_Add From People INNER JOIN Teacher WHERE People.User_ID=Teacher.User_ID";
$GetAllTeachersExecute = mysqli_query($connect,$GetAllTeachersQuery);
?>

<table border="1" class="table">
<tr class="rowH">
<td>User_ID</td>
<td>First Name</td>
<td>Last Name</td>
<td>Department</td>
<td>Date Of Birth</td>
<td>Phone Number</td>
<td>Email Address</td>
<td></td>
</tr>
<?php
while($Arr1=mysqli_fetch_array($GetAllTeachersExecute))
{
	echo 	'<tr>
				<td class="column">'.$Arr1['User_ID'].'</td>
				<td class="column">'.$Arr1['F_Name'].'</td>
				<td class="column">'.$Arr1['L_Name'].'</td>
				<td class="column">'.$Arr1['Dept_ID'].'</td>
				<td class="column">'.$Arr1['DOB'].'</td>
				<td class="column">'.$Arr1['Phone_Num'].'</td>
				<td class="column">'.$Arr1['Email_Add'].'</td>
				<td class="column"><input type="button" onclick="window.location = \'RegTeachCor.php?UID='.$Arr1['User_ID'].'\'" value="Courses taught" class="buttonA"></td>
			</tr>';
}
?>
<td colspan="8" class="column"><input type="submit" name="AddTeacher" value="Register a New Teacher" class="buttonA"></td>
<?php
echo"</table>";

?>

<h1> ALL CURRENTLY REGISTERED ADMINS</h1>
<table border="1" class="table">
<tr class="rowH">
<td>User_ID</td>
<td>First Name</td>
<td>Last Name</td>
<td>Date Of Birth</td>
<td>Phone Number</td>
<td>Email Address</td>
</tr>
<?php
$GetAllAdminsQuery = "SELECT People.User_ID , People.F_Name , People.L_Name , People.DOB , People.Phone_Num , People.Email_Add From People WHERE People.Acc_type = 'A'";
$GetAllAdminsExecute = mysqli_query($connect,$GetAllAdminsQuery);
while($Arr2=mysqli_fetch_array($GetAllAdminsExecute))
{
	echo 	'<tr>
				<td class="column">'.$Arr2['User_ID'].'</td>
				<td class="column">'.$Arr2['F_Name'].'</td>
				<td class="column">'.$Arr2['L_Name'].'</td>
				<td class="column">'.$Arr2['DOB'].'</td>
				<td class="column">'.$Arr2['Phone_Num'].'</td>
				<td class="column">'.$Arr2['Email_Add'].'</td>
			</tr>';
}
?>
<td colspan="6" class="column"><input type="submit" name="AddAdmin" value="Register a New Admin" class="buttonA"></td>
<?php
echo"</table>";	
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
