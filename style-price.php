<?  include("includes/configuration.php");
include("includes/paging.class_sub.php");
	$title_text = "Caricature Styles and Samples:";
	include (DIR_INCLUDES.'header.php');
	$pagination_object=new paging;
	$pagenum=$pagination_object->setPageNumber($_GET['page']);
	$maxrows=$pagination_object->setDisplayRows(15);
	$pagination_object->setURL($_SERVER['PHP_SELF'],base64_encode(serialize($_GET)));
	 
	$appquery.= "SELECT U . *,PT.user_id,SUM(product_price) as totalprice,SUM(product_turnaroundtime) as totalturntime FROM `toon_users` U, `toon_user_types` UT ,`toon_products` PT WHERE U.`utype_id` = UT.`utype_id` AND U.`user_id` = PT.`user_id` AND U.`user_status` = 'Active' AND U.`user_delete` = '0' AND UT.`utype_name` = 'Artist' AND PT.`product_delete`=0 GROUP BY PT.user_id";
	if($_REQUEST['srtby'])
	{  
		$sort=$_REQUEST['srtby'];
		if($sort==1)
		{
			$appquery.=" ORDER BY  totalprice DESC";
		}
		elseif($sort==2)
		{
			$appquery.=" ORDER BY  totalprice ASC";
		}
		elseif($sort==3)
		{
			$appquery.=" ORDER BY  totalturntime ASC";
		}
	}
	if(!$_REQUEST['srtby'])
	{  
		$appquery.=" ORDER BY U.`user_artist_priority` ASC";
	}
		
	$rs_artists=mysql_query($appquery);
	$num=mysql_num_rows($rs_artists);
	$sku_count=$pagination_object->setTotalPages($num);
	if($sku_count <= $pagenum)
	$pagenum=$pagination_object->setPageNumber($totalpages-1);
	$startrow=$pagination_object->setStartRow();
	$appquery.=" LIMIT $startrow,$maxrows";
	$rs_artists=mysql_query($appquery);	
?> 
<link rel="stylesheet" type="text/css" href="styles/highslide.css" />
<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>
<script type="text/javascript" src="javascripts/highslide-full.js"></script>
<script type="text/javascript">
	hs.graphicsDir = 'images/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.dimmingOpacity = 0.75;
	hs.allowSizeReduction = false;
	// define the restraining box
	hs.useBox = true;
	hs.width = 280;
	hs.height = 300;

	// Add the controlbar
	hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: false,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: 1,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<!--header ends-->
<!--content starts-->

<div id="price_contents">
    <div class="header_text">
        <div style="height:80px;">
            <div style="margin:0 0 0 40px;float:left;"><a href="http://referzo.com/seal.php?merchant_id=249&refer_url=www.caricaturetoons.com" style="text-decoration:none;" target="_blank" ><img src="images/earn_referred.png" border="0"/></a></div>
            <div style="padding:0 0 0 140px;float:left;"><img src="images/source_caricatures.png" border="0"/></div>
            <div style="padding:0 0 0 780px;"><img src="images/icons.png" border="0"/></div>
            </div>
                <div style="height:190px;">
                    <div style="float: left; width: 190px; padding: 0pt 0pt 0pt 15px;"><img src="images/guarantee-seal.png" width="190px" /></div>
                    <div style="padding: 20px 10px 20px 220px; width: 550px; float: left; position: absolute;" ><b style="padding-right:10px;">Our Caricatures cartoons come in many different styles at awesomely affordable prices. . If you&prime;re looking for a non-Triathlon related caricature cartoon, NO PROBLEM, just let your caricature artists know what you&prime;d like to see and they can easily accommodate.<br /><br />
            To get started is simple, just browse the list of artists&prime; styles and if you want to see more samples, check out the caricature artist&prime;s gallery. In the artist gallery you&prime;ll find some samples that may even trigger some cool ideas for your caricature.<br /><br />
            Once you find a caricature artist style you like, simply click the green order button and you can then upload your photo and order your caricature online. In 7 days or less you&prime;ll be looking at beautiful caricature toon. It&prime;s that easy! In the meantime, if you have any ordering related questions or special requests please feel free to <a href="mailto:<?=$_CONFIG['email_contact_us']?> <<?=$_CONFIG['email_contact_us']?>>?subject=Artist Submission">contact</a> our toon helpers who will be happy to help you out.</b></div>
                	<div style="margin: -46px 15px 0px 0px; float: right; position: relative;" >
                    	<div style="position: absolute; float: right; color: rgb(255, 255, 0); text-align: center; width: 173px; margin-top: 50px;" class="toon_digit_top">100</div>
                        <div style="position: absolute; float: right; color: rgb(255, 255, 0); text-align: center; width: 173px; margin-top: 167px; letter-spacing: 0pc;" class="toon_digit_bottom">$34.99</div><img src="images/Homepageadd.gif" width="187" height="288" /></div>
                </div>
                
                <div style="height:5px;"></div>
		        <div style="clear:both;"></div>
				  <div style="width:800px;">
				  <span style="padding:0 0 0 20px;"><img src="images/sort_by.png" border="0" /></span>
				  <select name="sort" style="border-radius:5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; color:#666; width:150px; background: url(images/arrowdown.jpg) no-repeat right #FFF; height:20px;" onchange="window.location='index.php?srtby='+this.value" >
				   <option value="0">Select sort order</option>
					<option value="1" <? if ($sort==1){ ?> selected="selected" <? } ?>>High to Low price</option>
					<option value="2" <? if ($sort==2){ ?> selected="selected" <? } ?>>Low to High price</option>
					<option value="3" <? if ($sort==3){ ?> selected="selected" <? } ?>>Turnaround time</option>
				  </select>&nbsp;&nbsp;PAGE <?=$page+1?> OF <?=$sku_count?><div style="margin:-20px 0 0 330px; position:relative;"><?php $pagination_object->pagenation();?></div>
				  </div>
                  <div class="buy_now_txt_btm_space"></div>
	
			<!--<div class="buy_now_txt_btm_space"></div>-->
			<div style="height:20px;"></div>
<!--<div class="buy_now_txt_btm_space"></div>-->
			
		<? $colori=0;
		while($row_artists = mysql_fetch_assoc($rs_artists))
		{
			 
			if($colori%3==2)
			{
				$bgimg="green";
			}
			else if($colori%3==1)
			{
				$bgimg="blue";
			}
			else if($colori%3==0)
			{
				$bgimg="orange";
			}
		?>
			<div >
				<div style="float:left;padding-left:15px;"><img src="images/<?=$bgimg?>_left.png" border="0"/></div>												
				<div style="float:left; background:url(images/<?=$bgimg?>.png) repeat-x; height:463px;">
				  	<div style="width: 910px; float: left; padding-top: 395px; position: absolute; padding-left: 15px;">
						<div>
						 <? $cat_query = mysql_query("SELECT * FROM `toon_products` WHERE `user_id`=$row_artists[user_id] AND `product_delete`=0 order by product_priority ASC");
						 	$num_pro=mysql_num_rows($cat_query);
							$procount=1;
                            while($cat_row = mysql_fetch_array($cat_query )){  ?>
                            <div style="float:left; <? if($procount!=$num_pro){?>border-right:dotted #FFF 1px; <? } ?> position: relative;">	
                                <div style="color:#FFF;padding: 0 20px;font-size:15px;font-weight:bold;"><?=$cat_row['product_title'];?></div>
                                <div style="color:#FFF;padding: 0 20px;font-size:15px;font-weight:bold;">$<?=number_format($cat_row['product_price'],2);?></div>
                                <div style="color:#FFF;padding: 0 20px;font-size:10px;clear:both;" >Turnaround time&nbsp;<?=$cat_row['product_turnaroundtime']; if($cat_row['product_turnaroundtime'] == 1) { echo ' day'; } else { echo ' days'; } ?>&nbsp;</div>
                            </div>
							<? $procount++; }?>	
							<div style="clear: both; position: relative; float: right; margin-top: -50px; margin-right: 50px;"><a href="order-caricature.php"><img src="images/order_now.png" border="0" alt="order" title="Order" /></a></div>
						</div>
					</div>
                    <div class="price_white_box" style="position:relative;">
						<div style="float:left;float: left; padding-left: 23px;">
							<div style="float:left;padding-top:20px;"><a href="artist/<?=$row_artists['user_id']?>/art-gall.html"><img alt="View <?=$row_artists['user_fname']?>'S Gallery" title="View <?=$row_artists['user_fname']?>'S Gallery" src="show_text/<? echo base64_encode("VIEW ".strtoupper($row_artists['user_fname'])."'S GALLERY")?>/13/" border="0"  /></a></div>
							<div style="float:left;padding-top:20px;"><a href="artist/<?=$row_artists['user_id']?>/art-gall.html" style="font-family:Arial, Helvetica, sans-serif"><img src="images/more.png" border="0"/></a></div>
						</div>
						<div style="float: right; position: relative; left: 27px; margin-top: 20px;"><img src="images/happy_customers.png"  /></div>
                        <div class="price_gallery_content" style="clear:both;">
						<?  $image_description=mysql_query("SELECT `img_phrase` FROM `toon_img_phrase`");
							$img_num = mysql_num_rows($image_description);
							$i=0;
							while($image_description_result = mysql_fetch_array($image_description ))
							{
								$image_descp[$i]=$image_description_result['img_phrase'];
								$i++;
							}
							//print_r($image_descp);
							$image_query = mysql_query("SELECT * FROM `toon_artist_gallery` WHERE `user_id`='{$row_artists['user_id']}' and `agal_priority`='1' LIMIT 0 , 3");
							while($image_row = mysql_fetch_array($image_query ))
							{ ?>	
                            <div class="gallery_position" style="padding-top: 5px; padding-left: 30px; width: 266px;">
								<div class="gallery_bg">
                                	<div class="gallery_first_img" align="center" style="line-height:120px;vertical-align:middle;">
                                    	&nbsp;<img src="<?='includes/imageProcess.php?image='.$image_row['agal_image'].'&type=artist&size=255';?>" border="0" alt="<? if($image_row['text_after']!='') { echo $image_row['text_after']. ' - ' .$image_descp[rand(1,$img_num)-1]; }?>" title="<? if($image_row['text_after']!=''){ echo $image_row['text_after']. ' - ' .$image_descp[rand(1,$img_num)-1]; }?>"/>
                                    </div>
							  </div>
							  <div style="width: 130px; position: absolute; margin-top: -35px; margin-left: 110px;">
                              <div class="price_enlarge_btn_first_img"><a href="z_uploads/artist_gallery/thumb_artist_images/<?=$image_row['agal_image'] ?>" onclick="return hs.expand(this)"><img src="images/enlarge_lens.png" border="0" alt="enlarge" title="Enlarge"  /></a></div>
							  <!--<div class="text_blue"><h4 style="width: 125px; padding: 0pt 0pt 0pt 15px; text-align: center;"><? if($image_row['text_after']!='') { echo $image_row['text_after']; }?></h4></div>--></div>
							  
							</div>
						<? }?>
						</div>
					</div>	
						
					<div style="clear:both; height:3px;"></div>
				</div>
				<div style="padding-right:1px;"><img src="images/<?=$bgimg?>_right.png" border="0"/></div>
			</div>
			<div style="height:40px" >&nbsp;</div>
		<? $colori++; }?>
        <div style="clear:both; height:10px;"> </div>
        <div class="header_text" style="padding-left:30px;"><b>* Win a FREE Caricature is open to all those on our mailing list.</br>
    Once a month we choose a winner from people who are on our mailing list and announce it in one of our monthly email blasts.</b></div>
	</div>
<!--content ends-->	
<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>