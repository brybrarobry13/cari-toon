<?
include("includes/configuration.php");
$user_id=$_SESSION['sess_tt_uid'];
$other_photos_query=mysql_query("SELECT * FROM `toon_ezprints_uploads` WHERE user_id='$user_id'");
$num_other_photos=mysql_num_rows($other_photos_query);
if($num_other_photos)
{
?>
<Source Id="default" Title="Personal Albums" IconUri="<?=$_CONFIG['site_url']?>images/ez_logo.jpg">
	<CollectionUri Id="1" Format="xml"><?=$_CONFIG['site_url']?>other_images.php</CollectionUri>
</Source>
<?
}
?>