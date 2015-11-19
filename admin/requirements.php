<?php
//start session
session_start();

//include functions
include("../functions.inc");

//connect to mysql
mysql_login();

//check of admin is logged in
check_admin();

//process add attendants
if(isset($_POST['add_attendance_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	mysql_query("DELETE attendance.* FROM attendance LEFT JOIN member_logins ON login_username=attended_member WHERE type<=10 AND attended_event_id='$event_id'") or die(mysql_error());
	$attendant_array=$attendance_users;
	for($a=0; $a<count($attendant_array); $a++) {
		$attendant=$attendant_array[$a];
		mysql_query("INSERT INTO attendance (attended_event_id, attended_member) VALUES ('$event_id', '$attendant')") or die(mysql_error());
	}
	$add_att_success=1;
}

//process add fundraising
if(isset($_POST['fund_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	mysql_query("INSERT INTO fundraising (fund_username, fund_amount, fund_semester, description) VALUES ('$username', '$add_fund_amount', '$semester', '$add_fund_for')") or die(mysql_error());
	$add_fund_success=1;
}
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
						<a href="/">Homepage </a><img src="../images/arrowPath.png" alt="" /> <a href="admin/">Admin </a><img src="../images/arrowPath.png" alt="" /> <strong>Requirements</strong>
					</div> <!-- close #path -->
					<h2>Requirements</h2>
					<?php
					if(isset($add_att_success)) {
						$start=dt($event_start);
						echo form_success("Attendants added to $event_name - $start.");
					}
					if(isset($add_fund_success)) {
						echo form_success("Fundraising amount added to $name.");
					}
					?>
					<h5 class="section">Attendance Requirements</h5>
					<?php
					if(isset($_POST['add_attendants_submit'])) {
						foreach ($_POST as $key => $value){
					    	$$key = $value;
						}
						$event=q("SELECT event_name, event_start FROM events WHERE event_id=$add_attendance_event");
						$event_row=a($event);
						$event_info=$event_row['event_name'].' - '.dt($event_row['event_start']);
						echo form_success("Adding attendants to $event_info.");
						echo '
							<form action="'.$_SERVER['PHP_SELF'].'" method="post">
						';
						$attended_members=q("SELECT attended_member FROM attendance WHERE attended_event_id='$add_attendance_event'");
						while($attended_members_array=mysql_fetch_assoc($attended_members)) {
						    $attended_members_arrays[]=$attended_members_array['attended_member'];
						}
						$member=q("SELECT username, fname, minit, lname FROM members, member_logins WHERE username=login_username AND type<=10 AND type<>0 ORDER BY fname ASC");
						while($member_row=a($member)) {
							$rowcount++;
							$member_name=member_name($member_row['fname'], $member_row['minit'], $member_row['lname']);
							if($rowcount%2) {
								if(isset($attended_members_arrays) && (in_array($member_row['username'], $attended_members_arrays))) {
									echo '
										<div class="attendance_left">
										<input type="checkbox" name="attendance_users[]" value="'.$member_row['username'].'" checked /> '.$member_name.'
										</div>
									';
								}
								else {
									echo '
										<div class="attendance_left">
										<input type="checkbox" name="attendance_users[]" value="'.$member_row['username'].'" /> '.$member_name.'
										</div>
									';
								}
							}
							else {
								if(isset($attended_members_arrays) && (in_array($member_row['username'], $attended_members_arrays))) {
									echo '
										<div class="attendance_right">
										<input type="checkbox" name="attendance_users[]" value="'.$member_row['username'].'" checked /> '.$member_name.'
										</div>
										<div class="clear"></div>
									';
								}
								else {
									echo '
										<div class="attendance_right">
										<input type="checkbox" name="attendance_users[]" value="'.$member_row['username'].'" /> '.$member_name.'
										</div>
										<div class="clear"></div>
									';
								}
							}
						}
						echo '
								<div class="clear"></div>
								<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="add_attendance_submit" id="add_attendance_submit" value="Add Attendants to Event" />&nbsp;<input type="reset" value="Reset">&nbsp;<input type=submit value="Cancel"></div></p>
								<div class="clear"></div>
								<input type="hidden" name="event_id" value="'.$add_attendance_event.'" />
								<input type="hidden" name="event_name" value="'.$event_row['event_name'].'" />
								<input type="hidden" name="event_start" value="'.$event_row['event_start'].'" />
							</form>
						';
					}
					else {
						echo '
							<p><div class="form_name">choose event:</div><div class="form_field">
								<form id="add_attendance" action="'.$_SERVER['PHP_SELF'].'" method="post">
									<select name="add_attendance_event">
						';
						$events=q("SELECT event_id, event_name, event_start FROM events, semester WHERE event_semester=semester_id AND current_semester=1 ORDER BY event_start ASC");
						while($events_row=a($events)) {
							echo '
								<option value="'.$events_row['event_id'].'">'.$events_row['event_name'].' - '.dt($events_row['event_start']).'</option>
							';
						}
						echo '
									</select>
							</div></p>
							<div class="clear"></div>
							<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="add_attendants_submit" id="add_attendants_submit" value="Choose Event" /></div></p>
							<div class="clear"></div>
							</form>	
						';
					}
					?>
					<div class="clear"></div>
					<h5 class="section">Fundraising Requirements</h5>
					<?php
					if(isset($_POST['fund_member_submit'])) {
						foreach ($_POST as $key => $value){
					    	$$key = $value;
						}
						$fund_amount=q("SELECT SUM(fund_amount) AS fund_total FROM fundraising, semester WHERE fund_semester=semester_id AND fund_semester IN (SELECT semester_id FROM semester WHERE current_semester=1) AND fund_username='$fund_member'");
						$fund_amount_array=a($fund_amount);
						$semester=q("SELECT semester_id FROM semester WHERE current_semester=1");
						$semester_array=a($semester);
						$name=q("SELECT fname, minit, lname FROM members WHERE username='$fund_member'");
						$name_array=a($name);
						$name_info=member_name($name_array['fname'], $name_array['minit'], $name_array['lname']);
						echo form_success("Adding fundraising amount to $name_info.");
						echo '
							<form id="add_fund" action="'.$_SERVER['PHP_SELF'].'" method="post">
								<p><div class="form_name">fundraising amount:</div><div class="form_field">&#36;';
						if($fund_amount_array['fund_total']==0) {
							echo '0.00';
						}
						else {
							echo $fund_amount_array['fund_total'];
						}
						echo '
							&#43 &#36;<input class="validate[required]" type="text" name="add_fund_amount" id="add_fund_amount" size="5" /></div></p>
								<div class="clear"></div>
								<p><div class="form_name">for:</div><div class="form_field"><input class="validate[required]" type="text" name="add_fund_for" id="add_fund_for" size="32" maxlength="32" /></div></p>
								<div class="clear"></div>
								<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="fund_submit" id="fund_submit" value="Add Fundraising Amount" /><input type="button" onClick="parent.location='; echo "'admin/requirements.php'"; echo '" value="Cancel"></div></p>
								<div class="clear"></div>
								<input type="hidden" name="username" value="'.$fund_member.'" />
								<input type="hidden" name="semester" value="'.$semester_array['semester_id'].'" />
								<input type="hidden" name="name" value="'.member_name($name_array['fname'], $name_array['minit'], $name_array['lname']).'" />
							</form>
						';
					}
					else {
						echo '
							<form id="edit_fund" action="'.$_SERVER['PHP_SELF'].'" method="post">
								<p><div class="form_name">member name:</div><div class="form_field">
									<select size="1" name="fund_member" id="fund_member">
						';
						$fund_member=q("SELECT username, fname, minit, lname FROM members, member_logins WHERE username=login_username AND type>0 ORDER BY fname, lname ASC");
						while($fund_member_row=a($fund_member)) {
							$fund_name=member_name($fund_member_row['fname'], $fund_member_row['minit'], $fund_member_row['lname']);
							echo '
								<option value="'.$fund_member_row['username'].'">'.$fund_name.'</option>
							';
						}
						echo '
									</select>
								</div></p>
								<div class="clear"></div>
								<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="fund_member_submit" id="fund_member_submit" value="Select Member" /></div></p>
								<div class="clear"></div>
							</form>	
						';
					}
					?>
					</form>
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