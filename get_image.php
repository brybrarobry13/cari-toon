<? include("includes/configuration.php");
include(DIR_INCLUDES.'functions/orders.php');
if (isset($_REQUEST['pdct_id']))
	{
		$pdct_id = $_REQUEST['pdct_id'];
		/*echo 'SELECT TU.user_fname, TG.agal_image FROM `toon_users`TU,`toon_products`TP, toon_artist_gallery TG WHERE TP.`user_id`=TU.`user_id` AND TP.`product_id` = '.$pdct_id.' AND TG.`user_id`=TU.`user_id`';*/
		$artist_res=mysql_query('SELECT TU.user_fname, TG.* FROM `toon_users`TU,`toon_products`TP, toon_artist_gallery TG WHERE TP.`user_id`=TU.`user_id` AND TP.`product_id` = '.$pdct_id.' AND TG.`user_id`=TU.`user_id` ORDER BY TG.agal_id DESC');
		$artist_row = mysql_fetch_array($artist_res);		
		if(mysql_num_rows($artist_res)==0)
		{
			echo '<div style="padding-right: 1px;"><img src="images/noimage.gif" border="0" alt="captoon" title="captoon" width="204"/ ></div>';
		}
		else
		{
			$org_aftr_img=str_replace("th_","",$artist_row['agal_image']);
			?>
			<div class="gallery_bg">
				<div style="height:5px;"></div>
			<a href="gallery_view.php?art_id=<?=$artist_row['user_id']?>"  onclick="return hs.htmlExpand(this,{headingText: '', objectType: 'iframe',width:1000,height:500 })"><div style="padding-right: 1px;"><img src="z_uploads/artist_gallery/thumb_artist_images/<?=$artist_row['agal_image']?>" border="0" width="204"/ ></div><div style="height:10px;"></div><img alt="View <?=$artist_row['user_fname']?>'S Gallery" title="View <?=$artist_row['user_fname']?>'S Gallery" src="show_text/<? echo base64_encode("VIEW ".strtoupper($artist_row['user_fname'])."'S GALLERY")?>/7/" border="0"  /></a>
			</div>
		<?php
		}
	}
?>
