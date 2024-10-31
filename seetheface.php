<?php
/*
Plugin Name: SeeTheFace
Plugin URI: http://www.seetheface.com
Description: SeeTheFace plugin transforms your text blog into a video blog. Utilizing SeeTheFace flash based A/V recorder application it allows you to record your A/V messages using your web camera and microphone and publish on your blog straight away.
Author: SeeTheFace
Version: 1.0
Author URI: http://www.seetheface.com
*/

// define URL
$myabspath = str_replace("\\","/",ABSPATH);  // required for windows
define('SEETHEFACE_URLPATH', get_settings('siteurl').'/wp-content/plugins/' . dirname(plugin_basename(__FILE__)).'/');

define('SEETHEFACE_ABSPATH', $myabspath.'wp-content/plugins/' . dirname(plugin_basename(__FILE__)).'/');
define('UPLOADS_PATH',		 $myabspath.'wp-content/uploads/');
define('UPLOADS_URL',		get_settings('siteurl').'/wp-content/uploads/');

// database pointer
$wpdb->seetheface					= $table_prefix . 'seetheface';
$wpdb->seetheface_settings			= $table_prefix . 'seetheface_settings';


//Installing tables
function seetheface_install () {
   global $wpdb;
   
   $table_name = $wpdb->prefix.seetheface;
   
   require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
    
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . "(
      id MEDIUMINT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      user_id BIGINT(20) NOT NULL,
      flvfilename MEDIUMTEXT,
      swffilename MEDIUMTEXT,
      author MEDIUMTEXT,
	  name TINYTEXT NOT NULL,
	  link MEDIUMTEXT,
	  thumb MEDIUMTEXT,
	  width SMALLINT(5),
	  height SMALLINT(5),
	  facedesc LONGTEXT NULL,
	  playerwidth SMALLINT(5),
	  playerheight SMALLINT(5)
	 );";

	dbDelta($sql);
   }
   
   if($wpdb->get_var("show tables like '$wpdb->seetheface_settings'") != $wpdb->seetheface_settings) {
      
      $sql = "CREATE TABLE " . $wpdb->seetheface_settings . "(
      api_key CHAR(32) NULL,
      flv_upload_path MEDIUMTEXT NULL,
      flv_http_path MEDIUMTEXT NULL,
      return_url MEDIUMTEXT NULL
      );";

	dbDelta($sql);
	
	 $sql = "INSERT INTO " . $wpdb->seetheface_settings . "(
      api_key, flv_upload_path,flv_http_path,return_url) VALUES ('your_api_key','".UPLOADS_PATH."' ,'".UPLOADS_URL."','/wordpress/wp-content/plugins/seetheface/seethefacelist');";

	dbDelta($sql);	
   }
}

//Replace <seetheface> tags with embedded video
function seetheface_preview($content) {
    global $profanities;
	global $wpdb;
	
	$settings = $wpdb->get_row("SELECT * FROM $wpdb->seetheface_settings");
	define('FLV_HTTP_PATH',	$settings->flv_http_path);
	 
	preg_match_all("/seetheface\sid=\"\w{0,}\"]/si",$content,$matches);
	while (list($key, $val) = each($matches[0])) {
	    $video_record=explode(" ",$val);
	    $id=preg_replace('/"]/','',preg_replace('/id="/','',$video_record[1]));
	    $act_videoset = $wpdb->get_row("SELECT * FROM $wpdb->seetheface WHERE id = $id");
	    $matches[0][$key]= htmlspecialchars(stripslashes($act_videoset->name));

	$code = '<object width="'.$act_videoset->playerwidth.'" height="'.$act_videoset->playerheight.'"><param name="movie" value="'.FLV_HTTP_PATH.$act_videoset->link.$act_videoset->swffilename.'"><param name="wmode" value="transparent"><embed src="'.FLV_HTTP_PATH.$act_videoset->link.$act_videoset->swffilename.'" type="application/x-shockwave-flash" wmode="transparent" width="'.$act_videoset->playerwidth.'" height="'.$act_videoset->playerheight.'" /></object><br />Title: <b>'.$act_videoset->name.'</b>';
  
	    $content=str_replace('['.$val,$code,$content);
	}
	
    return $content;
	
}

function seetheface_manage_page() {
	global $wpdb, $submenu;
		add_management_page('Seetheface manage', 'SeeTheFace', 'manage_options', 'seetheface/seetheface-admin.php');
}

	//Add menu item to the admin menu
	add_action('admin_menu', 'seetheface_manage_page');
	
	// Plugin activation
	add_action('activate_seetheface/seetheface.php', 'seetheface_install');
	
	//Replace tags <seetheface>
	add_filter('the_content', 'seetheface_preview', '', 1);
	
	/***************************************
	 Editor QuickButton
	 Inserts a Quickbutton into Editor
	 using buttonsnap (http://redalt.com)
	***************************************/
	
	require_once("buttonsnap.php");
	add_action('init', 'seetheface_buttons');
	add_action('edit_form_advanced', 'seetheface_quicktag_js');
	add_action('edit_page_form', 'seetheface_quicktag_js');

function seetheface_button($buttons) {
	array_push($buttons, "seetheface");
	return $buttons;
}

function seetheface_button_plugin($plugins) {
	array_push($plugins, "-seetheface");
	return $plugins;
}

function seetheface_button_script() {
	$pluginURL = get_option('siteurl')."/wp-content/plugins/seetheface/";
	echo 'tinyMCE.loadPlugin("seetheface", "'.$pluginURL.'");'."\n";
	return;
}

function seetheface_buttons() {
	global $wp_db_version;
	if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;
	if ( 3664 <= $wp_db_version && 'true' == get_user_option('rich_editing') ) {
		add_filter('mce_plugins', 'seetheface_button_plugin', 0);
		add_filter('mce_buttons', 'seetheface_button', 0);
		add_action('tinymce_before_init', 'seetheface_button_script');
	} else {
	    $post = (int) $_GET['post'];
		$base = buttonsnap_dirname(__FILE__);
		buttonsnap_jsbutton($base . '/seetheface-button.png', 'Seetheface video', "seetheface_insert($post);");
	}
}

function seetheface_quicktag_js() {
	$base = buttonsnap_dirname(__FILE__);
	echo "<script type='text/javascript' src='$base/seetheface-btn.js'></script>\n";
}

?>