<form action = "<?php echo $_SERVER['PHP_SELF']; ?> ?UID=<?php echo trim($_REQUEST['UID']); ?> " method = "POST" size="3">
head>
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
		background:white;
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
		padding:1%;
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
		.buttonAdd{
		line-height:40px;
		font-size: 20px;
		font-weight:bold;;
		background:white;
        width:auto;
		border:1px solid black;			
	}
	.buttonAdd:hover{
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
else if(!isset($_REQUEST['UID']))
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
	<?php
	if(isset($_POST['back']))
	{
		header("Location: AdminHome.php");
	}
	if(isset($_REQUEST['cid']))
	{
		$cid=$_REQUEST['cid'];
		$uid=$_REQUEST['UID'];
		$AddTeachTeachQuery="INSERT INTO Teaching (Course_ID,User_ID)Values('$cid','$uid')";
		$AddTeachTeachExecute=mysqli_query($connect,$AddTeachTeachQuery);
		if($AddTeachTeachExecute)
		{
			echo "<h1>This teacher has successfully been registred to teach $cid</h1>";
			header("Location: RegTeachCor.php?UID={$_REQUEST['UID']}");
		}
		else
		{
			echo mysqli_error($connect);
		}
			
	}
	?>
	<h1> Courses taught By 
	<?php
	$GetNameQuery="SELECT F_name, L_name FROM People WHERE User_ID = '{$_REQUEST['UID']}'";
	$GetNameExecute=mysqli_query($connect,$GetNameQuery);
	if($i=mysqli_fetch_row($GetNameExecute))
	{
		$firstName=$i[0];
		$lastName=$i[1];
	}
	echo "$firstName $lastName";
	echo "</h1>";
	$GetAllCoursesTaughtQuery = "SELECT teaching.Course_ID, course.NAME,course.Description FROM teaching,course WHERE teaching.Course_ID=course.Course_ID AND teaching.User_ID='{$_REQUEST['UID']}'";
	$GetAllCoursesTaughtExecute=mysqli_query($connect,$GetAllCoursesTaughtQuery);
	if((mysqli_num_rows($GetAllCoursesTaughtExecute))==0)
	{
		echo "<h3>This teacher is Not teaching any courses yet</h3>";
	}
	else
	{
		?>
		<table border="1" class="table">
		<tr class="rowH">
		<th>Course ID </th>
		<th>Name</th>
		<th>Description</th>
		</tr>
		<?php
		while($C=mysqli_fetch_array($GetAllCoursesTaughtExecute))
		{
			echo 	'<tr>
						<td class="column">'.$C['Course_ID'].'</td>
						<td class="column">'.$C['NAME'].'</td>
						<td class="column">'.$C['Description'].'</td>
					</tr>';
		}
		echo "</table>";
	}
	?>
	<br>
	<h3>Make them a teacher for a course by registering them in the table below<h3>
	<h4>Available courses for this teachers department : 
	<?php
	$GetDeptQuery="SELECT Dept_ID FROM Teacher WHERE User_ID='{$_REQUEST['UID']}'";
	$GetDeptExecute=mysqli_query($connect,$GetDeptQuery);
	while($r=mysqli_fetch_array($GetDeptExecute))
	{
		$depId=$r[0];
		echo "$depId</h4>";
	}

	$GetAvailCourseDeptQuery="SELECT course.Course_ID,course.NAME,course.Description FROM course WHERE course.Prog_ID IN (SELECT program.Prog_ID FROM program WHERE program.Dept_ID = '$depId') AND course.Course_ID NOT IN (SELECT teaching.Course_ID FROM teaching WHERE teaching.User_ID='{$_REQUEST['UID']}')";
	$GetAvailCourseDeptExecute=mysqli_query($connect,$GetAvailCourseDeptQuery);
	if(mysqli_num_rows($GetAvailCourseDeptExecute)==0)
	{
		echo "<h4>There are no more courses available for this teachers Department or </h4>";
		echo "<h4>This teacher is teaching all the courses in their department:($depId) </h4>";
	}
	else
	{
		?>
		<table border="1" class="table">
		<tr class="rowH">
		<th>Course ID</th>
		<th>Name</th>
		<th>Description</th>
		<th></th>
		</tr>
		<?php
		while($d=mysqli_fetch_array($GetAvailCourseDeptExecute))
		{
			echo 	'<tr>
					<td class="column">'.$d['Course_ID'].'</td>
					<td class="column">'.$d['NAME'].'</td>
					<td class="column">'.$d['Description'].'</td>
					<td class="column" ><input type="button" onclick="window.location = \'RegTeachCor.php?UID='.$_REQUEST['UID'].'&cid='.$d['Course_ID'].'\'" value="Register teacher to teach this course" class="buttonAdd"></td></tr>';
		}
		echo "</table>";
	}

	?>
	</br>
	</br>
	<input type="submit" name="back" value="Back to Home Page" class="buttonA">
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