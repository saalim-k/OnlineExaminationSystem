<form action = "<?php echo $_SERVER['PHP_SELF']; ?> ?cid=<?php echo trim($_REQUEST['cid']); ?> " method = "POST" size="3">
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
	.tableQ{
		width:100%;
		height:auto;
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
	.columnQ{
		padding-top:1%;
		padding-bottom:1%;
		padding-left:1%;
		width:100%;
		height:auto;
		text-align:left;
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
	.header{
		width:10%;
	}
</style>
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
	<table class="table" border="1">
	<tr class="rowH">
	<th>Course ID</th>
	<th>Test ID</th>
	<th>Test Name</th>
	<th>Test Date</th>
	<th>Start Time</th>
	<th>Duration</th>
	<th>End Time</th>
	<th>Created By</th>
	<th></th>
	</tr>
	<?php
	$getAllTests="SELECT test.*,people.F_Name,people.L_Name FROM test,people WHERE test.Course_ID ='{$_REQUEST['cid']}' AND test.User_ID=people.User_ID";
	$getAllTestsExec=mysqli_query($connect,$getAllTests);
	while ($x=mysqli_fetch_array($getAllTestsExec))
	{
		$coid=$x['Course_ID'];
		$tid=$x['Test_ID'];
		$tn=$x['Name'];
		$td=$x['Date'];
		$tst=$x['Start_time'];
		$tdu=$x['Duration'];
		$tet=$x['End_time'];
		$tcby=$x['F_Name']." ".$x['L_Name'];
		
		echo 	'<tr>
				<td class="column">'.$coid.'</td>
				<td class="column">'.$tid.'</td>
				<td class="column">'.$tn.'</td>
				<td class="column">'.$td.'</td>
				<td class="column">'.$tst.'</td>
				<td class="column">'.$tdu.'</td>
				<td class="column">'.$tet.'</td>
				<td class="column">'.$tcby.'</td>
				<td class="column"><input type="button" onclick="window.location = \'uploadedTests.php?cid='.$coid.'&tid='.$tid.'&tname='.$tn.'\'" value="View Questions" class="buttonA"></td></tr>';
	}
	echo '</table><br><br><br>';
	if((isset($_REQUEST['tid']))&&(isset($_REQUEST['tname'])))
	{
		echo 	'<table class="tableQ">
				<tr><th class="header">Test Name</th><th>:</th><th class="columnQ">'.$_REQUEST['tname'].'</th></tr>
				<tr><th class="header">Test ID</th><th>:</th><th class="columnQ">'.$_REQUEST['tid'].'</th></tr>
				</table><hr><hr>';
		$getAllQuestions="SELECT Questions.*,test.Name FROM questions,test WHERE questions.Test_ID='{$_REQUEST['tid']}' AND questions.Test_ID=test.Test_ID";
		$getAllQExec=mysqli_query($connect,$getAllQuestions);
		while($y=mysqli_fetch_array($getAllQExec))
		{
			echo 	'<table class="tableQ">';
			$tqn=$y['Q_No'];
			$tqd=$y['Q_Desc'];
			$toa=$y['Q_Option_A'];
			$tob=$y['Q_Option_B'];
			$toc=$y['Q_Option_C'];
			$tod=$y['Q_Option_D'];
			$tco=$y['Q_Correct_Option'];
			$tm=$y['Q_Marks'];
			
			echo 	'<tr><th class="header">Question Number</th><th>:</th><td class="columnQ">'.$tqn.'</td></tr>
					<tr><th class="header">Question Description</th><th>:</th><td class="columnQ">'.$tqd.'</td></tr>
					<tr><th class="header">Option A</th><th>:</th><td class="columnQ">'.$toa.'</td></tr>
					<tr><th class="header">Option B</th><th>:</th><td class="columnQ">'.$tob.'</td></tr>
					<tr><th class="header">Option C</th><th>:</th><td class="columnQ">'.$toc.'</td></tr>
					<tr><th class="header">Option D</th><th>:</th><td class="columnQ">'.$tod.'</td></tr>
					<tr><th class="header">Correct Option</th><th>:</th><td class="columnQ">'.$tco.'</td></tr>
					<tr><th class="header">Question Marks</th><th>:</th><td class="columnQ">'.$tm.'</td></tr>
					</table><br><hr>';
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
