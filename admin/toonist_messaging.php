<? 	
include('includes/configuration.php');
$order_id  = $_REQUEST['ord_id'];
if(!$order_id)
header("Location:orders.php");
$toon_orders = toon_orders($order_id);
$mysql_msg_query = mysql_query("SELECT concat(u.user_fname,' ',u.user_lname)as name,u.utype_id, m.msg_body, m.msg_attachment, m.msg_posted FROM toon_users u, toon_messages m WHERE u.user_id=m.user_id AND m.order_id='$order_id' ORDER BY m.msg_posted DESC");//For ordering the latest messages by posted date
$number_row=mysql_num_rows($mysql_msg_query);
include ('includes/header.php');
?> 

<!--header ends-->
<!--content starts-->
<link rel="stylesheet" type="text/css" href="../styles/highslide.css" />
<script type="text/javascript" src="../javascripts/highslide-with-html.js"></script>
<script type="text/javascript" src="../javascripts/highslide-full.js"></script>
<script type="text/javascript">
	hs.graphicsDir = '../images/graphics/';
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

<!--content ends-->	
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td valign="top">
	  <table cellpadding="0" cellspacing="0" width="97%">
		<tr>
			<td width="2%"><img src="images/left_top.gif" /></td>
			<td class="leftnav_border_top">&nbsp; </td>
			<td width="2%"><img src="images/right_top.gif" /></td>
		</tr>
		<tr>
        	<td class="leftnavborderleft">&nbsp;</td>
			<? if($number_row!=0) {?>
			
			<td>
			<? while($toon_messages=mysql_fetch_assoc($mysql_msg_query)) 
		 { ?>
		<table cellspacing="2" cellpadding="2">
			<tr>
				<td>
				<? if($toon_messages['utype_id']==3) { ?><span style="color:#FF0000;font-weight:bold;"><? echo $toon_messages['name'];?></span><? } else { ?><span style="color:#000099;font-weight:bold;"><? echo $toon_messages['name'];?></span><? }?><br/><? echo $toon_messages['msg_body'];?>
				</td>
			</tr><!--Displays user name & message content-->
			
			<? $msg_attachment=$toon_messages['msg_attachment'];
			   $file=explode('.',$msg_attachment);
			   $ext=$file[1];//Extention of the file attached
				if($msg_attachment)
				{?>
			<tr>
				<td>
				<?
					if(in_array($ext, getoption_values('image_types')))//Checks whether the attachment is an image file
					{ ?> 
						<a href="../z_uploads/messaging_images/<?=$msg_attachment?>" onclick="return hs.expand(this)"><img src="<?='../includes/imageProcess.php?image='.$msg_attachment.'&type=messaging&size=100';?>" border="0"/></a>&nbsp;&nbsp;<!--Displays attached image with pop-up--> 			
					<? } 
					else
					{ ?>
						<a href="../z_uploads/messaging_images/<?=$msg_attachment;?>"><img src="../images/generic.gif" border="0" /></a>&nbsp;&nbsp;<a href="../z_uploads/messaging_images/<?=$msg_attachment?>"><span style="font-size:12px;"><? echo $msg_attachment;?></span></a><!--Displays document image-->
					<? }?>
				</td>
			</tr>
            <tr><td><a href="../save_msg_image.php?image=<?=$msg_attachment?>">Download</a></td></tr>	
				<? }	?>
				
			<tr>
				<td>Date : <? echo $toon_messages['msg_posted'];?><!--Displays message posted date-->
				</td>
			</tr>
		</table>
		<? }?>
			</td>	
			<? } else {?>
			<td align="center" style="font-family:Arial, Helvetica, sans-serif;color:#FF3300" height="200"> No Messages </td><? }?>
            <td class="leftnavborderright">&nbsp;</td>
		</tr>  
		<tr>
			<td ><img src="images/btm_left.gif" /></td>
			<td class="leftnav_border_bottom">&nbsp;</td>
			<td><img src="images/btm_right.gif" /></td>
		</tr>
	</table>
  </td>
 </tr>
</table>
<!--footer-->	
<?
include ('includes/footer.php');

?>