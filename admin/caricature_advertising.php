<?  include('includes/configuration.php');
	include ('includes/header.php');
	include_once("includes/paging.class.php");
	
	$qry_string="";
			
	function getUserName($user_id)
	{
		$sql_user="SELECT * FROM toon_users WHERE user_id=".$user_id;
		$res_user=mysql_query($sql_user); 
		$row_user=mysql_fetch_array($res_user);
		$user_full_name=$row_user['user_fname'].' '.$row_user['user_lname'];
		return $user_full_name;
	}
?>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center" valign="top">
	    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Completed Caricature</td>
          </tr>
		  <tr>
		  	<td style="padding:0 0 30px 0;">
				<?php
				
				$sql_orders="SELECT * FROM toon_orders WHERE (order_status='Completed' OR order_status='artist paid') ORDER BY `order_id` ASC";
				$res_orders = mysql_query($sql_orders);
				while($row_orders = mysql_fetch_assoc($res_orders))
				{				
				$proof_image_query=mysql_query("SELECT TPI.* FROM toon_order_products TOP, toon_proofs TPI,toon_orders OT WHERE TOP.order_id = '".$row_orders['order_id']."' AND TOP.opro_id = TPI.opro_id AND (OT.order_status='Completed' OR OT.order_status='artist paid') ORDER BY  `TPI`.`proof_id` DESC LIMIT 0 , 1");	
				$proof_image_result=mysql_fetch_assoc($proof_image_query);
				?>
				<div style="float:left;padding:30px 0 15px 21px;width:225px;">
					<div style="float:left; padding-right:2px;" class="adv_order_detail_headings">Order Id : </div><div class="adv_order_details"><?=$row_orders['order_id']?></div>
					<div style="float:left; padding-right:2px;" class="adv_order_detail_headings">Customer : </div><div class="adv_order_details"><?=getUserName($row_orders['user_id']);?></div>
					<div style="float:left; padding-right:2px; padding-bottom:15px;" class="adv_order_detail_headings">Artist : </div><div class="adv_order_details"><?=getUserName($row_orders['artist_id']);?></div>
					<?php if($proof_image_result['proof_image']!='' && file_exists("../z_uploads/proof_images/".$proof_image_result['proof_image'])) { ?>
						<img src="../z_uploads/proof_images/<?=$proof_image_result['proof_image']?>" height="255" width="204">
					<?php } else { ?>
						<img src="../z_uploads/proof_images/noimage.gif" height="255" width="204">
					<?php } ?>
				</div>
				<?php	
				}
				?>
		  	</td>
		  </tr>
        </table>
	  </td>
    </tr>
</table>
<?	include("includes/footer.php");?>