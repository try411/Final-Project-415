
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ITMA HAWAII</title>
		<base href="http://itmahawaii.com" />
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="stylesheet" type="text/css" media="screen" href="styles/style.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="styles/reset.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="styles/960.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="styles/screen.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="styles/jNice.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="styles/coda-slider-2.0.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="styles/jqueryslidemenu.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="styles/validationEngine.jquery.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="styles/prettyPhoto.css" />
		<!--[if IE 6]>
			<link rel="stylesheet" type="text/css" media="screen" href="styles/ie6.css" />
		<![endif]-->

		<!--[if IE 7]>
			<link rel="stylesheet" type="text/css" media="screen" href="styles/ie7.css" />
		<![endif]-->
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
		<script type="text/javascript" src="scripts/jquery.jNice.js"></script>
		<script type="text/javascript" src="scripts/jquery-1.4.1.min.js"></script>
		<script type="text/javascript" src="scripts/jqueryslidemenu.js"></script>
		<script type="text/javascript" src="scripts/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="scripts/jquery.coda-slider-2.0.js"></script>
		<script type="text/javascript" src="scripts/jquery.validationEngine-en.js"></script>
		<script type="text/javascript" src="scripts/jquery.validationEngine.js"></script>
		<script type="text/javascript" src="scripts/usableforms.js"></script>
		<script type="text/javascript" src="scripts/jquery.prettyPhoto.js"></script>
		<script type="text/javascript" src="scripts/form_date/calendarDateInput.js"></script>
			<script>
			$(document).ready(function() {
				$("#login").validationEngine()
			})
		</script>
	</head>
	
	<body>
		<div id="header-wrap">
			<div id="header" class="container_16 clearfix">
				<div class="logo">
					<h1><a href="/" title="ITMA" id="logo">ITMA</a></h1>
				</div> <!-- close #logo -->
				<div id="topnav" class="jqueryslidemenu">
					<ul>
						
			<li><a class="home" href="/">Home</a></li>
		
		<li><a class="navEffect" href="about.php">About Us</a></li>
		<li><a class="navEffect" href="members.php">Members</a></li>
		<li><a class="navEffect" href="calendar.php">Calendar</a></li>
		<li><a class="navEffect" href="media.php">Media</a></li>
		<li><a class="navEffect" href="join.php">Join</a></li>
		
						</ul>
					<br style="clear:left" />
				</div> <!-- close #topnav -->
			</div> <!-- close #header -->
		</div> <!-- close #header-wrap -->
		<div id="contentTop"></div>
		<div id="content-wrap">
			<div id="content" class="container_16 clearfix">
				<div id="contentLeft" class="grid_16 fadehover">
					<div class="path">
						<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <strong>Login</strong>
					</div> <!-- close #path -->
					<h2>Login</h2>
										<form id="login" action="" method="post">
						<p><div class="form_name">username:</div><div class="form_field"><input id="login_username" class="validate[required]" name="login_username" type="text" size="32" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">password:</div><div class="form_field"><input  id="login_password" class="validate[required]" name="login_password" type="password" size="32" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="login_submit" value="Login" /></div>&nbsp;&nbsp;&nbsp;<a href="password_reset.php">Forgot Password?</a></p>
						<div class="clear"></div>
					</form>
				</div> <!-- close #contentLeft -->
			</div> <!-- close #content -->
		</div>	<!-- close #content-wrap -->
		<div id="footer-wrap">
			<div id="footer" class="container_16 clearfix">
			</div> <!-- close #footer -->
		</div>	<!-- close #footer_wrap -->
		<div id="bottom-wrap">
			<div id="bottom" class="container_16 clearfix">
				
			<p>&copy; 2010 Copyright ITMA. All Rights Reserved.</p>
			<ul>
				<li><a href="login.php">Log In</a></li>
				<li><a href="#">Register</a></li>
				<li><a href="#">Privacy Policy</a></li>
				<li><a href="#">Terms and Conditions</a></li>
				<li class="top"><p><a href="/login.php/#">Back to Top</a></p></li>
			</ul>
									</div>	<!-- end #bottom -->
		</div>	<!-- end #bottom-wrap -->
	<!-- END BOTTOM -->
	</body>

</html>