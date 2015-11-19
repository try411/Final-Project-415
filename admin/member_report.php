<?php
include("../functions.inc");

mysql_login();

check_admin();

$members=q("SELECT username, fname, minit, lname, email,member_type_id, member_type_name, join_semester, grad_semester, left_semester FROM members, member_logins, member_type, member_profiles WHERE username=login_username AND type=member_type_id AND username=member_username AND member_type_id<>0");
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
			<h2>Member Report</h2>
			<h3>Generated on: <?php echo date("F j, Y @ g:i a"); ?></h3>
			<form name="tcol" onsubmit="return false">
				<p>
					Member Type:&nbsp;&nbsp;
					<input type=checkbox name="col1" onclick="toggleVis(this.name)" checked> Officers&nbsp;
					<input type=checkbox name="col2" onclick="toggleVis(this.name)" checked> Members&nbsp;
					<input type=checkbox name="col3" onclick="toggleVis(this.name)" checked> Alumni&nbsp;
					<input type=checkbox name="col4" onclick="toggleVis(this.name)" checked> Departed&nbsp;
					<input type=checkbox name="col5" onclick="toggleVis(this.name)"> Middle Initial
				</p>
				<p>
					Other Info:&nbsp;&nbsp;
					<input type=checkbox name="col6" onclick="toggleVis(this.name)"> Semester Info&nbsp;
					<input type=checkbox name="col7" onclick="toggleVis(this.name)"> Fundraising&nbsp;
					<input type=checkbox name="col8" onclick="toggleVis(this.name)"> Attendance
				</p>
			</form>
		</div>
		<table id="test1" cellpadding="0" cellspacing="0" border="0" class="sortable-onload-0 rowstyle-alt colstyle-alt no-arrow">
			<thead>
				<th class="sortable">Username</th>
				<th class="sortable">First Name</th>
				<th class="sortable" name="tcol5" id="tcol5" style="display: none;">Middle initial</th>
				<th class="sortable">Last Name</th>
				<th class="sortable">Email</th>
				<th class="sortable">Member Type</th>
				<th class="sortable" name="tcol6" id="tcol6" style="display: none;">Join Semester</th>
				<th class="sortable" name="tcol6" id="tcol6" style="display: none;">Grad Semester</th>
				<th class="sortable" name="tcol6" id="tcol6" style="display: none;">Left Semester</th>
				<th class="sortable-currency" name="tcol7" id="tcol7" style="display: none;">Fundraising</th>
				<th class="sortable" name="tcol8" id="tcol8" style="display: none;">Orientation Picnic</th>
				<th class="sortable" name="tcol8" id="tcol8" style="display: none;">Super Club's Day</th>
				<th class="sortable" name="tcol8" id="tcol8" style="display: none;">PIN</th>
				<th class="sortable-numeric" name="tcol8" id="tcol8" style="display: none;">General Meetings</th>
				<th class="sortable" name="tcol8" id="tcol8" style="display: none;">Community Service</th>
				<th class="sortable-numeric" name="tcol8" id="tcol8" style="display: none;">Professional Events</th>
				<th class="sortable-numeric" name="tcol8" id="tcol8" style="display: none;">Socials</th>
			</thead>
			<tbody>
			<?php
			while($members_row=a($members)) {
				$username=$members_row['username'];
				if($members_row['member_type_id']<=9) {
					echo '
						<tr name="tcol1" id="tcol1">
					';
				}
				elseif($members_row['member_type_id']==10) {
					echo '
						<tr name="tcol2" id="tcol2">
					';
				}
				elseif($members_row['member_type_id']==11) {
					echo '
						<tr name="tcol3" id="tcol3">
					';
				}
				elseif($members_row['member_type_id']==12) {
					echo '
						<tr name="tcol4" id="tcol4">
					';
				}
				echo '
						<td>'.$username.'</td>
						<td>'.$members_row['fname'].'</td>
						<td name="tcol5" id="tcol5" style="display: none;">'.$members_row['minit'].'</td>
						<td>'.$members_row['lname'].'</td>
						<td>'.$members_row['email'].'</td>
						<td>'.$members_row['member_type_name'].'</td>
						<td name="tcol6" id="tcol6" style="display: none;">'.semester($members_row['join_semester']).'</td>
						<td name="tcol6" id="tcol6" style="display: none;">'.semester($members_row['grad_semester']).'</td>
						<td name="tcol6" id="tcol6" style="display: none;">'.semester($members_row['left_semester']).'</td>
				';
				$fundraising=q("SELECT SUM(fund_amount) AS fund_total FROM fundraising WHERE fund_username='$username' AND fund_semester IN (SELECT semester_id FROM semester WHERE current_semester=1)");
				while($fundraising_row=a($fundraising)) {
					if($fundraising_row['fund_total']==0.00) {
						echo '<td name="tcol7" id="tcol7" style="display: none; color: red;">&#36;0.00</td>';
					}
					elseif($fundraising_row['fund_total']>=0.00) {
						if($fundraising_row['fund_total']<50.00) {
							echo '<td name="tcol7" id="tcol7" style="display: none; color: red;">&#36;'.$fundraising_row['fund_total'].'</td>';
						}
						elseif($fundraising_row['fund_total']>=50.00) {
							echo '<td name="tcol7" id="tcol7" style="display: none;">&#36;'.$fundraising_row['fund_total'].'</td>';
						}
					}
				}
				$attendance=q("SELECT event_type_id, COUNT(*) AS count FROM event_type, events WHERE event_type_id=event_type AND event_id IN (SELECT attended_event_id FROM attendance WHERE attended_member='$username') GROUP BY event_type_id");
				while($attendance_row=a($attendance)) {
					$attendance_array[$username][$attendance_row['event_type_id']]=array($attendance_row['count']);
				}
				if(isset($attendance_array[$username][1][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none;">Yes</td>';
				}
				elseif(!isset($attendance_array[$username][1][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">No</td>';
				}
				if(isset($attendance_array[$username][2][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none;">Yes</td>';
				}
				elseif(!isset($attendance_array[$username][2][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">No</td>';
				}
				if(isset($attendance_array[$username][3][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none;">Yes</td>';
				}
				elseif(!isset($attendance_array[$username][3][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">No</td>';
				}
				if(isset($attendance_array[$username][5][0])) {
					if($attendance_array[$username][5][0]>=3) {
						echo '<td name="tcol8" id="tcol8" style="display: none;">'.$attendance_array[$username][5][0].'</td>';
					}
					if($attendance_array[$username][5][0]<3) {
						echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">'.$attendance_array[$username][5][0].'</td>';
					}

				}
				elseif(!isset($attendance_array[$username][5][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">0</td>';
				}
				if(isset($attendance_array[$username][8][0])) {
					if($attendance_array[$username][8][0]>=2) {
						echo '<td name="tcol8" id="tcol8" style="display: none;">'.$attendance_array[$username][8][0].'</td>';
					}
					if($attendance_array[$username][8][0]<2) {
						echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">'.$attendance_array[$username][8][0].'</td>';
					}
				}
				elseif(!isset($attendance_array[$username][8][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">0</td>';
				}
				if(isset($attendance_array[$username][6][0])) {
					if($attendance_array[$username][6][0]>=3) {
						echo '<td name="tcol8" id="tcol8" style="display: none;">'.$attendance_array[$username][6][0].'</td>';
					}
					if($attendance_array[$username][6][0]<3) {
						echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">'.$attendance_array[$username][6][0].'</td>';
					}
				}
				elseif(!isset($attendance_array[$username][6][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">0</td>';
				}
				if(isset($attendance_array[$username][7][0])) {
					if($attendance_array[$username][7][0]>=2) {
						echo '<td name="tcol8" id="tcol8" style="display: none;">'.$attendance_array[$username][7][0].'</td>';
					}
					if($attendance_array[$username][7][0]<2) {
						echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">'.$attendance_array[$username][7][0].'</td>';
					}
				}
				elseif(!isset($attendance_array[$username][7][0])) {
					echo '<td name="tcol8" id="tcol8" style="display: none; color: red;">0</td>';
				}
				echo '
					</tr>
				';
			}
			?>			
			</tbody>
		</table>
	</body>
</html>
