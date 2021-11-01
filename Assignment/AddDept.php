<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
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
	.table{
		width:50%;
		margin:auto;
			
	}
	.tableReg{
		width:50%;
		margin-left:25%;		
	}
	h1{
		text-align:center;
		padding-top:3%;
		padding-bottom:1%;
		
	}
	 #input{
		width:100%;
		padding-top:2%;
		padding-bottom:2%;
		text-align:center;
		font-size:18px;
		background:white;
		
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
	.column{
		width:30%;
		text-align:center;
		height:10px;
		font-weight:bold;
		font-size:20px;
	}

	.columnReg{
		width:auto;
		text-align:center;
		height:auto;
		font-size:20px;
		padding:1%;
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
	<h1>All CURRENTLY REGISTERED DEPARTMENTS</h1>
	<table border="1" class="table">
	<tr class="rowH">
	<td>Department ID</td>
	<td>Name</td>
	<td>Description</td>
	</tr>
	<?php
	$GetAllDeptQuery="SELECT * FROM Department";
	$GetAllDeptExecute=mysqli_query($connect,$GetAllDeptQuery);
	while($i=mysqli_fetch_array($GetAllDeptExecute))
	{
		echo 	'<tr>
				<td class="columnReg">'.$i['Dept_ID'].'</td>
				<td class="columnReg">'.$i['Name'].'</td>
				<td class="columnReg">'.$i['Description'].'</td>
				</tr>';
	}
	?>
	</table>
	<h1>Enter Details of New Department Below</h1>
	<table class="tableReg">
	<tr>
	<td class="column">Department Id</td>
	<td><input type="text" name="Dept_id" required id="input"></td>
	</tr>
	<tr>
	<td class="column">Department Name </td>
	<td><input type="text" name="Dn" required id="input"></td>
	</tr>
	<tr>
	<td class="column">Department Description</td>
	<td><input type="text" name="Ddesc" required id="input"></td>
	<tr>
	<td colspan="2" class="column" ><input type="submit" name="submit" value="Submit" class="buttonA"></td>
	</tr>
	</table>
	<?php
	if(isset($_POST['submit']))
	{
		$did=trim($_POST['Dept_id']);
		$dn=trim($_POST['Dn']);
		$dd=trim($_POST['Ddesc']);
		$InsertDepQuery="INSERT INTO Department(Dept_ID,NAME,Description) VALUES('$did','$dn','$dd')";
		$InsertDepExecute=mysqli_query($connect,$InsertDepQuery);
		if($InsertDepExecute)
		{
			header("Refresh:0");
		}
		else
		{
			echo mysqli_error($connect);
		}
	}
	?>
	<input type="button" onclick="window.location = '/Assignment/login.php'" value = "Back to Home Page" class="buttonA">
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
</div>