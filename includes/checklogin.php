<?php
include_once "key.php";
// Connect to server and select databse.
$con= mysqli_connect($host, $username,$password,$db_name) or die(mysql_error());
// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysqli_real_escape_string($con, $myusername);
$mypassword = mysqli_real_escape_string($con, $mypassword);
$sql="select * from $tbl_members where myusername='$myusername' and mypassword='$mypassword';";
$result=mysqli_query($con, $sql);
// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
	session_start();
// Register $myusername, $mypassword and redirect to file "login_success.php"
	$_SESSION["myusername"] = $myusername;
	$_SESSION["mypassword"] = $mypassword;
	#echo $_SESSION["myusername"];
	header("location:../csv2sql.php");
}

else {
	$merror = "Contraseña o Usuario invalido.";
	echo '<script language="javascript">alert("'.$merror.'");</script>';
	echo "<script language='javascript'>window.location='../index.php'</script>";
}
?>
