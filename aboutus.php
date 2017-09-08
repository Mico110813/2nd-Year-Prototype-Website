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
	
	<title>About Us</title>
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
			<li><a href="blog.php">Blog</a></li>
			<!--<li><a href="#">Gallery</a></li>-->
			<li><a href="contact.php">Contact</a></li>
		</ul>
		
	</nav>
	
	<div class="displayed">
		<div class="text">
			<p> Inspiring health through fitness and agility </p>
		</div>
	</div>
	
	<section>
		<p>The Dragon academy is a complete training regime and works on training the 4 basic elements. To master the elements you must be strong, fast, powerful, fluid and supple.</p>

		<p>First you must attend to the foundation skills. These prepare your body for the more difficult and strenuous activities you will find in the initiate levels.
			Ability and proficiency in the initiate movements and success in its challenges will then lead you towards the master levels.
			But don't forget, that the dragon academy is a complete training regime. Mastery of the body may lead you to neglect the mind.</p>

		<p>The arts of problem solving, teamwork, stillness, breathing and leadership must also be explored if you wish to progress as a dragon.</p>
		
	</section>
	
	
	<section class = "aboutus">
	
		<div id = "mark">
			<h3 class = "highlight">Mark</h3>
			<div id ="markimage"></div>
			<p>Mark teaches wellbeing through Nutrition and movement. As a qualified Nutritionist and Yoga instructor he is a well known teacher in the Edinburgh area and has helped many people to find better health; physically, mentally and spiritually.
			Mark has a unique set of skills that he uses to help people. A BSc with Honours in Nutrition, 20 years of meditation experience, 12 years of martial arts and 8 years of practicing Yoga. He keeps up to date with the science of Nutrition and Human Physiology but also believes in the wisdom and intuition of each and every one of us.
			<p>Mark is the director and lead teacher for <a href="http://www.positiviteam.com">Positiviteam</a>, a company dedicated to encouraging good health through Nutrition, movement and mindfulness</p>
			
		</div>
		
		<div id = "hedge">
			<h3 class = "highlight">Hedge</h3>
			<div id = "hedgeimage"></div>
			<p>John Hall or 'Hedge' as he is known, is an ADAPT Level 2 certified parkour coach. With an athletics and cross country background, Hedge discovered Parkour in late 2004 and caught the bug.</p>
			<p>Since then, he has become interested in developing a balanced practice; looking for ways to better prepare and protect his body from the long hours he spends training and coaching. 
				With a scientific background, Hedge drives to bring the absolute best coaching practice he can to his classes. 
				They are known to be physically and mentally challenging but incredibly rewarding</p>
			<p>Hedge is the director and head coach of <a href ="http://www.accessparkour.com">Access Parkour </a> where he teaches a range of classes for all ages and abilities.</p>
		</div>
		
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
	var userlevel=<?php echo $currentuser['userlevel']; ?>;
	document.onreadystatechange=function() {
		if(document.readyState=="complete") {
			prepareMenu();
			prepareIntents(userlevel);
		}
	}
</script>


</html>
