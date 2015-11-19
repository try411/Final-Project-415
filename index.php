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
		<script type="text/javascript">
			$().ready(function() {
				$('#coda-slider-1').codaSlider();
			});
		</script>
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
		<div id="featured-wrap" class="clearfix">
			<div id="featured" class="container_16 clearfix">
				<div class="coda-slider-wrapper">
					<div class="coda-slider preload" id="coda-slider-1">
						<div class="panel">
							<div class="panel-wrapper">
								<h2 class="title">1</h2>
								<h3>Like IT and study at UHM?</h3>
								<img src="images/slider/slide_img4.png" alt="" />
							</div> <!-- close .panel-wrapper -->
						</div> <!-- close .panel -->
						<div class="panel">
							<div class="panel-wrapper">
								<h2 class="title">2</h2>
								<h3>Network with Students...</h3>
								<img src="images/slider2014/ITMA2.jpg" alt="" />
							</div> <!-- close .panel-wrapper -->
						</div> <!-- close .panel -->
						<div class="panel">
							<div class="panel-wrapper">
								<h2 class="title">3</h2>
								<h3>Network with Professionals...</h3>
								<img src="images/slider2014/ITMA5.jpg" alt="" />
							</div> <!-- close .panel-wrapper -->
						</div> <!-- close .panel -->
						<div class="panel">
							<div class="panel-wrapper">
								<h2 class="title">4</h2>
								<h3>Network with Alumni...</h3>
								<img src="images/slider/slide_img3.png" alt="" />
							</div> <!-- close .panel-wrapper -->
						</div> <!-- close .panel -->
						<div class="panel">
							<div class="panel-wrapper">
								<h2 class="title">5</h2>
								<h3>Get ahead</h3>
								<img src="images/slider2014/ITMA1.jpg" alt="" />
							</div> <!-- close .panel-wrapper -->
						</div> <!-- close .panel -->
					</div>	<!-- close .coda-slider preload-->
				</div>	<!-- close .coda-slider-wrapper -->
			</div> <!-- close #featured -->
		</div> <!-- close #featured-wrap -->
		<div id="servicesTop"></div>
		<div id="services-wrap">
			<div id="services" class="container_16 clearfix">
				<div id="box1" class="grid_5">
					<h5>About ITMA</h5>
					<img src="images/about_splash.jpg" alt="" />
					<p>Our mission is to strengthen the social and professional network between members in ITMA, Alumni and professionals by focusing on the development of quality relationships.</p>
					<p>The ITMA is motivated and dedicated to provide its members social and professional relationships, provide access to technical resources, and be an example of a growing technical environment to foster career development.</p>
					<a href="about.php">Read more</a>
				</div>	<!-- close #box1 -->
				<div id="box2" class="grid_5">
					<h5>Upcoming Events</h5>
					<img src="images/events_splash.jpg" alt="" />
					<?php
					$events=q("SELECT * FROM events WHERE event_start>=CURDATE() AND event_semester IN (SELECT semester_id FROM semester WHERE current_semester=1) ORDER BY event_start ASC LIMIT 3");
					$events_count=c($events);
					if($events_count>0) {
						while($events_row=a($events)) {
							$event_date=d($events_row['event_start']);
							echo '
								<p>
									<b>Name: '.$events_row['event_name'].'</b><br />
									&nbsp;&nbsp;&nbsp;&nbsp;Date: '.$event_date.'<br />
									&nbsp;&nbsp;&nbsp;&nbsp;Location: '.$events_row['event_location'].'
								</p>
							';
						}
						echo '<a href="calendar.php">See more</a>';
					}
					else {
						echo '<p>No upcoming events scheduled.</p>';
					}
					?>
				</div>	<!-- close #box2 -->
				<div id="box3" class="grid_5 right">
					<h5>Get in Touch</h5>
					<div class="getInTouch">
						<ul>
							<!-- <li class="phoneContact"><strong>PHONE</strong><br/>(123) 456 7891</li> -->
							<li class="emailContact"><strong>EMAIL</strong><br/>itmaclub@gmail.com</li>
							<!-- <li class="skypeContact"><strong>SKYPE</strong><br/><a href="">yourskypename</a></li> -->
							<li class="addressContact"><strong>SNAIL MAIL</strong><br/>
							<b>Information Technology Management Association</b><br/>
							Shidler College of Business<br/>
							University of Hawaii at Manoa<br/>
							2404 Maile Way BusAd A101<br/>
							Honolulu, HI 96822<br/>
							</li>
							<!-- <li class="goForm"><a href="#">Contact Form</a></li> -->
						</ul>	
						<div class="socialIcons">
							<div class="facebook">
								<a href="http://www.facebook.com/itmaclub"><img src="images/facebook.png" /></a>
							</div>	
						</div>	<!-- close .socialIcons -->
					</div>	<!-- close .getInTouch -->
				</div>	<!-- close #box3 -->
			</div> <!-- close #services -->
		</div> <!-- close #services_wrap -->
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