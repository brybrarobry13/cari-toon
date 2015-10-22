<?
	$offers_query = mysql_query("SELECT * FROM `toon_promo` WHERE `promo_expiry` > current_date() and `promo_product_type`='Toon product' and `promo_display`='1' ORDER BY `promo_id` DESC");
	$number=mysql_num_rows($offers_query);
	$offers_ez_query = mysql_query("SELECT * FROM `toon_promo` WHERE `promo_expiry` > current_date() and `promo_product_type`='ez product' and `promo_display`='1' ORDER BY `promo_id` DESC");
	$number_ez=mysql_num_rows($offers_ez_query);
	
	$spo_query = mysql_query("SELECT * FROM `toon_special_offers` WHERE current_date() BETWEEN `spo_startdate` AND `spo_enddate` AND `spo_product`='Toon product'");
	$number_spo=mysql_num_rows($spo_query);
	$spo_ez_query = mysql_query("SELECT * FROM `toon_special_offers` WHERE current_date() BETWEEN `spo_startdate` AND `spo_enddate` AND `spo_product`='ez product'");
	$number_spo_ez=mysql_num_rows($spo_ez_query);
	
	if($number!=0 || $number_ez!=0 || $number_spo!=0 || $number_spo_ez!=0)
	{
?>			            
        <table width="100%">
            <? if($number_spo!=0)
			{?>
                <tr><td align="left" colspan="3" class="text_blue"><b>Toons Products</b></td></tr>
                <? while($spo_row=mysql_fetch_array($spo_query))
                {
                ?>
                	<tr><td>&nbsp;</td><td style="clear:both;margin-left:40px;color:#ff6e01;font-family:Arial, Helvetica, sans-serif;font-size:12px;margin-right:20px; text-align:left;"><?=$spo_row['spo_title']?> : <?=$spo_row['spo_description']?></td></tr>
                <? 
                }
			}?>
            <? if($number!=0 && $number_spo==0)
			{?>
                <tr><td align="left" colspan="3" class="text_blue"><b>Toons Products</b></td></tr>
                <? while($offers_row=mysql_fetch_array($offers_query))
				{?>
                    <tr><td>&nbsp;</td><td align="left" class="text_blue">
                    <?=$offers_row['promo_discount']; if($offers_row['promo_type']==0) { echo ' %';}else {echo ' $';}?> off on orders <? if($offers_row['promo_amount']!=0){?> over $<?=$offers_row['promo_amount'];}?></td><td class="text_blue" align="left">
                    Promo Code : <?=$offers_row['promo_code'];?>
                    </td></tr>
             	<? 
			 	}
			}?>
            
            
            <? if($number_spo_ez!=0)
			{?>
                <tr><td align="left" colspan="3" class="text_blue"><b> EZ Products</b></td></tr>
                <? while($spo_ez_row=mysql_fetch_array($spo_ez_query))
				{?>
              		<tr><td>&nbsp;</td><td style="clear:both;margin-left:40px;color:#ff6e01;font-family:Arial, Helvetica, sans-serif;font-size:12px;margin-right:20px; text-align:left;"><?=$spo_ez_row['spo_title']?> : <?=$spo_ez_row['spo_description']?></td></tr>
             <? }
			}?>
            <? if($number_ez!=0 && $number_spo_ez==0)
			{?>
                <tr><td align="center" colspan="3" class="text_blue"><b> EZ Products</b>
				</td></tr>
                <? while($offers_ez_row=mysql_fetch_array($offers_ez_query))
				{?>
                    <tr><td>&nbsp;</td><td align="left" class="text_blue">
                    <?=$offers_ez_row['promo_discount']; if($offers_ez_row['promo_type']==0) { echo ' %';}else {echo ' $';}?> off on orders <? if($offers_ez_row['promo_amount']!=0){?> over $<?=$offers_ez_row['promo_amount'];}?></td><td class="text_blue" align="left">
                    Promo Code : <?=$offers_ez_row['promo_code'];?>
                    </td></tr>
             <? }
			}?>
        </table>
 <? } 
	//else 
	//{?>
      <!-- <table><tr><td height="30" class="text_blue">No current offers</td></tr></table>-->
						 		
  <? //}?>