<?php
//start session
session_start();

//include functions
include("../functions.inc");

//connect to mysql
mysql_login();

//check if member is logged in
check_account();

$session=$_COOKIE['session'];

$attendance=q("SELECT event_type_id, COUNT(*) AS count FROM event_type, events WHERE event_type_id=event_type AND event_id IN (SELECT attended_event_id FROM attendance WHERE attended_member IN (SELECT login_username FROM member_logins WHERE session='$session')) GROUP BY event_type_id");
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
						<a href="/">Homepage </a><img src="../images/arrowPath.png" alt="" /> <a href="account/">Account Management</a><img src="../images/arrowPath.png" alt="" /> <strong>Requirements</strong>
					</div> <!-- close #path -->
					<h2>Requirements</h2>
					<h5 class="section">Attendance</h5>
					<?php
					while($attendance_row=a($attendance)) {
						$attendance_array[$attendance_row['event_type_id']]=array($attendance_row['count']);
					}
					?>
					<p>
						Orientation Picnic:&nbsp;
						<?php
						if(isset($attendance_array[1][0])) {
							echo '<span style="color: blue;">Yes</span>';
						}
						elseif(!isset($attendance_array[1][0])) {
							echo '<span style="color: red;">No</span>';
						}
						?>
					</p>
					<p>
						Super Club's Day:&nbsp;
						<?php
						if(isset($attendance_array[2][0])) {
							echo '<span style="color: blue;">Yes</span>';
						}
						elseif(!isset($attendance_array[2][0])) {
							echo '<span style="color: red;">No</span>';
						}
						?>
					</p>
					<p>
						PIN:&nbsp;
						<?php
						if(isset($attendance_array[3][0])) {
							echo '<span style="color: blue;">Yes</span>';
						}
						elseif(!isset($attendance_array[3][0])) {
							echo '<span style="color: red;">No</span>';
						}
						?>
					</p>
					<p>
						General Meetings:&nbsp;
						<?php
						if(isset($attendance_array[5][0])) {
							if($attendance_array[5][0]>=3) {
								echo '<span style="color: blue;">'.$attendance_array[5][0].'</span>';
							}
							if($attendance_array[5][0]<3) {
								echo '<span style="color: red;">'.$attendance_array[5][0].'</span>';
							}
						}
						elseif(!isset($attendance_array[2][0])) {
							echo '<span style="color: red;">No</span>';
						}
						?>
					</p>
					<p>
						Community Service:&nbsp;
						<?php
						if(isset($attendance_array[8][0])) {
							if($attendance_array[8][0]>=2) {
								echo '<span style="color: blue;">'.$attendance_array[8][0].'</span>';
							}
							if($attendance_array[8][0]<2) {
								echo '<span style="color: red;">'.$attendance_array[8][0].'</span>';
							}
						}
						elseif(!isset($attendance_array[8][0])) {
							echo '<span style="color: red;">No</span>';
						}
						?>
					</p>
					<p>
						Professional Events:&nbsp;
						<?php
						if(isset($attendance_array[6][0])) {
							if($attendance_array[6][0]>=3) {
								echo '<span style="color: blue;">'.$attendance_array[6][0].'</span>';
							}
							if($attendance_array[6][0]<3) {
								echo '<span style="color: red;">'.$attendance_array[6][0].'</span>';
							}
						}
						elseif(!isset($attendance_array[6][0])) {
							echo '<span style="color: red;">No</span>';
						}
						?>
					</p>
					<p>
						Socials:&nbsp;
						<?php
						if(isset($attendance_array[7][0])) {
							if($attendance_array[7][0]>=2) {
								echo '<span style="color: blue;">'.$attendance_array[7][0].'</span>';
							}
							if($attendance_array[7][0]<2) {
								echo '<span style="color: red;">'.$attendance_array[7][0].'</span>';
							}
						}
						elseif(!isset($attendance_array[7][0])) {
							echo '<span style="color: red;">No</span>';
						}
						?>
					</p>
					<br />
					<h5 class="section">Fundraising</h5>
					<p>Amount:&nbsp;
					<?php
					$fundraising=q("SELECT SUM(fund_amount) AS fund_total FROM fundraising, semester WHERE fund_semester=semester_id AND fund_semester IN (SELECT semester_id FROM semester WHERE current_semester=1) AND fund_username IN (SELECT login_username FROM member_logins WHERE session='$session')");
					while($fundraising_row=a($fundraising)) {
						if($fundraising_row['fund_total']==0.00) {
							echo '<span style="color: red;">&#36;0.00</span>';
						}
						elseif($fundraising_row['fund_total']>=0.00) {
							if($fundraising_row['fund_total']<50.00) {
								echo '<span style="color: red;">&#36;'.$fundraising_row['fund_total'].'</span>';
							}
							elseif($fundraising_row['fund_total']>=50.00) {
								echo '<span style="color: blue;">&#36;'.$fundraising_row['fund_total'].'</span>';
							}
						}
					}
					?>
					</p>
				</div> <!-- close #contentLeft_side -->
				<div id="contentRight" class="grid_5">
					<div id="subNavigation">
						<?php account_sub_navigation(); ?>
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