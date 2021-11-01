<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<head>
<style>
	body{
		margin:auto;
	}
	#div1{
		width: auto;
		position: relative;
		top: 20px;
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
	h1{
		text-align:center;
		padding-top:3%;
		padding-bottom:1%;
		letter-spacing:2px;
		
	}
	h2{
		text-align:center;
		
	}
	 #input{
		width:100%;
		padding-top:2%;
		padding-bottom:2%;
		text-align:center;
		font-size:18px;
		background:white;
		
	}
	.column{
		width:30%;
		text-align:center;
		height:10px;
		font-weight:bold;
		font-size:20px;
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
	.username{
		color:black;
		text-align:right;
		font-size:30px;
	}
	.user{
		margin-top:2%;
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
$today=date('Y-m-d');
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
else
{
	?>
	<body style="background-color:#bdc3c7">
	<div class="user">
	<label class="username"><?php echo "Username&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp".$_SESSION['User']."";?></label><br><br>
	<label class="acctype"><?php echo 'Account Type&nbsp:&nbsp &nbsp'. yourAcType().'';?></label>
	</div>
	<div id="div1" class="center">
	<h1>MY PROFILE</h1>
	<?php
	if(isset($_REQUEST['up']))
	{
		echo "<h1>You have Successfully updated your Information</h1>";
	}
	?>
	<table class="table">
	<?php
	$GetMyUserIdQuery="Select People.User_ID FROM People INNER JOIN Account WHERE People.User_ID=Account.User_ID AND Account.USERNAME='{$_SESSION['User']}'";
	$GetMyUserIdExecute=mysqli_query($connect,$GetMyUserIdQuery);
	if($row=mysqli_fetch_row($GetMyUserIdExecute))
	{
		$Uid=$row[0];
	}
	$GetMyInfoQuery="SELECT F_Name,L_Name,DOB,Phone_Num,Email_Add FROM People WHERE User_ID='$Uid'";
	$GetMyInfoExecute=mysqli_query($connect,$GetMyInfoQuery);
	while($i=mysqli_fetch_row($GetMyInfoExecute))
	{
		echo 	'<tr><td class="column">First Name</td><td><input type="text" name="Fn" value="'.$i[0].'" required id="input"></td></tr>
				<tr><td class="column">Last Name</td><td><input type="text" name="Ln" value="'.$i[1].'" required id="input"></td></tr>
				<tr><td class="column">Date Of Birth</td><td><input type="date" name="Dob" value="'.$i[2].'" max="'.$today.'" required id="input"></td></tr>
				<tr><td class="column">Phone Number</td><td><input type="text" name="Pn" value="'.$i[3].'" pattern="^(\+?6?01)[0|1|2|3|4|6|7|8|9]-*[0-9]{7,8}$" title="Example: +60111111111" required id="input"></td></tr>
				<tr><td class="column">Email Address</td><td><input type="text" name="Eadd" value="'.$i[4].'" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please Enter a correct email format. Example: 123@abc.com" required id="input"></td></tr>
				<tr><td colspan="2" class="column"><input type="submit" name="Update" Value="Update information" class="buttonA"></td></tr>
				</table>';
	}
	if (isset($_POST['Update']))
	{
		$Fn=trim($_POST['Fn']);
		$Ln=trim($_POST['Ln']);
		$Dob=trim($_POST['Dob']);
		$Pn=trim($_POST['Pn']);
		$Eadd=trim($_POST['Eadd']);
		$UpdateMyInfoQuery="Update People SET F_Name='$Fn',L_Name='$Ln',DOB='$Dob',Phone_Num='$Pn',Email_Add='$Eadd' WHERE User_ID='$Uid'";
		$UpdateMyInfoExecute=mysqli_query($connect,$UpdateMyInfoQuery);
		if($UpdateMyInfoExecute)
		{
			header("location:/Assignment/Myprofile.php?up=yes");
		}
	}
	?>
	</br>
	<input type="button" onclick="window.location = 'ChangePass.php'" value = "Change Password" class="buttonA">
	</br>
	</br>
	<input type="button" onclick="window.location = 'login.php'" value = "Back to Home Page" class="buttonA">
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
