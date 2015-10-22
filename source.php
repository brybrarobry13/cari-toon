<?php
include("includes/configuration.php");
$user_id=$_SESSION['sess_tt_uid'];
$other_photos_query=mysql_query("SELECT * FROM `toon_ezprints_uploads` WHERE user_id='$user_id'");
$num_other_photos=mysql_num_rows($other_photos_query);
$query = "SELECT OP.opro_caricature 
				FROM `toon_order_products` OP, `toon_orders` O  
				WHERE OP.order_id = O.order_id 
				AND O.user_id=$user_id 
				AND (O.order_status='Completed'
				OR O.order_status='artist paid')";
$content=mysql_query($query);
$number=mysql_num_rows($content);
if($number!=0 || $num_other_photos!=0)
{
$i=1;
?>

<Source Id="default" Title="Personal Albums" IconUri="<?=$_CONFIG['site_url']?>images/ez_logo.jpg">
	<?
	if($number!=0)
		{
	?>
	<CollectionUri Id="<?=$i?>" Format="xml"><?=$_CONFIG['site_url']?>caricatures.php</CollectionUri>
    
    <? $i++;
		}
	if($num_other_photos!=0)
		{
	?>
		<CollectionUri Id="<?=$i?>" Format="xml"><?=$_CONFIG['site_url']?>other_images.php</CollectionUri>
        
    <? 	}
	?>
</Source>
<?
}
?>