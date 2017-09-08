<?php
session_start();
include('php/functions.php');
$currentuser=getUserLevel();
?>

<!doctype html>
<html>
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
			<li><a href="aboutus.php">About Us</a></li>
			<li><a href="classes.php">Classes</a></li>
			<li><a href="gallery.php">Gallery</a></li>
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
	
	
	
	
	<section>
		
		<div class ="alignment">
			<article class="article">
					<h2 class="highlight">Welcome to Dragon Academy</h2>
					
					<p>The Dragon Academy is a holistic movement class for children from 8 - 18 based on teaching a wide range of movement skills. 
					Based on Parkour and Yoga, but borrowing from many different disciplines it aims to develop strong, balanced students while being an incredible amount of fun..</p>
					<p>The Academy aims to teach a complete movement package by breaking the whole sphere of movement down into 4 elements. Fire represents power, endurance
					and leadership. Earth is strength, control and stillness. Water is coordination, agility and teamwork. Air is flexibility, balance and breathing. 
					Students are encouraged to work on their weaknesses and become proficient in all 4 areas.</p>
					<p>If you would like to know more or enquire about our classes please <a href="contact.html">contact us</a></p>
					<p></p>
			</article>
		
			<div id ="right">
				<div id = "facebook">
					<a href = "https://www.facebook.com/EdinburghDragons?ref=profile" title="Dragons on Facebook"><img src="assets/fb.png" alt="facebook" width="100%" height = "100%"/></a>
				</div>
				<!-- set twitter link to display:none in stylesheets as there is no account as of yet, remove display when ready to show -->
				<div id = "twitter">
					<a href = "https://www.facebook.com/EdinburghDragons?ref=profile" title="Dragons on Twitter"><img src="assets/tw.png" alt="twitter" width="100%" height = "100%"/></a>
				</div>
			</div>
			
		</div>
			
	</section>
	
	<section class = "elements">
	
		<div id = "earth">
			<h3 class = "highlight">Earth</h3>
			<p>Strong, stable and durable.
			Masters of stillness and position.</p>
		</div>
		
		<div id = "air">
			<h3 class="highlight">Air</h3>
			<p>Control and balance
			Masters of flexibility and co-ordination</p>
		</div>
		
		<div id = "fire">
			<h3 class="highlight">Fire</h3>
			<p>Power and endurance
			Masters of combat and great Athletes</p>
		</div>
		
		<div id = "water">
			<h3 class="highlight">Water</h3>
			<p>Grace and poise
			Masters of speed, agility and fluid movement</p>
		</div>
	
	</section>
	
	<footer>
	
	<span>&copy; 2014 Mico Web Design</span>
		
	<nav>
	
		<ul>
			<li><a href="#">Sitemap</a></li>
			<li><a href="#">Terms</a></li>
			<li><a href="#">Privacy</a></li>
			<li><a href="#">To Top</a></li>
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
		}
	}
</script>


</html>
