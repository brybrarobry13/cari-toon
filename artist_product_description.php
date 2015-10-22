<? include('includes/configuration.php');
   $user = $_REQUEST['artist'];
   $prodct_id=$_REQUEST['product'];
   $sql_product="SELECT * FROM `toon_products` WHERE `user_id`='$user' AND `product_id`='$prodct_id'";
   $rs_product = mysql_query($sql_product);
   while($row_desc=mysql_fetch_assoc($rs_product))
   {
?>

<table cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td><?=$row_desc['product_title'];?></td>
  </tr>
  <tr>
    <td align="left" class="event_txt"><?=$row_desc['product_description'];?></td>
  </tr>
</table>
<? } ?>
