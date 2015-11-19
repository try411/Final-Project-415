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

if(isset($_POST['change_email_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	mysql_query("UPDATE members, member_logins SET email='$new_email' WHERE username=login_username AND session='$session'") or die(mysql_error());
	$change_email_success=1;
}
if(isset($_POST['change_password_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	$encrypted_old_password=md5($old_password);
	$encrypted_new_password=md5($new_password);
	$check_password=q("SELECT * FROM member_logins WHERE session='$session' AND password='$encrypted_old_password'");
	$check_password_count=c($check_password);
	if($check_password_count==1) {
		mysql_query("UPDATE member_logins SET password='$encrypted_new_password' WHERE session='$session' AND password='$encrypted_old_password'") or die(mysql_error());
		$change_password_success=1;
	}
	elseif($check_oassword_count==0) {
		$old_password_error=1;
	}
}

$member=q("SELECT * FROM members, member_logins, member_profiles WHERE username=login_username AND username=member_username AND session='$session'");
$member_array=a($member);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<?php headers(); ?>
		<script>
			$(document).ready(function() {
				$("#change_email").validationEngine()
			})
		</script>
		<script>
			$(document).ready(function() {
				$("#change_password").validationEngine()
			})
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
						<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <strong>Account Management</strong>
					</div> <!-- close #path -->
					<h2>Account Management</h2>
					<?php
					if(isset($change_email_success)) {
						echo form_success("You have successfully changed your email address.");
					}
					if(isset($change_password_success)) {
						echo form_success("You have successfully changed your password.");
					}
					if(isset($old_password_error)) {
						echo form_error("Your old password does not match.  Please try again.");
					}
					?>
					<h5 class="section">Account Info</h5>
					<p>Username: <?php echo $member_array['username']; ?></p>
					<p>Name: <?php echo member_name($member_array['fname'], $member_array['minit'], $member_array['lname']); ?></p>
					<p>Member Since: <?php echo semester($member_array['join_semester']); ?></p>
					<p>
						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
							Email: <?php echo $member_array['email']; ?>&nbsp;
							<input type="submit" name="edit_email" value="Edit" />
						</form>
					</p>
					<p>
						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
							Password: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;
							<input type="submit" name="edit_password" value="Edit" />
						</form>
					</p>
					<?php
					if(isset($_POST['edit_email'])) {
						echo '
							<br />
							<h5 class="section">Change Email</h5>
							<form id="change_email" action="'.$_SERVER['PHP_SELF'].'" method="post">
							<p><div class="form_name">new email:</div><div class="form_field"><input class="validate[required,custom[email]]" type="text" name="new_email" id="new_email" size="32" maxlength="32" /></div></p>
							<div class="clear"></div>
							<p><div class="form_name">confirm email:</div><div class="form_field"><input class="validate[required,confirm[new_email]]" type="text" name="confirm_email" id="confirm_email" size="32" maxlength="32" /></div></p>
							<div class="clear"></div>
							<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="change_email_submit"  id="change_email_submit" value="Change Email"</div></p>
							<div class="clear"></div>
						';
					}
					if(isset($_POST['edit_password'])) {
						echo '
							<br />
							<h5 class="section">Change Password</h5>
							<form id="change_password" action="'.$_SERVER['PHP_SELF'].'" method="post">
							<p><div class="form_name">old password:</div><div class="form_field"><input class="validate[required]" type="password" name="old_password" id="old_password" size="32" /></div></p>
							<div class="clear"></div>
							<p><div class="form_name">new password:</div><div class="form_field"><input class="validate[required]" type="password" name="new_password" id="new_password" size="32" /></div></p>
							<div class="clear"></div>
							<p><div class="form_name">confirm password:</div><div class="form_field"><input class="validate[required,confirm[new_password]]" type="password" name="confirm_password" id="confirm_password" size="32" /></div></p>
							<div class="clear"></div>
							<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="change_password_submit"  id="change_password_submit" value="Change Password"</div></p>
							<div class="clear"></div>
						';
					}
					?>
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