<?php
session_start();
include("functions.php");
//The ampersand is used to assign a 'null' value if 
//there is currently no userid session variable set
$clientid=&$_SESSION['clientid'];
$sessionid=session_id();
if(!is_null($clientid)) {
	//To prevent hack attempts from logging people out with
	//legitimate logins both userid and session id must match
	//before it clears the sessionid
	$clearquery="update studentinfo set sessionid='' where clientid=? and sessionid=?";
	$db=createConnection();
	$doclear=$db->prepare($clearquery);
	$doclear->bind_param("is",$clientid,$sessionid);
	$doclear->execute();
	$doclear->close();
	$db->close();
}
// Unset the session variables then destroy the current session
session_unset();
session_destroy();
header("location: ../index.php");
?>
