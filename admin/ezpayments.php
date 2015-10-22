<?
include('includes/configuration.php');
$ezopro_id=$_REQUEST['ezopro_id'];
$sortbydate=$_REQUEST['sort_check'];
$first_date=$_REQUEST['first_date'];
$last_date=$_REQUEST['last_date'];
$status_sort=$_REQUEST['orderstatus'];
$searchword = $_REQUEST['Search_box'];

$sql_content = "SELECT TEOP.*,TC.cart_array,TC.promo_code,TP.ezpayment_amount,TP.ezpayment_date
			FROM `toon_ez_order_products` TEOP,`toon_cart` TC ,`toon_ez_payments`TP
			WHERE TEOP.`cart_id`= TC.`cart_id` 
			AND TP.ezopro_id = TEOP.ezopro_id";
			
if($searchword!=''&&$searchword!='Enter keyword')
	{									
	$sql_append=" AND TEOP.`ezopro_id` LIKE '$searchword'";
	}
	if($status_sort)
	{									
	$sql_append.=" AND TEOP.ezopro_ez_paymentstatus='$status_sort'";
	}
	if($first_date!=""&&$last_date!=""&&$sortbydate=='date_range')
	{									
	$sql_append.=" AND TP.ezpayment_date BETWEEN '$first_date' AND '$last_date' ";
	}		
	//echo $sql_content.$sql_append;	
$rs_content = mysql_query($sql_content.$sql_append);
if(isset($_POST['download']))
		{	
			$exel_headding="Ord. No. \t Wholesale Price \t Retail Price \t Ez Prints Paymnet Status \t Date \t <:nextline:> ";
			for($val=0;$val<=$_POST['content_no'];$val++)
			{
				$exel_content.=$_POST['excel_data'.$val];
			}
			$filename ="Ez Payments".date('dMy').".xls";
			$contents1=$exel_headding.$exel_content;
			$contents = str_replace("<:nextline:>","\n",$contents1);
			header('Content-type: application/ms-excel');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $contents;
			exit();
		
	   }
include ('includes/header.php');
?>
<link rel="stylesheet" href="styles/datechooser.css" type="text/css" />
<script language="javascript" type="text/javascript" src="javascripts/datechooser.js"></script>
<script language="javascript" type="text/javascript" src="javascripts/date-functions.js"></script>
<script type="text/javascript">
function show_confirm()
{
	var r=confirm("Do you really want to delete this order?");
	return r;
    
}
function search_default()
{
	document.getElementById('Search_box').value='';
}
function search_set()
{
	if(document.getElementById('Search_box').value=='')
		document.getElementById('Search_box').value='Enter keyword';
}
</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
	<td height="40px;"></td>
    <td>
    <form name="calender" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <table cellpadding="0" cellspacing="2" width="100%">
        	<tr>
            	<td colspan="2"><input type="checkbox" value="date_range" <? if($sortbydate){?> checked="checked"<? }?> name="sort_check" id="sort_check" /> Sort By Date Range
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <input type="text" name="first_date" id="first_date" value="<?=$first_date?>" readonly="readonly" />
                    <img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'first_date', 'cal_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="cal_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 155px"></div>
             </td>
             <td style="padding-left:159px">
                   <select onchange="document.calender.submit()" id="orderstatus" name="orderstatus">
                        <option value="">All</option>
                        <option value="Paid" <? if($status_sort=='Paid') { echo 'selected="selected"';}?>>EZ Prints Paid</option>
                        <option value="Not Paid" <? if($status_sort=='Not Paid') { echo 'selected="selected"';}?>>EZ Prints Not Paid</option>
                    </select>
                
                </td>
            </tr>
            <tr>
            	<td width="50%">
                    <input type="text" value="<?=$last_date?>" id="last_date" name="last_date" readonly="readonly" />
                    <img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'last_date', 'last_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="last_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 155px"></div>
                </td>
                 
                <td align="right">
                <input id="Search_box" name="Search_box" class="textField_search" value="<? if($searchword) {echo $searchword;}else{ echo "Enter keyword";} ?>" type="text" onClick="search_default()" onBlur="search_set()">
                <input style="vertical-align:inherit;" type="image" src="images/search.gif">
                </td>
            </tr>
             
        </table>
    </form>
    </td>
 </tr>
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center" valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" height="30" width="100%" colspan="4">EZ products Payments</td></tr>
      <tr><td height="40px;"></td></tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			$count=mysql_num_rows($rs_content);
			if ($count)
			{?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
      <tr class="heading_bg">
      	  <td class="sub_heading" align="left">Order Id</td>
          <td class="sub_heading" align="left">Wholesale Price</td>
          <td class="sub_heading" align="left">Retail Price</td>
          <!--<td class="sub_heading" align="left">Shipping Price</td>-->
		  <td class="sub_heading" align="left">Ez Prints Payment Status</td>
		  <td class="sub_heading" align="left">Date</td>
          <td class="sub_heading">Actions</td>
	 </tr>
       <?
	   while($content=mysql_fetch_assoc($rs_content))
			{
			$cart_array=unserialize(base64_decode($content['cart_array']));
			//print_r($cart_array);
			$total=0;
			$total_wholesale_price=0;
			foreach($cart_array as $name)
			{
			$total+=$name['totalprice'];
			$total_wholesale_price+=$name['ezproduct_wholesaleprice']*$name['number'];
			
			}
			//$discount_sql=mysql_query("SELECT * FROM `toon_promo` WHERE `promo_code`='".$content['promo_code']."'");
//			$disc_num_rows=mysql_num_rows($discount_sql);
//			$discount_rs=mysql_fetch_array($discount_sql);
//			if($disc_num_rows!=0&&$total>$discount_rs['promo_amount'])
//				{
//					if($discount_rs['promo_type']==0)
//						{
//							$discount=($total * $discount_rs['promo_discount'])/100;
//						}
//					else
//						{
//							$discount=$discount_rs['promo_discount'];
//						}
//				}
//			echo $discount;				
			//echo $content['ezpayment_amount'];
	   ?>
        <tr>
          <td align="left" class="table_details" ><?=$content['ezopro_id']?></td>
          <td align="left" class="table_details" ><?=number_format($total_wholesale_price,2)?></td>
		   <td align="left" class="table_details" ><?=number_format($total,2)?></td>
           <!--<td align="left" class="table_details" ><?=number_format($content['ezpayment_amount']-$total,2)?></td>-->
           <td align="left" class="table_details" ><?=$content['ezopro_ez_paymentstatus']?></td>
		  <td align="left" class="table_details" ><? echo date('m-d-Y',strtotime($content['ezpayment_date']))?></td>
          <td align="left" class="table_details"><a href="ezorder_details.php?ezopro_id=<?=$content['ezopro_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="View order details" alt="View order details" /></a>
		  </td>
        </tr>
        <?
		 $excel_content=$content['ezopro_id']."\t".number_format($total_wholesale_price,2)."\t".number_format($total,2)."\t".$content['ezopro_ez_paymentstatus']."\t".date('m-d-Y',strtotime($content['ezpayment_date']))."\t <:nextline:>";
		 $i++;
		?>
		 <input type="hidden" value="<? echo str_replace('"',"",$excel_content);?>" name="excel_data<?=$i?>" />
		<?
	   }?>
        <input type="hidden" name="content_no" value="<?=$i?>" />
         <tr>
          <td height="40" colspan="4"></td><td><input type="submit" name="download" value="Download" /></td>
        </tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table>
     </form>
	    <? }else
			{?>
				<table align="center">
			<tr>
				<td class="no_details_msg">No Payments</td>
			</tr>
		</table>
			<? } ?>
	   </td>
      <td width="2%">&nbsp;</td>
    </tr>
      <tr><td height="40" colspan="4"></td></tr>
   </table>
  </td>
 </tr>
</table>
<?	include("includes/footer.php");?>