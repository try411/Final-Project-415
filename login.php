<?php
//start session
session_start();

//include functions
include("functions.inc");

//connect to mysql
mysql_login();

//process login
if(isset($_POST['login_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	$encrypted_password=md5($login_password);
	$login=q("SELECT * FROM member_logins WHERE login_username='$login_username' AND password='$encrypted_password' AND type<=10");
	$login_array=a($login);
	$login_count=c($login);
	if($login_count==1) {
		if($login_array['reset_password']==1) {
			$_SESSION['username']=$login_array['login_username'];
			header('Location: password_change.php');
		}
		else {
			$session_id=crypt("itm@hawaii");
			$session_time=time()+3600;
			setcookie('session', $session_id, $session_time);
			mysql_query("UPDATE member_logins SET session='$session_id' WHERE login_username='$login_username' AND password='$encrypted_password'") or die(mysql_error());
			$ip=$_SERVER['REMOTE_ADDR'];
			$browser_os=$_SERVER['HTTP_USER_AGENT'];
			mysql_query("SET time_zone='Pacific/Honolulu';") or die(mysql_error());
			mysql_query("INSERT INTO access_log (id, username, ip, browser_os, access_time) VALUES ('', '$login_username', '$ip', '$browser_os', NOW())") or die(mysql_error());
			header('Location: /');
		}
	}
	elseif($login_count==0) {
		$login_error='1';
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<?php headers(); ?>
		<script>
			$(document).ready(function() {
				$("#login").validationEngine()
			})
		</script>
	</head>
	
	<body>
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
						<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <strong>Login</strong>
					</div> <!-- close #path -->
					<h2>Login</h2>
					<?php
					if(isset($login_error)) {
						echo form_error("Wrong username or password.  Please try again.");
					}
					if(isset($_SESSION['login_new_pass'])) {
						echo form_success("Please login with your new password.");
						unset($_SESSION['login_new_pass']);
					}
					?>
					<form id="login" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
						<p><div class="form_name">username:</div><div class="form_field"><input id="login_username" class="validate[required]" name="login_username" type="text" size="32" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">password:</div><div class="form_field"><input  id="login_password" class="validate[required]" name="login_password" type="password" size="32" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="login_submit" value="Login" /></div>&nbsp;&nbsp;&nbsp;<a href="password_reset.php">Forgot Password?</a></p>
						<div class="clear"></div>
					</form>
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