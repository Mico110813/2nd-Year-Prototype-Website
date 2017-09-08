<?php
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
	
	<title>Admin Level Edit</title>
	
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
			$userdetailssql="select studentinfo.forename, studentinfo.surname, stuelement.elementid, elementlevel.elemname, stuelement.elemlevel
						from studentinfo, stuelement, elementlevel
						where (studentinfo.clientid = stuelement.clientid)
						and(elementlevel.elementid = stuelement.elementid)
						and (studentinfo.clientid =? );";
			$userdetails = $db->prepare($userdetailssql);
			$userdetails->bind_param("i",$clientid);
			$userdetails->execute();
			$userdetails->store_result();
			$userdetails->bind_result($forename, $surname, $elementid, $elemname, $elemlevel);
			if($userdetails->num_rows>0) 
			{
			?>
				<form id="edituser" name="edituser" method="post" action="applylevelchanges.php">
											
					<fieldset>
						<legend>Edit Element Level</legend>
							<?php $i=1;
									while($userdetails->fetch())
									{?>
										<input name="clientid<?php echo $i; ?>" id="clientid<?php echo $i; ?>" type="text" size="8" value="<?php echo $clientid; ?>" />
										<input name="elementid<?php echo $i; ?>" id="elementid<?php echo $i; ?>" type="text" size="8" value="<?php echo $elementid;?>" readonly/>
										<input name="elemname<?php echo $i; ?>" id="elemname<?php echo $i; ?>" type="text" size="15"  value="<?php echo $elemname; ?>"  readonly/>
										<input name="elemlevel<?php echo $i; ?>" id="elemlevel<?php echo $i; ?>" type="text" size="8" required value="<?php echo $elemlevel; ?>" /></br>
										</br>
									<?php $i++;
									}?>
					
					
					</fieldset>
								
							<button type="submit">Edit Student Levels</button>
				
				</form>
		<?php
			} else 
				{
					//Insert default values into stuelement when no levels are found,
					echo "<p>No Levels found for this user</p></br>";
					$db = createConnection();
					$clientid=$_POST['clientid'];
					$insertquery="insert into stuelement (clientid, elementid, elemlevel) values (?,1,0),(?,2,0),(?,3,0),(?,4,0);";
					$inst=$db->prepare($insertquery);
					$inst->bind_param("iiii", $clientid,$clientid,$clientid,$clientid);
					$inst->execute();
					
					//check default values have been inserted
					if($inst->affected_rows>0) 
						{
							echo "<p>Default Values Inserted, please refresh the page</p>";
						} 
				
					else
						{ 
						//feedback that there was a problem, admin shouldn't see this ever, unless insert default values were not executed
						
						echo "<p>There was a problem updating with default values</p>"; 
						}
					$inst->close();
					$db->close(); 
				}
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
		}
	}
</script>


</html>
