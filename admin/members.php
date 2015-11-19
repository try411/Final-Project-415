<?php
//start session
session_start();

//include functions
include("../functions.inc");

//connect to mysql
mysql_login();

//check of admin is logged in
check_admin();

//process add member
if(isset($_POST['add_member_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	mysql_query("INSERT INTO members (username, fname, minit, lname, email) VALUES ('$add_member_username', '$add_member_fname', '$add_member_minit', '$add_member_lname', '$add_member_email')") or die(mysql_error());
	mysql_query("INSERT INTO member_profiles (member_username, join_semester) VALUES ('$add_member_username', '$add_member_join_sem')") or die(mysql_error());
	$pass=genRandomString();
	$temp_pass=md5($pass);
	mysql_query("INSERT INTO member_logins (login_username, password, type, session, reset_password) VALUES ('$add_member_username', '$temp_pass', '$add_member_type', '', '1')") or die(mysql_error());
	$to=$add_member_email;
	$subject="Your new account to the ITMA Hawaii website";
	$body="Hello $add_member_fname,\n\nA new account has been created for you.\n\nPlease use the below temporary password to login.  You will be asked to change your password afterwards.\n\nUsername: $add_member_username\nTemporary password: $pass\n\nLogin here: http://www.itmahawaii.com/login.php";
	$headers="From: ITMA Hawaii<no-reply@itmahawaii.com>\r\n";
    $headers.="Return-Path: <no-reply@itmahawaii.com>\r\n";
    $headers.="Envelope-from: <no-reply@itmahawaii.com>\r\n";
    $headers.="X-Mailer: PHP" . phpversion();
	if(mail($to, $subject, $body, $headers)) {
		$add_member_success=1;
	} 
	else {
		$add_member_success=0;
	}
}

//process edit member
if(isset($_POST['edit_member_info_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	mysql_query("UPDATE members SET fname='$edit_member_fname', minit='$edit_member_minit', lname='$edit_member_lname', email='$edit_member_email' WHERE username='$edit_member_name'")or die(mysql_error());
	mysql_query("UPDATE member_logins SET type='$edit_member_type' WHERE login_username='$edit_member_name'")or die(mysql_error());
	if($edit_member_type<=10) {
		mysql_query("UPDATE member_profiles SET grad_semester=NULL, left_semester=NULL WHERE member_username='$edit_member_name'")or die(mysql_error());
	}
	if($edit_member_type==11) {
		mysql_query("UPDATE member_profiles SET grad_semester='$add_member_grad_sem', left_semester=NULL WHERE member_username='$edit_member_name'")or die(mysql_error());
	}
	if($edit_member_type==12) {
		mysql_query("UPDATE member_profiles SET grad_semester=NULL, left_semester='$add_member_left_sem' WHERE member_username='$edit_member_name'")or die(mysql_error());
	}
	$edit_member_success=1;
}

//process delete member
if(isset($_POST['delete_member_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	$delete_name=q("SELECT fname, minit, lname FROM members WHERE username='$delete_member_name'");
	$delete_name_array=a($delete_name);
	mysql_query("DELETE FROM members WHERE username='$delete_member_name'") or die(mysql_error());
	mysql_query("DELETE FROM member_profiles WHERE member_username='$delete_member_name'") or die(mysql_error());
	mysql_query("DELETE FROM member_logins WHERE login_username='$delete_member_name'") or die(mysql_error());
	$delete_member_success=1;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<?php headers(); ?>
		<script>
			$(document).ready(function() {
				$("#add_member").validationEngine()
			})
			$(document).ready(function() {
				$("#edit_member").validationEngine()
			})
		</script>
		<script>
		<!--
		// Nannette Thacker http://www.shiningstar.net
		function confirmSubmit() 
		{
		var agree=confirm("Are you sure you want to delete this member?  This cannot be undone.");
		if (agree)
			return true ;
		else
			return false ;
		}
		// -->
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
		<div id="contentTop"></div>
		<div id="content-wrap">
			<div id="content" class="container_16 clearfix">
				<div id="contentLeft_side" class="grid_10">
					<div class="path">
						<a href="/">Homepage </a><img src="../images/arrowPath.png" alt="" /> <a href="admin/">Admin </a><img src="../images/arrowPath.png" alt="" /> <strong>Members</strong>
					</div> <!-- close #path -->
					<h2>Members</h2>
					<?php
					if(isset($add_member_success)) {
						$member_name=member_name($add_member_fname, $add_member_minit, $add_member_lname);
						if($add_member_success==1) {
							echo form_success("Member $member_name added. Email sent to $add_member_email.");
						}
						elseif($add_member_success==0) {
							echo form_error("There was a problem adding $member_name. Please contact the webmaster.");
						}
					}
					if(isset($edit_member_success)) {
						$member_name=member_name($edit_member_fname, $edit_member_minit, $edit_member_lname);
						echo form_success("Member $member_name&rsquo;s information edited.");
					}
					if(isset($delete_member_success)) {
						$member_name=member_name($delete_name_array['fname'], $delete_name_array['minit'], $delete_name_array['lname']);
						echo form_success("Member $member_name deleted.");
					}
					?>
					<h5 class="section">Add Member</h5>
					<form id="add_member" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
						<p><div class="form_name">first name:</div><div class="form_field"><input class="validate[required]" type="text" name="add_member_fname" id="add_member_fname" size="32" maxlength="32" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">middle inital:</div><div class="form_field"><input type="text" name="add_member_minit" id="add_member_minit" size="1" maxlength="1" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">last name:</div><div class="form_field"><input class="validate[required]" type="text" name="add_member_lname" id="add_member_lname" size="32" maxlength="32" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">username:</div><div class="form_field"><input class="validate[required]" type="text" name="add_member_username" id="add_member_username" size="32" maxlength="32" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">email:</div><div class="form_field"><input class="validate[required,custom[email]]" type="text" name="add_member_email" id="add_member_email" size="32" maxlength="32" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">join semester:</div><div class="form_field">
							<select size="1" name="add_member_join_sem" id="add_member_join_sem">
							<?php
							$semester_join=q("SELECT * FROM semester");
							while($semester_join_row=a($semester_join)) {
								if($semester_join_row['current_semester']==1) {
									echo '<option value="'.$semester_join_row['semester_id'].'" selected>'.$semester_join_row['semester_name'].'</option>';
								}
								else {
									echo '<option value="'.$semester_join_row['semester_id'].'">'.$semester_join_row['semester_name'].'</option>';
								}
							}
							?>
							</select>
						</div></p>
						<div class="clear"></div>
						<p><div class="form_name">member type:</div><div class="form_field">
							<select size="1" name="add_member_type" id="add_member_type">
			            	<?
			            	$add_member_type=q("SELECT * FROM member_type ORDER BY member_type_id ASC");
							while($add_member_type_row=a($add_member_type)) {
								if($add_member_type_row['member_type_id']==10) {
									echo '
										<option value="'.$add_member_type_row['member_type_id'].'" selected>'.$add_member_type_row['member_type_name'].'</option>
									';
								}
								else {
									echo '
										<option value="'.$add_member_type_row['member_type_id'].'">'.$add_member_type_row['member_type_name'].'</option>
									';
								}
							}
			            	?>
			            	</select>
						</div></p>
						<div class="clear"></div>
						<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="add_member_submit" id="add_member_submit" value="Add Member" />&nbsp;<input type="reset" value="Reset"></div></p>
						<div class="clear"></div>
					</form>
					<h5 class="section">Edit Member</h5>
					<?php
					if(isset($_POST['edit_member_submit'])) {
						foreach ($_POST as $key => $value){
					    	$$key = $value;
						}
						$member_info=q("SELECT * FROM members, member_logins WHERE username=login_username AND username='$edit_member_name'");
						while($member_info_row=a($member_info)) {
							$member_name=member_name($member_info_row['fname'], $member_info_row['minit'], $member_info_row['lname']);
							echo form_success("Editing $member_name&rsquo;s information.");
							echo '
								<form id="edit_member" action="'.$_SERVER['PHP_SELF'].'" method="post">
								<p><div class="form_name">first name:</div><div class="form_field"><input class="validate[required]" type="text" name="edit_member_fname" id="edit_member_fname" size="32" maxlength="32" value="'.$member_info_row['fname'].'" /></div></p>
								<div class="clear"></div>
								<p><div class="form_name">middle inital:</div><div class="form_field"><input type="text" name="edit_member_minit" id="edit_member_minit" size="1" maxlength="1" value="'.$member_info_row['minit'].'" /></div></p>
								<div class="clear"></div>
								<p><div class="form_name">last name:</div><div class="form_field"><input class="validate[required]" type="text" name="edit_member_lname" id="edit_member_lname" size="32" maxlength="32" value="'.$member_info_row['lname'].'" /></div></p>
								<div class="clear"></div>
								<p><div class="form_name">email:</div><div class="form_field"><input class="validate[required,custom[email]]" type="text" name="edit_member_email" id="edit_member_email" size="32" maxlength="32" value="'.$member_info_row['email'].'" /></div></p>
								<div class="clear"></div>
								<p><div class="form_name">edit member type:</div><div class="form_field">
									<select size="1" name="edit_member_type" id="edit_member_type">
							';
							$edit_member_type=q("SELECT * FROM member_type ORDER BY member_type_id ASC");
							while($edit_member_type_row=a($edit_member_type)) {
								if($edit_member_type_row['member_type_id']==$member_info_row['type']) {
									if($edit_member_type_row['member_type_id']==11) {
										echo '<option rel="grad_sem" value="'.$edit_member_type_row['member_type_id'].'" selected>'.$edit_member_type_row['member_type_name'].'</option>';
									}
									elseif($edit_member_type_row['member_type_id']==12) {
										echo '<option rel="left_sem" value="'.$edit_member_type_row['member_type_id'].'" selected>'.$edit_member_type_row['member_type_name'].'</option>';
									}
									else {
										echo '
											<option rel="none" value="'.$edit_member_type_row['member_type_id'].'" selected>'.$edit_member_type_row['member_type_name'].'</option>
										';
									}
								}
								else {
									if($edit_member_type_row['member_type_id']==11) {
										echo '<option rel="grad_sem" value="'.$edit_member_type_row['member_type_id'].'" >'.$edit_member_type_row['member_type_name'].'</option>';
									}
									elseif($edit_member_type_row['member_type_id']==12) {
										echo '<option rel="left_sem" value="'.$edit_member_type_row['member_type_id'].'" >'.$edit_member_type_row['member_type_name'].'</option>';
									}
									else {
										echo '
											<option rel="none" value="'.$edit_member_type_row['member_type_id'].'" >'.$edit_member_type_row['member_type_name'].'</option>
										';
									}
								}
							}
							echo '
									</select>
								</div></p>
								<div class="clear"></div>
								<p><div rel="grad_sem" class="form_name">grad semester:</div><div rel="grad_sem" class="form_field">
									<select size="1" name="add_member_grad_sem" id="add_member_grad_sem">
							';
							$semester_option=q("SELECT * FROM semester");
							while($semester_grad_row=a($semester_option)) {
								if($semester_grad_row['current_semester']==1) {
									echo '<option value="'.$semester_grad_row['semester_id'].'" selected>'.$semester_grad_row['semester_name'].'</option>';
								}
								else {
									echo '<option value="'.$semester_grad_row['semester_id'].'">'.$semester_grad_row['semester_name'].'</option>';
								}
							}
							echo '
									</select>
								</div></p>
								<p><div rel="left_sem" class="form_name">left semester:</div><div rel="left_sem" class="form_field">
									<select size="1" name="add_member_left_sem" id="add_member_left_sem">
							';
							$semester_left=q("SELECT * FROM semester");
							while($semester_left_row=a($semester_left)) {
								if($semester_left_row['current_semester']==1) {
									echo '<option value="'.$semester_left_row['semester_id'].'" selected>'.$semester_left_row['semester_name'].'</option>';
								}
								else {
									echo '<option value="'.$semester_left_row['semester_id'].'">'.$semester_left_row['semester_name'].'</option>';
								}
							}
							echo '
									</select>
								</div></p>
								<div class="clear"></div>
								<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="edit_member_info_submit" id="edit_member_info_submit" value="Edit Member Information" /><input type="submit" value="Cancel"></div></p>
								<div class="clear"></div>
								<input type="hidden" name="edit_member_name" value="'.$edit_member_name.'" />
							';
						}
					}
					else {
						echo '
							<form id="edit_member" action="'.$_SERVER['PHP_SELF'].'" method="post">
								<p><div class="form_name">edit member:</div><div class="form_field">
									<select size="1" name="edit_member_name" id="edit_member_name">
						';
						$edit_member=q("SELECT username, fname, minit, lname FROM members WHERE username IN (SELECT login_username FROM member_logins WHERE type>0) ORDER BY fname, lname ASC");
						while($edit_member_row=a($edit_member)) {
							$edit_member_name=member_name($edit_member_row['fname'], $edit_member_row['minit'], $edit_member_row['lname']);
							echo '
								<option value="'.$edit_member_row['username'].'">'.$edit_member_name.'</option>
							';
						}
						echo '
									</select>
								</div></p>
								<div class="clear"></div>
								<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="edit_member_submit" id="edit_member_submit" value="Edit Member" /></div></p>
								<div class="clear"></div>
							</form>
						';
					};
					?>
					<h5 class="section">Delete Member</h5>
					<form id="delete_member" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
						<p><div class="form_name">member name:</div><div class="form_field">
							<select size="1" name="delete_member_name" id="delete_member_name">
								<?php
								$delete_member=q("SELECT username, fname, minit, lname FROM members WHERE username IN (SELECT login_username FROM member_logins WHERE type>0) ORDER BY fname, lname ASC");
								while($delete_member_row=a($delete_member)) {
									$delete_member_name=member_name($delete_member_row['fname'], $delete_member_row['minit'], $delete_member_row['lname']);
									echo '
										<option value="'.$delete_member_row['username'].'">'.$delete_member_name.'</option>
									';
								}
								?>
							</select>
						</div></p>
						<div class="clear"></div>
						<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="delete_member_submit" id="delete_member_submit" value="Delete Member" onClick="return confirmSubmit()" /></div></p>
						<div class="clear"></div>
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