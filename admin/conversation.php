<? 
include('includes/configuration.php');
	$order_id=$_REQUEST['order_id'];
	$sql_conversation="SELECT *,DATE_FORMAT(`msg_posted`, '%m-%d-%Y') as `date`FROM `toon_messages` WHERE `order_id` = '$order_id' ORDER BY `msg_posted` ASC";
   	$rs_conversation = mysql_query($sql_conversation);
	
include ('includes/header.php');
?>
<link rel="stylesheet" type="text/css" href="../styles/highslide.css" />
<script type="text/javascript" src="../javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
	hs.graphicsDir = '../images/graphics/';
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
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center" valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" height="30" width="100%" colspan="4">Conversation</td></tr>
      <tr><td height="40px;"></td></tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
			<table width="100%" cellpadding="0" cellspacing="0">  
			 <? while($conversation=mysql_fetch_assoc($rs_conversation))
	          {  
			  	 $name=mysql_fetch_assoc(mysql_query("SELECT concat(`user_fname`,' ',`user_lname`)as name FROM `toon_users` WHERE `user_id`='$conversation[user_id]'"));
				$attachment=$conversation['msg_attachment'];
				$file=explode('.',$attachment);
				$ext=$file[1];
	         ?>                          
		  		<tr>
                <td width="25%"class="table_details"  valign="top"><?=$name['name']?> :</td>
                <td class="message" >
                <? if($attachment)
					{
						if(in_array($ext, getoption_values('image_types')))
						{?>
                			<a href="<?=DIR_MESSAGING_IMAGES.$attachment;?>"onclick="return hs.expand(this)"><img src="<?='../includes/imageProcess.php?image='.$attachment.'&type=messaging&size=30';?>" border="0"/></a></br><?
					    }else
						{?>
                        	<a href="<?=DIR_MESSAGING_IMAGES.$attachment;?>"><img src="images/generic.gif" border="0" /></a></br>
               		 <? }
					}?><?=$conversation['msg_body']?></td>
                    
				</tr>
				<tr>
                <td width="25%">&nbsp;</td>
				<td align="left" class="msg_date">Posted On:&nbsp;<?=$conversation['date']?></td>
				</tr>
			
			<? }?>                  
		
				<tr>
					<td height="5"></td>
				</tr>
			</table>
		</td>
      <td width="2%">&nbsp;</td>
     </tr>
     <tr><td height="40" colspan="4"></td></tr>
   </table>
  </td>
 </tr>
</table>
