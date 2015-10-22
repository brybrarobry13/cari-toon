<?
	include('includes/configuration.php');
	//TO DELETE CLASSMATES
	$sortby=$_REQUEST['sortby'];
	$sortorder=$_REQUEST['sortorder'];
	if($sortorder=='ascending')
	{
	$sort_order='ASC';
	}
	else
	{
	$sort_order='DESC';
	}
	if($sortby=='name')
	{
	$sort_by='user_fname';
	}
	elseif($sortby=='email')
	{
	$sort_by='user_email';
	}
	elseif($sortby==Totalspend)
	{
	$sort_by='SUM( `SUM` )';
	}
	elseif($sortby==joined)
	{
	$sort_by='user_joined';
	}
	else
	{
	$sort_by='user_joined';
	}
	$user_id=$_REQUEST['user_id'];
	if($user_id)
	{
		$del_query="UPDATE `toon_users` SET `user_delete` = '1' where user_id='$user_id'";
		mysql_query($del_query);
    }	
	
	$sql_content="SELECT *, SUM(`sum`)  FROM (SELECT TU. * , SUM( T.order_price ) as `sum` , DATE_FORMAT( `user_joined` , '%m-%d-%y' ) AS `joined_date`,'order' AS `type` FROM `toon_users` TU LEFT JOIN `toon_orders` T ON ( T.user_id = TU.user_id AND T.order_status!='Pending' ) WHERE `utype_id` =3 AND `user_delete`=0 GROUP BY TU.user_id UNION SELECT TU. *,SUM( E.ezopro_totalprice ) as `sum`, DATE_FORMAT( `user_joined` , '%m-%d-%y' ) AS `joined_date`,'ezp' AS `type` FROM `toon_users` TU LEFT JOIN `toon_ez_order_products` E ON(TU.user_id = E.user_id AND E.ezopro_paymentstatus='Paid')  WHERE `utype_id` =3 AND `user_delete`=0 GROUP BY TU.user_id)AS result GROUP BY user_id ORDER BY $sort_by $sort_order";
	
	
	
	$rs_content = mysql_query($sql_content);
	if(isset($_POST['download']))
		{	
			$exel_headding="Name \t Email \t Total Spend  \t Joined On \t <:nextline:> ";
			$exel_content="";
			for($val=0;$val<=$_POST['content_no'];$val++)
			{
				$exel_content.=$_POST['excel_data'.$val];
			}
		$filename ="Customers".date('dMy').".xls";
		$contents1=$exel_headding.$exel_content;
		$contents = str_replace("<:nextline:>","\n",$contents1);
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $contents;
		exit();
		
		}
	include ('includes/header.php');
	?>
	<script>
function confirmation()
{
	if(confirm("Do you really want to delete?"))
	{
		return true;
	}
	return false;	
}
</script>
<form action="customers.php" method="post">
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center" valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" width="100%" colspan="4">Customers</td></tr>
      <tr><td height="40px;"></td></tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			$count=mysql_num_rows($rs_content);
			if ($count)
			{?>
				<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
      <tr class="heading_bg">
          <td class="sub_heading"><a class="sub_heading" style="padding-left:0px" href="customers.php?sortby=name&sortorder=<? if($sort_order=='DESC'){echo 'ascending';}else{echo 'descending';}?>">Name</a></td>
          <td class="sub_heading"><a class="sub_heading" style="padding-left:0px" href="customers.php?sortby=email&sortorder=<? if($sort_order=='DESC'){echo 'ascending';}else{echo 'descending';}?>" >Email</a></td>
          <td class="sub_heading"><a class="sub_heading" style="padding-left:0px" href="customers.php?sortby=Totalspend&sortorder=<? if($sort_order=='DESC'){echo 'ascending';}else{echo 'descending';}?>" >Total Spend</a></td>
		  <td class="sub_heading"><a class="sub_heading" style="padding-left:0px" href="customers.php?sortby=joined&sortorder=<? if($sort_order=='DESC'){echo 'ascending';}else{echo 'descending';}?>" >Joined On</a></td>
          <td class="sub_heading">Actions</td>
      </tr>
       <?
	   while($content=mysql_fetch_assoc($rs_content))
	   {
	   ?>
        <tr>
          <td align="left" class="table_details"><?=$content['user_fname'].' '.$content['user_lname']?></td>
          <td align="left" class="table_details"><?=$content['user_email']?></td>
          <td align="left" class="table_details"><a href="purchase_history.php?user_id=<?=$content['user_id'];?>"><? if($content['SUM(`sum`)']!=''){echo '$ ';}?> <?=number_format($content['SUM(`sum`)'],2,'.',',');?></a></td>
		  <td align="left" class="table_details"><?=$content['joined_date']?></td>
          <td align="left" class="table_details"><a href="edit_customer.php?user_id=<?=$content['user_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify the Profile" alt="Modify the Profile" /></a>  <a onclick="return confirmation()"href="customers.php?user_id=<?=$content['user_id'];?>&del"><img border="0" src="images/delete.png" title="Delete this Customer" alt="Delete this Customer"/></a></td>
        </tr>
        <?
		if($content['SUM(`sum`)']!='')
		{
		$total= '$ '.round($content['SUM(`sum`)'],2);
		}
		else
		{
		$total='-';
		}
        $excel_content=$content['user_fname']." ".$content['user_lname']."\t".$content['user_email']."\t".$total."\t".$content['joined_date']."\t <:nextline:>";
        $i++;
		?>
       <input type="hidden" value="<? echo str_replace('"',"",$excel_content);?>" name="excel_data<?=$i?>" />
       <? }?>
        <input type="hidden" name="content_no" value="<?=$i?>" />
        <tr>
          <td height="40" colspan="5"></td>
        </tr>
        <tr>
          <td height="40" colspan="3"></td><td><input type="submit" name="download" value="Download" /></td>
        </tr>
      </table>
	    <? }else
			{?>
				<table align="center">
			<tr>
				<td class="no_details_msg">No customers registered so far</td>
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
</form>
<?	include("includes/footer.php");?>