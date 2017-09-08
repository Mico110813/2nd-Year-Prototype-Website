<?php
session_start();
include("functions.php");
$db = createConnection();
$currentuser=getUserLevel();

$blogpostdate=$_POST['blogpostdate'];
// Get next blog article
$sql = "select blogid,articletitle,articletext,blogtime,blogposter,username from dragonblog join studentinfo on blogposter=clientid where blogtime<? order by blogtime desc limit 1";
$stmt = $db->prepare($sql);
$stmt->bind_param("s",$blogpostdate);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($articleid,$articletitle,$articletext,$blogtime,$blogposter,$username);
$stmt->fetch();

//construct article associative array, includes user array data
$json[]=array (
	'articleid' => $articleid,
	'articletitle' => $articletitle,
	'articletext' => nl2br($articletext),
	'blogtime' => $blogtime,
	'blogposter' => $blogposter,
	'username' => $username,
	'currentuser' => $currentuser
	);
echo json_encode($json);
$stmt->close();
$db->close();
?>
