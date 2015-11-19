<?php
//start session
session_start();

//include functions
include("../functions.inc");

//connect to mysql
mysql_login();

//check of admin is logged in
check_admin();

//process change semester
if(isset($_POST['semester_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	mysql_query("UPDATE semester SET current_semester=0 WHERE current_semester=1") or die(mysql_error());
	mysql_query("UPDATE semester SET current_semester=1 WHERE semester_id='$select_semester'") or die(mysql_error());
	$new_semester=q("SELECT semester_name FROM semester WHERE semester_id='$select_semester'");
	$new_semester_array=a($new_semester);
	$new_semester_name=$new_semester_array['semester_name'];
	$semester_success=1;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<?php headers(); ?>
		<script>
		<!--
		// Nannette Thacker http://www.shiningstar.net
		function confirmSubmit() 
		{
		var agree=confirm("Are you sure you want change the current semester?");
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
						<a href="/">Homepage </a><img src="../images/arrowPath.png" alt="" /> <strong>Admin</strong>
					</div> <!-- close #path -->
					<h2>Admin</h2>
					<?php
					if(isset($semester_success)) {
						echo form_success("Semester changed to $new_semester_name.");
					}
					?>
					<h5 class="section">Current Semester</h5>
					<form id="semester" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
					<p><div class="form_name">choose current semester:</div><div class="form_field">
						<select name="select_semester">
						<?
						$semester=q("SELECT * FROM semester ORDER BY semester_id ASC");
						while($semester_row=a($semester)) {
							if($semester_row['current_semester']==1) {
								echo '<option value="'.$semester_row['semester_id'].'" selected>'.$semester_row['semester_name'].'</option>';
							}
							else {
								echo '<option value="'.$semester_row['semester_id'].'">'.$semester_row['semester_name'].'</option>';
							}
						}
						?>
						</select>
					</div></p>
					<div class="clear"></div>
					<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="semester_submit" id="semester_submit" value="Submit" onClick="return confirmSubmit()" /></div></p>
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