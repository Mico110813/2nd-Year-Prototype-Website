<?php
session_start();
include("functions.php");
$username=checkUser($_SESSION['clientid'],session_id(),3);
$currentuser=getUserLevel();
$article=$_POST['articleid'];
if(!$article) { header("location: ../blog.php"); }

$db=createConnection();
// get the first two articles
$sql = "select blogid,clientid from dragonblog join studentinfo on blogposter = clientid where blogid=?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i",$article);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($articleid,$clientid);
if($stmt->num_rows==1) {
	$stmt->fetch();
	if($currentuser['userlevel']>2 || ($currentuser['userid']==$clientid && $currentuser['userlevel']>2)) {
		$deletesql="delete from blogarticle where blogid=?;";
		$deletestmt=$db->prepare($deletesql);
		$deletestmt->bind_param("i",$article);
		$deletestmt->execute();
	}
	
}
$stmt->close();
$deletestmt->close();
$db->close();
header("location: ../blog.php");
?>
