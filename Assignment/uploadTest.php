<form action = "<?php echo $_SERVER['PHP_SELF']; ?> ?UID=<?php echo trim($_REQUEST['UID']); ?>&cid=<?php echo trim($_REQUEST['cid']);?> " method = "POST" size="3">
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
		width: 50%;
		margin-left:25%;		
	}
	.column{
		width:30%;
		text-align:center;
		height:10px;
		font-weight:bold;
		font-size:20px;
	}
	 #input{
		width:100%;
		padding-top:2%;
		padding-bottom:2%;
		text-align:center;
		font-size:18px;
		background:white;
		
	}
	h1{
		text-align:center;
		padding-top:3%;
		padding-bottom:1%;
		
	}
	h3{
		text-align:center;
	}
	.center{
		margin-top:25px;
		margin-left:auto;
		margin-right:auto;
		width:40%;
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
	#wrapper
	{
		width: 1531px;
		margin: 0 auto;
	}
	.link
	{
		font-size:40px;
		margin-top:8%;
		font-size:20px;
		margin-left:2%;
		color:black;
	}
	.link a
	{
		color:black;
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
		letter-spacing:5px;
	}
	.buttonA:hover{
		background:grey;
		color: white;
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
	.username{
		color:black;
		text-align:right;
		font-size:30px;
	}
	.user{
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
date_default_timezone_set("Asia/Kuala_Lumpur");
function getduration($st,$et)
{
	$b4=strtotime($st);
	$aft=strtotime($et);
	$dur=$aft-$b4;
	if($dur<0)
		return -1;
	else
	return ($dur/3600);
}
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
</div>
</div>
<div class ="link">
<a href='login.php'>BACK</a>
</div>
<body style="background-color:#bdc3c7">
<div class="user">
<label class="username"><?php echo "Username&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp".$_SESSION['User']."";?></label><br><br>
<label class="acctype"><?php echo 'Account Type&nbsp:&nbsp &nbsp'. yourAcType().'';?></label>
</div>
<div id="div1" class="center">
<?php 
echo "<h1>Please insert the test information below for {$_REQUEST['cid']}.</h1>";

?>
<table class="table">
<tr>
<td class="column">Name:</td>
<td><input type="text" name="nm" value="<?php if(isset($_POST['nm']))echo $_POST['nm'] ?>" required id="input"></td>
</tr>
<tr>
<td class="column">Date:</td>
<td><input type="Date" name="dt" value="<?php if(isset($_POST['dt']))echo $_POST['dt'] ?>" required min="<?php echo date('Y-m-d') ?>" id="input"></td>
</tr>
<tr>
<td class="column">Start time:</td>
<td><input type="time" name="st" required value="<?php if(isset($_POST['st']))echo $_POST['st'] ?>" id="input"></td>
</tr>
<tr>
<td class="column">End time:</td>
<td><input type="time" name="et" required value="<?php if(isset($_POST['et']))echo $_POST['et'] ?>" id="input"></td>
</tr>
<tr>
<td class="column">No of questions</td>
<td><input type="number" name="qn" required min="1" value="<?php if(isset($_POST['qn']))echo $_POST['qn'] ?>" id="input"></td>
</tr>
<tr>
<td colspan="2" class="column"><input type="submit" name="next" value="Next" class="buttonA"></td>
</tr>
</table>
<?php

if(isset($_POST['next']))
{
	$uid=$_REQUEST['UID'];
	$cid=$_REQUEST['cid'];
	$nm=$_POST['nm'];
	$dt=$_POST['dt'];
	$st=$_POST['st'];
	$et=$_POST['et'];
	$qn=$_POST['qn'];
	$dur= getDuration($st,$et);
	?>
	<input type="Hidden" name="next" >
	
	<?php
	if($dur==-1)
	{
		echo"<h4>End time cannot be before start time<h4>";
	}
	else
	{
		for($i=1;$i<=$qn;$i++)
		{
			echo 	'<hr/><table border="1" class="table"><tr><th colspan="2" class="rowH">No:'.$i.'</th></tr>
					<tr><td class="column">Marks</td><td><input type="number" name="'.$i.'M" id="input"></td></tr>
					<tr><td class="column">Description</td><td><textarea name="'.$i.'Desc"  id="input"></textarea></td></tr>
					<tr><td class="column">Option A</td><td><input type="text" name="'.$i.'OA"  id="input"></td></tr>
					<tr><td class="column">Option B</td><td><input type="text" name="'.$i.'OB"  id="input"></td></tr>
					<tr><td class="column">Option C</td><td><input type="text" name="'.$i.'OC"  id="input"></td></tr>
					<tr><td class="column">Option D</td><td><input type="text" name="'.$i.'OD"  id="input"></td></tr>
					<tr><td class="column">Correct option</td><td><select name="'.$i.'CO"  id="input"><option value="A">A</option>
					<option value="B">B</option><option value="C">C</option><option value="D">D</option></select></td></tr><table>
					<hr/>';
		}
		?>
		<table>
		<input type="submit" name="upload" value="Upload test" class="buttonA">
		</table>
		<?php
	}
	
}
if(isset($_POST['upload']))
{
	$InsertIntoTestquery="INSERT INTO test(Name,Date,Start_Time,Duration,End_Time,Course_ID,User_ID) VALUES('$nm','$dt','$st','$dur','$et','$cid','$uid')";
	$InsertIntoTestExec=mysqli_query($connect,$InsertIntoTestquery);
	if(!$InsertIntoTestExec)
	{
		echo mysqli_error($connect);
	}
	else
	{
	echo "Update successful";
	for ($j=1;$j<=$qn;$j++)
	{
		$getName="Select Test_ID FROM test WHERE Name ='$nm' ";
		$getnExec=mysqli_query($connect,$getName);
		if($n=mysqli_fetch_array($getnExec))
		{
			$tid=$n['Test_ID'];
		}
		$noq=$j;
		$mk=$_POST[$j.'M'];
		$qd=$_POST[$j.'Desc'];
		$qoa=$_POST[$j.'OA'];
		$qob=$_POST[$j.'OB'];
		$qoc=$_POST[$j.'OC'];
		$qod=$_POST[$j.'OD'];
		$co=$_POST[$j.'CO'];
		$InsertIntoQQuery="INSERT INTO questions(Test_ID,Q_No,Q_Marks,Q_Desc,Q_Option_A,Q_Option_B,Q_Option_C,Q_Option_D,Q_Correct_Option) VALUES('$tid','$noq','$mk','$qd','$qoa','$qob','$qoc','$qod','$co')";
		$InsertIntoQExec=mysqli_query($connect,$InsertIntoQQuery);
		if($InsertIntoQExec)
			echo"update successfull";
		else
			echo mysqli_error($connect);
	}
	}
	$msg="Test Has Been Added!";
	echo "<script type='text/javascript'>alert('$msg');window.location.href = 'login.php';</script>";
	
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
</body>
</div>
