<?php
setCookie("userintent","",(time+86400),"/~11006366");
session_start();
include('php/functions.php');
$username=checkUser($_SESSION['clientid'],session_id(),3);
$currentuser=getUserLevel();
?>

<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta charset="utf-8">
	
	<title>Dragons Admin</title>
	
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
						<a href="admin.php">Admin Page</a>
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
			<li><a href="blog.php">Blog</a></li>
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
			$db=createConnection();
			if($currentuser['userlevel']=3)
				{
					$userlistsql="select clientid, forename, surname from studentinfo;";
				}
			else
				{
					echo "Not Authorised to access this information";
				}
			$userlist = $db->prepare($userlistsql);
			$userlist->execute();
			$userlist->store_result();
			$userlist->bind_result($clientid,$forename, $surname);
			if($userlist->num_rows>0) 
				{?>
					<form id="listusers" name="listusers" method="post" action="edituserlevel.php">
						<fieldset>
							<legend>Edit Dragon Level</legend>
								<label for="clientid">Select User to Update </label>
								<select name="clientid" id="clientid" required>
									<?php
										while($userlist->fetch())
										{
											echo "<option value='$clientid'>$forename $surname</option>";
										}
									?>
								</select>
								<button type="submit">Update Level</button>
						</fieldset>
					</form>
				<?php }

			else
				{
					echo "<p>No users found!</p>";
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
