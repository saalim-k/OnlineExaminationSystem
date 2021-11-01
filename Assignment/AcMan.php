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
		display: inline;
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
		font-weight:bold;
		background:white;
		border:1px solid black;
        width:auto;		
	}
	.buttonA:hover{
		    background:grey;
			color: white;
	}
	.buttonBack{
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
	.buttonBack:hover{
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
	if(isset($_POST['Gtest']))
	{
		header("Location: gradedTests.php");
	}	
	if(isset($_POST['AcMan']))
	{
		header("Location: AcMan.php");
	}
	if(isset($_POST['MyProfile']))
	{
		header("Location:MyProfile.php");
	}
	if(isset($_POST['logout']))
	{
		setcookie("username", $_SESSION["User"], time() -100, "/");
		setcookie("password", $_SESSION["Pass"], time()-100,"/");
		setcookie("AccType", $_SESSION["AccType"], time()-100,"/");
		session_destroy();
		header("refresh:0");
		
	}
	if(isset($_POST['ACor']))
	{
		header("Location:AddCor.php");
	}
	if(isset($_POST['AProg']))
	{
		header("Location:AddProg.php");
	}
	if(isset($_POST['Adept']))
	{
		header("Location:AddDept.php");
	}
	?>
	<h1>DEPARTMENT</h1>
	<table border = "1" class="table">
	<tr class="rowH">
	<td>Department ID</td>
	<td>Name</td>
	<td>Description</td>
	</tr>
	<?php
	$GetAllDeptQuery="SELECT * FROM Department";
	$GetAllDeptExecute=mysqli_query($connect,$GetAllDeptQuery);
	while($i=mysqli_fetch_array($GetAllDeptExecute))
	{
		echo 	'<tr>
				<td class="column">'.$i['Dept_ID'].'</td>
				<td class="column">'.$i['Name'].'</td>
				<td class="column">'.$i['Description'].'</td>
				</tr>';
	}
	?>
	<tr><td colspan="3" class="column"><input type="submit" name="Adept" Value="Add more Departments" class="buttonA"></td>
	</table>
	
	<h1>PROGRAMS</h1>
	<table border="1" class="table">
	<tr class="rowH">
	<td>Program ID</td>
	<td>Name</td>
	<td>Description</td>
	<td>Department</td>
	</tr>
	<?php
	$GetAllProgQuery="SELECT * FROM Program";
	$GetAllProgExecute=mysqli_query($connect,$GetAllProgQuery);
	While($j=mysqli_fetch_array($GetAllProgExecute))
	{
		echo 	'<tr>
				<td class="column">'.$j['Prog_ID'].'</td>
				<td class="column">'.$j['NAME'].'</td>
				<td class="column">'.$j['Description'].'</td>
				<td class="column">'.$j['Dept_ID'].'</td>
				</tr>';
	}
	?>
	<tr><td colspan="4" class="column"><input type="submit" name="AProg" value="Add more programs" class="buttonA"></td>
	</table>
	
	<h1>COURSES</h1>
	<table border="1" class="table">
	<tr class="rowH">
	<td>Course ID</td>
	<td>Name</td>
	<td>Description</td>
	<td>Program</td>
	</tr>
	<?php
	$GetAllCorQuery="SELECT * FROM course";
	$GetAllCorExecute=mysqli_query($connect,$GetAllCorQuery);
	While($k=mysqli_fetch_array($GetAllCorExecute))
	{
		echo 	'<tr>
				<td class="column">'.$k['Course_ID'].'</td>
				<td class="column">'.$k['NAME'].'</td>
				<td class="column">'.$k['Description'].'</td>
				<td class="column">'.$k['Prog_ID'].'</td>
				</tr>';
	}
	?>
	<td colspan="4" class="column"><input type="submit" name="ACor" value="Add more Courses" class="buttonA"></td>
	</table>

	</br>
	</br>
	<input type="button" onclick="window.location = '/Assignment/login.php'" value = "Back to Home Page" class="buttonBack">
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