<?
include("includes/configuration.php");
$user_id=$_SESSION['sess_tt_uid'];
$other_photos_query=mysql_query("SELECT * FROM `toon_ezprints_uploads` WHERE user_id='$user_id'");
$num_other_photos=mysql_num_rows($other_photos_query);
if($num_other_photos)
{
?>
<Collection Id="2" IconUri="<?=$_CONFIG['site_url']?>images/ez_logo.jpg" Title="My Photos">
<AssetsUri Format="xml" AssetCount="<?=$num_other_photos?>"><?=$_CONFIG['site_url']?>toons_assets_other.php</AssetsUri>
</Collection>
<?
}
?>