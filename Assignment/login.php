<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
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
	h2{
		text-align:center;
		
	}
	h4{
		text-align:center;
		
	}
	.center{
		margin-top:12%;;
		margin-left:auto;
		margin-right:auto;
		width:40%;
		
	}
	.image{
		margin-left:auto;
		margin-right:auto;
		display:block;
		width:10%;
		
	}
	.button{
		
		background:white;
		margin-top:15px;
		font-size:20px;
		margin-left:30%;
		width:20%;
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
		font-weight:bold;
	}
	
	
	</style>
	<meta charset="utf-8"/>
</head>
<body style="background-color:#bdc3c7">
<div id="div1" class="center">
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
	echo "<h2>LOGIN FORM</h2>";
	echo "<h4>Don't have an account?  ";
	echo "<a href='Registration.php'>Go to registration form</a><br />";
	echo "Forgot Your Password?  ";
	echo "<a href='resetPassword.php'>Go to Reset Password</a><br /><br />";
	
	?>
	<table class="table">
	<tr>
	<td class="column">Username:</td>
	<td ><input type="text" name="USERNAME" id="input" ></td>
	</tr>
	<tr>
	<td class="column">Password:</td>
	<td><input type="Password" name="PASSWORD" id="input" ></td>
	</tr>
	<tr>
	<td colspan="2" class="columnR"><input type="checkbox" id="rememberMe" name="rememberMe" value="Rememberme">
	<label for="rememberMe">Remember Me!</label></td>
	</tr>
	<tr>
	<td colspan="2"><input type="submit" name="login" value="Login" class="button"></td>
	</tr>
	</table>
	</div>
	</form>
	<?php
	if(isset($_POST['login'])){
		$USERNAME=mysqli_real_escape_string($connect,$_POST['USERNAME']);
		$PASSWORD=mysqli_real_escape_string($connect,$_POST['PASSWORD']);
		if(isset($_POST['rememberMe']))
		{
			$sqlGetAcc="SELECT * FROM Account WHERE USERNAME='$USERNAME' AND PASSWORD='$PASSWORD'";
			$verify=mysqli_query($connect,$sqlGetAcc);
			if(mysqli_num_rows($verify)>0)
			{
				if($Row=mysqli_fetch_row($verify))
				{
					$User_ID=$Row[0];
					$sqlGetAccType="SELECT People.Acc_type FROM People INNER JOIN Account WHERE Account.User_ID=People.User_ID And Account.User_ID='$User_ID'";
					$getAccType=mysqli_query($connect,$sqlGetAccType);
					if($Row1=mysqli_fetch_row($getAccType))
					{
						$AccType=$Row1[0];
						$_SESSION["User"]=$USERNAME;
						$_SESSION["Pass"]=$PASSWORD;
						$_SESSION["AccType"]=$AccType;
						setcookie("username", $_SESSION["User"], time() + (86400 * 30), "/");
						setcookie("password", $_SESSION["Pass"], time()+ (86400 * 30),"/");
						setcookie("AccType", $_SESSION["Acctype"], time()+ (86400 * 30),"/");
						header("Refresh:0");
					}
				}
			}
			else
			{
				echo "<h4>Invalid username or password</h4>";
			}
		}
		else
		{
			$sqlGetAcc="SELECT * FROM Account WHERE USERNAME='$USERNAME' AND PASSWORD='$PASSWORD'";
			$verify=mysqli_query($connect,$sqlGetAcc);
			if(mysqli_num_rows($verify)>0)
			{
				if($Row=mysqli_fetch_row($verify))
				{
					$User_ID=$Row[0];
					$sqlGetAccType="SELECT People.Acc_type FROM People INNER JOIN Account WHERE Account.User_ID=People.User_ID And Account.User_ID='$User_ID'";
					$getAccType=mysqli_query($connect,$sqlGetAccType);
					if($Row1=mysqli_fetch_row($getAccType))
					{
						$AccType=$Row1[0];
						$_SESSION["User"]=$USERNAME;
						$_SESSION["Pass"]=$PASSWORD;
						$_SESSION["AccType"]=$AccType;
						header("Refresh:0");
					}
				}
			}
			else
			{
				echo "<h4>Invalid username or password</h4>";
			}
		}
	}
}
else
{
	if(($_SESSION['AccType'])=="A")
	{
		//Direct to Admin Home
		header("Location: AdminHome.php");
	}
	else if(($_SESSION['AccType'])=="T")
	{
		//Direct to Teacher Home
		header("Location:teacherHome.php");
	}
	else if(($_SESSION['AccType'])=="S")
	{
		//Direct to Student Home
		header("Location:student.php");
	}
}
?>
</div>