<?php
session_start();
include("functions.php");
$username=checkUser($_SESSION['clientid'],session_id(),3);
$currentuser=getUserLevel();
	$db=createConnection();

	$articletitle=$_POST['articletitle'];
	$articletext=$_POST['articletext'];
	$insertblogsql="insert into dragonblog (articletitle,articletext,blogposter) values (?,?,?)";
	$insertblog=$db->prepare($insertblogsql);
	$insertblog->bind_param("ssi",$articletitle,$articletext,$currentuser['clientid']);
	$insertblog->execute();
	$insertblog->close();
	$db->close();
header("location: ../blog.php");
?>
