<?
include("includes/configuration.php");
$user_id=$_SESSION['sess_tt_uid'];
$other_photos_query=mysql_query("SELECT * FROM `toon_ezprints_uploads` WHERE user_id='$user_id'");
$num_other_photos=mysql_num_rows($other_photos_query);
if($num_other_photos)
{

    $i=1;
    while($other_images_row=mysql_fetch_array($other_photos_query))
    {
        $image='z_uploads/ez_uploads/'.$other_images_row['ez_image_name'];
        $image_regular='z_uploads/ez_uploads/regular/'.$other_images_row['ez_image_name'];
        $image_thumb='z_uploads/ez_uploads/thumb/'.$other_images_row['ez_image_name'];
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
                <Asset Id="<?=$i?> " Title="caricature" Description="caricatures" Size="" PrintResUri="<?=$_CONFIG['site_url'].$image?>" PrintResWidth="<?=$width?>" PrintResHeight="<?=$height?>"  ScreenResUri="<?=$_CONFIG['site_url'].$image_regular?>" IconUri="<?=$_CONFIG['site_url'].$image_thumb?>"/>
            <?php
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