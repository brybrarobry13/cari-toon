<?php
include("includes/configuration.php");
$user_id=$_SESSION['sess_tt_uid'];
$query = "SELECT OP.opro_caricature 
				FROM `toon_order_products` OP, `toon_orders` O  
				WHERE OP.order_id = O.order_id 
				AND O.user_id=$user_id 
				AND (O.order_status='Completed'
				OR O.order_status='artist paid')";
	$content=mysql_query($query);
$number=mysql_num_rows($content);
if($number)
{
?>	
<Collection Id="1" IconUri="<?=$_CONFIG['site_url']?>images/ez_logo.jpg" Title="My Caricatures">
<AssetsUri Format="xml" AssetCount="<?=$number?>"><?=$_CONFIG['site_url']?>toons_assets.php</AssetsUri>
</Collection>
<?
}
?>