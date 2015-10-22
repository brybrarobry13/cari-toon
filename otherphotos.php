<?
include("includes/configuration.php");
include('includes/imageResize.php');
include (DIR_INCLUDES.'functions/encryption.php');
@$encrypt_obj = new AzDGCrypt(1074);
$user_id=$encrypt_obj->decrypt($_GET['u_id']);
if($_FILES['Filedata']['name']!='')
{	
	$ext = end(explode(".",$_FILES['Filedata']['name']));	
	$ext = strtolower( $ext );
	$fileSize = $_FILES['photo_'.$upload_count]['size'];
	$fileSize = 0;

	if ($ext == "gif" || $ext == "jpeg" || $ext == "jpg" || $ext == "png")
	{
		if($fileSize < 104857600)
		{
			$photoName1=$_FILES['Filedata']['name'];
			$photoName=str_replace(" ","_",$photoName1);
			$insert_image=mysql_query("INSERT INTO `toon_ezprints_uploads` (`user_id` ,`ez_image_name`) VALUES ('$user_id', '$photoName')");
			$last_id=mysql_insert_id();
			$newname=$last_id.'_'.$photoName;
			move_uploaded_file($_FILES['Filedata']['tmp_name'],DIR_EZUPLOAD_IMAGES.$newname);
			copy(DIR_EZUPLOAD_IMAGES.$newname,DIR_EZUPLOAD_IMAGES."/thumb/$newname");
			copy(DIR_EZUPLOAD_IMAGES.$newname,DIR_EZUPLOAD_IMAGES."/regular/$newname");
			new imageProcessing(DIR_EZUPLOAD_IMAGES."/thumb/$newname",120,120);
			new imageProcessing(DIR_EZUPLOAD_IMAGES."/regular/$newname",600,600);
			mysql_query("UPDATE `toon_ezprints_uploads` SET `ez_image_name`='$newname' WHERE `ez_image_id`='$last_id'");
			echo 200;
		}
		else
		{
			echo 500;
			//mail ("m.varg@yahoo.com", "Photo size is too high", $_FILES['photo_'.$upload_count]['size']);
		}
	}
	else
	{
		echo 500;
		//echo "The extesion '$ext', is not allowed.";
	}
}
?>
