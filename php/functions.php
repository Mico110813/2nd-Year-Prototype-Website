<?php
function createConnection() {
	$host="xxx";
	$user="xxx";
	$userpass='xxx';
	$schema="xxx";
	$conn = new mysqli($host,$user,$userpass,$schema);
	if(mysqli_connect_errno()) {
		echo "Could not connect to database: ".mysqli_connect_errno();
		exit;
	}
	return $conn;
}
function getChar($chartoget) {
	$charstr="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	return $charstr[$chartoget];
}

function getSalt($saltLength) {
	$randomString="";
	for($i=0;$i<$saltLength;$i++) {
		$randomChar=getChar(mt_rand(0,51));
		$randomString.=$randomChar;
	}
return $randomString;
}

function makeHash($plainText,$salt,$n) {
	$hash=$plainText.$salt;
	for($i=0;$i<$n;$i++) {
		$hash=hash("sha256",$plainText.$hash.$salt);
	}
	return $hash;
}
//Params passed in
//$usersessionid = user's id, $sessionid=session_id()
//$ptype = level of access required for current page 1,2 or 3
function checkUser($usersessionid,$sessionid,$ptype) {
	$dbchk = createConnection();
	$lookupsql="select usertype,sessionid,username from studentinfo where clientid=?";
	$lookup=$dbchk->prepare($lookupsql);
	$lookup->bind_param("i",$usersessionid);
	$lookup->execute();
	$lookup->store_result();
	$lookup->bind_result($utype,$storedsession,$uname);
	$lookup->fetch();
	if($lookup->num_rows==1) {
		$lookup->close();
		$dbchk->close();
		if($sessionid!=$storedsession || $storedsession=="" || $utype<$ptype) {		
			header("location: php/logout.php");
			exit;
		}
	} else {
		$lookup->close();
		$dbchk->close();
		header("location: php/logout.php");
		exit;
	}
	return $uname;
}
function getUserLevel() {
	$utype=0;
	$uname="Anonymous";
	if($_SESSION['clientid']!=null) {
		$sessionid=session_id();
		$usersessionid=$_SESSION['clientid'];
		$dbchk = createConnection();
		$lookupsql="select usertype,sessionid,username from studentinfo where clientid=?";
		$lookup=$dbchk->prepare($lookupsql);
		$lookup->bind_param("i",$usersessionid);
		$lookup->execute();
		$lookup->store_result();
		$lookup->bind_result($utype,$storedsession,$uname);
		$lookup->fetch();
		// Whilst no valid user should find themselves here these checks just
		// ensure that levels higher than what should be allowed are not passed
		// on to the user as this function will also be used on pages where
		// a login is not necessary. If we find ourselves here we clear the
		// userid session variable too as it should not be set.
		if($lookup->num_rows!=1 || $sessionid!=$storedsession || $storedsession=="") {
			$uname="Anonymous";
			$utype=0;
			$_SESSION['clientid']="";
			$usersessionid=-1;
		}
		$lookup->close();
		$dbchk->close();		
	}
	// Here is the associative or keyed array that is sent back to the original
	// page indicating the current users access rights
	$userinfo= Array(
		'userlevel' =>	$utype,
		'username'	=>	$uname,
		'clientid'	=>	$usersessionid
	);
	return $userinfo;
}

?>
