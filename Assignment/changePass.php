<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<head>
<style>
	body{
		margin:auto;
		
		
	}
	#div1{
		background-color:white;
		padding:5px;
		border:1px solid;
		border-radius:10px;
	}
	table{
		background-color:white;
	}
	h1{
		text-align:center;
		
	}
	h2{
		text-align:center;
		
	}
	h4{
		text-align:center;
		
	}
	h3
	{
		text-align:center;
	}
	.center{
		margin-top:5%;
		margin-left:auto;
		margin-right:auto;
		width:40%;
		
	}
	.button{
		
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
	.button:hover{
		color:black;
		background:#DEDEDE;
	}
	
	.table{
		background-color:white;
		width: 100%;
		margin:auto;
		font-size:20px;

	}
	.column{
		width:30%;
		text-align:center;
		height:10px;
	}
	.columnR{
		padding-left:30%;
	}
    
    #input{
		width:100%;
		padding-top:2%;
		padding-bottom:2%;
		text-align:center;
		font-size:15px;
		background:white;
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
?>
<body style="background-color:#bdc3c7">
<div class="user">
<label class="username"><?php echo "Username&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp".$_SESSION['User']."";?></label><br><br>
<label class="acctype"><?php echo 'Account Type&nbsp:&nbsp &nbsp'. yourAcType().'';?></label>
</div>
<div id="div1" class="center">
<h1>CHANGE PASSWORD FORM</h1>
<table class="table">
<tr>
<td class="column">Current Password:</td>
<td><input type="password" name="PASSS" id="input"></td>
</tr>
<tr>
<td class="column">New Password:</td>
<td><input type="password" name="NEWPASSS" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" id="input"></td>
</tr>
<tr>
<td class="column">Confirm New Password:</td>
<td><input type="password" name="CNEWPASSS" id="input" ></td>
</tr>
<tr>
<td colspan="2" class="column"><input type="submit" name="change" value="Submit" class="button"></td>
</tr>
</tr>
<td colspan="2" class="column"><input type="button" onclick="window.location = '/Assignment/login.php'" value = "Back to Home Page" class="button"></td>
</tr>
</table>
</form>
<?php
if(isset($_POST['change']))
{
	$PASSS=mysqli_real_escape_string($connect,$_POST['PASSS']);
	$NEWPASSS=mysqli_real_escape_string($connect,$_POST['NEWPASSS']);
	$CNEWPASSS=mysqli_real_escape_string($connect,$_POST['CNEWPASSS']);
	
	$sql="SELECT * FROM account WHERE USERNAME='{$_SESSION['User']}' AND PASSWORD='$PASSS'";
	$verify=mysqli_query($connect,$sql);
	if(mysqli_num_rows($verify)>0)
	{
		if($PASSS!=$NEWPASSS)
		{
			if($NEWPASSS==$CNEWPASSS)
			{
				$set="UPDATE account SET PASSWORD='$NEWPASSS' WHERE USERNAME='{$_SESSION['User']}' AND PASSWORD='$PASSS'";
				$update=mysqli_query($connect,$set);
				echo "<h3>Password changed successfully</h3>";
				echo "<h3>Your new Password is :$NEWPASSS</h3>";
				if(isset($_COOKIE['password']))
				{
					$_COOKIE['password']=$NEWPASSS;
				}
				if(isset($_SESSION['Pass']))
				{
					$_SESSION['Pass']=$NEWPASSS;
				}
			}
			else
			{
				echo "<h3>New password and confirm new password are not match</h3>";
			}
		}
		else
		{
			echo "<h3>New password and current password cannot be the same.</h3>";
		}
	}
	else
	{
		echo "<h3>Current password doesnt match with your actual current password</h3>";
		echo "<h3>$PASSS $NEWPASSS  $CNEWPASSS</h3>";
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
