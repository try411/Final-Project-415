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
	</head>
	
	<body>
		<div id="header-wrap">
			<div id="header" class="container_16 clearfix">
				<?php show_logged() ?>
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
						<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <strong>About Us</strong>
					</div> <!-- close #path -->
					<h2>About Us</h2>
					<h5 class="section">Mission Statement</h5>
					<p>Our mission is to strengthen the social and professional network between members in ITMA, Alumni and professionals by focusing on the development of quality relationships.</p>
					<img style="display: block; margin-left: auto; margin-right: auto; width: 550px; border-style: solid; border-width:5px; border-color: #000000" src="images/about.jpg" alt="" />
					<p>The ITMA is motivated and dedicated to provide its members social and professional relationships, provide access to technical resources, and be an example of a growing technical environment to foster career development.</p>
					<p>The Purposes of the Information Technology Management Association are to:</p>
					<div id="list" class="listStyle">
						<ul>
							<li>Provide a better understanding of the nature and functions of information systems and related areas.</li>
							<li>Prepare its members for a career in information technology.</li>
							<li>Proliferate interaction between members and the business community.</li>
							<li>Propagate a communication link between its members and faculty.</li>
							<li>Produce lasting-relationships between its members.</li>
						</ul>
					</div> <!-- close #list -->
					<br />
					<h5 class="section">NOTE:</h5>
					<p>Although the registered organization has members who are University of Hawaii students, the registered organization is independent of the University of Hawaii and does not represent the views of the University. The registered organization is responsible for its own contracts, acts, or omissions.</p>
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