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
		<?php
		if(isset($_GET['album'])) {
			echo '<script type="text/javascript" src="pictures/'.$_GET['album'].'/getalbumpics.php?id='.$_GET['album'].'"></script>';
		}
		?>
		<script type="text/javascript">
		//Optional, manual description for particular pictures inside album
		//Syntax: albumid.desc[index]="Picture description here"
		//eg: myvacation.desc[2]="This is description for the 3rd picture in the album"
		//eg: myvacation.desc[6]="This is description for the 7th picture in the album"
		</script>
		<script type="text/javascript" src="scripts/ddphpalbum.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/ddphpalbum.css" />
		<link href="styles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
		<script src="scripts/facebox.js" type="text/javascript"></script>
		<script type="text/javascript">
		    jQuery(document).ready(function($) {
		      $('a[rel*=facebox]').facebox() 
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
				<div id="contentPortfolio" class="grid_16 fadehover">
					<div class="path">
						<?php
						if(isset($_GET['album'])) {
							echo '<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <a href="media.php">Media </a><img src="images/arrowPath.png" alt="" /> <strong>'.$_GET['title'].' - '.$_GET['date'].'</strong>';
						}
						else {
							echo '<a href="/">Homepage </a><img src="images/arrowPath.png" alt="" /> <strong>Media</strong>';
						}
						?>
					</div> <!-- close #path -->
					<?php
					if(isset($_GET['album'])) {
						echo '<h2>'.$_GET['title'].' - '.$_GET['date'].'</h2>';
					}
					else {
						echo '<h2>Media</h2>';
					}
					?>
					
					<?php
					if(isset($_GET['album'])) {
						echo '
							<script type="text/javascript">
							new phpimagealbum({
								albumvar: '.$_GET['album'].', //ID of photo album to display (based on getpics.php?id=xxx)
								dimensions: [4,4],
								sortby: ["file", "asc"], //["file" or "date", "asc" or "desc"]
								autodesc: "<!-- Photo %i -->&nbsp", //Auto add a description beneath each picture? (use keyword %i for image position, %d for image date)
								showsourceorder: false, //Show source order of each picture? (helpful during set up stage)
								onphotoclick:function(thumbref, thumbindex, thumbfilename){
									jQuery.facebox(';
									
									echo "'<img src="; echo '"'; echo "' + thumbref.src +'"; echo'" width="800px"/>'; echo "'";
									
									
									echo '
									)
								}
							})
							</script>
						';
					}
					else {
                                                echo '
<h5 class="section">Links</h5>
					<a href="https://docs.google.com/spreadsheets/d/1G3tS_u2M75XEU1mX5Cfu88BSEeteU_k1-Nzh40MdZWc/edit?usp=sharing">
					Active Status Tracker</a>
                                                ';
						echo '<h5 class="section">Pictures</h5>';
						$objDOM = new DOMDocument(); 
						$objDOM->load("pictures/albums.xml"); //make sure path is correct 
						$album = $objDOM->getElementsByTagName("album"); 
						foreach($album as $value) { 
							$dirs=$value->getElementsByTagName("dir"); 
							$dir=$dirs->item(0)->nodeValue; 
							$titles=$value->getElementsByTagName("title"); 
							$title=$titles->item(0)->nodeValue; 
							$dates=$value->getElementsByTagName("date"); 
							$date=$dates->item(0)->nodeValue; 
							$thumbs=$value->getElementsByTagName("thumb"); 
							$thumb=$thumbs->item(0)->nodeValue; 
							$descs=$value->getElementsByTagName("desc"); 
							$desc=$descs->item(0)->nodeValue; 
							//echo "$dir - $title - $thumb<br>";
							$num++;
							if($num%3) {
								echo '<div id="boxPortfolio1" class="grid_5">';
							}
							else {
								echo '<div id="boxPortfolio1" class="grid_5 right">';
							}
							echo '
									<a class="project_hoverPhoto" href="media.php?album='.$dir.'&title='.$title.'&date='.$date.'" rel="prettyPhoto[mixed]"></a>
									<img src="pictures/'.$dir.'/'.$thumb.'" alt="" width="276px" height="183px "/>
									<h6>'.$title.' - '.$date.'</h6>
									<p>'.$desc.'</p>
								</div>
							';
						}
						echo '
							<div class="clear"></div>
							<h5 class="section">Videos</h5>
							<p>Coming Soon!</p>
						';
					}
					?>
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