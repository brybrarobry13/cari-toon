<?  include("includes/configuration.php");
	include(DIR_FUNCTIONS.'options.php');
	$artist_id=$_GET['artist_id'];
	$artist_name_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`='$artist_id'");
	$artist_name_row=mysql_fetch_array($artist_name_query);
	$artist_review_query = mysql_query("SELECT * FROM toon_orders WHERE artist_id = '".$artist_id."' AND (order_status='Completed' OR order_status='artist paid') ORDER BY `review_date` DESC");
	$artist_num=@mysql_num_rows($artist_review_query);
	$countryprovince = getoption_values('country');
?> 
<link rel="stylesheet" type="text/css" href="styles/highslide.css" />
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<div >
    <div>
        <div style="padding-left:10px; padding-bottom:10px; height:150px;">
            <div style="float:left;margin-right:10px;"><? if($artist_name_row['user_image']==''){ ?><img src="z_uploads/profile_images/noimage.gif" border="0" width="100" /><?  }else {?><img src="z_uploads/profile_images/<?=$artist_name_row['user_image']?>" border="0" width="140" /><? }?></div>	
			<div>
                <div class="text_blue" style="padding-left:140px; font-size:18px;"><b><?=$artist_name_row['user_fname'];?></b></div>
				<div  style="padding-left:140px;"><span class="text_blue"><b><? foreach($countryprovince as $key=>$value) { if($key==$artist_name_row['user_country']) { echo  $value;} }?></b></span></div>
                <div style="padding-left:140px;padding-top:20px;" class="text_blue"><?=$artist_name_row['user_description'];?></div>
            </div>
		</div>
		<div style="height:30px;background-color:#FF6600;padding:10px 0 0 10px;"><img src="images/customer.png" /></div>
		<div style="height:10px;"></div>
        <? if($artist_num>0) { ?>
		<? while($artist_review_result=mysql_fetch_array($artist_review_query)) { ?>
		<div style="height:30px;">
			<div style="padding:5px 0 0 10px;">
			<div><? if($artist_review_result['review_rating']==1) { ?><img src="images/icon_green.png" border="0"  width="15" height="20"/><? } else { ?><img src="images/icon_red.png" border="0"  width="15" height="20"/><? } ?><span style="padding:0 0 0 10px;" class="header_text"><?=$artist_review_result['review_comment'];?></span></div>
			</div>
		</div>		
		<div style="height:5px;" ><hr /></div>
		<? }  
		} else {?>
        <div style="height:160px;padding-left:10px; color:#F00;" class="text_blue">No feedbacks to list</div>
        <? } ?>
	</div>
	<div style="clear:both"></div>
</div>