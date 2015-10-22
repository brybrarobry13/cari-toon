<? 	include("includes/configuration.php");
	include('includes/imageResize.php');
	if(!isloggedIn())
	{
		header('Location:alogin.php');
		exit();
	}
	$userDetails = getUserDetails();
	$status = $_REQUEST['status'];
	$proof_id = $_REQUEST['proof_id'];
	if($proof_id != "" && $status=='approved')
	{
		$proof_table = mysql_query("SELECT * FROM `toon_proofs` where `proof_id`='$proof_id'");
		$proof_details = mysql_fetch_array($proof_table);
		$proof_img	=	$proof_details['proof_image'];
		$proof_opro_id	=	$proof_details['opro_id'];
		$order_products_table = mysql_query("SELECT * FROM `toon_order_products` where `opro_id`='$proof_opro_id'");
		$order_products_details = mysql_fetch_array($order_products_table);
		$order_products_id	=	$order_products_details['order_id'];
	
		$update_toon_orders = mysql_query("UPDATE `toon_orders` SET `order_status` = 'Completed',`order_completed_date`=NOW() WHERE `order_id`='$order_products_id'");
		
		//mail
		$sql_content = mysql_query("SELECT 
			T.*, 
			TP.`product_title`,
			TP.`product_turnaroundtime`, 
			TA.`user_fname` AS `artist_fname`, 
			TA.`user_lname` AS `artist_lname`, 
			TC.`user_fname` AS `cust_fname`, 
			TC.`user_lname` AS `cust_lname` 
		FROM `toon_orders` T,`toon_products` TP,`toon_users`TA ,`toon_users`TC 
		WHERE T.`order_id` = $order_products_id
			AND T.`product_id` = TP.`product_id` 
			AND T.user_id = TC.user_id 
			AND T.artist_id = TA.user_id");
		$sql_details = mysql_fetch_array($sql_content);
		$order_date = strtotime($sql_details['order_date']);
		$deadline = $order_date+$sql_details['product_turnaroundtime']*24*60*60;
		$wholesale_price = number_format($sql_details['order_wholesale_price'],2,'.',',');
		$to = $_CONFIG['email_contact_us'];
		$subject = "Order ID $order_products_id Toon Accepted";	
		$from = $_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
		$header = "From: ".$from."\n";
		$header.= "MIME-Verson: 1.1\n";
		$header.= "Content-type:text/html; charset=iso-8859-1\n";
		$message = "Date:".date("m-d-Y")."<br> Order ID:".$sql_details['order_id']."<br><br>";
		$message.= "The Caricature Toon with Order ID {$sql_details['order_id']} is accepted by the customer and payment can now be made to the artist.<br /><br />";
		$message.= "The details are given below:<br />";
		$message.= "<b> Customer Name       : </b> {$sql_details['cust_fname']} {$sql_details['cust_lname']}<br />";
		$message.= "<b> Artist Name         : </b> {$sql_details['artist_fname']} {$sql_details['artist_lname']}<br />";
		$message.= "<b> Product             : </b> {$sql_details['product_title']}<br />";
	 	$message.= "<b> Wholesale price     : </b> $".$wholesale_price."<br />";
		$message.= "<b> Total Cost          : </b> $".$sql_details['order_price']."<br />";
		$message.= "<b> Order Date          : </b> ".date("m-d-Y",strtotime($sql_details['order_date']))."<br />"; 
		$message.= "<b> Deadline Date       : </b> ".date("m-d-Y",$deadline)."<br />"; 
		$message.= "<b> Order Complete Date : </b> ".date("m-d-Y",strtotime($sql_details['order_completed_date']))."<br />"; 
		mail($to,$subject,$message,$header);
		//end of mail

		$newname=$proof_opro_id.'_'.$proof_img;
		$update_toon_order_products = mysql_query("UPDATE `toon_order_products` SET `opro_caricature` = '$newname' WHERE `opro_id`='$proof_opro_id'");
		
		copy(DIR_PROOF_IMAGES."$proof_img",DIR_CARICATURE_IMAGES."/thumb/$newname");
		copy(DIR_PROOF_IMAGES."$proof_img",DIR_CARICATURE_IMAGES."/regular/$newname");
		copy(DIR_PROOF_IMAGES."$proof_img",DIR_CARICATURE_IMAGES."$newname");
		new imageProcessing(DIR_CARICATURE_IMAGES."/thumb/$newname",120,120);
		new imageProcessing(DIR_CARICATURE_IMAGES."/regular/$newname",600,600);
		
		header("location:appvd.php?opro_id=$proof_opro_id");
	}
	$u_id=$_SESSION['sess_tt_uid'];
	
	$last_uploaded = mysql_query("SELECT * FROM (SELECT O.*,TOP.`opro_id`, TP.`proof_image`,TP.`proof_id` FROM `toon_orders` O, `toon_order_products`TOP, `toon_proofs`TP WHERE O.order_id = TOP.order_id AND TP.opro_id = TOP.opro_id AND O.user_id='$u_id' AND O.order_status='waiting for approval' ORDER BY TP.proof_posted DESC)AS `result`  GROUP BY order_id");
	$num_rows=mysql_num_rows($last_uploaded);	
	
	$u_id=$_SESSION['sess_tt_uid'];
	$artist_image = mysql_query("SELECT * FROM `toon_orders` WHERE user_id='$u_id' AND (order_status='Paid' OR order_status='Work In Progress')");
	$num_rows_artist_image=mysql_num_rows($artist_image);	
	$title_text = "My Caricatures:";
	include (DIR_INCLUDES.'header.php');  
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

	// define the restraining box
	hs.useBox = true;
	hs.width = 280;
	hs.height = 400;

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
	<script type="text/javascript">   
    function conformation(ordrid)
    {	
        if(confirm('Are You 100% Satisfied and Ready to show off your Toon?'))
        {
			window.open ("<?=$_SERVER['HTTP_HOST']?>customerfeedback.php?ordid="+ordrid, "mywindow","location=1,status=1,scrollbars=1,width=700,height=350");
        }
        else
        {
            return false;
        }
    }
    </script>
    <link rel="stylesheet" type="text/css" href="styles/highslide/highslide.css" />
	<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>
    <script type="text/javascript">
    hs.graphicsDir = 'styles/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    hs.wrapperClassName = 'draggable-header';
    </script>
		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
	<?
    if($num_rows!=0||$num_rows_artist_image!=0)
    {
    ?>
        
        <div id="content">
		<?
        while($completed_work = mysql_fetch_array($last_uploaded))
		{
		?>	<div class="my_stuff_final_transition_img" style="padding-top:10px"><img src="images/transition.gif" border="0" alt="Transition Zone" title="Transition Zone" /></div>
			<div style="clear:both">&nbsp;</div>
			<div class="my_stuff_final_toon">
				
                <? 	
					$completed_img	=	$completed_work['proof_image'];
				?>
				<div><img src="<?='includes/imageProcess.php?image='.$completed_work['proof_image'].'&type=proof&size=410&proof=1';?>" border="0"  class="photo_border"/></div>
				<?
				if($completed_img!='')
				{
				?>
				<div class="my_stuff_enlarge_btn"><a href="<?='includes/imageProcess.php?image='.$completed_work['proof_image'].'&type=proof&size=1000';?>" onclick="return hs.expand(this)"><img src="images/enlargebutton2.gif" border="0" alt="enlarge" title="Enlarge" /></a></div>
				<div class="my_stuff_previous_btn"><img src="images/view_previous.gif" border="0" alt="view previous" title="View previous" /></div>
				<div class="view_prev my_stuff_previous_txt" ><a href="p-proof.php?ord_id=<?=$completed_work['order_id']?>" class="view_prev">VIEW PREVIOUS PROOFS</a></div>
				<? }?>
				
			</div>
			<div>
				<div class="my_stuff_final_box_position">
					<div class="float_left"><img src="images/small_box_top_left_curve.gif" /></div>
						<div class="small_box_top_middle_strip mystuff_final_box_middle_strp_properties"></div>
						<div class="my_stuff_final_small_box_right"><img src="images/small_box_top_right_curve.gif" /></div>
						
					 	 <div class="small_box_bg_strip my_stuff_final_content_box_properties">
							
                            <div class="my_stuff_final_approved_img"><? if ($completed_work['proof_id'] !="") { ?> <a href="my-caricature-toons.php?proof_id=<?=$completed_work['proof_id']?>&status=approved" onclick="conformation(<?=$completed_work['order_id']?>)"><img src="images/approved.gif" border="0" alt="approved download and buy products" title="Approved dowload and buy" /></a><? } ?></div>
                            <div class="my_stuff_final_approved_img">
                            <?
                            $is_unread = mysql_num_rows(mysql_query("SELECT * FROM `toon_messages` WHERE `order_id`='".$completed_work['order_id']."' AND `user_id`!='".$_SESSION['sess_tt_uid']."' AND `msg_read`=0"));
							if($is_unread)
								$img_name_append = '_unread';
							else
								$img_name_append = '';
							?>
                            <a href="mess.php?ord_id=<?=$completed_work['order_id']?>"><img src="images/toon_me_up<?=$img_name_append?>.gif" border="0" /></a>
                            </div>
							
                            <!--<div class="my_stuff_final_previous_finishes_img"><img src="images/view_previous.gif" border="0" alt="view communications" title="view"  /></div>
							<div class="register_content_txt my_stuff_final_previous_finishes_txt"><a href="mess.php?ord_id=<?=$completed_work['order_id']?>" class="register_content_txt">VIEW COMMUNICATIONS</a></div>-->
							<div class="my_stuff_final_approved_img"><a href="order-caricature.php"><img src="images/order_another_toon.gif" border="0" alt="order another toon" title="Order another toon" /></a></div>
							<div class="my_stuff_final_previous_finishes_img"><img src="images/view_previous.gif" border="0" alt="view previous Caricatures" title="view Previous Caricatures"/></div>
							<div class="register_content_txt my_stuff_final_previous_finishes_txt"><a href="p-finish.php" class="register_content_txt">VIEW PREVIOUS CARICATURES</a></div>
							<div>&nbsp;</div>
						</div>
						<div class="my_stuff_final_left_top_curve"><img src="images/small_box_btm_left_curve.gif" /></div>
						<div class="small_box_btm_middle_strip mystuff_final_box_middle_strp_properties"></div>
						<div class="float_left"><img src="images/small_box_btm_right_curve.gif" /></div>
				</div>
			</div>
			<div style="clear:both;height:50px">&nbsp;</div>
        <?
        }
		?>
        <div class="clear_both">&nbsp;</div>
        <?
			if($num_rows_artist_image!=0){
			while($rows_orders=mysql_fetch_assoc($artist_image))
			{
			$artist_product_row=mysql_fetch_array(mysql_query("SELECT * FROM `toon_products` WHERE product_id='$rows_orders[product_id]'"));
			$deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD('$rows_orders[order_date]', INTERVAL  '$artist_product_row[product_turnaroundtime]' DAY)"));
			$artist_image_row=mysql_fetch_array(mysql_query("SELECT * FROM `toon_users` WHERE user_id='$rows_orders[artist_id]'"));
			?>	<div class="my_stuff_final_transition_img" style="padding-top:10px"><img src="images/transition.gif" border="0" alt="transition zone" title="Transition zone"/></div>
				<div style="clear:both">&nbsp;</div>
                <div class="my_stuff_final_toon">
                        <div>
						<?
						if($artist_image_row['user_image']!='')
						{
                        ?>
                        <img src="<?='includes/imageProcess.php?image='.$artist_image_row['user_image'].'&type=profile&size=375';?>" border="0"  class="photo_border"/>
                        <?
						}
						else
						{
                        ?>
                        <img src="images/tris.jpg" alt="thanks for your order" title="Thanks for your order" />
                        <?
                        }
						?>
                          <div style="clear:both;">&nbsp;</div>
						  <!--<div align="center"><img src="images/thanks_for_your_order.gif" border="0" /></div>-->
                      	  <div style="padding-bottom:10px;font-family:Rockwell;font-size:17px;color:#009900">Thanks for your Caricature Toons Order. Your Caricaturist  <?=$artist_image_row['user_fname']?> should have your Caricatures drawing ready for your review by <? echo date("m-d-Y",strtotime($deadline[0]));?> </div>
                  </div>
                </div>
                <div>
                    <div class="my_stuff_final_box_position">
                        <div class="float_left"><img src="images/small_box_top_left_curve.gif" /></div>
                            <div class="small_box_top_middle_strip mystuff_final_box_middle_strp_properties"></div>
                            <div class="my_stuff_final_small_box_right"><img src="images/small_box_top_right_curve.gif" /></div>
                            
                             <div class="small_box_bg_strip my_stuff_final_content_box_properties">
                                
                                <div class="my_stuff_final_approved_img">
                                <?
                           		 	$is_unread = mysql_num_rows(mysql_query("SELECT * FROM `toon_messages` WHERE `order_id`='".$rows_orders['order_id']."' AND `user_id`!='".$_SESSION['sess_tt_uid']."' AND `msg_read`=0"));
									if($is_unread)
										$img_name_append = '_unread';
									else
										$img_name_append = '';
								?>
                                <a href="mess.php?ord_id=<?=$rows_orders['order_id']?>"><img src="images/toon_me_up<?=$img_name_append?>.gif" border="0" /></a>
                                </div>
                                
                                <!--<div class="my_stuff_final_previous_finishes_img"><img src="images/view_previous.gif" border="0" /></div>
                                <div class="register_content_txt my_stuff_final_previous_finishes_txt"><a href="m-order.php" class="register_content_txt">VIEW COMMUNICATIONS</a></div> -->
                                <div class="my_stuff_final_approved_img"><a href="order-caricature.php"><img src="images/order_another_toon.gif" border="0"  alt="order another toon" title="Order another toon"/></a></div>
                                <div class="my_stuff_final_previous_finishes_img"><img src="images/view_previous.gif" border="0" alt="View Previous Toons" title="View Previous Toons"/></div>
                                <div class="register_content_txt my_stuff_final_previous_finishes_txt"><a href="p-finish.php" class="register_content_txt">VIEW PREVIOUS TOONS</a></div>
                                <div>&nbsp;</div>
                            </div>
                            <div class="my_stuff_final_left_top_curve"><img src="images/small_box_btm_left_curve.gif" /></div>
                            <div class="small_box_btm_middle_strip mystuff_final_box_middle_strp_properties"></div>
                            <div class="float_left"><img src="images/small_box_btm_right_curve.gif" /></div>
                    </div>
                </div>
                <div style="clear:both;height:100px">&nbsp;</div>
            <? 
			}
			}
		?>
        </div>
	<?
    }
    else
    {
    ?>
        <div id="content">
		<? 	
			
			if($num_rows_artist_image==0)
			{
			?>
            
            <div class="my_stuff_final_toon">
            
				<div class="my_stuff_final_div_height"></div>
                	
                    <div><a href="order-caricature.php"><img src="images/captoon.png" border="0" alt="the captoon wants to toon you up" title="Captoon"/></a><div style="clear:both;">&nbsp;</div>
                    <div style="padding-bottom:10px;margin-left:10px" class="orange_txt" align="center"><a href="order-caricature.php"><img src="images/Order-Your-Toon-Today!.png" border="0" alt="order your toons today" title="Order your toons today"/></a></div>
                    <div style="clear:both;width:280px;float:left;text-align:center;margin-left:10px">
                      <a href="" onclick="return hs.htmlExpand(this,{headingText: 'Current Deals'})"><img border="0" src="images/current_deals_bn.gif" alt="current deals" title="Current deals" /></a>
                      <div class="highslide-maincontent">
					<? include("includes/special_offers_popup.php");?>
                    </div>
                    </div>
                </div>
			</div>
			<div>
				<div class="my_stuff_final_profile_settings_img">&nbsp;</div>
				<div class="my_stuff_final_transition_img"><img src="images/transition.gif" border="0" alt="transition zone" title="Transition zone" /></div>
				<div class="my_stuff_final_box_position">
					<div class="float_left"><img src="images/small_box_top_left_curve.gif" /></div>
						<div class="small_box_top_middle_strip mystuff_final_box_middle_strp_properties"></div>
						<div class="my_stuff_final_small_box_right"><img src="images/small_box_top_right_curve.gif" /></div>
						
					 	 <div class="small_box_bg_strip my_stuff_final_content_box_properties">
							
                            <div class="my_stuff_final_approved_img"><a href="m-order.php"><img src="images/toon_me_up.gif" border="0" alt="talk to your toonist" title="Talk to your toonist" /></a></div>
							
                            <!--<div class="my_stuff_final_previous_finishes_img"><img src="images/view_previous.gif" border="0" /></div>
							<div class="register_content_txt my_stuff_final_previous_finishes_txt"><a href="m-order.php" class="register_content_txt">VIEW COMMUNICATIONS</a></div> -->
							<div class="my_stuff_final_approved_img"><a href="order-caricature.php"><img src="images/order_another_toon.gif" border="0" alt="order another toon" title="Order another toon" /></a></div>
							<div class="my_stuff_final_previous_finishes_img"><img src="images/view_previous.gif" border="0" alt="View Previous Toons" title="View Previous Toons" /></div>
							<div class="register_content_txt my_stuff_final_previous_finishes_txt"><a href="p-finish.php" class="register_content_txt">VIEW PREVIOUS TOONS</a></div>
							<div>&nbsp;</div>
						</div>
						<div class="my_stuff_final_left_top_curve"><img src="images/small_box_btm_left_curve.gif" /></div>
						<div class="small_box_btm_middle_strip mystuff_final_box_middle_strp_properties"></div>
						<div class="float_left"><img src="images/small_box_btm_right_curve.gif" /></div>
				</div>
			</div>
            <div style="clear:both;height:100px">&nbsp;</div>
            <?
			}
			?>
			<div class="clear_both"></div>
		</div>
	<?
    }
    ?>
        
		<!--content ends-->	
		<!--footer-->	
<? include ('includes/footer.php');?>