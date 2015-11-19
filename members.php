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
		<link rel="stylesheet" type="text/css" href="styles/profiles.css">
		
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
				<div id="contentPortfolio" class="grid_16 fadehover">
					<div class="path">
						<?php
						if(isset($_GET['album'])) {
							echo '<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <a href="media.php">Media </a><img src="images/arrowPath.png" alt="" /> <strong>'.$_GET['title'].' - '.$_GET['date'].'</strong>';
						}
						else {
							echo '<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <strong>Members</strong>';
						}
						?>
					</div> <!-- close #path -->
					
					
					<h5 class="section">Executive Board</h5>
					<div>
					 <div class="executive">
    <div class="executive-profile">
    <img src="ebimages/rachel.jpg">
    <span class="text-content"><span>Executive President<br>Rachel Pang</span></span>
      
    </div>
    <div class="executive-profile">
    <img src="ebimages/Facebook-Profile.jpg">
    <span class="text-content"><span>Executive VP<br>Tracy Wong</span></span>
    </div>
    <div class="executive-profile">
    <img src="ebimages/Facebook-Profile.jpg">
    <span class="text-content"><span>VP of Finance<br>Lee Ann Cauilan</span></span>
    </div>
    <div class="executive-profile-end">
    <span class="text-content"><span>Director of<br>Professional Relations<br>Laura Yoshizawa</span></span>
    <img src="ebimages/laura.jpg">
    </div>
  </div>

    <div class="executive">
    <div class="executive-profile">
    <img src="ebimages/brandon.jpg">
    <span class="text-content"><span>Director of Fundraising<br>Brandon Luu</span></span>
    </div>
    <div class="executive-profile">
    <img src="ebimages/Facebook-Profile.jpg">
    <span class="text-content"><span>Director of <br>Student Relations<br>Yubi Peterson</span></span>
    </div>
    <div class="executive-profile">
     <img src="ebimages/Facebook-Profile.jpg">
     <span class="text-content"><span>Director of Marketing<br>Anthony Chang</span></span>
    </div>
     <div class="executive-profile-end">
    <span class="text-content"><span>Inter-Business Council Senator<br>Derek DePonte</span></span>
    <img src="ebimages/derek.jpg">
    </div>
  </div>
  </div>
  <br>
					
					<h5 class="section">Members</h5>
					
					
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