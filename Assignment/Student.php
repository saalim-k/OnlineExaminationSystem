<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
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
	.tableW{
		width: 100%;		
	}
	h1{
		text-align:center;
		padding-top:3%;
		padding-bottom:1%;
		
	}
	h3{
		text-align:center;
	}
	.urPrg{
		text-align:right;
		padding-right:5%;
	}
	
	.hello{
		text-align:left;
		padding-left:5%;
		font-size:50px;
		padding-bottom:0%;
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
		line-height:60px;
		border: none;
		color: white;
		text-decoration: none;
		font-size: 20px;
		width: 150px;
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
		border:none;
		background:white;
        width:auto;
		box-shadow: 0 0 10px #ddd;			
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
		width:40%;
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
	.row
	{
		text-align: center;
		font-size: 20px;
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
	}

	.columnYesNo
	{
		padding-top:1%;
		padding-bottom:1%;
		width:50%;
	}
	
	.buttonYESNO
	{
		display:flex;
		line-height:50px;
		font-size: 50px;
		font-weight:bold;
		border:none;
		background:white;
        width:auto;	
		margin-left:50%;
		padding-left:1%;
		padding-right:1%;
	}
	.buttonYESNO:hover
	{
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
date_default_timezone_set('Asia/Kuala_Lumpur');
if((isset ($_COOKIE["username"])) && (isset($_COOKIE["password"])) && (isset($_COOKIE["AccType"])))
{
	$USERNAME = $_COOKIE["username"];
	$PASSWORD = $_COOKIE["password"];
	$AccType = $_COOKIE["AccType"];
	$_SESSION["User"]= $USERNAME;
	$_SESSION["Pass"] = $PASSWORD;
	$_SESSION["AccType"] = $AccType;
}
if ((!isset($_SESSION['User'])) && (!isset($_SESSION['Pass'])) && (!isset($_SESSION['AccType'])))
{
	header ("Location:login.php");
}
else
{
?>
<div id= "header">
<div id ="wrapper">
<div id ="logo"><label>STUDENT EXAMINATION SYSTEM</label></div>
<div id ="menu">
<input type= "submit"  name="Home" value="HOME" class ="button">
<input type = "submit" name="MyProfile"   value = "MY PROFILE" class ="button">
<input type ="submit" name = "history" value ="HISTORY" class ="button">
<input type ="submit" name = "rank" value ="RANKING" class ="button">
<input type ="submit" name = "logout" value ="LOG OUT" class ="button"><br><br>
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
if (isset($_POST ['Home']))
{
	header("Location:login.php");
}
if (isset($_POST ['MyProfile']))
{
	header("Location:MyProfile.php");
}
if (isset($_POST ['history']))
{
	header("Location:Student_History.php");
}
if (isset($_POST ['rank']))
{
	header("Location:gradedTests.php");
}
if (isset($_POST ['logout']))
 {
	setcookie("username", $_SESSION["User"], time()-100, "/");
	setcookie("password", $_SESSION["Pass"], time()-100, "/");
	setcookie("AccType", $_SESSION["AccType"], time()-100, "/");
	session_destroy();
	header("refresh:0");
 }
 
	$GetMyUserIdQuery="Select People.User_ID,People.F_Name,student.Prog_ID FROM People INNER JOIN Account ON People.User_ID=Account.User_ID AND Account.USERNAME='{$_SESSION['User']}' INNER JOIN student ON student.User_ID=Account.User_ID";
	$GetMyUserIdExecute=mysqli_query($connect,$GetMyUserIdQuery);
	if($row=mysqli_fetch_row($GetMyUserIdExecute))
	{
		$Uid=$row[0];
		$name = $row[1];
		$Prog= $row[2];
	}
	if (isset($_REQUEST ['CID']))
	{
		$CourseID= $_REQUEST ['CID'];
		echo "<h1>Are you sure you want to enroll in $CourseID?</h1><br>";
		echo '<table class="table"><tr ><td class="columnYesNo" ><input type="button" onclick="window.location =\'Student.php?yes='.$_REQUEST['CID'].'\'" value="YES" class="buttonYESNO"></td><td class="columnYesNo"><input type="button" onclick="window.location =\'Student.php\'" value="NO" class="buttonYESNO"></td></tr></table>';
	}	
	else if (isset($_REQUEST['yes']))
	{
		echo $Uid;
		$Success= trim($_REQUEST['yes']); 
		$enrollQuery = "INSERT INTO enrolled (User_ID, Course_ID) VALUES ('$Uid', '$Success')";
		$enrollCourse = mysqli_query($connect,$enrollQuery);
			
		if ($enrollCourse)
		{
			header("Location:Student.php");
		}
		else 
		{
			echo "There is a problem enrolling because ".mysqli_error($connect); 
		}
	}
	else
	{
		echo"<table class='tableW'>
		<tr><td><h1 class='hello'>Welcome $name</h1></td><td><h1 class='urPrg'>Your Program: $Prog</h1></td>
		<tr></table>";
		echo"<h1>ENROLLED COURSES</h1>";
		$enrolledCourse = mysqli_query ($connect, "SELECT course.* FROM course WHERE course.Course_ID IN (SELECT enrolled.Course_ID FROM enrolled WHERE enrolled.User_ID ='$Uid')");
		if ($ec = mysqli_num_rows ($enrolledCourse)==0)
		{
			echo "<h3>You have not enrolled in any of the courses</h3>";
		}
		else
		{
			echo"<table border='1'  class ='table'>
			<tr class = 'rowH'><td class = 'rowH'>Course ID</td><td class ='rowH'>Course Name</td><td class ='rowH'></td></tr>";	
			while ($rowE = mysqli_fetch_array ($enrolledCourse))
			{
				echo '<tr class = "row">
					 <td class="column">'.$rowE['Course_ID'].'</td>
					 <td class="column">'.$rowE['NAME'].'</td>
					 <td class="column"><input type="button" onclick="window.location = \'Student_Test.php?cid='.$rowE['Course_ID'].'\'" value="View Available Test" class="buttonA"></td>
					 </tr>';
			}
			echo "</table>";
			echo "<br><br>";
		}
		echo "<h1>AVAILABLE COURSES</h1>";
		$allCourseQuery= "SELECT  course.* FROM course WHERE course.Course_ID NOT IN (SELECT enrolled.Course_ID FROM enrolled WHERE enrolled.User_ID ='$Uid') AND course.Prog_ID IN (SELECT student.Prog_ID FROM student WHERE student.User_ID='$Uid')";
		$allCourse = mysqli_query ($connect,$allCourseQuery);
		if ($ac = mysqli_num_rows ($allCourse)==0)
		{
			echo "<h3>You have enrolled in all the courses</h3>";
		}
		else
		{
			echo "<table border='1' class ='table'>
			<tr class = 'rowH'><td class = 'rowH'>Program ID</td><td class = 'rowH'>Course ID</td><td class = 'rowH'>Course Name</td><td class = 'rowH'>Description</td><td class = 'rowH'></td></tr>";

			while ($rowAll = mysqli_fetch_array($allCourse))
			{
				echo '<tr class = "row">
				<td class="column">'.$rowAll['Prog_ID'].'</td>
				<td class="column">'.$rowAll['Course_ID'].'</td>
				<td class="column">'.$rowAll['NAME'].'</td>
				<td class="column">'.$rowAll['Description'].'</td>
				<td class="column"><input type= "button" onclick="window.location = \'Student.php?CID='.$rowAll['Course_ID'].'\'" class="buttonA" Value = "Enroll"></td>
				</tr>';
			}
			echo "</table>";
			echo "<br><br>";
		}
	}
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
</table>
</form>


	  
	
