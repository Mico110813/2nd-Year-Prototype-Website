<!doctype html>
<html lang="en-gb" dir="ltr">
<head>

</head>
<body>
<?php
include("php/functions.php");
$username=$_POST['username'];
$forename=$_POST['forename'];
$surname=$_POST['surname'];
$emailadd=$_POST['emailadd'];
$dayob=$_POST['dayob'];
$monthob=$_POST['monthob'];
$yearob=$_POST['yearob'];
$dob=$yearob."-".$monthob."-".$dayob;
$emercont=$_POST['emercont'];
$emernum=$_POST['emernum'];
$userpass=$_POST['userpass'];
$secondpass=$_POST['secondpass'];
$tnc=(isset($_POST['tnc'])?1:0);
$salt=getSalt(16);
$cryptpass=makeHash($userpass,$salt,50);
// Used to check that submitted user does not exist already
$userexists=false;
$emailexists=false;
// connect to database
$db = createConnection();
// check form details again in case javascript disabled form bypassed
// javascript client side scripting
// check username and email do not already exist
$sql="select username,emailadd from studentinfo where username=? or emailadd=?;";
$stmt=$db->prepare($sql);
$stmt->bind_param("ss",$username,$emailadd);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userresult,$emailresult);
while($row=$stmt->fetch()) {
	if($userresult==$username) {$userexists=true;}
	if($emailresult==$emailadd) {$emailexists=true;}
}
// check user is old enough, in this example users must be 16
$latestbirthday=mktime(0, 0, 0,date("m"),date("d"),date("Y")-2); // the last value controls min age
$birthday=mktime(0, 0, 0, $monthob, $dayob, $yearob);
$validage=(($birthday-$latestbirthday)>0?false:true);
// Check submitted and calculated variables before storing
if(!$userexists && !$emailexists && $userpass==$secondpass && isset($userpass) && filter_var($emailadd, FILTER_VALIDATE_EMAIL) && $tnc && isset($forename) && isset($surname) && $validage) {

// insert new user
	$insertquery="insert into studentinfo (username, forename, surname, emailadd, dob, emercont, emernum, usertype, tandc, salt, userpassword) values (?,?,?,?,?,?,?,2,?,?,?);";
	$inst=$db->prepare($insertquery);
	$inst->bind_param("sssssssiss", $username, $forename, $surname, $emailadd, $dob, $emercont, $emernum, $tnc, $salt, $cryptpass);
	$inst->execute();
	// check user inserted, if so create login form
	if($inst->affected_rows==1) {
	
	?>
	<header>
		<h1>Your Registration Details</h1>
	</header>
	<p>Welcome <?php echo $forename." ".$surname; ?></p>
	<p>You can now login with your username <em><?php echo $username; ?></em></p>
	<br>
	<p>Return to the <a href ="index.php" >Home page</a></p>
<?php } else { 
		//feedback there was a problem adding the user
		echo "<p>There was a problem adding your details. </p>"; 
		}
} else { 
// registration failed either due to disabled javascript or other attempt to bypass validation
?>
		<header>
			<h1>Registration failed</h1>
		</header>
		<?php 
		if($emailexists){ echo "<p>The email address $emailadd already exists.</p>"; }
		if($userexists){ echo "<p>The username $username already exists.</p>"; }
		if($userpass!=$secondpass){ echo "<p>The passwords do not match.</p>"; }
		if(!filter_var($emailadd, FILTER_VALIDATE_EMAIL)){ echo "<p>The email address is invalid.</p>"; }
		?>
		<p>You need to return to the registration page and try again</p>
<?php 
}
$stmt->close();
$inst->close();
$db->close(); 
?>
<p>Return to the <a href="index.php">home</a> page.</p>
</body>
</html>
