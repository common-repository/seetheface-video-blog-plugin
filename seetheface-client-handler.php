<?php
/** 
 * @package SeeTheFace SiteClip
 * @version 1.0
 * @copyright seetheface.com
 * 
 * Hander Page example
 * client_handler.php
 */



require_once('../../../wp-config.php');
/**
 * Get POST variables
 */

//custom variable, just to define video author
$userId = $_POST['param1']; 

//video filename
$flvFilename = $_POST['file_flv_name'];
//player filename
$swfFilename = $_POST['file_swf_name'];

//video size in bytes
$flvSizeBytes = $_POST['file_flv_size'];
//player size in bytes
$swfSizeBytes = $_POST['file_swf_size'];
//total files' size in bytes, can be used to check if enough disk space available
$totalSizeBytes = $_POST['files_size'];

//video recoding name
$videoName = $_POST['video_name'];
//length in seconds
$videoLength = $_POST['video_length'];
$videoWidth = $_POST['video_width'];
$videoHeight = $_POST['video_height'];

//flash player dimmensions, in pixels
$playerWidth = $_POST['player_width'];
$playerHeight = $_POST['player_height'];

$flvUploaded = false;
$swfUploaded = true;

$sql="SELECT * FROM ". $table_prefix."seetheface_settings";
$db=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
mysql_select_db(DB_NAME,$db);
$result = mysql_query($sql,$db);
$set=mysql_fetch_array($result);
	
define('FLV_UPLOAD_PATH',	$set['flv_upload_path']);

function trace($message) {
	$content = print_r($message, true);
	$handle = @fopen(FLV_UPLOAD_PATH.'log.txt', 'a');
	@fwrite($handle, date("Y-m-d H:i:s")."\r\n".$content."\r\n\r\n");
	@fclose($handle);
}


function get_extension($filename) {
			ereg("\.(.+)$", $filename, $ext);   
			return $ext[0];
}

	/**
	 * Create directory to save files to
	 */
	
	
	$dir = $userId.'_'.date('YmdHs');
	$path = FLV_UPLOAD_PATH.$dir;
	echo $path." ".$set['flv_upload_path'].'<br>';
	mkdir($path, 0777);
	$path = $path.'/';
	
	// Save video
	if (strlen($flvFilename) && move_uploaded_file($_FILES['file_flv']['tmp_name'], $path.$flvFilename)) {
		$flvUploaded = true;
	}
	else
		{
			$msg=print_r($_FILES, true);
			trace("upload failed ".$msg);
		}
	// Save player
	if (strlen($swfFilename) && move_uploaded_file($_FILES['file_swf']['tmp_name'], $path.$swfFilename)) {
		$swfUploaded = true;
		

	}
		
	/**
	 * Do custom stuff here
	 * Let's save html code snippet to use it later on Return Page
	 */
	$sql='INSERT INTO '.$table_prefix.seetheface.' (swffilename, flvfilename ,name, width, height, playerwidth, playerheight, link) VALUES ("'.$swfFilename.'","'.$flvFilename.'","'.$videoName.'",'.$videoWidth.','.$videoHeight.','.$playerWidth.','.$playerHeight.', "'.$dir.'/")';
		
	$db=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	mysql_select_db(DB_NAME,$db);
	if(mysql_query($sql)==false){
			
			unlink($path.$flvFilename);
			unlink($path.$swfFilename);
			trace("can`t inser record ".$sql);
	}
		 



	/**
	 * Output result for SeeTheFace API server
	 */
	if ($flvUploaded && $swfUploaded) {
		echo "result=ok";
	} else {
		echo "result=error";
	}
?>