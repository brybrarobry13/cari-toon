<?
	include('includes/configuration.php');
	
	$sql_newsletter="SELECT u.user_fname,u.user_lname,nt.nltr_email FROM  toon_users u,toon_newsletter nt WHERE 	u.user_email=nt.nltr_email";
	$rs_newsletter=mysql_query($sql_newsletter);
	if(isset($_POST['download']))
		{	
			$exel_headding="Name \t Email \t <:nextline:> ";
			$exel_content="";
			for($val=0;$val<=$_POST['content_no'];$val++)
			{
				$exel_content.=$_POST['excel_data'.$val];
			}
		$filename ="Newsletter Suscriptions".date('dMy').".xls";
		$contents1=$exel_headding.$exel_content;
		$contents = str_replace("<:nextline:>","\n",$contents1);
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $contents;
		exit();
		
		}
	include ('includes/header.php');
?>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><form action="send_mail.php" method="post"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" width="100%" colspan="4">Newsletter Subscriptions</td>
        </tr>
        <tr>
          <td height="40px;"></td>
        </tr>
        <tr>
          <td width="2%">&nbsp;</td>
          <td align="center"><?
		
		$number=mysql_num_rows($rs_newsletter);
		if (count!=$number)
		{?>
            <table cellpadding="4" cellspacing="0" width="94%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Name</td>
                <td class="sub_heading" height="30">Email</td>
                 </tr>
              <?
	   while($row_newsletter=mysql_fetch_assoc($rs_newsletter))
	   {$i++
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$row_newsletter['user_fname'].' '.$row_newsletter['user_lname']?></td>
                <td align="left" class="table_details"><?=$row_newsletter['nltr_email']?></td>
              </tr>
              <?
              $excel_content=$row_newsletter['user_fname']." ".$row_newsletter['user_lname']."\t".$row_newsletter['nltr_email']."\t <:nextline:>";
			  ?>
              <input type="hidden" value="<? echo str_replace('"',"",$excel_content);?>" name="excel_data<?=$i?>" />
       <? }?>
       			 <input type="hidden" name="content_no" value="<?=$i?>" />
                <tr>
             		 <td height="40" colspan="1" ></td><td align="center"><input type="submit" name="download" value="Download" /></td>
            	</tr>
              <tr>
                <td height="40" colspan="4"></td>
              </tr>
             </table>
        <? }
		else
		{?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Newsletter subscriptions!</td>
              </tr>
            </table>
       <? }?>
          </td>
          <td width="2%">&nbsp;</td>
        </tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table></form></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
