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
						<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <strong>Join ITMA</strong>
					</div> <!-- close #path -->
					<h2>Join ITMA</h2>
					<img style="display: block; margin-left: auto; margin-right: auto; width: 550px; border-style: solid; border-width:5px; border-color: #000000" src="images/SCD_GROUP.jpg" alt="" />
					
					<h5 class="section">Membership Fees</h5>
					
					<h6 > Standard Membership</h6>
					<p>$40 for new members </p>
					<p>$35 for returning members </p>
					<p>Membership fee will cover the costs for the following:
					<div id="list" class="listStyle">
						<ul>
							<li>Club T-Shirt</li>
							<li>Professional Interaction Night (PIN)</li>
						</ul>
					</div>
					<h6 > Free Membership</h6>
					<p>The free membership is geared more towards members who may not want to attend the major events, but still want to be a part of the club. With the free membership you can attend any event you wish: general meetings, social events, and professional events. However if you want to attend a specific major event you can pay that individual event fee. The fees for individual major events are:   </p>
					<div id="list" class="listStyle">
						<ul>
							<li>Professional Interaction Night (PIN): $35</li>
							<li>Club T-Shirt (Required to Attend Super Clubs Day): $15</li>
						</ul>
					</div>
					
					<h5 class="section">Active Member Requirements</h5>
					
					<p>In order to be considered an active member of ITMA, members <b>must</b> complete the following:</p>
					<div id="list" class="listStyle">
						<ul>
							<li>Mandatory Events: Super Clubs Day and Professional Interaction Night</li>
							<li>Fundraising: $50</li>
							<li>General Meetings: 4 meetings</li>
							<li>Professional Events (i.e. Tours, Workshops, Guest Speakers, HICTA, PIN, etc.): 4 events</li>
							<li>Socials: 3 events</li>
						</ul>
					</div>
					<p><i>Please note: to make it easier for you to meet active status, many of the events we have satisify more than 1 of the requirements listed above.</i></p>
					<p><i>For example: If we have a professional guest speaker at a General Meeting, it will award you 1x general meeting credit and 1x professional credit.</i></p>
					
					<h5 class="section">Active Member Benefits</h5>
									
					<div id="list" class="listStyle">
						<ul>
							<li><a href= "Dreamspark_List.pdf"> Dreamspark Premium Suite License </a></li>
							<li>Extra Credit in most "Information Technology Management (ITM)" classes depending on the professor.</li>
							<li>Access to an upcominng job employment website hosted by the MIS department (information TBA)</li>
						</ul>
					</div>
					
					
					<br />
					<h5 class="section">ITMA Application</h5>
					<p><a href="http://www.itmahawaii.com/files/ITMA_APP.pdf">Download an Application</a></p>
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