<?php
setCookie("userintent","",(time+86400),"/~11006366");
session_start();
include('php/functions.php');
$username=checkUser($_SESSION['clientid'],session_id(),2);
$currentuser=getUserLevel();
?>

<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta charset="utf-8">
	
	<title>Admin User Edit</title>
	
	<link rel="tab icon" href="assets/favicon.png">
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 1000px)" href="css/wide.css" />
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 840px) and (max-width:999px)" href="css/medium.css" />
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 640px) and (max-width:839px)" href="css/medium_narrow.css" />
	<link rel="stylesheet" type="text/css" media="screen and (max-width:639px)" href="css/narrow.css" />
	<link rel="stylesheet" type="text/css" media="print" href="css/print.css" />
	
</head>

<body>
			<!--[if IE]><div style='clear: both; height: 112px; padding:0; position: relative;'><a href="http://www.theie8countdown.com/ie-users-info"><img src="http://www.theie8countdown.com/assets/badge_iecountdown.png" border="0" height="112" width="348" alt="" /></a></div><![endif]-->
	
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
							<a href="admin.php">Admin</a>
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
			<li><a href="aboutus.phpl">About Us</a></li>
			<li><a href="classes.phpl">Classes</a></li>
			<!--<li><a href="#">Gallery</a></li>-->
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
	
	
	
	
	<section>
		
		<?php
		if(isset($_POST['clientid'])) 
		{
			$clientid=$_POST['clientid'];
			$db=createConnection();
			$userdetailssql="select username, forename, surname, usertype, emercont, emernum from studentinfo where clientid=?;";
			$userdetails = $db->prepare($userdetailssql);
			$userdetails->bind_param("i",$clientid);
			$userdetails->execute();
			$userdetails->store_result();
			$userdetails->bind_result($username, $forename, $surname, $usertype, $emercont, $emernum);
			if($userdetails->num_rows==1) {
			$userdetails->fetch();
		?>
		<form id="edituser" name="edituser" method="post" action="applychanges.php">
			<fieldset>
				<legend>Edit User</legend>
					<label for="clientid">Client Id : </label>
					<input name="clientid" id="clientid" type="text" size="5" readonly required value="<?php echo $clientid; ?>" /><br />
					<label for="username">User Name : </label>
					<input name="username" id="username" type="text" size="12" required value="<?php echo $username; ?>" /><br />
					<label for="forename">First Name : </label>
					<input name="forename" id="forename" type="text" size="15" required value="<?php echo $forename; ?>" /><br />
					<label for="surname">Surname : </label>
					<input name="surname" id="surname" type="text" size="15" required value="<?php echo $surname; ?>" /><br />
					<label for="emercont">Emergency Contact : </label>
					<input name="emercont" id="emercont" type="text" size="15" required value="<?php echo $emercont; ?>" /><br />
					<label for="emernum">Emergency Number : </label>
					<input name="emernum" id="emernum" type="text" size="15" required value="<?php echo $emernum; ?>" /><br />
					<?php if($currentuser['userlevel']>2) { ?>
						<label for="usertype">User Level : </label>
						<input name="usertype" id="usertype" type="text" size="1" required value="<?php echo $usertype; ?>" />: Use this to set a user to admin level. 3 is Admin, 2 is default, 1 is suspended<br />
					<?php } ?>
					<?php if($currentuser['userlevel']==2) { ?>
						<label for="usertype">User Level : </label>
						<input name="usertype" id="usertype" type="hidden" size="1" readonly value="<?php echo $usertype; ?>" />
					<?php } ?>
					<label for="userpass">Password : </label>
					<input name="userpass" id="userpass" type="password" size="10" /><br />
					<button type="submit">Edit User</button>
			</fieldset>
		</form>
		<?php
			} else 
			{
				echo "<p>No user found!</p>";
			}
	} 
	else 
		{
			echo "<p>No user submitted to edit</p>";
		}
?>
	
	</section>
	
	<footer>
	
	<span>&copy; 2014 Mico Web Design</span>
		
	<nav>
	
		<ul>
			<!--<li><a href="#">Sitemap</a></li>
			<li><a href="#">Terms</a></li>
			<li><a href="#">Privacy</a></li>
			<li><a href="#">To Top</a></li>-->
			<li><a href="contact.php">Contact Us</a></li>
		</ul>
		
	</nav>
	
	</footer>
	
</body>

<script src="js/functions.js"></script>
<script src="js/iefix.js"></script>

<script>
	var userlevel=<?php echo $currentuser['userlevel']; ?>;
	document.onreadystatechange=function() {
		if(document.readyState=="complete") {
			prepareMenu();
			prepareIntents(userlevel);
		}
	}
</script>


</html>
