<?php
//start session
session_start();

//include functions
include("functions.inc");

//connect to mysql
mysql_login();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<?php headers(); ?>
		<script language="JavaScript">
			var time = null
			function move() {
				window.location = 'http://itmahawaii.com/'
			}
		</script>
	</head>
	
	<body onload="timer=setTimeout('move()',3000)">
		<div id="header-wrap">
			<div id="header" class="container_16 clearfix">
				<div class="logo">
					<h1><a href="/" title="ITMA" id="logo">ITMA</a></h1>
				</div> <!-- close #logo -->
				<div id="topnav" class="jqueryslidemenu">
					<ul>
						<?php navigation($_SERVER['PHP_SELF']); ?>
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
						<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <strong>Oops</strong>
					</div> <!-- close #path -->
					<h2>Oops</h2>
					<p>Oops.  You can't go in there.  Big top-secret stuff.  Redirecting you to the homepage...</p>
				</div> <!-- close #contentLeft -->
			</div> <!-- close #content -->
		</div>	<!-- close #content-wrap -->
		<div id="footer-wrap">
			<div id="footer" class="container_16 clearfix">
			</div> <!-- close #footer -->
		</div>	<!-- close #footer_wrap -->
		<div id="bottom-wrap">
			<div id="bottom" class="container_16 clearfix">
				<?php bottom() ?>
				<?php debug_arrays() ?>
			</div>	<!-- end #bottom -->
		</div>	<!-- end #bottom-wrap -->
	<!-- END BOTTOM -->
	</body>

</html>