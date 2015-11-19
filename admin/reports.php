<?php
//start session
session_start();

//include functions
include("../functions.inc");

//connect to mysql
mysql_login();

//check of admin is logged in
check_admin();
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
				<div id="contentLeft_side" class="grid_10">
					<div class="path">
						<a href="/">Homepage </a><img src="../images/arrowPath.png" alt="" /> <a href="admin/">Admin </a><img src="../images/arrowPath.png" alt="" /> <strong>Reports</strong>
					</div> <!-- close #path -->
					<h2>Reports</h2>
					<p><a href="admin/member_report.php" target="_blank">[Generate Members Report]</a></p>
					<p>
						<a href="admin/sem_event_report.php" target="_blank">[Generate Current Semester Events Report]</a>
						&nbsp;&nbsp;&nbsp;
						<a href="admin/all_event_report.php" target="_blank">[Generate All Semester Events Report]</a>
					</p>
				</div> <!-- close #contentLeft -->
				<div id="contentRight" class="grid_5">
					<div id="subNavigation">
						<?php admin_sub_navigation(); ?>
					</div> <!-- close #subNavigation -->
				</div> <!-- close #contentRight -->
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