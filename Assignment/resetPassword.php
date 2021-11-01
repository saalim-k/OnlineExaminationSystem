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
	}
	
	
	</style>
	<meta charset="utf-8"/>
</head>
<body style="background-color:#bdc3c7">
<div id="div1" class="center">
<?php
include("DB.php");
echo "<h1>Reset password form</h1>";
echo "<h4>Don't have an account?  ";
echo "<a href='Registration.php'>Go to registration form</a><br />";
echo"<br>";
echo "Already Have an Account?";
echo "<a href='Login.php'>Go to Login form</a>";
echo"<br>";
echo"<br>";
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table class="table">
<tr>
<td class="column">Username:</td>
<td><input type="text" name="Usern" id="input"></td>
</tr>
<tr>
<td class="column"> Email:</td>
<td><input type="text" name="email" id="input"></td>
</tr>
<tr>
<td colspan="2" class="column"><input type="submit" name="change" value="Submit" class="button"></td>
</tr>

</table>
</form>
<?php
if(isset($_POST['change']))
{
	$Usern=mysqli_real_escape_string($connect,$_POST['Usern']);
	$email=mysqli_real_escape_string($connect,$_POST['email']);
	
	
	$sql="SELECT account.* FROM account,people WHERE account.USERNAME='$Usern' AND people.Email_Add='$email' AND people.User_ID=account.User_ID";
	$verify=mysqli_query($connect,$sql);
	if(mysqli_num_rows($verify)>0){
			
			
			$reset=random_pass();
			$set="UPDATE account SET PASSWORD='$reset' WHERE USERNAME='$Usern'";
			$update=mysqli_query($connect,$set);
			$msg="Your new password is ".$reset;
			
			echo "Password changed successfully";
			 echo "<script type='text/javascript'>alert('$msg');</script>";
	}
	else{
		echo "Invalid user ID or email.";
	}
	
}
function random_pass($length=10)
{
	$char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
	$reset=substr(str_shuffle($char),0,$length);
	return $reset;
	
}


?>
