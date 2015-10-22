<? 	
include("includes/configuration.php");
include (DIR_INCLUDES.'header.php');
if(!isloggedIn())
{
	header('Location:alogin.php');
	exit();
}
$user_id=$_SESSION['sess_tt_uid'];

//select all caricature
$select_toon_orders = mysql_query("SELECT * FROM `toon_orders` WHERE `user_id`='$user_id' AND (`order_status`= 'Paid' OR `order_status`= 'Work In Progress' OR `order_status`= 'waiting for approval') ORDER BY `order_date` DESC");
?> 

<!--header ends-->
<link rel="stylesheet" type="text/css" href="styles/highslide.css" />
<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
	hs.graphicsDir = 'images/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
	</script>
<style type="text/css">
.border_line{	
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #E2E2E2;
}
</style>
<!--content starts-->

<div id="content">
	<div class="height80"></div>
	
	<div style="height:20px;"></div>
	<div>
		<div class="buy_now_curvepadding contact_margin"><img src="images/white_curve_top_left.gif" /></div>
		<div class="buy_now_white_curve_top_middle_strip previous_whiteCurve_middle_strip"></div>
		<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
		<div class="finish_white_curve_middle_border contact_margin_both">
			<h3 style="color:#ff6e00; font-family:Arial, Helvetica, sans-serif; padding-left:10px; padding-top:0px; margin:0 0 0 0;" align="center" >MY ORDERS</h3>
			<div>
			<div class="border_line"></div>
			<?  
				while($details_toon_orders=mysql_fetch_assoc($select_toon_orders))
				{	
					$order_id = $details_toon_orders['order_id'];
					$select_order_products = mysql_query("SELECT * FROM `toon_order_products` WHERE `order_id`='$order_id'");
					while($details_order_products = mysql_fetch_assoc($select_order_products)) {
					 ?>
                        <div  style="height:10px;vertical-align:middle"></div>
                        <div  class="contact_artist_box_left_margin" style="clear:both;margin-bottom:35px;">
                            <div style="float:left;width:300px;">
                            <div style="margin-left:60px;vertical-align:middle;" class="contact_artist_message_txt" ><br/><b>Order ID #</b> <? echo $details_order_products['order_id'];?> <br/><b>Date :</b> <?=date('m-d-Y',strtotime($details_toon_orders['order_date'])); ?></div>
                            
                            </div>
                            <div style="height:20px;float:right;padding-right:25px;width:200px;" align="center">
                            
                            <?	if($details_toon_orders['order_status'] == 'Pending')
									{ ?>
									<div class="text_greenbold" align="center">Pending</div>
									<div align="center"><a href="chkout.php?ord_id=<?=$details_order_products['order_id']?>">Pay Now</a></div>
								<?	}
								else if($details_toon_orders['order_status'] == 'Completed' )
									{ ?>
									<div class="text_blue" align="center"><b><?= $details_toon_orders['order_status'];?></b></div>
									<div>
                                    <form action="reciept.php?ord_id=<?=$details_order_products['order_id']?>" method="post" name="billing_info">
                                    <input type="image" style="margin-top:10px;" src="images/printer_icon.gif" title="Print Receipt" />
                                    <input type="hidden" name="payment" value="1" />
                                    </form>
                                    </div>
								<?	}
								else
									{
									$getuserDetails 	  = getUserDetails($details_toon_orders['artist_id']);
									 ?>
                            	<div align="center"><span class="text_blue"><b><?=ucfirst($details_toon_orders['order_status'])?></b></span><br />
                                    <div style="float:left;padding-left:50px">&nbsp;
                                    <? if($getuserDetails['user_delete']=='0')
										{
											$is_unread = mysql_num_rows(mysql_query("SELECT * FROM `toon_messages` WHERE `order_id`='".$details_order_products['order_id']."' AND `user_id`!='".$_SESSION['sess_tt_uid']."' AND `msg_read`=0"));
											if($is_unread)
												$img_name_append = '_unread';
											else
												$img_name_append = '';
									?>
                                    <a href="mess.php?ord_id=<? echo $details_order_products['order_id'];?>"  class=""><img src="images/mail<?=$img_name_append?>.gif" border="0" title="Messages"/></a>
                                    <? }?>
                                    </div>
                             	    <form action="reciept.php?ord_id=<?=$details_order_products['order_id']?>" method="post" name="billing_info">
                                    <div style="float:left;padding-left:15px;padding-top:10px">
                                    <input type="image" src="images/printer_icon.gif" title="Print Receipt" />
                                    </div>
                                    <input type="hidden" name="payment" value="0" />
                                    </form>
                                </div>
                           <?	}
                            ?>	
                            </div>
                        </div>
                        <div style="height:10px;clear:both" class="border_line"></div>
				<? } }
				if(count($details_order_products) == 0) { ?><div style="height:20px;"></div><div class="text_blue" align="center"> YOU HAVE NOT YET MADE ANY ORDERS </div> 
				 <div style="height:20px;" align="center" ><a href="order-caricature.php" style="font-family:Helvetica, Verdana, Arial, sans-serif">ORDER NOW</a></div>
				<?
				}
				?>
			</div>
			<div class="contact_artist_space">&nbsp;</div>
		</div>
		<div>
			<div class="buy_now_curvepadding contact_margin"><img src="images/contact_btm_left_curve.gif" /></div>
			<div class="white_btm_middle_strip previous_whiteCurve_middle_strip"></div>
			<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
		</div>
        <div style="clear:both;height:50px;">&nbsp;</div>
	</div>
	<div>&nbsp;</div>
</div>
<!--content ends-->	
<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>