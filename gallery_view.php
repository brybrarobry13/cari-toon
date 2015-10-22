<?  include("includes/configuration.php");
	$artist_id=$_REQUEST['art_id'];
	$query = mysql_query("SELECT * FROM `toon_artist_gallery` WHERE `user_id`='$artist_id' ORDER BY `agal_id` DESC , `opro_image` DESC");
	$artist_name_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`='$artist_id'");
	$artist_name_row=mysql_fetch_array($artist_name_query);
	//$_SERVER['HTTP_HOST']="http://www.toonsforu.com/";
	$_SERVER['HTTP_HOST']="http://www.caricaturetoons.com/";
	//$_SERVER['HTTP_HOST']="http://localhost/priswin/caricaturetoons/";
?>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.imgareaselect-0.3.min.js"></script>
<link href="<?=$_SERVER['HTTP_HOST']?>styles/style.css" rel="stylesheet" type="text/css" />	
<link rel="stylesheet" type="text/css" href="<?=$_SERVER['HTTP_HOST']?>styles/highslide.css" />
<link href="<?=$_SERVER['HTTP_HOST']?>styles/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="styles/highslide/highslide.css" />
<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>

<!--<base href="http://www.toonsforu.com/" />-->
<base href="http://www.caricaturetoons.com/" />
<!--<base href="http://localhost/priswin/caricaturetoons/" />-->
<div align="center">			
    <div class="artistprice_white_curve_middle_border" style="margin-left:10px; margin-right:10px; margin-bottom:0px; width:950px; margin-top:10px; border-radius:15px; -moz-border-radius:15px; -webkit-border-radius:15px;">
        <div  style="-moz-border-radius:35px;">
            <div style="height:auto;clear:left;text-align:center; padding-top:30px;"><img alt="<?=$artist_name_row['user_fname']."'s idea gallery and style"?>" title="<?=$artist_name_row['user_fname']."'s idea gallery and style"?>" src="<?=$_SERVER['HTTP_HOST']?>show_text/<? echo base64_encode(strtoupper($artist_name_row['user_fname']."'S IDEA GALLERY & STYLE"));?>/17/" border="0"  /></div>
            <div style="margin:20px; margin-bottom:10px;">
            <?php  while($img_row=mysql_fetch_array($query)) {?>
                <div style="float:left; margin:10px 10px 10px 10px;">
					<img src="z_uploads/artist_gallery/thumb_artist_images/<?=$img_row['opro_image']?>" width="204" />
					<?php
					$org_bfr_img = str_replace("th_","",$img_row['opro_image']);
					?>
					<div style="height:5px;"></div>
					<a href="<?=$_SERVER['HTTP_HOST']?>z_uploads/artist_gallery/artist_images/<? echo $org_bfr_img; ?>" onclick="return hs.expand(this);" >
					<img src="<?=$_SERVER['HTTP_HOST']?>images/enlarge.png" border="0" alt="enlarge" title="Enlarge" width="80" /></a>
				</div>
				
                <div style="float:left; margin:10px 10px 10px 10px;">
					<img src="z_uploads/artist_gallery/thumb_artist_images/<?=$img_row['agal_image']?>" width="204" />
					<?php
					$org_bfr_img = str_replace("th_","",$img_row['agal_image']);
					?>
					<div style="height:5px;"></div>
					<a href="<?=$_SERVER['HTTP_HOST']?>z_uploads/artist_gallery/artist_images/<? echo $org_bfr_img; ?>" onclick="return hs.expand(this)" >
					<img src="<?=$_SERVER['HTTP_HOST']?>images/enlarge.png" border="0" alt="enlarge" title="Enlarge" width="80" /></a>
				</div>
            <?php } ?>
            <div style="clear:both; height:15px;"></div>
            </div>
        </div>
     </div>
 </div>						