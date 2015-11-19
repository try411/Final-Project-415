<?php
include("../functions.inc");

mysql_login();

check_admin();

$events=q("SELECT * FROM events, event_type, semester WHERE event_type=event_type_id AND event_semester=semester_id AND current_semester=1");
?>

<html>
	<head>
		<?php report_headers(); ?>
	  	<script language="javascript">
			var showMode = '';
			if (document.all) showMode='block';
			function toggleVis(btn){
				btn   = document.forms['tcol'].elements[btn];
				cells = document.getElementsByName('t'+btn.name);
				mode = btn.checked ? showMode : 'none';
				for(j = 0; j < cells.length; j++) cells[j].style.display = mode;
			}
		</script>
	</head>
	<body>
		<div class="options">
			<h2>Event Report</h2>
			<h3>Generated on: <?php echo date("F j, Y @ g:i a"); ?></h3>
			<form name="tcol" onsubmit="return false">
				<p>
					Event Type:&nbsp;&nbsp;
					<input type=checkbox name="col1" onclick="toggleVis(this.name)" checked> Orientation Picnic&nbsp;
					<input type=checkbox name="col2" onclick="toggleVis(this.name)" checked> Super Club's Day&nbsp;
					<input type=checkbox name="col3" onclick="toggleVis(this.name)" checked> PIN&nbsp;
					<input type=checkbox name="col4" onclick="toggleVis(this.name)" checked> Fundraising&nbsp;
					<input type=checkbox name="col5" onclick="toggleVis(this.name)" checked> GM&nbsp;
					<input type=checkbox name="col6" onclick="toggleVis(this.name)" checked> Prof. Event&nbsp;
					<input type=checkbox name="col7" onclick="toggleVis(this.name)" checked> Social&nbsp;
					<input type=checkbox name="col8" onclick="toggleVis(this.name)" checked> Comm. Service&nbsp;
					<input type=checkbox name="col9" onclick="toggleVis(this.name)" checked> Other
				</p>
				<p>
					Other Info:&nbsp;&nbsp;
					<input type=checkbox name="col10" onclick="toggleVis(this.name)"> Description&nbsp;
				</p>
			</form>
		</div>
		<table id="test1" cellpadding="0" cellspacing="0" border="0" class="sortable-onload-3 rowstyle-alt colstyle-alt no-arrow">
			<thead>
				<th class="sortable">Name</th>
				<th class="sortable">Semester</th>
				<th class="sortable-date-mdy">Date</th>
				<th>Time Start</th>
				<th>Time End</th>
				<th class="sortable">Location</th>
				<th class="sortable" name="tcol10" id="tcol10" style="display: none;">Description</th>
				<th class="sortable">Event Type</th>
			</thead>
			<tbody>
			<?php
			while($events_row=a($events)) {
				if($events_row['event_type']==1) {
					echo '
						<tr name="tcol1" id="tcol1">
					';
				}
				elseif($events_row['event_type']==2) {
					echo '
						<tr name="tcol2" id="tcol2">
					';
				}
				elseif($events_row['event_type']==3) {
					echo '
						<tr name="tcol3" id="tcol3">
					';
				}
				elseif($events_row['event_type']==4) {
					echo '
						<tr name="tcol4" id="tcol4">
					';
				}
				elseif($events_row['event_type']==5) {
					echo '
						<tr name="tcol5" id="tcol5">
					';
				}
				elseif($events_row['event_type']==6) {
					echo '
						<tr name="tcol6" id="tcol6">
					';
				}
				elseif($events_row['event_type']==7) {
					echo '
						<tr name="tcol7" id="tcol7">
					';
				}
				elseif($events_row['event_type']==8) {
					echo '
						<tr name="tcol8" id="tcol8">
					';
				}
				elseif($events_row['event_type']==9) {
					echo '
						<tr name="tcol9" id="tcol9">
					';
				}
				echo '
						<td>'.$events_row['event_name'].'</td>
						<td>'.$events_row['semester_name'].'</td>
						<td>'.sd($events_row['event_start']).'</td>
						<td>'.t($events_row['event_start']).'</td>
						<td>'.t($events_row['event_end']).'</td>
						<td>'.$events_row['event_location'].'</td>
						<td name="tcol10" id="tcol10" style="display: none;">'.$events_row['event_description'].'</td>
						<td>'.$events_row['event_type_name'].'</td>
					</tr>
				';
			}
			?>				
			</tbody>
		</table>
	</body>
</html>
