<?
		include('includes/configuration.php');
		$sql_message="SELECT m.user_id,o.*,p.product_title FROM  toon_messages m,toon_orders o,toon_products p WHERE m.order_id=o.order_id GROUP BY m.order_id ORDER BY m.`msg_posted` DESC";
	 	$rs_message=mysql_query($sql_message);
	 	include ('includes/header.php');
?>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" width="100%" colspan="4">Messages</td>
        </tr>
        <tr>
          <td height="40px;"></td>
        </tr>
        <tr>
          <td width="2%">&nbsp;</td>
          <td align="center">
		  <?
			$number=mysql_num_rows($rs_message);
			if ($number!=0)
			{
		?>
            <table cellpadding="2" cellspacing="0" width="94%" class="table_border" >
              <tr class="heading_bg">
			   <td class="sub_heading" height="30">Product Name</td>
                <td class="sub_heading" height="30">Customer Name</td>
                <td class="sub_heading" height="30">Artist Name</td>
                <td class="sub_heading" height="30">Price($)</td>
                <td class="sub_heading" height="30">Messages</td>
              </tr>
              <?
	   while($row_message=mysql_fetch_assoc($rs_message))
	   {
	    	
	  		$customer=mysql_fetch_assoc(mysql_query("SELECT concat(`user_fname`,' ',`user_lname`)as name FROM `toon_users` WHERE `user_id`='$row_message[user_id]'"));
			$artist=mysql_fetch_assoc(mysql_query("SELECT concat(`user_fname`,' ',`user_lname`)as name FROM `toon_users` WHERE `user_id`='$row_message[artist_id]'"));

	   ?>
              <tr>
			  <td align="left" class="table_details"><?=$row_message['product_title']?></td>
                <td align="left" class="table_details"><?=$customer['name']?></td>
                <td align="left" class="table_details"><?=$artist['name']?>
                </td>
                <td align="left" class="table_details"><?=$row_message['order_price']?></td>
                <td align="left" class="table_details"><a href="conversation.php?order_id=<?=$row_message['order_id']?>" class="anger_tags"><img border="0" src="images/mail.gif" title="messages" alt="message" /></a> </td>
              </tr>
              <?
	   }
       ?>
              <tr>
                <td height="40" colspan="4"></td>
              </tr>
            </table>
            <?
		}
		else
		{
		?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Messages!</td>
              </tr>
            </table>
            <? } ?>
          </td>
          <td width="2%">&nbsp;</td>
        </tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
