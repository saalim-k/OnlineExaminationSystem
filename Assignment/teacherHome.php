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
		display: inline-block;
		justify-content:center;
		margin-top:20px;
		margin-left:2%;
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
		border:1px solid black;
		background:white;
        width:auto;		
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
		width:50%;
	    float:left;
	    line-height:100px;
		font-size: 30px;
		color: white;
		letter-spacing: 5px;
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
		text-align:center;
		font-size:20px;
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
else if ($_SESSION['AccType']!= 'T')
{
	echo"<h1>You are not a Teacher</h1>";
	header("refresh:5;login.php");
}
else
{
?>

<div id= "header">
<div id ="wrapper">
<div id ="logo"><label>TEACHER MANAGEMENT SYSTEM</label></div>
<div id ="menu">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<input type="submit" name="home" value="HOME" class="button">
<input type="submit" name="graded" value="GRADED TEST" class="button">
<input type="submit" name="MyProfile" value="MY PROFILE" class="button">
<input type="submit" name="logout" value="LOG OUT" class="button">
</div>
</div>
</div>
</form>
<body style="background-color:#bdc3c7">
<div class="user">
<label class="username"><?php echo "Username&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp".$_SESSION['User']."";?></label><br><br>
<label class="acctype"><?php echo 'Account Type&nbsp:&nbsp &nbsp'. yourAcType().'';?></label>
</div>
<div id="div1" class="center">
<?php
if(isset($_POST['home']))
{
	header("Location: teacherHome.php");
}
if(isset($_POST['graded']))
{
	header("Location: gradedTests.php");
}
if(isset($_POST['MyProfile']))
{
	header("Location: MyProfile.php");
}
if(isset($_POST['logout']))
{
	setcookie("username", $_SESSION["User"], time() -100, "/");
	setcookie("password", $_SESSION["Pass"], time()-100,"/");
	setcookie("AccType", $_SESSION["AccType"], time()-100,"/");
	session_destroy();
	header("refresh:0");
}
?>
<h1>Courses Where I am currently Teaching</h1>

<?php
$GetMyUidQuery="SELECT User_ID FROM Account WHERE USERNAME = '{$_SESSION['User']}'";
$GetMyUidExec=mysqli_query($connect,$GetMyUidQuery);
if($a=mysqli_fetch_array($GetMyUidExec))
{
	$MyUid=$a['User_ID'];
}
else
{
	echo mysqli_error($connect);
}
$GetMyCoTeQuery="Select * from Teaching WHERE User_ID='$MyUid'";
$GetMyCoTeExec=mysqli_query($connect,$GetMyCoTeQuery);
echo '</br><table border="1" class="table"><tr class="rowH"><th colspan="4">Course</th></tr>';
while($b=mysqli_fetch_array($GetMyCoTeExec))
{
	echo	'<tr><td  class="column" >'.$b['Course_ID'].'</td>
			<td class="column"><input type="button" onclick="window.location = \'uploadTest.php?UID='.$MyUid.'&cid='.$b['Course_ID'].'\'" value="Set Test" class="buttonA"></td>
			<td class="column"><input type="button" onclick="window.location = \'MyStudents.php?UID='.$MyUid.'&cid='.$b['Course_ID'].'\'" value="Students" class="buttonA"></td>
			<td class="column"><input type="button" onclick="window.location = \'uploadedTests.php?cid='.$b['Course_ID'].'\'" value="View Uploaded tests" class="buttonA"></td>
			</tr>';
}
echo '</table>';
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
</body>

