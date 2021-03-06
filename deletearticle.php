<?php
session_start();
include("php/functions.php");
$username=checkUser($_SESSION['clientid'],session_id(),3);
$currentuser=getUserLevel();
$article=$_GET['aID'];
if(!$article) { header("location: blog.php"); }
?>
<!doctype html>
<html lang="en-gb" dir="ltr">
<head>

	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta charset="utf-8">
	
	<title>Dragon Academy</title>
	
	<link rel="tab icon" href="assets/favicon.png">
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 1000px)" href="css/wide.css" />
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 840px) and (max-width:999px)" href="css/medium.css" />
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 640px) and (max-width:839px)" href="css/medium_narrow.css" />
	<link rel="stylesheet" type="text/css" media="screen and (max-width:639px)" href="css/narrow.css" />
	<link rel="stylesheet" type="text/css" media="print" href="css/print.css" />

</head>

<body>

	<header>
		<div class="pageheader">
		
			<div class="dragons"></div>
			
			<aside>
				<?php if($currentuser['userlevel']<1) { ?>
					<form name="loginform" id="loginform" method="post" action="php/processlogin.php">
					
								<label for="username">Username : </label><input type="text" name="username" id="username" size="20" required /><br />
								<label for="userpassword">Password :  </label><input type="password" name="userpassword" id="userpassword" size="20" required /><br />
								<button type="submit" id="submit">Login</button>
								<INPUT TYPE="button" value = "Register" onClick="parent.location='register.html'">
					</form>
						
				<?php } else 
					{ ?>
					<p>Welcome back <?php echo $currentuser['username'];?>!</p>
					<form>
						<INPUT TYPE="button" value="Logout" onClick="parent.location='php/logout.php'">
						<?php if($currentuser['userlevel']==3) { ?><!--only displays the admin link if user has admin level-->
							<li><a href="admin.php">Admin</a></li>
						<?php } ?>
					</form>
					<?php } ?>	
			</aside>
		</div>
	</header>

	<nav>
		<div id="menubutton">Menu</div>
		<ul id="menu">
			<li><a href="index.php">Home</a></li>
			<li><a href="aboutus.php">About Us</a></li>
			<li><a href="classes.php">Classes</a></li>
			<!--<li><a href="#">Gallery</a></li>-->
			<li><a href="blog.php">Blog</a></li>
			<li><a href="contact.php">Contact</a></li>
			<?php if($currentuser['userlevel']>0) { ?><!--only displays the account link if user is logged in-->
				<li><a href="user.php">Account</a></li>
			<?php } ?><!--end of if statement-->
		</ul>
		
	</nav>
	
	<div class="displayed">
		<div class="text">
			<p> Inspiring health through fitness and agility </p>
		</div>
	</div>
	
	
	
	

<h1>Delete Article</h1>

<div id="main">
<?php
$db=createConnection();
// get the first two articles
$sql = "select blogid,articletitle,articletext,blogtime,blogposter,username,clientid from dragonblog join studentinfo on blogposter = clientid where blogid=?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i",$article);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($articleid,$articletitle,$articletext,$blogtime,$blogposter,$username,$clientid);

//build article html
while($stmt->fetch()) {
	echo "<article id='a$articleid'>
			<h1>$articletitle</h1>
			<p>".nl2br($articletext)."</p>
			<footer><p>Posted on <time datetime='$blogtime'>$blogtime</time> by <em>$username</em></p></footer>";

	// if user is logged in and not suspended add delete button
	if($currentuser['userlevel']>2 || ($currentuser['clientid']==$clientid && $currentuser['userlevel']>2)) {
		?> <form method='post' action='php/xdeletearticle.php'>
			<input type="hidden" readonly value="<?php echo $article ?>" id="articleid" name="articleid" />
			<button type="submit">Confirm Delete</button>
			</form> 
		<?php
	}
	echo "</article>";
}
$stmt->close();
$db->close();

?>

</body>
</html>
