<?  include("includes/configuration.php");
	include("includes/paging.class_sub.php");
	include("includes/resizeimage.php");
	$pagination_object=new paging;
	$pagenum=$pagination_object->setPageNumber($_GET['page']);
	$maxrows=$pagination_object->setDisplayRows(15);
	$pagination_object->setURL($_SERVER['PHP_SELF'],base64_encode(serialize($_GET)));
	$title_text = "Caricature Styles and Samples:";
	include (DIR_INCLUDES.'header.php');
	
	//Fetching values
	$fields	= " U.*, PT.user_id, PT.product_title, PT .product_turnaroundtime, SUM(product_price) as totalprice";
	//From tables names
	$from	= "`toon_users` U, `toon_user_types` UT, `toon_products` PT";
	//Using conditions
	$where	= "U.`utype_id`=UT.`utype_id` AND U.`user_id`=PT.`user_id` AND U.`user_status`='Active' AND U.`artist_gallery_status`='Active' AND U.`user_delete`='0' AND UT.`utype_name`='Artist' AND PT.`product_delete`=0 AND `approval_status`='Approved'";
	
	//Artist styles filtering
	if($_REQUEST['ftrby'])
	{  
		$filter  = $_GET['ftrby'];
		$fields .= " ,S.* ";
		$from	.=	" ,toon_artist_styles_selections S";
		if($filter!="ALL")
		{
			$where	.= " AND S.style_id = ".$filter." AND S.artist_id = U.user_id ";
		}
	}
	//Sorting methods
	if($_REQUEST['srtby'])
	{  
		$sort   = $_GET['srtby'];
		if($sort==1) //Popular (Most Orders)
		{  
			$fields .= " ,(SELECT COUNT(order_id) FROM toon_orders WHERE artist_id = U.`user_id`) rowcount ";
		 	$where  .= " GROUP BY PT.user_id ORDER BY rowcount DESC";
		}
		elseif($sort==2) //Fastest Turnaround time - Head & Bust
		{
			$where.= " AND PT.product_title ='Head & Bust' GROUP BY PT.user_id ORDER BY product_turnaroundtime DESC";
		}
		elseif($sort==3) //Fastest Turnaround time - Head & Body
		{
			$where.= " AND PT.product_title ='Head & Body' GROUP BY PT.user_id ORDER BY product_turnaroundtime DESC";
		}
		elseif($sort==4) //Fastest Turnaround time - Head, Body & Background
		{
			$where.= " AND PT.product_title ='Head, body & Background' GROUP BY PT.user_id ORDER BY product_turnaroundtime DESC";
		}
		elseif($sort==5) //Fastest Turnaround time - Head, Body & Background
		{
			$where.= " GROUP BY U.user_id ORDER BY  `U`.`user_joined` DESC ";
		}
		else //Other sorting methods
		{
			$priceresult= base64_decode($sort);
			$value = explode("-", $priceresult);
			if($value[1]=="High to Low price")
			{
				$where.= " AND PT.product_title ='".$value[0]."' GROUP BY PT.user_id ORDER BY totalprice DESC";
			}
			else
			{
				$where.= " AND PT.product_title ='".$value[0]."' GROUP BY PT.user_id ORDER BY totalprice ASC";
			}
		}
	}
	//If no sorting methods and artist styles are selceted 
	if(!$_REQUEST['srtby'])
	{  
		 $where.= " GROUP BY PT.user_id ORDER BY U.`user_artist_priority` ASC";
	}
	//Full query
	$appquery	= "SELECT ".$fields." FROM ".$from." WHERE ".$where."";	
	//echo $appquery;
	$rs_artists=mysql_query($appquery);
	$num=@mysql_num_rows($rs_artists);
	$sku_count=$pagination_object->setTotalPages($num);
	if($sku_count <= $pagenum)
	$pagenum=$pagination_object->setPageNumber($totalpages-1);
	$startrow=$pagination_object->setStartRow();
	$appquery.=" LIMIT $startrow,$maxrows";
	$rs_artists=mysql_query($appquery);	

	//Least price between active artists
	$sql="SELECT MIN(toon_products.product_price) prd_min FROM toon_users INNER JOIN toon_products ON toon_products.user_id = toon_users.user_id  WHERE toon_users.utype_id=2 AND toon_users.user_status='Active' AND toon_users.artist_gallery_status='Active' AND toon_products.product_delete=0 AND toon_users.approval_status='Approved'";
	$res_ct=mysql_query($sql);
	$result_prd=mysql_fetch_array($res_ct);
	
	//Active artist count
	$art_sql="SELECT * FROM toon_users WHERE `utype_id`=2 AND `user_status`='Active' AND `artist_gallery_status`='Active' AND `user_delete`=0 AND `approval_status`='Approved'";
	$art_res_ct=mysql_query($art_sql);
	$art_result_prd=@mysql_num_rows($art_res_ct);
	
	//Fetching all artist styles
	$sql_styles="SELECT * FROM toon_artist_styles INNER JOIN toon_artist_styles_selections ON toon_artist_styles.style_id = toon_artist_styles_selections.style_id GROUP BY toon_artist_styles_selections.style_id ORDER BY toon_artist_styles.style_name ";
	$res_styles=mysql_query($sql_styles);
	?>
<script type="text/javascript">
function filter_sort()
{
	var sort_value = document.getElementById('sort').value;
	var filter_value = document.getElementById('filter').value;
	var flag = false;
	var url='index.php?';
	if(sort_value != '0')
	{
		url +='srtby='+sort_value;
		flag = true;
	}
	if(filter_value != '')
	{
		if(flag == true)
		{
			url += '&';
		}
		url += 'ftrby='+filter_value;
	}
	window.location=url;
}
</script>	
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
            <div style="margin:0 0 0 40px;float:left; width:147px;">&nbsp;</div>
            <div style="padding:0 0 0 140px;float:left;"><img src="images/source_caricatures.png" border="0"/></div>
            <div style="padding:0 0 0 780px;">
            <script type="text/javascript" src="http://cdn.socialtwist.com/2011113055505/script.js"></script><a class="st-taf" href="http://tellafriend.socialtwist.com:80" onclick="return false;" style="border:0;padding:0;margin:0;"><img alt="SocialTwist Tell-a-Friend" style="border:0;padding:0;margin:0;" src="http://images.socialtwist.com/2011113055505/button.png" onmouseout="STTAFFUNC.hideHoverMap(this)" onmouseover="STTAFFUNC.showHoverMap(this, '2011113055505', window.location, document.title)" onclick="STTAFFUNC.cw(this, {id:'2011113055505', link: window.location, title: document.title });"/></a>
            </div>
            </div>
                <div style="height:190px;">
                    <div style="float: left; width: 190px; padding: 0pt 0pt 0pt 15px; position: absolute; z-index: 1000;"><a href="terms.php"><img src="images/guarantee-seal.png" width="190px" border="0" /></a></div>
                    <div style="padding: 20px 10px 20px 220px; width: 550px; float: left; position: absolute;" ><span style="padding-right:10px;">Welcome to Caricature Toons, the #1 Source for Hand Drawn Caricatures on the web. Our artists are among the best in the business, some even World Renown. We offer Awesome styles at prices everyone can afford.<br/><br/>Caricatures make great gifts on those special occasions. Imitation is said to be the greatest form of flattery. Who doesn't like a caricature, they're fun to give and even funnier to receive. Who doesn't like a humorous caricature of themselves or give to others, they're keepsakes. They really mark a special occasion for family, friends, business associates or any event you want to make memorable.<br/><br/>Personalized caricatures are great for any occasion. They are a great gift to celebrate retirements, birthdays, graduations, corporate events, fathers day, mothers day, hobbies, weddings, vacations, pets, avatars, groups & teams and the list goes on and on, only limited by the imagination. For volume orders or group caricatures please <a href="contact.php" style="text-decoration:underline;">contact us</a> for a custom quote.</span></div>
                	<div style="margin: -46px 15px 0px 0px; float: right; position: relative;" >
                    	<div style="position: absolute; float: right; color: rgb(255, 255, 0); text-align: center; width: 173px; margin-top: 53px;" class="toon_digit_top"><?=$art_result_prd;?></div>
                        <div style="position: absolute; float: right; color: rgb(255, 255, 0); text-align: center; width: 173px; margin-top: 170px; letter-spacing: 0pc;" class="toon_digit_bottom">$<?=$result_prd['prd_min'];?></div><img src="images/Homepageadd.gif" width="187" height="288" /></div>
                </div>
                <div style="height:5px;"></div>
		        <div style="clear:both;"></div>
				  <div style="width:800px;">
				  <span style="padding:0 0 0 20px;"><img src="images/sort_by.png" alt="" title="" /></span>
				   <select name="sort" id="sort" style="border-radius:5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; color:#666; width:150px; background: url(images/arrowdown.jpg) no-repeat right #FFF; height:20px;" onchange="filter_sort()" >
				    <option value="0">Select Sort Order</option>
					<option value="1" <? if($sort==1){ ?> selected="selected" <? } ?>>Most Popular</option>
                    <option value="5" <? if($sort==5){ ?> selected="selected" <? } ?>>Newest Artists</option>
                    <option value="2" <? if($sort==2){ ?> selected="selected" <? } ?>>Fastest Turnaround time - Head & Bust</option>
                    <option value="3" <? if($sort==3){ ?> selected="selected" <? } ?>>Fastest Turnaround time - Head & Body</option>
                    <option value="4" <? if($sort==4){ ?> selected="selected" <? } ?>>Fastest Turnaround time - Head, Body & Background</option> 
					<? $titlequery=mysql_query("SELECT U . *,PT.user_id,PT.product_title FROM `toon_users` U, `toon_products` PT WHERE U.user_id = PT.user_id AND U.user_status = 'Active' AND U.artist_gallery_status='Active' AND PT.product_delete=0 AND U.approval_status='Approved' GROUP BY PT.product_title");
					while($resultproduct_title=mysql_fetch_array($titlequery)) {
					$high="High to Low price";
					$low="Low to High price";
					 ?>
					<option value="<?=base64_encode($resultproduct_title['product_title']."-".$high)?>" <? if ($sort==base64_encode($resultproduct_title['product_title']."-".$high)){ ?> selected="selected" <? } ?>><?=$resultproduct_title['product_title']?> - High to Low price</option>
					<option value="<?=base64_encode($resultproduct_title['product_title']."-".$low)?>" <? if ($sort==base64_encode($resultproduct_title['product_title']."-".$low)){ ?> selected="selected" <? } ?>><?=$resultproduct_title['product_title']?> - Low to High price</option>
					<? }?>
				  </select>
				  
				  
				    <span style="padding:0 0 0 20px;"><img src="images/filter_by.png" alt="" title="" /></span>
				   <select name="filter" id="filter" style="border-radius:5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; color:#666; width:150px; background: url(images/arrowdown.jpg) no-repeat right #FFF; height:20px;" onchange="filter_sort()" >
				    <option value="0">Select Artist Styles</option>
                    <option value="ALL"<?php if($_GET['ftrby']=="ALL"){?> selected="selected"<?php } ?>>ALL</option>
					<?php 
					while($row_styles = mysql_fetch_array($res_styles))
					{?>
						<option value="<?=$row_styles['style_id']?>" <?php if($row_styles['style_id']==$_GET['ftrby']) {?> selected="selected"<?php }  ?>><?=$row_styles['style_name'];?></option>
					<?php
					}
					?>
				  </select>
				  &nbsp;&nbsp;<b>PAGE <?=$pagenum+1?> OF <?=$sku_count?></b><div style="margin: -20px 0pt 0pt 580px; position: relative;"><?php $pagination_object->pagenation();?></div>
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
                                <div style="color:#9cff00;padding: 0 20px;font-size:15px;font-weight:bold;"><?=$cat_row['product_title'];?></div>
                                <div style="color:#ffff00;padding: 0 20px;font-size:15px;font-weight:bold;">$<?=number_format($cat_row['product_price'],2);?></div>
                                <div style="color:#002691;padding: 0 20px;font-size:10px;clear:both;" >Turnaround time&nbsp;<?=$cat_row['product_turnaroundtime']; if($cat_row['product_turnaroundtime'] == 1) { echo ' day'; } else { echo ' days'; } ?>&nbsp;</div>
                            </div>
							<? $procount++; }?>	
							<div style="clear: both; position: relative; float: right; margin-top: -50px; margin-right: 50px;"><a href="order-caricature.php?artistname=<?=$row_artists['user_fname'];?>"><img src="images/order_now.png" border="0" alt="order" title="Order" /></a></div>
						</div>
					</div>
                    <div class="price_white_box" style="position:relative;">
						<div style="float:left;float: left; padding-left: 23px;">
							<div style="float:left;padding-top:20px;"><a href="artist/<?=$row_artists['user_id']?>/art-gall.html"><img alt="View <?=$row_artists['user_fname']?>'S Gallery" title="View <?=$row_artists['user_fname']?>'S Gallery" src="show_text/<? echo base64_encode("VIEW ".strtoupper($row_artists['user_fname'])."'S GALLERY")?>/13/" border="0"  /></a></div>
							<div style="float:left;padding-top:20px;"><a href="artist/<?=$row_artists['user_id']?>/art-gall.html" style="font-family:Arial, Helvetica, sans-serif"><img src="images/more.png" border="0"/></a></div>
						</div>
                        <?
						if($row_artists['user_id'])
						{						
							$artist_total_qry = mysql_query("SELECT * FROM toon_orders WHERE artist_id='".$row_artists['user_id']."'");
							$artist_total_orders = @mysql_num_rows($artist_total_qry);	
							
							$artist_like_qry = mysql_query("SELECT * FROM toon_orders WHERE review_rating = 1 AND artist_id='".$row_artists['user_id']."'");
							$artist_like_rating=@mysql_num_rows($artist_like_qry);
							if($artist_like_rating>0)
							{
								$artist_like_rating = $artist_like_rating;
							}
							else
							{
								$artist_like_rating = 0;
							}
							$artist_dislike_qry = mysql_query("SELECT * FROM toon_orders WHERE review_rating = 0 AND artist_id='".$row_artists['user_id']."'");
							$artist_dislike_rating=@mysql_num_rows($artist_dislike_qry);
							if($artist_dislike_rating>0)
							{
								$artist_dislike_rating = $artist_dislike_rating;
							}
							else
							{
								$artist_dislike_rating = 0;
							}
							
							if($artist_total_orders>0)
							{
								$per_ord = round(($artist_like_rating/$artist_total_orders)*100);
							}
							else
							{
								$per_ord = 100;
							}
						}
						?>
						<div style="float: right; position: relative; left: 27px; margin-top: 20px;"><img src="<?=$_SERVER['HTTP_HOST']?>images/happy.png" /><a href="reviewfeedback.php?artist_id=<?=$row_artists['user_id']?>" onclick="return hs.htmlExpand(this,{headingText: '', objectType: 'iframe',width:700,height:450 })"><div style="margin-top: 10px; position: relative; width: 46px; height: 16px; float: right; margin-left: -56px; margin-right: 5px;"><img src="<?=$_SERVER['HTTP_HOST']?>images/reviews.png" /></div></a>
                <div style="font-family: Arial,Helvetica,sans-serif; color: rgb(161, 246, 0); position: absolute; font-weight: bold; margin-top: -42px; font-size: 25px; width: 45px; text-align: right; margin-left: 60px;"><?=$per_ord?></div>
                <div style="font-family: Arial,Helvetica,sans-serif; color: rgb(161, 246, 0); position: absolute; font-weight: bold; font-size: 12px; margin-left: 170px; margin-top: -44px;"><?=$artist_like_rating?></div>
                <div style="font-family: Arial,Helvetica,sans-serif; color: rgb(161, 246, 0); position: absolute; font-weight: bold; font-size: 12px; margin-left: 170px; margin-top: -25px;"><?=$artist_dislike_rating?></div></div>
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
                            <div class="gallery_position" style="padding-top: 5px; padding-left: 55px; width: 235px;">
								<div class="gallery_bg">
                                	<div class="gallery_first_img" align="center" style="line-height:120px;vertical-align:middle;">
                                    	<? if($image_row['text_after']!='') { $alt=$title=$image_row['text_after']. ' - ' .$image_descp[rand(1,$img_num)-1]; } ?>
                                    	<? $after_image_name = print_image($image_row['agal_image'],'artist',204,255,$alt,$title); ?>
                                        <?php /*?><? if($image_row['agal_image']!="noimage.gif"){ ?>
                                        &nbsp;<img src="z_uploads/artist_gallery/thumb_artist_images/<?=$image_row['agal_image']?>" border="0" alt="<?=$alt?>" title="<?=$title?>"/>
                                        <? } else { ?>
                                        &nbsp;<img src="z_uploads/artist_gallery/thumb_artist_images/noimage.gif" border="0" alt="No image" title="No image"/>
                                        <? } ?><?php */?>
                                        <? $org_aftr_img=str_replace("th_","",$image_row['agal_image']); ?>
                                    </div>
							  </div>
							  <div style="width: 130px; position: absolute; margin-top: -35px; margin-left: 65px;">
                              <div class="price_enlarge_btn_first_img"><a href="z_uploads/artist_gallery/artist_images/<?=$org_aftr_img?>" onclick="return hs.expand(this)"><img src="images/enlarge_lens.png" border="0" alt="enlarge" title="Enlarge"  /></a></div>
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
        <div style="float:right;">
        	<div style="margin: -21px 0pt 0pt 0px; position: relative; float: left; width: 125px;">&nbsp;&nbsp;<span style="color:#887F7A;font-family:Arial;font-size:18px;font-size-adjust:none;font-style:normal;font-variant:normal;font-weight:bold;line-height:normal;">PAGE <?=$pagenum+1?> OF <?=$sku_count?></span></div>
			<div style="margin: -20px 0pt 0pt 0px; position: relative; float: right; padding-right: 30px;"><?php $pagination_object->pagenation();?></div>
        </div>
        <div style="height:30px" >&nbsp;</div>
        <div style="clear:both;"> </div>
        <div class="header_text" style="padding-left:20px;padding-right:15px;">Have some fun and explore all our Artists Galleries, each artist has their own unique style and there is bound to be something you love. We have like to think we have a stroke for every folk. They are easy to order online with 7-day or less turnaround and all our Caricatures are Royalty Free to use as you like and you can't go wrong with our 100% money back guarantee.<br/><br/>Also check out all the cool gift ideas by clicking Buy Products and using our product builder, we have hundreds of pre-designed products you can add drop your caricature into to make, they make awesome gifts for those special occasions and holidays.<br/><br/>Caricatures make awesome personal gifts; everyone loves a caricature of yourself or others. Aside from Caricatures making great looking avatars, we also have awesome ways for you to display your caricature on things like Mugs, T-Shirts, Framed Posters, Framed Canvas, Mouse pad, Calendars, Greeting Cards, Water Bottles, Aprons, Tote Bag, Puzzles, Coasters, Buttons, Photo Key and Luggage Tag, Playing Cards, Ceramic Tiles, Jewelry, Keepsake Box, Desktop Organizer, Magnets, Gallery Wrapped Canvas, Rolled Canvas, Rolled Posters, Flat Cards, Eco Friendly Cards and Notepads, Cards, Stickers,<br/><br/>Our Caricature Artists are among some of the Top Caricature Artists in the World, some even award winning. Many work for major Entertainment Parks, Newspapers and Magazines. Rest assured when you order a hand-drawn Caricature Toon you're getting more than a cartoon caricature, your getting a work of art that will be cherished for years.<br/><br/><br/>

<span style="font-size:16px;font-weight:normal;">The process to order your caricature online:</span><br/>
<ul>
	<li>View all our expert caricature styles</li>
	<li>Find the artist&prime;s drawing style you like the most</li>
	<li>Check out their respective galleries and you&prime;ll surely find many samples of their beautiful caricature artwork along with the original photographs they were supplied with thus giving you a crystal clear idea of what to expect</li>
	<li>Once the caricature artist style and price point has been liked and picked selected placing an order is easy</li>
	<li>Simply upload your best looking photo, give the caricaturist a brief description of what you&prime;d like to see in it. Select your caricaturists name from the easy to use pull down menu and place your order. It undoubtedly is that easy and simple</li>
	<li>The net result will be a fantastic looking A4-300 dpi caricature royalty free cartoon. These make lovely gift products for anniversaries, fathers day, mothers day, birthdays, weddings, retirements, marketing materials, avatars and special events.</li>
</ul><br/>

Enjoy our website, it is a package full of fun, be sure to tell your friends. Caricature not just yourself but others too. Welcome to our site and enjoy!!
<br/><br/></div>
	</div>
<!--content ends-->	
<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>