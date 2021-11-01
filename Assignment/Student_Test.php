
<form action="<?php echo $_SERVER['PHP_SELF']; ?> ?cid=<?php echo trim($_REQUEST['cid']); ?>" method="post">
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
		padding-left:1%;
		padding-right:1%;
		width:auto;
	}
	
    .button{
		line-height:40px;
		font-size: 20px;
		font-weight:bold;
		border:none;
		background:white;
        width:auto;		
	}
	
	.button:hover{
		    background:grey;
			color: white;
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
	$cid=$_REQUEST['cid'];
?>
<div id= "header">
<div id ="wrapper">
<div id ="logo"><label>STUDENT EXAMINATION SYSTEM</label></div>
</div>
</div>
<div class ="link">
<a href='Student.php'  >BACK</a>
</div>
<body style="background-color:#bdc3c7">
<div class="user">
<label class="username"><?php echo "Username&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp".$_SESSION['User']."";?></label><br><br>
<label class="acctype"><?php echo 'Account Type&nbsp:&nbsp &nbsp'. yourAcType().'';?></label>
</div>
<div id="div1" class="center">
<?php	

echo "<h1>AVAILABLE TEST FOR $cid</h1>";
$testQuery = mysqli_query($connect,"SELECT Test_ID,Name,Date,Start_Time,End_Time,Duration,Course_ID FROM `test` WHERE Course_ID='{$_REQUEST['cid']}'");	
if ( $test = mysqli_num_rows($testQuery)==0)
{
	echo "<h3>There is not upcoming test for this course</h3>";
}
else
{
echo"<table border ='1' class='table'>
<tr class = 'rowH'><td>Test ID</td><td>Test Name</td><td>Date</td><td>Start Time</td><td>End Time</td><td>Duration</td><td>Course ID</td><td></td></tr>";

while ($rowT = mysqli_fetch_array($testQuery))
{
	echo '<tr class = "row">
	<td class="column">'.$rowT['Test_ID'].'</td>
    <td class="column">'.$rowT['Name'].'</td>	
	<td class="column">'.$rowT['Date'].'</td>
	<td class="column">'.$rowT['Start_Time'].'</td>
	<td class="column">'.$rowT['End_Time'].'</td>
	<td class="column">'.$rowT['Duration'].'</td>
	<td class="column">'.$rowT['Course_ID'].'</td>
	<td class="column"><input type="button" onclick ="window.location = \'Student_TakeTest.php?tid='.$rowT['Test_ID'].'\'" value="Take Test" class="button"></td>
    </tr>';
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