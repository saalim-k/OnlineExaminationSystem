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
	
	h1{
		text-align:center;
		
	}
	h3{
		text-align:center;
		
	}
	h4{
		text-align:center;
		
	}
	.center{
		margin-top:2%;;
		margin-left:2%;
		margin-right:2%;
		width:auto;
		
	}
	.table{
		background-color:white;
		width: 50%;
		box-shadow: 0 0 2px black;
		margin-left:25%;		
	}
	.tableRegister
	{
		background-color:white;
		width: 50%;	
		margin-left:20%;
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
	}
	.columnRegister
	{
		padding-top:1%;
		padding-bottom:1%;
		width:auto;
		height:auto;
		text-align:center;
		font-weight:bold;
		font-size:20px;
	}
	#input{
		width:100%;
		padding-top:2%;
		padding-bottom:2%;
		text-align:center;
		font-size:20px;
		background:white;
	}
	.buttonSubmit
	{
		display: inline;
		justify-content:center;
		margin-top:20px;
		margin-left:30px;
		line-height:60px;
		color: white;
		text-decoration: none;
		font-size: 25px;
		width: 30%;
		height: 60px;
		font-weight:bold;
		background:#262626;
		border:1px solid black;
	}
	.buttonSubmit:hover{
		color:black;
		background:grey;
	}
		
</style>
<meta charset="utf-8"/>
</head>
<body style="background-color:#bdc3c7">
<div id="div1" class="center">
<?php
include("DB.php");
if(isset($_POST['submit']))
{
	$Uid=trim($_POST['User_id']);
	$User=trim($_POST['Username']);
	$Pass=trim($_POST['Password']);
	$Fn=trim($_POST['Fname']);
	$Ln=trim($_POST['Lname']);
	$dob=trim($_POST['DOB']);
	$Pn=trim($_POST['Pn']);
	$Eadd=trim($_POST['Eadd']);
	$Pid=($_POST['Prog']);
	$date=strtotime($dob);
	$today = strtotime(date('Y/m/d'));
	if($date>=$today)
		echo "<h4>Error. Date of birth cannot be after today<h4>";
	else
	{
		$InsertAccQuery="INSERT INTO Account(User_ID,USERNAME,PASSWORD) VALUES('$Uid','$User','$Pass')";
		$InsertPeopleQuery="INSERT INTO People(User_ID,Acc_type,F_Name,L_Name,DOB,Phone_Num,Email_Add)VALUES('$Uid','S','$Fn','$Ln','$dob','$Pn','$Eadd')";
		$InsertStudQuery="INSERT INTO Student(User_ID,Prog_ID)VALUES('$Uid','$Pid')";
		$insert1=mysqli_query($connect,$InsertAccQuery);
		$insert2=mysqli_query($connect,$InsertPeopleQuery);
		$insert3=mysqli_query($connect,$InsertStudQuery);
		if($insert1){
			if($insert2){
				if($insert3){
					echo "<h4>You have registred successfully</h4>";
					echo "<h4>Your Username: $User</h4>";
					echo "<h4>Your Password: $Pass</h4>";
					header("refresh:10");
				}
			}
		}
		else{
			echo "<h4>Username or User ID already exists, please try another username or User ID</h4>";
		}
	}
}
?>
<h1>Welcome To The Online Examination Website Registration Page</h2>
<br>
<h4>Already Have an Account?</h4>
<h4><a href='login.php'>Go to Login form</a></h4>
</br>
<h4>If you are a teacher, contact Admin to create an account for you</h4>
<table border="1" class="table">
<tr class="rowH"><td colspan="3" class="column">Here are all the admins info</td></tr>
<?php
$GetAllAd="Select F_Name,L_Name,Phone_Num,Email_Add FROM People WHERE Acc_type='A'";
$GetAllAdExec=mysqli_query($connect,$GetAllAd);
while($i=mysqli_fetch_array($GetAllAdExec))
{
	echo 	'<tr>
				<td class="column" >'.$i['F_Name'].' '.$i['L_Name'].'</td>
				<td class="column">'.$i['Phone_Num'].'</td>
				<td class="column">'.$i['Email_Add'].'</td>
			</tr>';
}
echo "</table>";
echo "</br>";
echo "</br>";

?>
<h4>If you are a student and you dont have an account, Please enter your details below to register</h4>
<table class="tableRegister">
<tr>
<td class="columnRegister">User Id</td>
<td><input type="text" name="User_id" required id='input'></td>
</tr>
<tr>
<td class="columnRegister">Username </td>
<td><input type="text" name="Username" required id='input'></td>
</tr>
<tr>
<td class="columnRegister">Password</td>
<td><input type="text" name="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required id='input'></td>
</tr>
<tr>
<td class="columnRegister">First Name</td>
<td><input type="text" name="Fname" required id='input'></td>
</tr>
<tr>
<td class="columnRegister">Last Name</td>
<td><input type="text" name="Lname" required id='input'></td>
</tr>
<tr>
<td class="columnRegister">Date Of Birth</td>
<td><input type="date" name="DOB" max="<?php echo date('Y-m-d'); ?>" required id='input'></td>
</tr>
<tr>
<td class="columnRegister">Phone Number</td>
<td><input type="text" name="Pn" pattern="^(\+?6?01)[0|1|2|3|4|6|7|8|9]-*[0-9]{7,8}$" title="Example: +60111111111" required id='input'></td>
</tr>
<tr>
<td class="columnRegister">Email Address</td>
<td><input type="text" name="Eadd" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please Enter a correct email format. Example: 123@abc.com" required id='input'></td>
</tr>
<tr>
<td class="columnRegister">Program</td>
<td><select name = "Prog" id='input'>
<?php
$GetAllProgQuery="SELECT * FROM Program";
$GetAllProgExecute=mysqli_query($connect,$GetAllProgQuery);
while($x=mysqli_fetch_row($GetAllProgExecute))
{
	echo "<option  value='{$x[0]}'>$x[0]</option>";
}
?>
</tr>
<tr>
<td colspan="2" class="column"><input type="submit" name="submit" value="Submit" class="buttonSubmit"></td>
</tr>
</table>
</div>