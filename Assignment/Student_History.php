<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" size="3">
<style>
	body{
		margin:auto;
	}
	#div1{
		width: auto;
		position: relative;
		top: 10px;
		background: #ddd;
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
		line-height:60px;
		border: none;
		color: white;
		text-decoration: none;
		font-size: 20px;
		width: 200px;
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
	.tb
	{
		width:100%;
		padding:2%;
		font-size:15px;
		font-weight:bold;
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
		letter-spacing: 5px;
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
	.link
	{
		font-size:40px;
		margin-top:8%;
		font-size:20px;
		margin-left:2%;
		color:black;
		font-overline:none;
	}
	.link a
	{
		color:black;
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
date_default_timezone_set('Asia/Kuala_Lumpur');
if((isset ($_COOKIE['username'])) && (isset($_COOKIE['password'])) && (isset($_COOKIE["AccType"])))
{
	$USERNAME = $_COOKIE['username'];
	$PASSWORD = $_COOKIE['password'];
	$AccType = $_COOKIE['AccType'];
	$_SESSION["User"]= $USERNAME;
	$_SESSION["pass"] = $PASSWORD;
	$_SESSION["AccType"] = $AccType;
}
if ((!isset($_SESSION['User'])) && (!isset($_SESSION['pass'])) && (!isset($_SESSION['AccType'])))
{
	header ("Location:login.php");
}

else
{
?>

<div id= "header">
<div id ="wrapper">
<div id ="logo"><label>STUDENT EXAMINATION SYSTEM</label></div>
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
echo "<h1>HISTORY</h1>";
echo'<table class="tableSearch"><tr><td><input class="tb" type="text" name="searchcid" ></td><td><input class="buttonA" type="submit" name="search" value="Search By Course ID"></td></tr></table><br>';

if (isset($_POST['search']))
{
	$search= mysqli_real_escape_string($connect, $_POST['searchcid']);
	$GetMyUserIdQuery="Select People.User_ID,People.F_Name FROM People INNER JOIN Account WHERE People.User_ID=Account.User_ID AND Account.USERNAME='{$_SESSION['User']}'";
	$GetMyUserIdExecute=mysqli_query($connect,$GetMyUserIdQuery);
	if($row=mysqli_fetch_row($GetMyUserIdExecute))
	{
		$Uid=$row[0];
		$name = $row[1];
	}
	$getAllTid4User= "SELECT testrec.Test_ID FROM testrec JOIN Account ON testrec.User_ID = Account.User_ID WHERE Account.User_ID ='$Uid'";
	$getAllTid4UserExec = mysqli_query($connect,$getAllTid4User);
	if(mysqli_num_rows($getAllTid4UserExec)==0)
	{
		echo "<h3>You have not taken any test</h3>";
	}
	else
	{
		$sq= "SELECT testrec.*,test.Course_ID FROM testrec JOIN test ON test.Test_ID=testrec.Test_ID WHERE testrec.User_ID ='$Uid' AND test.Course_ID LIKE '%$search%'";
		$sqEx=mysqli_query($connect,$sq);
		if(mysqli_num_rows($sqEx)==0)
		{
			echo"<h3>No Results Found</h3>";
		}
		else
		{
			?>
			<table border ='1' class="table">
			<tr class = 'rowH'>
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
				
				$searchQuery="SELECT testrec.*,test.Name,test.Course_ID,test.Date,(SELECT SUM(questions.Q_Marks) AS total FROM questions JOIN test ON questions.Test_ID=test.Test_ID JOIN testrec ON 
				test.Test_ID=testrec.Test_ID WHERE testrec.User_ID='$Uid' AND testrec.Test_ID='{$allTid['Test_ID']}')AS total FROM testrec JOIN test ON testrec.Test_ID = test.Test_ID 
				WHERE testrec.User_ID='$Uid' AND testrec.Test_ID='{$allTid['Test_ID']}' AND test.Course_ID LIKE '$search'";
				$searchExec=mysqli_query($connect,$searchQuery);
				if ($all = mysqli_fetch_array($searchExec))
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
				<td>
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
			}
			echo'</table>';
		}			
	}
		
}

else
{
	historyAll();
}	
}




function historyAll()
{
	include("DB.php");
	$GetMyUserIdQuery="Select People.User_ID,People.F_Name FROM People INNER JOIN Account WHERE People.User_ID=Account.User_ID AND Account.USERNAME='{$_SESSION['User']}'";
	$GetMyUserIdExecute=mysqli_query($connect,$GetMyUserIdQuery);
	if($row=mysqli_fetch_row($GetMyUserIdExecute))
	{
		$Uid=$row[0];
		$name = $row[1];
	}
	$getAllTid4User= "SELECT testrec.Test_ID FROM testrec JOIN Account ON testrec.User_ID = Account.User_ID WHERE Account.User_ID ='$Uid'";
	$getAllTid4UserExec = mysqli_query($connect,$getAllTid4User);
	if(mysqli_num_rows($getAllTid4UserExec)==0)
		{
			echo "<h3>You have not taken any test</h3>";
		}
		else
		{
			
			?>
			<table border ='1' class="table">
			<tr class = 'rowH'>
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
				
				$result = "SELECT testrec.*,test.Name,test.Course_ID,test.Date,(SELECT SUM(questions.Q_Marks) AS total FROM questions JOIN test ON questions.Test_ID=test.Test_ID JOIN testrec ON test.Test_ID=testrec.Test_ID WHERE testrec.User_ID='$Uid' AND testrec.Test_ID='{$allTid['Test_ID']}')AS total FROM testrec JOIN test ON testrec.Test_ID = test.Test_ID WHERE testrec.User_ID = '$Uid' AND testrec.Test_ID='{$allTid['Test_ID']}'";
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
</form>


	
	
