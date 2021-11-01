<form action = "<?php echo $_SERVER['PHP_SELF']; ?> ?UID=<?php echo trim($_REQUEST['UID']); ?>&cid=<?php echo trim($_REQUEST['cid']);?>&studid=<?php echo trim($_REQUEST['studid']);?> " method = "POST" size="3">
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
	$GetNameQuery="SELECT F_name, L_name FROM People WHERE User_ID = '{$_REQUEST['studid']}'";
	$GetNameExecute=mysqli_query($connect,$GetNameQuery);
	if($i=mysqli_fetch_row($GetNameExecute))
	{
		$firstName=$i[0];
		$lastName=$i[1];
	}
	echo "</h1>";
	?>
	<h1>Tests taken and marks by
	<?php
	echo "$firstName $lastName for {$_REQUEST['cid']} </h1>";
	$getAllTid4User= "SELECT testrec.Test_ID FROM testrec JOIN test ON testrec.Test_ID = test.Test_ID JOIN account ON testrec.User_ID=account.User_ID JOIN course ON test.Course_ID=course.Course_ID WHERE Account.User_ID ='{$_REQUEST['studid']}' AND test.Course_ID='{$_REQUEST['cid']}'";
	$getAllTid4UserExec = mysqli_query($connect,$getAllTid4User);
	if(mysqli_num_rows($getAllTid4UserExec)==0)
		{
			echo "<h3>This student has not sat for any tests yet.</h3>";
		}
	else
	{
		
		?>
		<table border ='1' class="table">
		<tr class="rowH">
		<th>Test ID</th>
		<th>Test Name</th>
		<th>Course ID</th>
		<th>Date Taken</th>
		<th>Marks</th>
		<th>Marks(%)</th>
		<th>Grade</th>
		<th></th>
		</tr>
				
		<?php
		while ($allTid = mysqli_fetch_array($getAllTid4UserExec))
		{
			
			$result = "SELECT testrec.*,test.Name,test.Course_ID,test.Date,(SELECT SUM(questions.Q_Marks) AS total FROM questions JOIN test ON questions.Test_ID=test.Test_ID JOIN testrec ON test.Test_ID=testrec.Test_ID WHERE testrec.User_ID='{$_REQUEST['studid']}' AND testrec.Test_ID='{$allTid['Test_ID']}')AS total FROM testrec JOIN test ON testrec.Test_ID = test.Test_ID WHERE testrec.User_ID = '{$_REQUEST['studid']}' AND testrec.Test_ID='{$allTid['Test_ID']}'";
			$resultExec=mysqli_query($connect, $result);
			if ($all = mysqli_fetch_array($resultExec))
			{
				$td= $all['Test_ID'];
				$name= $all['Name'];
				$cid= $all['Course_ID'];
				$date= $all['Date'];
				$m= $all ['Marks'];
				$tot= $all ['total'];
			?>
			<tr>
			<td class="column"><?php echo $td; ?></td>
			<td class="column"><?php echo $name; ?></td>
			<td class="column"><?php echo $cid; ?></td>
			<td class="column"><?php echo $date ?></td>
			<td class="column"><?php echo $m.'/'.$tot; ?></td>
			<td class="column">
			<?php
			echo calculateMark($m,$tot); ?>
			</td>
			<td class="column">
			<?php
			$g=grade($m,$tot);
			echo $g; ?>
			</td>
			<td class="column">
			<?php
			echo isPass($g); ?>
			</td>
			</tr>
			
			<?php	
			
			}
			else
			{
				echo mysqli_error($connect);
			}
			
		}
		echo'</table>';
		
	}
}
function calculateMark($m,$tot)
		{
			$percentage = round(($m/$tot)*100,2);
			return $percentage;
		}
function grade($m,$tot)
{
	$percentage = round(($m/$tot)*100,2);
	
	if($percentage>=90)
	{
		return 'A+';
	}
	else if($percentage >= 80 )
	{
		return 'A';
	}
	else if($percentage >= 75)
	{
		return 'A-';
	}
	else if($percentage >=70)
	{
		return 'B+';
	}
	else if($percentage >= 65)
	{
		return 'B';
	}
	else if($percentage >= 60)
	{
		return 'B-';
	}
	else if($percentage >= 55)
	{
		return 'C+';
	}
	else if($percentage >= 50)
	{
		return 'C';
	}
	else if($percentage >= 45)
	{
		return 'C-';
	}
	else if($percentage >= 40)
	{
		return 'D';
	}
	else if($percentage <= 39)
	{
		return 'F';
	}
}
function isPass($g)
{
	if ($g=='C-' || $g=='D' || $g=='F')
	{
		return "FAIL";
	}
	else
	{
		return "PASS";
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