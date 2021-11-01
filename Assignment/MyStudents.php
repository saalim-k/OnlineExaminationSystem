<form action = "<?php echo $_SERVER['PHP_SELF']; ?> ?UID=<?php echo trim($_REQUEST['UID']); ?>&cid=<?php echo trim($_REQUEST['cid']);?> " method = "POST" size="3">
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
	.center{
		margin-top:25px;
		margin-left:auto;
		margin-right:auto;
		width:40%;
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
	#wrapper
	{
		width: 1531px;
		margin: 0 auto;
	}
	#menu
	{
		 margin: 0;
		 padding: 0;
		 text-align: center;
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
		font-size: 22px;
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
else if((!isset($_REQUEST['UID'])) && (!isset($_REQUEST['cid'])))
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
	//echo '<input type="button" onclick="window.location = \'login.php\'" value="Back">';
	echo '<h1>List of Students enrolled in '.$_REQUEST['cid'].'</h1>';
	$GetStudTakCorQ="SELECT People.* FROM People JOIN student ON People.User_ID=student.User_ID JOIN enrolled ON student.User_ID=enrolled.User_ID AND enrolled.Course_ID='{$_REQUEST['cid']}'";
	$GetStudTakCorE=mysqli_query($connect,$GetStudTakCorQ);
	if(($x=mysqli_num_rows($GetStudTakCorE))==0)
	{
		echo "<h3>There are no students enrolled in this course.</h3>";
	}
	else
	{
		?>
		<table border="1" class="table">
		<tr class="rowH"><th>Student ID</th><th>Name</th><th>phone number</th><th>Email Address</th><th></th></tr>
		<?php
		while($r=mysqli_fetch_array($GetStudTakCorE))
		{
		echo 	'<tr><td class="column">'.$r['User_ID'].'</td>
				<td class="column">'.$r['F_Name'].' '.$r['L_Name'].'</td>
				<td class="column">'.$r['Phone_Num'].'</td>
				<td class="column">'.$r['Email_Add'].'</td>
				<td class="column"><input type="button" onclick="window.location = \'TestsAndMarksByCourse.php?UID='.$_REQUEST['UID'].'&cid='.$_REQUEST['cid'].'&studid='.$r['User_ID'].'\'" value="Tests and Marks" class="buttonA"></td></tr>';
		}
	}
	/*while($r=mysqli_fetch_array($GetStudTakCorE))
	{
		echo 	'<tr><td class="column">'.$r['User_ID'].'</td></tr>';
	}*/
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
	