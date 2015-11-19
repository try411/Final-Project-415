<?php
//start session
session_start();

//include functions
include("../functions.inc");

//connect to mysql
mysql_login();

//check of admin is logged in
check_admin();

//process add event
if(isset($_POST['add_event_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	$add_event_start=mysql_time($add_event_date,$begin_time_hour,$begin_time_min);
	$add_event_end=mysql_time($add_event_date,$end_time_hour,$end_time_min);
	mysql_query("INSERT INTO events (event_id, event_name, event_semester, event_start, event_end, event_location, event_description, event_type) VALUES ('', '$add_event_name', '$add_event_semester', '$add_event_start', '$add_event_end', '$add_event_location', '$add_event_desc', '$add_event_type')") or die(mysql_error());
	$add_event_success=1;
}

//process edit event
if(isset($_POST['edit_event_info_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	$edit_event_start=mysql_time($edit_event_date,$edit_begin_time_hour,$edit_begin_time_min);
	$edit_event_end=mysql_time($edit_event_date,$edit_end_time_hour,$edit_end_time_min);
	mysql_query("UPDATE events SET event_name='$edit_event_name', event_semester='$edit_event_semester', event_start='$edit_event_start', event_end='$edit_event_end', event_location='$edit_event_location', event_description='$edit_event_desc', event_type='$edit_event_type' WHERE event_id='$edit_event_id'") or die(mysql_error());
	$edit_event_info_success=1;
}

//process delete event
if(isset($_POST['delete_event_submit'])) {
	foreach ($_POST as $key => $value){
    	$$key = $value;
	}
	$delete_event_info=q("SELECT * FROM events WHERE event_id='$delete_event_id'");
	$delete_event_info_row=a($delete_event_info);
	$delete_event_info=$delete_event_info_row['event_start'];
	$delete_event_name=$delete_event_info_row['event_name'];
	$delete_event_success=1;
	mysql_query("DELETE FROM events WHERE event_id='$delete_event_id'") or die(mysql_error());
	mysql_query("DELETE FROM attendance WHERE attended_event_id='$delete_event_id'") or die(mysql_error());
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<?php headers(); ?>
		<script>
			$(document).ready(function() {
				$("#add_event").validationEngine()
			})
			$(document).ready(function() {
				$("#edit_event").validationEngine()
			})
		</script>
		<script>
		<!--
		// Nannette Thacker http://www.shiningstar.net
		function confirmSubmit() 
		{
		var agree=confirm("Are you sure you want to delete this event?  This cannot be undone.");
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
						<a href="/">Homepage </a><img src="../images/arrowPath.png" alt="" /> <a href="admin/">Admin </a><img src="../images/arrowPath.png" alt="" /> <strong>Calendar</strong>
					</div> <!-- close #path -->
					<h2>Calendar</h2>
					<?php
					if(isset($add_event_success)) {
						$start=dt($add_event_start);
						echo form_success("$add_event_name - $start added.");
					}
					if(isset($edit_event_info_success)) {	
						$start=dt($edit_event_start);
						echo form_success("$edit_event_name - $start information edited.");
					}
					if(isset($delete_event_success)) {	
						$start=dt($delete_event_info);
						echo form_success("$delete_event_name - $start deleted.");
					}
					?>
					<h5 class="section">Add Event</h5>
					<form id="add_event" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
						<p><div class="form_name">event name:</div><div class="form_field"><input class="validate[required]" type="text" name="add_event_name" id="add_event_name" size="32" maxlength="64" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">event semester:</div><div class="form_field">
							<select name="add_event_semester">
							<?php
							$event_semester=q("SELECT * FROM semester ORDER BY semester_id ASC");
							while($event_semester_row=a($event_semester)) {
								if($event_semester_row['current_semester']==1) {
									echo '<option value="'.$event_semester_row['semester_id'].'" selected>'.$event_semester_row['semester_name'].'</option>';
								}
								else {
									echo '<option value="'.$event_semester_row['semester_id'].'">'.$event_semester_row['semester_name'].'</option>';
								}
							}
							?>
							</select>
						</div></p>
						<div class="clear"></div>
						<p><div class="form_name">event date:</div><div class="form_field">
						<script>DateInput('add_event_date', true, 'YYYY-MM-DD')</script>
						</div></p>
						<div class="clear"></div>
						<p><div class="form_name">event time:</div><div class="form_field">
							<select name="begin_time_hour">
								<option value="00">12 am</option>
								<option value="01">01 am</option>
								<option value="02">02 am</option>
								<option value="03">03 am</option>
								<option value="04">04 am</option>
								<option value="05">05 am</option>
								<option value="06">06 am</option>
								<option value="07">07 am</option>
								<option value="08" selected>08 am</option>
								<option value="09">09 am</option>
								<option value="10">10 am</option>
								<option value="11">11 am</option>
								<option value="12">12 pm</option>
								<option value="13">01 pm</option>
								<option value="14">02 pm</option>
								<option value="15">03 pm</option>
								<option value="16">04 pm</option>
								<option value="17">05 pm</option>
								<option value="18">06 pm</option>
								<option value="19">07 pm</option>
								<option value="20">08 pm</option>
								<option value="21">09 pm</option>
								<option value="22">10 pm</option>
								<option value="23">11 pm</option>
							</select>
							:
							<select name="begin_time_min">
								<option value="00">00</option>
								<option value="15">15</option>
								<option value="30">30</option>
								<option value="45">45</option>
							</select>
							&nbsp;to&nbsp;
							<select name="end_time_hour">
								<option value="00">12 am</option>
								<option value="01">01 am</option>
								<option value="02">02 am</option>
								<option value="03">03 am</option>
								<option value="04">04 am</option>
								<option value="05">05 am</option>
								<option value="06">06 am</option>
								<option value="07">07 am</option>
								<option value="08">08 am</option>
								<option value="09">09 am</option>
								<option value="10">10 am</option>
								<option value="11">11 am</option>
								<option value="12">12 pm</option>
								<option value="13">01 pm</option>
								<option value="14">02 pm</option>
								<option value="15">03 pm</option>
								<option value="16">04 pm</option>
								<option value="17" selected>05 pm</option>
								<option value="18">06 pm</option>
								<option value="19">07 pm</option>
								<option value="20">08 pm</option>
								<option value="21">09 pm</option>
								<option value="22">10 pm</option>
								<option value="23">11 pm</option>
							</select>
							:
							<select name="end_time_min">
								<option value="00">00</option>
								<option value="15">15</option>
								<option value="30">30</option>
								<option value="45">45</option>
							</select>
						</div></p>
						<div class="clear"></div>
						<p><div class="form_name">event location:</div><div class="form_field"><input class="validate[required]" type="text" name="add_event_location" id="add_event_location" size="32" maxlength="64" /></div></p>
						<div class="clear"></div>
						<p><div class="form_name">event description:</div><div class="form_field"><textarea name="add_event_desc" id="add_event_desc" cols="40" rows="6" maxlength="512"></textarea></div></p>
						<div class="clear"></div>
						<p><div class="form_name">event type:</div><div class="form_field">
							<select size="1" name="add_event_type" id="add_event_type">
				            	<?php
				            	$event_type=q("SELECT * FROM event_type ORDER by event_type_id ASC");
								while($event_type_row=a($event_type)) {
									echo '<option value="'.$event_type_row['event_type_id'].'">'.$event_type_row['event_type_name'].'</option>';
								}
				            	?>
			            	</select>
						</div></p>
						<div class="clear"></div>
						<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="add_event_submit" id="add_event_submit" value="Add Event" />&nbsp;<input type="reset" value="Reset"></div></p>
						<div class="clear"></div>
					</form>
					<h5 class="section">Edit Event</h5>
					<?php
					if(isset($_POST['edit_event_submit'])) {
						foreach ($_POST as $key => $value){
					    	$$key = $value;
						}
						$edit_event_info=q("SELECT * FROM events WHERE event_id='$edit_event_id'");
						$edit_event_info_row=a($edit_event_info);
						$parsed_begin_date=date_parse($edit_event_info_row['event_start']);
						$parsed_end_date=date_parse($edit_event_info_row['event_end']);
						$start_date=$parsed_begin_date['year'].'-'.$parsed_begin_date['month'].'-'.$parsed_begin_date['day'];
						$edit_info=$edit_event_info_row['event_name'].' - '.dt($edit_event_info_row['event_start']);
						echo form_success("Editing $edit_info information.");
						echo '
							<form action="'.$_SERVER['PHP_SELF'].'" id="edit_event" method="post">
								<p><div class="form_name">edit event name:</div><div class="form_field"><input class="validate[required]" type="text" name="edit event_name" id="edit_event_name" size="32" maxlength="32" value="'.$edit_event_info_row['event_name'].'" /></div></p>
								<div class="clear"></div>
								<p><div class="form_name">edit event semester:</div><div class="form_field">
									<select name="edit_event_semester">
						';
						$edit_event_semester=q("SELECT * FROM semester ORDER BY semester_id ASC");
						while($edit_event_semester_row=a($edit_event_semester)) {
							if($edit_event_semester_row['semester_id']===$edit_event_info_row['event_semester']) {
								echo '<option value="'.$edit_event_semester_row['semester_id'].'" selected>'.$edit_event_semester_row['semester_name'].'</option>';
							}
							else {
								echo '<option value="'.$edit_event_semester_row['semester_id'].'">'.$edit_event_semester_row['semester_name'].'</option>';
							}
						}			
						echo '
									</select>
								</div></p>
								<div class="clear"></div>
								<p><div class="form_name">edit event date:</div><div class="form_field">
									<script>DateInput("edit_event_date", true, "YYYY-MM-DD", "'.$start_date.'")</script>
								</div></p>
								<div class="clear"></div>
								<p><div class="form_name">edit event time:</div><div class="form_field">
									<select name="edit_begin_time_hour">
						';
						if($parsed_begin_date['hour']==0) {
							echo '<option value="00" selected>12 am</option>';
						}
						else echo '<option value="00">12 am</option>';
						
						if($parsed_begin_date['hour']==1) {
							echo '<option value="01" selected>01 am</option>';
						}
						else echo '<option value="01">01 am</option>';
						
						if($parsed_begin_date['hour']==2) {
							echo '<option value="02" selected>02 am</option>';
						}
						else echo '<option value="02">02 am</option>';
						
						if($parsed_begin_date['hour']==3) {
							echo '<option value="03" selected>03 am</option>';
						}
						else echo '<option value="03">03 am</option>';
						
						if($parsed_begin_date['hour']==4) {
							echo '<option value="04" selected>04 am</option>';
						}
						else echo '<option value="04">04 am</option>';
						
						if($parsed_begin_date['hour']==5) {
							echo '<option value="05" selected>05 am</option>';
						}
						else echo '<option value="05">05 am</option>';
						
						if($parsed_begin_date['hour']==6) {
							echo '<option value="06" selected>06 am</option>';
						}
						else echo '<option value="06">06 am</option>';
						
						if($parsed_begin_date['hour']==7) {
							echo '<option value="07" selected>07 am</option>';
						}
						else echo '<option value="07">07 am</option>';
						
						if($parsed_begin_date['hour']==8) {
							echo '<option value="08" selected>08 am</option>';
						}
						else echo '<option value="08">08 am</option>';
						
						if($parsed_begin_date['hour']==9) {
							echo '<option value="09" selected>09 am</option>';
						}
						else echo '<option value="09">09 am</option>';
						
						if($parsed_begin_date['hour']==10) {
							echo '<option value="10" selected>10 am</option>';
						}
						else echo '<option value="10">10 am</option>';
						
						if($parsed_begin_date['hour']==11) {
							echo '<option value="11" selected>11 am</option>';
						}
						else echo '<option value="11">11 am</option>';
						
						if($parsed_begin_date['hour']==12) {
							echo '<option value="12" selected>12 pm</option>';
						}
						else echo '<option value="12">12 pm</option>';
						
						if($parsed_begin_date['hour']==13) {
							echo '<option value="13" selected>01 pm</option>';
						}
						else echo '<option value="13">01 pm</option>';
						
						if($parsed_begin_date['hour']==14) {
							echo '<option value="14" selected>02 pm</option>';
						}
						else echo '<option value="14">02 pm</option>';
						
						if($parsed_begin_date['hour']==15) {
							echo '<option value="15" selected>03 pm</option>';
						}
						else echo '<option value="15">03 pm</option>';
						
						if($parsed_begin_date['hour']==16) {
							echo '<option value="16" selected>04 pm</option>';
						}
						else echo '<option value="16">04 pm</option>';
						
						if($parsed_begin_date['hour']==17) {
							echo '<option value="17" selected>05 pm</option>';
						}
						else echo '<option value="17">05 pm</option>';
						
						if($parsed_begin_date['hour']==18) {
							echo '<option value="18" selected>06 pm</option>';
						}
						else echo '<option value="18">06 pm</option>';
						
						if($parsed_begin_date['hour']==19) {
							echo '<option value="19" selected>07 pm</option>';
						}
						else echo '<option value="19">07 pm</option>';
						
						if($parsed_begin_date['hour']==20) {
							echo '<option value="20" selected>08 pm</option>';
						}
						else echo '<option value="20">08 pm</option>';
						
						if($parsed_begin_date['hour']==21) {
							echo '<option value="21" selected>09 pm</option>';
						}
						else echo '<option value="21">09 pm</option>';
						
						if($parsed_begin_date['hour']==22) {
							echo '<option value="22" selected>10 pm</option>';
						}
						else echo '<option value="22">10 pm</option>';
						
						if($parsed_begin_date['hour']==23) {
							echo '<option value="23" selected>11 pm</option>';
						}
						else echo '<option value="23">11 pm</option>';
									
						echo '
									</select>
									:
									<select name="edit_begin_time_min">
						';
						
						if($parsed_begin_date['minute']==0) {
							echo '<option value="00" selected>00</option>';
						}
						else echo '<option value="00">00</option>';
						
						if($parsed_begin_date['minute']==15) {
							echo '<option value="15" selected>15</option>';
						}
						else echo '<option value="15">15</option>';
						
						if($parsed_begin_date['minute']==30) {
							echo '<option value="30" selected>30</option>';
						}
						else echo '<option value="30">30</option>';
						
						if($parsed_begin_date['minute']==45) {
							echo '<option value="45" selected>45</option>';
						}
						else echo '<option value="45">45</option>';
									
						echo '
									</select>
									&nbsp;to&nbsp;
									<select name="edit_end_time_hour">
						';
						
						if($parsed_end_date['hour']==0) {
							echo '<option value="00" selected>12 am</option>';
						}
						else echo '<option value="00">12 am</option>';
						
						if($parsed_end_date['hour']==1) {
							echo '<option value="01" selected>01 am</option>';
						}
						else echo '<option value="01">01 am</option>';
						
						if($parsed_end_date['hour']==2) {
							echo '<option value="02" selected>02 am</option>';
						}
						else echo '<option value="02">02 am</option>';
						
						if($parsed_end_date['hour']==3) {
							echo '<option value="03" selected>03 am</option>';
						}
						else echo '<option value="03">03 am</option>';
						
						if($parsed_end_date['hour']==4) {
							echo '<option value="04" selected>04 am</option>';
						}
						else echo '<option value="04">04 am</option>';
						
						if($parsed_end_date['hour']==5) {
							echo '<option value="05" selected>05 am</option>';
						}
						else echo '<option value="05">05 am</option>';
						
						if($parsed_end_date['hour']==6) {
							echo '<option value="06" selected>06 am</option>';
						}
						else echo '<option value="06">06 am</option>';
						
						if($parsed_end_date['hour']==7) {
							echo '<option value="07" selected>07 am</option>';
						}
						else echo '<option value="07">07 am</option>';
						
						if($parsed_end_date['hour']==8) {
							echo '<option value="08" selected>08 am</option>';
						}
						else echo '<option value="08">08 am</option>';
						
						if($parsed_end_date['hour']==9) {
							echo '<option value="09" selected>09 am</option>';
						}
						else echo '<option value="09">09 am</option>';
						
						if($parsed_end_date['hour']==10) {
							echo '<option value="10" selected>10 am</option>';
						}
						else echo '<option value="10">10 am</option>';
						
						if($parsed_end_date['hour']==11) {
							echo '<option value="11" selected>11 am</option>';
						}
						else echo '<option value="11">11 am</option>';
						
						if($parsed_end_date['hour']==12) {
							echo '<option value="12" selected>12 pm</option>';
						}
						else echo '<option value="12">12 pm</option>';
						
						if($parsed_end_date['hour']==13) {
							echo '<option value="13" selected>01 pm</option>';
						}
						else echo '<option value="13">01 pm</option>';
						
						if($parsed_end_date['hour']==14) {
							echo '<option value="14" selected>02 pm</option>';
						}
						else echo '<option value="14">02 pm</option>';
						
						if($parsed_end_date['hour']==15) {
							echo '<option value="15" selected>03 pm</option>';
						}
						else echo '<option value="15">03 pm</option>';
						
						if($parsed_end_date['hour']==16) {
							echo '<option value="16" selected>04 pm</option>';
						}
						else echo '<option value="16">04 pm</option>';
						
						if($parsed_end_date['hour']==17) {
							echo '<option value="17" selected>05 pm</option>';
						}
						else echo '<option value="17">05 pm</option>';
						
						if($parsed_end_date['hour']==18) {
							echo '<option value="18" selected>06 pm</option>';
						}
						else echo '<option value="18">06 pm</option>';
						
						if($parsed_end_date['hour']==19) {
							echo '<option value="19" selected>07 pm</option>';
						}
						else echo '<option value="19">07 pm</option>';
						
						if($parsed_end_date['hour']==20) {
							echo '<option value="20" selected>08 pm</option>';
						}
						else echo '<option value="20">08 pm</option>';
						
						if($parsed_end_date['hour']==21) {
							echo '<option value="21" selected>09 pm</option>';
						}
						else echo '<option value="21">09 pm</option>';
						
						if($parsed_end_date['hour']==22) {
							echo '<option value="22" selected>10 pm</option>';
						}
						else echo '<option value="22">10 pm</option>';
						
						if($parsed_end_date['hour']==23) {
							echo '<option value="23" selected>11 pm</option>';
						}
						else echo '<option value="23">11 pm</option>';
									
						echo '
									</select>
									:
									<select name="edit_end_time_min">
						';
						
						if($parsed_end_date['minute']==0) {
							echo '<option value="00" selected>00</option>';
						}
						else echo '<option value="00">00</option>';
						
						if($parsed_end_date['minute']==15) {
							echo '<option value="15" selected>15</option>';
						}
						else echo '<option value="15">15</option>';
						
						if($parsed_end_date['minute']==30) {
							echo '<option value="30" selected>30</option>';
						}
						else echo '<option value="30">30</option>';
						
						if($parsed_end_date['minute']==45) {
							echo '<option value="45" selected>45</option>';
						}
						else echo '<option value="45">45</option>';
								
						echo '
									</select>
								</div></p>
								<div class="clear"></div>
								<p><div class="form_name">edit_event location:</div><div class="form_field"><input class="validate[required]" type="text" name="edit_event_location" id="edit_event_location" size="32" maxlength="32" value="'.$edit_event_info_row['event_location'].'" /></div></p>
								<div class="clear"></div>
								<p><div class="form_name">edit event description:</div><div class="form_field"><textarea name="edit_event_desc" id="edit_event_desc" cols="40" rows="6" maxlength="512">'.$edit_event_info_row['event_description'].'</textarea></div></p>
								<div class="clear"></div>
								<p><div class="form_name">edit event type:</div><div class="form_field">
									<select size="1" name="edit_event_type" id="edit_event_type">
						';
	            		$event_type=q("SELECT * FROM event_type");
						while($event_type_row=a($event_type)) {
							if($event_type_row['event_type_id']==$edit_event_info_row['event_type']) {
								echo '<option value="'.$event_type_row['event_type_id'].'" selected>'.$event_type_row['event_type_name'].'</option>';
							}
							else {	
								echo '<option value="'.$event_type_row['event_type_id'].'">'.$event_type_row['event_type_name'].'</option>';
							}
						}		
						echo '
				            		</select>
								</div></p>
								<div class="clear"></div>
								<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="edit_event_info_submit" id="edit_event_info_submit" value="Edit Event Information" /><input type="submit" value="Cancel"></div></p>
								<div class="clear"></div>
								<input type="hidden" name="edit_event_id" value="'.$edit_event_id.'" />
							</form>
						';
					}
					else {
						echo '
						<form action="'.$_SERVER['PHP_SELF'].'" method="post">
							<p><div class="form_name">choose semester:</div><div class="form_field">
								<select size="1" name="choose_edit_semester" id="choose_edit_semester">
						';
						$choose_edit_semester=q("SELECT * FROM semester ORDER BY semester_id ASC");
						$choose_edit_semester_count=c($choose_edit_semester);
						while($choose_edit_semester_row=a($choose_edit_semester)) {
							if($choose_edit_semester_row['current_semester']==1) {
								echo '<option rel="edit_'.$choose_edit_semester_row['semester_id'].'" value="'.$choose_edit_semester_row['semester_id'].'" selected>'.$choose_edit_semester_row['semester_name'].'</option>';
							}
							else {
								echo '<option rel="edit_'.$choose_edit_semester_row['semester_id'].'" value="'.$choose_edit_semester_row['semester_id'].'">'.$choose_edit_semester_row['semester_name'].'</option>';
							}
						}
						echo '
								</select>
							</div></p>
							<div class="clear"></div>
						';
						for($m=1; $m<=$choose_edit_semester_count; $m++) {
							$choose_edit_event=q("SELECT * FROM events WHERE event_semester='$m' ORDER BY event_start ASC");
							$choose_edit_event_count=c($choose_edit_event);
							if($choose_edit_event_count==0) {
								echo '
									<div rel=edit_'.$m.'>
										<p><div class="form_name">edit event:</div><div class="form_field">
											<select size="1">
												<option>No events found for this semester</option>
											</select>
										</div></p>
									</div>
									<div class="clear"></div>
								';
							}
							else {
								echo '
									<div rel=edit_'.$m.'>
										<p><div class="form_name">edit event:</div><div class="form_field">
											<select size="1" name="edit_event_id" id="edit_event_id">
								';
								while($choose_edit_event_row=a($choose_edit_event)) {
									echo '
										<option value="'.$choose_edit_event_row['event_id'].'">'.$choose_edit_event_row['event_name'].' - '.dt($choose_edit_event_row['event_start']).'</option>
									';
								}
								echo '
											</select>
										</div></p>
									</div>
									<div class="clear"></div>
									<div rel=edit_'.$m.'>
										<p><div class="form_name">&nbsp;</div><div class="form_field"><input type="submit" name="edit_event_submit" id="edit_event_submit" value="Edit Event" /></div></p>
									</div>
									<div class="clear"></div>
								';
							}
						}
						echo '
							</form>
						';
					}
					?>
					<h5 class="section">Delete Event</h5>
					<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
						<p><div class="form_name">choose semester:</div><div class="form_field">
							<select size="1" name="choose_delete_semester" id="choose_delete_semester">
							<?php
							$choose_delete_semester=q("SELECT * FROM semester ORDER BY semester_id ASC");
							$choose_delete_semester_count=c($choose_delete_semester);
							while($choose_delete_semester_row=a($choose_delete_semester)) {
								if($choose_delete_semester_row['current_semester']==1) {
									echo '<option rel="del_'.$choose_delete_semester_row['semester_id'].'" value="'.$choose_delete_semester_row['semester_id'].'" selected>'.$choose_delete_semester_row['semester_name'].'</option>';
								}
								else {
									echo '<option rel="del_'.$choose_delete_semester_row['semester_id'].'" value="'.$choose_delete_semester_row['semester_id'].'">'.$choose_delete_semester_row['semester_name'].'</option>';
								}
							}
							?>
							</select>
						</div></p>
						<div class="clear"></div>
						<?php
						for($p=1; $p<=$choose_delete_semester_count; $p++) {
							$choose_delete_event=q("SELECT * FROM events WHERE event_semester='$p' ORDER BY event_start ASC");
							$choose_delete_event_count=c($choose_delete_event);
							if($choose_delete_event_count==0) {
								echo '
									<div rel=del_'.$p.'>
										<p><div class="form_name">delete event:</div><div class="form_field">
											<select size="1">
												<option>No events found for this semester</option>
											</select>
										</div></p>
									</div>
									<div class="clear"></div>
								';
							}
							else {
								echo '
									<div rel=del_'.$p.'>
										<p><div class="form_name">delete event:</div><div class="form_field">
											<select size="1" name="delete_event_id" id="delete_event_id">
								';
								
								while($choose_delete_event_row=a($choose_delete_event)) {
									echo '
										<option value="'.$choose_delete_event_row['event_id'].'">'.$choose_delete_event_row['event_name'].' - '.dt($choose_delete_event_row['event_start']).'</option>
									';
								}
								
								echo '
											</select>
										</div></p>
									</div>
									<div class="clear"></div>
									<div rel=del_'.$p.'>
										<p><div rel=del_'.$p.' class="form_name">&nbsp;</div><div rel=del_'.$p.' class="form_field"><input type="submit" name="delete_event_submit" id="delete_event_submit" value="Delete Event" onClick="return confirmSubmit()" /></div></p>
									</div>
									<div class="clear"></div>
								';
							}
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