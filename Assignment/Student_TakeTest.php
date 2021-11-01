<!DOCTYPE HTML>
<html>
<form action="<?php echo $_SERVER['PHP_SELF']; ?> ?tid=<?php echo trim($_REQUEST['tid']); ?>" method="post" size="3">
<style>
	body{
		margin:auto;
	}
	#div1{
		width:auto;
		position: relative;
		top: 5px;
		background: #ddd;
		margin:2%;
		height:auto;	
	}
	h1{
		text-align:center;
	}
	h2{
		text-align:center;
		letter-spacing: 2px;
		font-size:60px;
		
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
		margin-top:5%;
	}
	.link a
	{
	  font-size:20px;
      margin-left:40px;
      color:black; 	  
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

	.button
	{
		font-size: 15px;
		width: 100px;
		height:30px;	
	}
	
	.buttonYESNO
	{
		display:flex;
		line-height:50px;
		font-size: 50px;
		font-weight:bold;
		border:none;
		background:#262626;
        width:auto;	
		margin-left:50%;
		padding-left:1%;
		padding-right:1%;
		color:white;
	}
	.buttonYESNO:hover
	{
		background:grey;
		color: white;
	}
	.question{
		font-size:30px;
		text-align: center;
		letter-spacing: 2px;
		
	}
	.answer{
		margin:5%;
		font-size:30px;
	}
	.ddl
	{
		width:auto;
		font-size:30px;
		margin-left:5%;
		padding-left:1%;
	}
	.buttonS{
		width:20%;
		height:8%;
		font-size:40px;
		margin-left:40%;
		margin-bottom:5%;
	}
	.allq{
		margin:2%;
	}
	#demo
	{
		text-align:center;
		padding-right:10%;
		font-size:40px;
	}
	.table{
		width:100%;
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
	<div id="header">
	<div id ="wrapper">
	<div id ="logo"><label>STUDENT EXAMINATION SYSTEM</label></div>
	</div>
	</div>
	<div class ="link">
	<a href='Student.php'  >BACK</a>
	</div>
	<body style="background-color:#bdc3c7">
	
	<div id="div1" class="center">
	<?php
	$GetMyUserIdQuery="Select People.User_ID,People.F_Name FROM People INNER JOIN Account WHERE People.User_ID=Account.User_ID AND Account.USERNAME='{$_SESSION['User']}'";
	$GetMyUserIdExecute=mysqli_query($connect,$GetMyUserIdQuery);
	if($user=mysqli_fetch_row($GetMyUserIdExecute))
	{
		$Uid=$user[0];
		$name = $user[1];
	}
	$isintestrecq="SELECT Test_ID from testrec where User_ID= '$Uid' AND Test_ID='{$_REQUEST['tid']}'";
	$isintestrecexec=mysqli_query($connect,$isintestrecq);
	if(($lol=mysqli_num_rows($isintestrecexec))>0)
	{
		echo "<h1>You have already taken this test.</h1>";
		echo '<input type="button" onclick ="window.location = \'login.php\'" value="OK" class="buttonYESNO">';
	}
	else
	{
		//echo "</br>";
		//echo "</br>";
		//echo "</br>";
		//echo "</br>";
		//echo "</br>";
		echo "</br>";
		$today=date('Y-m-d');
		$time=date('H:i');
		$getdatequ="SELECT date, Start_time , End_time, Duration from test where Test_ID='{$_REQUEST['tid']}'";
		$getdateex=mysqli_query($connect,$getdatequ);
		if($t=mysqli_fetch_row($getdateex))
		{
			$dot=$t[0];//date of test
			$stot=$t[1];//start time of test
			$etot=$t[2];//end time of test
			$dur=$t[3]*60*60;//duration in seconds
			if((strtotime($dot))>(strtotime($today)))
			{
				echo "<h1>You can only take this test on $dot</h1>";
				echo '<input type="button" onclick ="window.location = \'login.php\'" value="OK" class="buttonYESNO">';
			}
			else if((strtotime($dot))<(strtotime($today)))
			{
				echo "<h1>You cannot take this test anymore as the date for this test has already passed.</h1>";
				echo '<input type="button" onclick ="window.location = \'login.php\'" value="OK" class="buttonYESNO">';
			}
			else
			{
				if((strtotime($time))>(strtotime($etot)))
				{
					echo "<h1>You cannot take this test since the end time of the test has already passed</h1>";
					echo '<input type="button" onclick ="window.location = \'login.php\'" value="OK" class="buttonYESNO">';
				}
				else if((strtotime($time))<(strtotime($stot)))
				{
					echo "<h1>The test has not yet started. Refresh the page at $stot to start the test. Your current time is $time</h1>";
					echo '<input type="button" onclick ="window.location = \'login.php\'" value="OK" class="buttonYESNO">';
				}
				else
				{
					$GetMyUserIdQuery="Select People.User_ID,People.F_Name FROM People INNER JOIN Account WHERE People.User_ID=Account.User_ID AND Account.USERNAME='{$_SESSION['User']}'";
					$GetMyUserIdExecute=mysqli_query($connect,$GetMyUserIdQuery);
					if($user=mysqli_fetch_row($GetMyUserIdExecute))
					{
						$Uid=$user[0];
						$name = $user[1];
					}
					
					$testName =mysqli_query($connect,"SELECT Name,Test_ID FROM test WHERE Test_ID = '{$_REQUEST['tid']}'");
					if($row=mysqli_fetch_row($testName))
					{
						$tname=$row[0];
						$tid = $row[1];
					}
					echo"<table class='table'><tr><td><h2>$tname</h2><td><h3 id='demo'></h3></td></tr></table>";
					
					$testQuestionQuery = "SELECT questions.* FROM questions WHERE Test_ID = '{$_REQUEST['tid']}'"; 
					$questions = mysqli_query ($connect, $testQuestionQuery);

					while ($rowQ = mysqli_fetch_array($questions))
					{
						$qn = $rowQ['Q_No'];
						$q = $rowQ ['Q_Desc'];
						$OA= $rowQ ['Q_Option_A'];
						$OB= $rowQ ['Q_Option_B'];
						$OC= $rowQ ['Q_Option_C'];
						$OD= $rowQ ['Q_Option_D'];
						$QA = $rowQ ['Q_Correct_Option'];
						$M =  $rowQ ['Q_Marks']
						?>
						<div class="allq">
						<hr/><br>
						<label class ="question"><?php echo "$qn . "; ?></label>
						<label class ="question"><?php echo "$q "; ?></label><br><br><br>
						<label class ="answer" for ="A" ><?php echo "A.  $OA"; ?></label><br><br><br>
						<label class ="answer" for ="B" ><?php echo "B.  $OB"; ?> </label><br><br><br>
						<label class ="answer" for ="C" ><?php echo "C.  $OC"; ?> </label><br><br><br>
						<label class ="answer" for ="D" ><?php echo "D.  $OD"; ?> </label><br><br><br>
						<select class="ddl" name="<?php echo $qn; ?>">
						<option name = "choice" >A</option>
						<option name="choice" >B</option>
						<option name = "choice" >C</option>
						<option name = "choice" >D</option>
						</select>
						<br><br>
						</div>
						<?php
					}
					?>
					<br>
					<input id="this" type ="submit" name="submit" class="buttonS" value ="SUBMIT">
					<div id="yessing"></div>
					<div id="noing"></div>
					<div id="iamhidden"></div>
					<?php
					$totalQuery = "SELECT COUNT(Q_No) AS TQ FROM questions WHERE Test_ID='{$_REQUEST['tid']}'";
					$totalQ = mysqli_query ($connect, $totalQuery);
					if ($x = mysqli_fetch_array ($totalQ))
					{
						$s = $x['TQ'];
					}
					if (isset ($_POST['submit']))
					{
						$totalM = 0;
						for ($i = 1 ; $i<=$s ; $i++)
						{
							if ((isset($_POST[$i])))
							{
								$c =$_POST[$i];
								$marksQuery = "SELECT Q_Correct_Option, Q_Marks FROM questions WHERE Test_ID = '{$_REQUEST['tid']}' AND Q_No = '$i'";
								$marks = mysqli_query ($connect, $marksQuery);
								if ($t = mysqli_fetch_array ($marks))
								{   
									$a = $t['Q_Correct_Option'];
									$b = $t['Q_Marks'];
								}
								if ($c == $a)
								{
									$totalM+=$b;				
								}
							}
						}
						echo "<script type='text/javascript'>alert('You got $totalM marks for this test.');</script>";
						$addMarksToDBQue="INSERT INTO Testrec (User_ID,Test_ID,Marks) values ('$Uid','{$_REQUEST['tid']}','$totalM') ";
						$addMarksToDB=mysqli_query($connect,$addMarksToDBQue);
						if($addMarksToDB)
						{
							$taak="Your marks have been updated";
							echo "<script type='text/javascript'>alert('$taak');window.location.href = 'login.php';</script>";
						}
						else
						{
							echo "error updating database with marks".mysqli_error($connect);
						}
					}
					?>
					<script type="text/javascript">
					// Set the date we're counting down to
					var y='<?php echo "$dot $etot"; ?>';
					var countDownDate = new Date(y).getTime();

					// Update the count down every 1 second
					var x = setInterval(function() {

					  // Get today's date and time
					  var now = new Date().getTime();
						
					  // Find the distance between now and the count down date
					  var distance = countDownDate - now;
						
					  // Time calculations for days, hours, minutes and seconds
					  //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
						
					  // Output the result in an element with id="demo"
					  document.getElementById("demo").innerHTML = hours + "h "
					  + minutes + "m " + seconds + "s ";
						
					  // If the count down is over, write some text 
					  if (distance < 0) {
						clearInterval(x);
						alert('Time is up. This test will be automatically submitted');
						document.getElementById('this').click();
							
					  }
					}, 1000);
					</script>
					<?php
				}
			}
		}
	}
}
?>

</div>
</html>
</form>	
	
	
	
	