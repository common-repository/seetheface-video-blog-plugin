<?php

global $wpdb;

### Define common constant
define('SEETHEFACE_RELPATH', '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)));

$base_name = plugin_basename('seetheface/seetheface-admin.php');
$base_page = 'admin.php?page='.$base_name;
$mode = trim($_GET['mode']);
$act_vid = trim($_GET['id']);
$act_pid = trim($_GET['pid']);


// ### Start the button form processing 
if (isset($_POST['do'])){
	switch(key($_POST['do'])) {
			
	case 1:	// UPDATE VIDEO DESCRIPTION
			// read the $_POST values
			$act_name = addslashes(trim($_POST['act_name']));
			
			$wpdb->query("UPDATE $wpdb->seetheface SET name = '$act_name' WHERE id = '$act_vid' ");
			
			// Finished
			$text = '<font color="green">'.__('Update Successfully','wpSeetheface').'</font>';
			
			$mode = 'main';
			
		break;
		
	case 2:	// CANCEL
			$mode = 'main';
		break;
	case 3://SAVE SEE THE FACE SETTINGS
			$api_key = trim($_POST['api_key']);
			$flv_upload_path = trim($_POST['srv_path']);
			$flv_http_path = trim($_POST['http_path']);
			$return_url = trim($_POST['return_url']);
			
			$wpdb->query("UPDATE $wpdb->seetheface_settings SET api_key  = '$api_key', flv_upload_path = '$flv_upload_path', flv_http_path='$flv_http_path'");
			
			// Finished
			$text = '<font color="green">'.__('Update Successfully','wpSeetheface').'</font>';
			
			$mode = 'main';
			
		break;
	}
}
//Edit description of  videofile
if ($mode == 'sett'){
	// edit table
	$act_videoset = $wpdb->get_row("SELECT * FROM $wpdb->seetheface_settings");
	?>
	<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
	<!-- Edit Settings -->
	<script type="text/javascript" src="../wp-includes/js/dbx.js"></script>
	<script type="text/javascript" src="../wp-includes/js/tw-sack.js"></script>
	<script type="text/javascript" src="<?php echo SEETHEFACE_URLPATH ?>dbx-key.js"></script>
	<div class="wrap">
		<h2><?php _e('Edit SeeTheFace plugin settings', 'wpSeetheface') ?></h2>
		<div id="poststuff">
		<form name="table_options" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" id="video_options">
			<fieldset class="options"> 
				<table class="optiontable">
					<tr>
						<th scope="row"><?php _e('API KEY','wpSeetheface') ?></th>
						<td><input type="text" size="50"  name="api_key" value="<?php echo "$act_videoset->api_key" ?>" /></td>
					</tr>
					
					<tr>
						<th scope="row"><?php _e('HTTP absolute path to uploads dir','wpSeetheface') ?></th>
						<td><input type="text" size="50"  name="http_path" value="<?php echo "$act_videoset->flv_http_path" ?>" />
						<br /><?php _e('Enter the URL to view the media file','wpSeetheface') ?></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Server absolute path to uploads dir','wpSeetheface') ?></th>
						<td><input type="text" size="50" name="srv_path" value="<?php echo "$act_videoset->flv_upload_path" ?>" />
						<br /><?php _e('Enter the server path file','wpSeetheface') ?></td>
					</tr>
			
				</table>
				<div class="submit"><input type="submit" name="do[2]" value="<?php _e('Cancel'); ?>" class="button" />
				<input type="submit" name="do[3]" value="<?php _e('Save settings'); ?> &raquo;" class="button" /></div>
		</fieldset>
		</form>
		</div>
		
		</center>
	</div>
	<?php
}



//Delete description & videofile
if ($mode == 'delete'){
	
	$settings = $wpdb->get_row("SELECT * FROM $wpdb->seetheface_settings");
	define('FLV_UPLOAD_PATH',	$settings->flv_upload_path);
	
	$delete_video = $wpdb->get_row("SELECT * FROM $wpdb->seetheface WHERE id = $act_vid ");
		
	if(file_exists(FLV_UPLOAD_PATH.$delete_video->link.$delete_video->swffilename)) {
		unlink(FLV_UPLOAD_PATH.$delete_video->link.$delete_video->swffilename);	
	}
	if(file_exists(FLV_UPLOAD_PATH.$delete_video->link.$delete_video->flvfilename)) {
		unlink(FLV_UPLOAD_PATH.$delete_video->link.$delete_video->flvfilename);	
	}
 	
	$delete_video = $wpdb->query("DELETE FROM $wpdb->seetheface WHERE id = $act_vid");
	if(!$delete_video) {
	 	$text = '<font color="red">'.__('Error in deleting media file','wpSeetheface').' \''.$act_vid.'\' </font>';
	}
	if(empty($text)) {
		$text = '<font color="green">'.__('Media file','wpSeetheface').' \''.$act_vid.'\' '.__('deleted successfully','wpSeetheface').'</font>';
	}
	$mode = 'main'; // show main page
}

//Edit description of  videofile
if ($mode == 'edit'){
	// edit table
	$settings = $wpdb->get_row("SELECT * FROM $wpdb->seetheface_settings");
	define('FLV_HTTP_PATH',	$settings->flv_http_path);
	
	$act_videoset = $wpdb->get_row("SELECT * FROM $wpdb->seetheface WHERE id = $act_vid ");
	$act_name = htmlspecialchars(stripslashes($act_videoset->name));
	
	?>
	<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
	<!-- Edit Video -->
	<script type="text/javascript" src="../wp-includes/js/dbx.js"></script>
	<script type="text/javascript" src="../wp-includes/js/tw-sack.js"></script>
	<script type="text/javascript" src="<?php echo SEETHEFACE_URLPATH ?>dbx-key.js"></script>
	<div class="wrap">
		<h2><?php _e('Edit media file', 'wpSeetheface') ?></h2>
		<div id="poststuff">
		<form name="table_options" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" id="video_options">
		<?php _e('If you want to show this media file in your page, enter the tag :', 'wpSeetheface') ?><strong>[seetheface id="<?php echo $act_vid; ?>"]</strong></p>
			<fieldset class="options"> 
				<table class="optiontable">
					<tr>
						<th scope="row"><?php _e('Media title','wpSeetheface') ?></th>
						<td><input type="text" size="50"  name="act_name" value="<?php echo "$act_name" ?>" /></td>
					</tr>
				</table>
				<div class="submit"><input type="submit" name="do[2]" value="<?php _e('Cancel'); ?>" class="button" />
				<input type="submit" name="do[1]" value="<?php _e('Update'); ?> &raquo;" class="button" /></div>
		</fieldset>
		</form>
		</div>
		<h2><?php _e('Preview', 'wpSeetheface') ?></h2>
		<center>
		<?php
		echo  '
		<object width="'.$act_videoset->playerwidth.'" height="'.$act_videoset->playerheight.'">
		<param name="movie" value="'.FLV_HTTP_PATH.$act_videoset->link.$act_videoset->swffilename.'">
		<param name="wmode" value="transparent">
		<embed src="'.FLV_HTTP_PATH.$act_videoset->link.$act_videoset->swffilename.'" type="application/x-shockwave-flash" wmode="transparent" width="'.$act_videoset->width.'" height="'.$act_videoset->height.'" />
		</object>
		<br />
		Title: <b>'.$act_videoset->name.'</b>';
			?>
		</center>
	</div>
	<?php
}

/*** MAIN ADMIN PAGE ***/	
if ((empty($mode)) or ($mode == 'main')) {
 	// check for page navigation
	if ( isset( $_GET['apage'] ) )
		$page = (int) $_GET['apage'];
	else
		$page = 1; 
		
 	$start = $offset = ( $page - 1 ) * 10;
 
	$tables = $wpdb->get_results("SELECT * FROM $wpdb->seetheface ORDER BY 'id' ASC LIMIT $start, 10");
	$total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->seetheface ");
	?>
	<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
	<!-- Manage Video-->
		<div class="wrap">
		<h2><?php _e('Manage Media files','wpSeetheface'); ?></h2>
		<!-- Navigation -->
		<?php if ( $total > 10 ) {
		$total_pages = ceil( $total / 10 );
		$r = '';
		if ( 1 < $page ) {
			$args['apage'] = ( 1 == $page - 1 ) ? FALSE : $page - 1;
			$r .=  '<a class="prev" href="'. add_query_arg( $args ) . '">&laquo; '. __('Previous Page') .'</a>' . "\n";
		}
		if ( ( $total_pages = ceil( $total / 10 ) ) > 1 ) {
			for ( $page_num = 1; $page_num <= $total_pages; $page_num++ ) {
				if ( $page == $page_num ) {
					$r .=  "<span>$page_num</span>\n";
				} else {
					$p = false;
					if ( $page_num < 3 || ( $page_num >= $page - 3 && $page_num <= $page + 3 ) || $page_num > $total_pages - 3 ) {
						$args['apage'] = ( 1 == $page_num ) ? FALSE : $page_num;
						$r .= '<a class="page-numbers" href="' . add_query_arg($args) . '">' . ( $page_num ) . "</a>\n";
						$in = true;
					} elseif ( $in == true ) {
						$r .= "...\n";
						$in = false;
					}
				}
			}
		}
		if ( ( $page ) * 10 < $total || -1 == $total ) {
			$args['apage'] = $page + 1;
			$r .=  '<a class="next" href="' . add_query_arg($args) . '">'. __('Next Page') .' &raquo;</a>' . "\n";
		}
		echo "<p class='pagenav'>$r</p>\n";
		?>
		<?php } ?>
			<!-- Table -->
			<table id="the-list-x" width="100%" cellspacing="3" cellpadding="3">
			<thead>
			<tr>
				<th scope="col"><?php _e('ID','wpSeetheface'); ?></th>
				<th scope="col"><?php _e('Title','wpSeetheface'); ?></th>
				<th scope="col" colspan="2"><?php _e('Action'); ?></th>
			</tr>
			</thead>
			<?php
				if($tables) {
					$i = 0;
					foreach($tables as $table) {
					 	if($i%2 == 0) {
							echo "<tr class='alternate'>\n";
						}  else {
							echo "<tr>\n";
						}
						echo "<th scope=\"row\">$table->id</th>\n";
						echo "<td>".stripslashes($table->name)."</td>\n";
						echo "<td><a href=\"$base_page&amp;mode=edit&amp;id=$table->id\" class=\"edit\">".__('Edit')."</a></td>\n";
						echo "<td><a href=\"$base_page&amp;mode=delete&amp;id=$table->id\" class=\"delete\" onclick=\"javascript:check=confirm( '".__("Delete this file ?",'wpSeetheface')."');if(check==false) return false;\">".__('Delete')."</a></td>\n";
						echo '</tr>';
						$i++;
					}
				} else {
					echo '<tr><td colspan="7" align="center"><b>'.__('No entries found','wpSeetheface').'</b></td></tr>';
				}
			?>
			</table>
		<h3><a href="?page=seetheface/<?php echo basename(__FILE__); ?>&mode=sett"><?php _e('Change plugin settings','wpSeetheface') ?> &raquo;</a></h3>
		<h3><a href="http://www.seetheface.com/forum/"><?php _e('Support forum','wpSeetheface') ?> &raquo;</a></h3>
		
		</div>
		<?php 
}


?>
		