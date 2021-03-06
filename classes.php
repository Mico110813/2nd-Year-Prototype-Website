<?php
setCookie("userintent","",(time+86400),"/~11006366");
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
	
	<title>Class Information</title>
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
								<label for="userpass">Password :  </label><input type="password" name="userpass" id="userpass" size="20" required /><br />
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
		
		<article class="classinfo">
			
						<h3 class="highlight">Enrollment</h3>
			<p>To join the dragon academy requires nothing more than turning up to the class and filling in a short disclaimer form.</p>
			<p>If you are interested in continuing, we normally run the class in blocks of 5. Every 5th week is a 'grading'. If you wish to take part in the gradings you need to purchase a booklet to keep track of your progress. </p>

			<p>You can purchase a booklet either in the starter pack: £15 or individually £3</p>
			<p>The starter pack includes your booklet, a dragon t-shirt and your first 5 dragon wristbands. </p>
			
			<h3 class ="highlight">The Classes</h3>
			<p> Class venue - Mary Erskine School, Ravelston Dykes Road, Edinburgh </p>
			<p> Every Sunday starting 18th January 2015<p>
			<p> Primary School Age 3pm - 4.30pm. 90 min class
			<p> Secondary School age 5pm - 7pm. 2Hr class
			
			<h3 class ="highlight">Prices</h3>
			<p> <strong>P1 - P7</strong>		-	£8 per lesson or £30 for a block of 5</p>
			<p> <strong>S1 - Adult</strong>		-	£10 per lesson or £40 for a block of 5</p>
			<p> <strong>Dragons T-shirt</strong> - £12</p>
			<p>	<strong>Progress Booklet</strong>	- £3</p>
			<p>	<strong>Dragon Wristbands</strong> - £0.50p</p>
			
			<p>If you would like to know more, enquire about our classes or to book a class please <a href="contact.html">contact us</a></p>
			
		
		</article>
		
	</section>
	
	<footer>
	
	<span>&copy; 2014 Mico Web Design</span>
		
	<nav>
	
		<ul>
			<!--<li><a href="#">Sitemap</a></li>
			<li><a href="#">Terms</a></li>
			<li><a href="#">Privacy</a></li>
			<li><a href="#">To Top</a></li>-->
			<li><a href="contact.html">Contact Us</a></li>
		</ul>
		
	</nav>
	
	</footer>
	
</body>

<script src="js/functions.js"></script>

<script>
	document.onreadystatechange=function() {
		if(document.readyState=="complete") {
			prepareMenu();
		}
	}
</script>


</html>
