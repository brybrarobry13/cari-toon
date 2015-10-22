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
    $i=1;
    while($caricatures_row=mysql_fetch_array($content))
    {
        $image='z_uploads/caricature_images/'.$caricatures_row['opro_caricature'];
        $image_regular='z_uploads/caricature_images/regular/'.$caricatures_row['opro_caricature'];
        $image_thumb='z_uploads/caricature_images/thumb/'.$caricatures_row['opro_caricature'];
        if(file_exists($image)&&file_exists($image_regular)&&file_exists($image_thumb))
        {
            list($width, $height, $type, $attr) = getimagesize($image);
            if($i==1)
			{
			?>
            <Assets>
            <?
			}
            ?>
    <Asset Id="<?=$i?> " Title="caricature" Description="caricatures" Size="" PrintResUri="<?=$_CONFIG['site_url'].$image?>" PrintResWidth="<?=$width?>" PrintResHeight="<?=$height?>"  ScreenResUri="<?=$_CONFIG['site_url'].$image_regular?>" IconUri="<?=$_CONFIG['site_url'].$image_thumb?>"/>		<?php
            $i++;
        }
    }
	
    if($i>1)
	{
	?>
	</Assets>
	<?
	}
}
?>