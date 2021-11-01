<form action = "<?php echo $_SERVER['PHP_SELF']; ?> ?UID=<?php echo trim($_REQUEST['UID']); ?> " method = "POST" size="3">
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
	h1{
		text-align:center;
		padding-top:3%;
		padding-bottom:1%;
		
	}
	h3{
		text-align:center;
	}
	.table{
		width: 100%;
        border:1px solid black;		
	}
	.tableInfo{
		width: 50%;
		margin-left:28%;
        border:1px solid black;		
	}
	.column{
		width:30%;
		text-align:left;
		height:10px;
		font-weight:bold;
		font-size:20px;
	}
	.columnC{
		width:auto;
		text-align:center;
		height:10px;
		font-size:20px;
		padding:1%;
	}
	.columnE{
		width:auto;
		text-align:center;
		height:10px;
		font-size:20px;
		padding:1%;
	}

	 #input{
		width:100%;
		padding-top:2%;
		padding-bottom:2%;
		text-align:center;
		font-size:18px;
		background:white;
		
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
else if(!isset($_REQUEST['UID']))
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
</div>
</div>
<body style="background-color:#bdc3c7">
<div class="user">
<label class="username"><?php echo "Username&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp".$_SESSION['User']."";?></label><br><br>
<label class="acctype"><?php echo 'Account Type&nbsp:&nbsp &nbsp'. yourAcType().'';?></label>
</div>
<div id="div1" class="center">	
<h1> Records for 
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
?>
<table class="tableInfo">
<tr class="rowH">
<th colspan="3">Students Information</th>
</tr>
<?php
if(isset($_POST['back']))
{
	header("Location: login.php");
}
$GetStudentDetailsQuery="SELECT People.User_ID , People.F_Name , People.L_Name , Student.Prog_ID , People.DOB , People.Phone_Num , People.Email_Add From People INNER JOIN 
Student WHERE People.User_ID=Student.User_ID AND Student.User_ID='{$_REQUEST['UID']}'";
$GetStudentDetailsExecute=mysqli_query($connect,$GetStudentDetailsQuery);
if($Row=mysqli_fetch_row($GetStudentDetailsExecute))
{
	$Uid=$Row[0];
	$Fname=$Row[1];
	$Lname=$Row[2];
	$Pid=$Row[3];
	$Dob=$Row[4];
	$Pno=$Row[5];
	$Eadd=$Row[6];
	echo 	"<tr><td class='column'>User ID</td><td class='columnC'>:</td><td class='column'>$Uid</td>
			<tr><td class='column'>First Name</td><td class='columnC'>:</td><td class='column'>$Fname</td>
			<tr><td class='column'>Last Name</td><td class='columnC'>:</td><td class='column'>$Lname</td>
			<tr><td class='column'>Program</td><td class='columnC'>:</td><td class='column'>$Pid</td>
			<tr><td class='column'>Date Of Birth</td><td class='columnC'>:</td><td class='column'>$Dob</td>
			<tr><td class='column'>Phone Number</td><td class='columnC'>:</td><td class='column'>$Pno</td>
			<tr><td class='column'>Email Address</td><td class='columnC'>:</td><td class='column'>$Eadd</td>";
}
?>
</table>
<h1>Courses Where This student is Enrolled</h1>
<?php
$GetAllCoursesEnrolledQuery = "SELECT enrolled.Course_ID, course.NAME,course.Description,course.Prog_ID FROM enrolled,course WHERE enrolled.User_ID='{$_REQUEST['UID']}' AND enrolled.Course_ID=course.Course_ID";
$GetAllCoursesEnrolledExecute=mysqli_query($connect,$GetAllCoursesEnrolledQuery);
if((mysqli_num_rows($GetAllCoursesEnrolledExecute))==0)
{
	echo "This Student is Not enrolled in any courses yet";
}
else
{
	?>
	<table border="1" class="table">
	<tr class="rowH">
	<th>Course ID </th>
	<th>Name</th>
	<th>Description</th>
	<th>Program ID</th>
	</tr>
	<?php
	while($C=mysqli_fetch_array($GetAllCoursesEnrolledExecute))
	{
		echo 	'<tr>
					<td class="columnE">'.$C['Course_ID'].'</td>
					<td class="columnE">'.$C['NAME'].'</td>
					<td class="columnE">'.$C['Description'].'</td>
					<td class="columnE">'.$C['Prog_ID'].'</td>					
				</tr>';
	}
}

?>
</table>
<h1>Tests taken and marks for this student</h1>
<?php
$getAllTid4User= "SELECT testrec.Test_ID FROM testrec JOIN Account ON testrec.User_ID = Account.User_ID WHERE Account.User_ID ='{$_REQUEST['UID']}'";
$getAllTid4UserExec = mysqli_query($connect,$getAllTid4User);
if(mysqli_num_rows($getAllTid4UserExec)==0)
	{
		echo "<h3>This student has not sat for any tests yet.<h3>";
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
		
		$result = "SELECT testrec.*,test.Name,test.Course_ID,test.Date,(SELECT SUM(questions.Q_Marks) AS total FROM questions JOIN test ON questions.Test_ID=test.Test_ID JOIN testrec ON test.Test_ID=testrec.Test_ID WHERE testrec.User_ID='{$_REQUEST['UID']}' AND testrec.Test_ID='{$allTid['Test_ID']}')AS total FROM testrec JOIN test ON testrec.Test_ID = test.Test_ID WHERE testrec.User_ID = '{$_REQUEST['UID']}' AND testrec.Test_ID='{$allTid['Test_ID']}'";
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
		<td class="columnC"><?php echo $td; ?></td>
		<td class="columnC"><?php echo $name; ?></td>
		<td class="columnC"><?php echo $cid; ?></td>
		<td class="columnC"><?php echo $date ?></td>
		<td class="columnC"><?php echo $m.'/'.$tot; ?></td>
		<td class="columnC">
		<?php
		echo calculateMark($m,$tot); ?>
		</td>
		<td class="columnC">
		<?php
		$g=grade($m,$tot);
		echo $g; ?>
		</td>
		<td class="columnC">
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
?>
</br>
</br>
<input type="submit" name="back" value="Back to Home Page" class="button">
<?php
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