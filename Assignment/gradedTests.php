<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" size="5">
<head>
<style>
	body{
		margin:auto;
	}
	#div1{
		width: auto;
		position: relative;
		top: 5px;
		background: #ddd;
		margin:2%;
		height:auto;	
	}
	
	.table{
		background-color:white;
		width: 100%;
		margin:auto;
		border: 1px solid black;
		
		
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
	.link
	{
		font-size:40px;
		margin-top:8%;
	}
	
	.link a
	{
	  font-size:20px;
      margin-left:40px;
      color:black;
	  font-overline:0;
 	  
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
		#logoT
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
		padding-left:1%;
		padding-right:1%;
		width:auto;
		text-align:center;
		font-size:25px;
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
		line-height:20px;
		font-size: 20px;
		font-weight:bold;
		border:1px solid;
		background:#ddd;
        width:auto;		
	}
	.buttonA:hover{
		    background:grey;
			color: white;
	}
	.buttonView{
		line-height:40px;
		font-size: 20px;
		font-weight:bold;;
		background:white;
        width:auto;
		border:1px solid black;			
	}
	.buttonView:hover{
		    background:grey;
			color: white;
	}
	.tb
	{
		width:100%;
		padding:2%;
		font-size:15px;
		font-weight:bold;
		text-align:center;
	}
	.tableSearch{
		margin-left:78%;
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
else
{
	if($_SESSION['AccType']=='S')
	{
		?>
		<div id= "header">
		<div id ="wrapper">
		<div id ="logo"><label>STUDENT EXAMINATION SYSTEM</label></div>
		</div>
		</div>
		<div class="link">
		<a href='login.php'>BACK</a>
		</div>
		<?php
	}
	else if ($_SESSION['AccType']=='T')
	{
		?>
		<div id= "header">
		<div id ="wrapper">
		<div id ="logoT"><label>TEACHER MANAGEMENT SYSTEM</label></div>
		</div>
		</div>
		<div class="link">
		<a href='login.php'>BACK</a>
		</div>
		<?php
	}
	else
	{
		?>
		<div id= "header">
		<div id ="wrapper">
		<div id ="logo"><label>ADMIN MANAGEMENT SYSTEM</label></div>
		<div id ="menu">
		<input type="submit" name="Home" value="Home" class="button"></td>
		<input type="submit" name="Gtest" value="Graded Tests" class="button"></td>
		<input type="submit" name="AcMan" value="Academic Management" class="button"></td>
		<input type="submit" name="MyProfile" value="My Profile" class="button"></td>
		<input type="submit" name="logout" value="Log Out" class="button"></td>
		</div>
		</div>
		</div>
		<div class="link">
		<a href='login.php'>BACK</a>
		</div>
		<?php
	}
?>

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
	if(isset($_POST['logout']))
	{
		setcookie("username", $_SESSION["User"], time() -100, "/");
		setcookie("password", $_SESSION["Pass"], time()-100,"/");
		setcookie("AccType", $_SESSION["AccType"], time()-100,"/");
		session_destroy();
		header("refresh:0");
		
	}
	?>
	</br>
	<table class="tableSearch">
	<tr>
	<td><input type="text" name="txtSearch" class="tb"></td>
	<td><input type="submit" name="btnSearch" value="Search By Test ID" class="buttonA"></td>
	</tr>
	</table>
	</br>
	<?php
	if(isset($_POST['btnSearch']))
	{
		$search=$_POST['txtSearch'];
		$getSearchedTest="SELECT SUM(questions.Q_Marks) AS TotalMarks,test.Test_ID,test.Name,test.Date,course.NAME FROM questions,test,course WHERE questions.Test_ID=test.Test_ID AND test.Course_ID=course.Course_ID AND test.Test_ID IN (SELECT DISTINCT testrec.Test_ID FROM testrec WHERE testrec.Test_ID='{$_POST['txtSearch']}')";
		$getSearchedTestExec=mysqli_query($connect,$getSearchedTest);
		if($isHave=mysqli_fetch_array($getSearchedTestExec))
		{
			if($isHave['TotalMarks']==null)
			{
				echo "<h1>No records found for the Test ID you have entered</h1>";
			}
			else
			{
				$totalMarks=$isHave['TotalMarks'];
				echo "<h2>Records for Test ID: {$_POST['txtSearch']}.</h2> <h2>Test Name: {$isHave['Name']}</h2> <h2>Test Date: {$isHave['Date']}</h2> <h2>Course: {$isHave['NAME']}.</h2>";
				echo '<table border="1" class="table">';
				echo '<tr class="rowH"><th>Rank</th><th>User ID</th><th>First Name</th><th>Last Name</th><th>Marks</th><th>%Marks</th><th>Grade</th><th></th></tr>';
				$getRanking="SELECT testrec.*,student.User_ID,people.F_Name,people.L_Name FROM testrec,student,people Where testrec.User_ID=student.User_ID AND student.User_ID=people.User_ID AND testrec.Test_ID='{$_POST['txtSearch']}' ORDER BY testrec.Marks DESC";
				$getRankingexec=mysqli_query($connect,$getRanking);
				$x=1;
				while($numb=mysqli_fetch_array($getRankingexec))
				{
					$g=grade($numb['Marks'],$totalMarks);
					$p=isPass($g);
					echo'<tr><td class="column">'.$x.'</td><td class="column">'.$numb['User_ID'].'</td><td class="column">'.$numb['F_Name'].'</td><td class="column">'.$numb['L_Name'].'</td><td class="column">'.$numb['Marks'].'/'.$totalMarks.'</td><td class="column">'.calculateMark($numb['Marks'],$totalMarks).'</td><td class="column">'.$g.'</td><td class="column">'.$p.'</td>';
					$x=$x+1;
				}
				echo '</table>';
			}
		}
	}
	else if((isset($_REQUEST['totm']))&&(isset($_REQUEST['tid']))&&(isset($_REQUEST['tnm']))&&(isset($_REQUEST['tdate']))&&(isset($_REQUEST['cname'])))
	{
		$getSelectedTest="SELECT SUM(questions.Q_Marks) AS TotalMarks,test.Test_ID,test.Name,test.Date,course.NAME FROM questions,test,course WHERE questions.Test_ID=test.Test_ID AND test.Course_ID=course.Course_ID AND test.Test_ID IN (SELECT DISTINCT testrec.Test_ID FROM testrec WHERE testrec.Test_ID='{$_REQUEST['tid']}')";
		$getSelectedTestExec=mysqli_query($connect,$getSelectedTest);
		if($isHave=mysqli_fetch_array($getSelectedTestExec))
		{

			$totalMarks=$_REQUEST['totm'];
			echo "<h2>Records for Test ID: {$_REQUEST['tid']}.</h2><h2>Test Name: {$_REQUEST['tnm']}</h2><h2>Test Date: {$_REQUEST['tdate']}</h2><h2>Course: {$_REQUEST['cname']}.</h2>";
			echo '<table border="1" class="table">';
			echo '<tr class="rowH"><th>Rank</th><th>User ID</th><th>First Name</th><th>Last Name</th><th>Marks</th><th>%Marks</th><th>Grade</th><th></th></tr>';
			$getRanking="SELECT testrec.*,student.User_ID,people.F_Name,people.L_Name FROM testrec,student,people Where testrec.User_ID=student.User_ID AND student.User_ID=people.User_ID AND testrec.Test_ID='{$_REQUEST['tid']}' ORDER BY testrec.Marks DESC";
			$getRankingexec=mysqli_query($connect,$getRanking);
			$x=1;
			while($numb=mysqli_fetch_array($getRankingexec))
			{
				$g=grade($numb['Marks'],$totalMarks);
				$p=isPass($g);
				echo'<tr><td class="column">'.$x.'</td><td class="column">'.$numb['User_ID'].'</td><td class="column">'.$numb['F_Name'].'</td><td class="column">'.$numb['L_Name'].'</td><td class="column">'.$numb['Marks'].'/'.$totalMarks.'</td><td class="column">'.calculateMark($numb['Marks'],$totalMarks).'</td><td class="column">'.$g.'</td><td class="column">'.$p.'</td>';
				$x=$x+1;
			}
			echo '</table>';
		}
	}
	else
	{
		echo '<table border="1" class="table">';
		echo '<tr class="rowH"><th>Test ID</th><th>Test Name</th><th>Date Taken</th><th>Course Name</th><th></th></tr>';
		$showALLtests="SELECT SUM(questions.Q_Marks) AS TotalMarks,test.Test_ID,test.Name,test.Date,course.NAME FROM questions,test,course WHERE questions.Test_ID=test.Test_ID AND test.Course_ID=course.Course_ID AND test.Test_ID IN (SELECT DISTINCT testrec.Test_ID FROM testrec) GROUP BY test.Test_ID";
		$showAlltestsExec=mysqli_query($connect,$showALLtests);
		while($showAll=mysqli_fetch_array($showAlltestsExec))
		{
			$totm=$showAll['TotalMarks'];
			$tid=$showAll['Test_ID'];
			$tnm=$showAll['Name'];
			$tdate=$showAll['Date'];
			$cname=$showAll['NAME'];
			echo 	'<tr>
					<td class="column">'.$tid.'</td>
					<td class="column">'.$tnm.'</td>
					<td class="column">'.$tdate.'</td>
					<td class="column">'.$cname.'</td>
					<td class="column"><input type="button" value="View Records for this Test" Onclick="window.location = \'gradedTests.php?totm='.$totm.'&tid='.$tid.'&tnm='.$tnm.'&tdate='.$tdate.'&cname='.$cname.'\'" class="buttonView" ></td>';
		}
		
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
</body>
</div>
</form>