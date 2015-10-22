<?
	include("includes/configuration.php");
	if(!isloggedIn())
	{
		header('Location:login.php');
		exit();
	}
	$u_id=$_SESSION['sess_tt_uid'];
	$new_ord_query = mysql_query("SELECT * FROM `toon_orders` WHERE `artist_id`='$u_id' and `order_status`='Paid'");
	$number_new_ord = mysql_num_rows($new_ord_query);
	$work_progress_query = mysql_query("SELECT * FROM `toon_orders` WHERE `artist_id`='$u_id' and `order_status`='Work In Progress'");
	$number_work_pro = mysql_num_rows($work_progress_query);
	$work_waiting_query = mysql_query("SELECT * FROM `toon_orders` WHERE `artist_id`='$u_id' and `order_status`='waiting for approval'");
	$number_waiting_approval = mysql_num_rows($work_waiting_query);
	$completed_query = mysql_query("SELECT *  FROM `toon_orders` WHERE `artist_id`='$u_id' and `order_status`='completed'");
	$number_completed = mysql_num_rows($completed_query);
	$refunded_query = mysql_query("SELECT *  FROM `toon_orders` WHERE `artist_id`='$u_id' and `order_status`='Refunded'");
	$number_refunded = mysql_num_rows($refunded_query);
	$artist_paid_query = mysql_query("SELECT *  FROM `toon_orders` WHERE `artist_id`='$u_id' and `order_status`='artist paid'");
	$number_artist_paid = mysql_num_rows($artist_paid_query);
	include (DIR_INCLUDES.'artist_header.php');
?>
<link href="styles/style.css" rel="stylesheet" type="text/css" />

<div id="content">
<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td height="75" colspan="2">
		</td>
	</tr>
	<tr>
		<td align="center">
			<table width="95%" cellpadding="0" cellspacing="3">	
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"  width="100%" >
							<tr><td colspan="3" class="header_text" >Hello Artist, below is your Caricature Toons Orders. Included are instructions and images. Any questions or concerns we encourage you to communicate directly with the customer only through the messaging envelope.  When finished, upload your caricatures and the customer will automatically be notified their artwork is ready.</td></tr>
                            <tr><td height="20"></td></tr>
                            <tr>
								<td width="23" align="left"><img src="images/topleft.gif"></td>
								<td width="100%" class="artist_top" valign="middle" align="center"><span class="text_blue"><b>New Orders</b></span></td>
								<td align="right" width="23"><img src="images/top_right.gif"></td>
							</tr>
							<tr>
								<td class="artist_left">&nbsp;</td>
								<? if($number_new_ord>0){?>
								<td>
									<table id="worktable" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF">
										<tr>
											<td align="center" class="text_blue" style="font-weight:bold">Order Id
											</td>
                                            <td align="center" style="font-weight:bold" class="text_blue">Order Date
											</td>
											<td align="center" style="font-weight:bold" class="text_blue">Due Date
											</td>
                                            <td align="center" style="font-weight:bold" class="text_blue">Customer
											</td>
                                            <td align="center" style="font-weight:bold" class="text_blue">Wholesale Price
											</td>
											<td align="center" style="font-weight:bold" class="text_blue">Action
											</td>
										</tr>
										<? while($new_ord_row=mysql_fetch_array($new_ord_query))
											{
											$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`=$new_ord_row[product_id]");
											$product_row=mysql_fetch_array($product_query);
											$user_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`=$new_ord_row[user_id]");
											$user_row=mysql_fetch_array($user_query);
										    $deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD('$new_ord_row[order_date]', INTERVAL $product_row[product_turnaroundtime] DAY),NOW() AS `today`"));
										?>
										<tr>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=$new_ord_row['order_id'];?>
											</td>
                                            <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><? echo date("m-d-Y",strtotime($new_ord_row['order_date']));?>
											</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=date("m-d-Y",strtotime($deadline[0]));?>
											</td>
                                            <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=$user_row['user_fname'];?>
											</td>
                                             <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=number_format($new_ord_row['order_wholesale_price'],2)?>
											</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>">
											<a target="_blank" href="order-d.php?ord_id=<?=$new_ord_row['order_id'];?>"><img src="images/view.gif" style="border:none;" alt="view" title="View" /></a>
											<?
												$is_unread = mysql_num_rows(mysql_query("SELECT * FROM `toon_messages` WHERE `order_id`='".$new_ord_row['order_id']."' AND `user_id`!='".$_SESSION['sess_tt_uid']."' AND `msg_read`=0"));
												if($is_unread)
													$img_name_append = '_unread';
												else
													$img_name_append = '';
											?>
											&nbsp;<a href="mess.php?ord_id=<?=$new_ord_row['order_id'];?>"><img src="images/mail<?=$img_name_append?>.gif" border="0" width="20" title="Messages"/></a>
											</td>
										</tr>
										<? }?>
									</table>
								</td>
									<? }else{?> 
									<td bgcolor="#FFFFFF" align="center" height="50" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;">No new orders</td>
									<? }?>
								
								<td class="artist_right"></td>
							</tr>
							<tr>
								<td align="left"><img src="images/contact_btm_left_curve.gif"></td>
								<td class="artist_bottom"></td>
								<td colspan="2" align="right"><img src="images/contact_btm_right_curve.gif"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="20">
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"  width="100%">
							<tr>
								<td width="23"><img src="images/topleft.gif"></td>
								<td class="artist_top" valign="middle" align="center"><span class="text_blue"><b>Work in progress</b></span>	</td>
								<td align="right" width="23"><img src="images/top_right.gif"></td>
							</tr>
							<tr>
								<td class="artist_left">&nbsp;</td>
								
								<? if($number_work_pro>0){?>
								<td>
									<table id="worktable" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF">
											<tr>
												<td height="30" align="center"><span class="text_blue" style="font-weight:bold;">Order Id</span>
												</td>
                                                <td align="center"><span class="text_blue" style="font-weight:bold;">Order Date</span>
												</td>
												<td align="center" ><span class="text_blue" style="font-weight:bold;">Due Date</span>
												</td>
                                                <td align="center" ><span class="text_blue" style="font-weight:bold;">Customer</span>
												</td>
                                                <td align="center" ><span class="text_blue" style="font-weight:bold;">Wholesale Price</span>
											</td>
												<td align="center" class="text_blue" style="font-weight:bold;">Action
												</td>
											</tr>
											<? while($work_progress_row=mysql_fetch_array($work_progress_query))
												{
												$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`=$work_progress_row[product_id]");
												$product_row=mysql_fetch_array($product_query);
												$user_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`=$work_progress_row[user_id]");
												$user_row=mysql_fetch_array($user_query);
											    $deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD('$work_progress_row[order_date]', INTERVAL $product_row[product_turnaroundtime] DAY),NOW() AS `today`"));
											 ?>
											<tr>
												<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=$work_progress_row['order_id'];?>
												</td>
                                                <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><? echo date("m-d-Y",strtotime($work_progress_row['order_date']));?>
												</td>
												<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=date("m-d-Y",strtotime($deadline[0]));?>
												</td>
                                                <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=$user_row['user_fname'];?>
												</td>
                                                <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=number_format($work_progress_row['order_wholesale_price'],2)?>
												</td>
												<td align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><a target="_blank" href="order-d.php?ord_id=<?=$work_progress_row['order_id'];?>"><img src="images/view.gif" style="border:none;" alt="view" title="View" /></a>&nbsp;
                                                <?
                                                if($user_row['user_delete']==0)
												{
													$is_unread = mysql_num_rows(mysql_query("SELECT * FROM `toon_messages` WHERE `order_id`='".$work_progress_row['order_id']."' AND `user_id`!='".$_SESSION['sess_tt_uid']."' AND `msg_read`=0"));
													if($is_unread)
														$img_name_append = '_unread';
													else
														$img_name_append = '';
												?>
												<a href="mess.php?ord_id=<?=$work_progress_row['order_id'];?>"><img src="images/mail<?=$img_name_append?>.gif" border="0" width="20" title="Messages"/></a>
                                                <?
                                                }
												?>
                                                </td>
											</tr>
											<? }?>
										</table>
								</td>
								<? }else{?>
								<td bgcolor="#FFFFFF" align="center" height="50" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;">No Work in progress</td>
									<? }?>
								<td class="artist_right">&nbsp;</td>
							</tr>
							<tr>
								<td><img src="images/contact_btm_left_curve.gif"></td>
								<td class="artist_bottom">&nbsp;</td>
								<td colspan="2" align="right"><img src="images/contact_btm_right_curve.gif"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="20">
					</td>
				</tr>
                <tr>
					<td>
						<table cellpadding="0" cellspacing="0"  width="100%">
							<tr>
								<td width="23"><img src="images/topleft.gif"></td>
								<td class="artist_top" valign="middle" align="center"><span class="text_blue"><b>Waiting for customers approval</b></span>	</td>
								<td align="right" width="23"><img src="images/top_right.gif"></td>
							</tr>
							<tr>
								<td class="artist_left">&nbsp;</td>
								
								<? if($number_waiting_approval>0){?>
								<td>
									<table id="worktable" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF">
											<tr>
												<td height="30" align="center"><span class="text_blue" style="font-weight:bold;">Order Id</span>
												</td>
                                                <td align="center"><span class="text_blue" style="font-weight:bold;">Order Date</span>
												</td>
												<td align="center" ><span class="text_blue" style="font-weight:bold;">Due Date</span>
												</td>
                                                <td align="center" ><span class="text_blue" style="font-weight:bold;">Customer</span>
												</td>
                                                <td align="center" ><span class="text_blue" style="font-weight:bold;">Wholesale Price</span>
											</td>
												<td align="center" class="text_blue" style="font-weight:bold;">Action
												</td>
											</tr>
											<? while($work_waiting_row=mysql_fetch_array($work_waiting_query))
												{
												$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`=$work_waiting_row[product_id]");
												$product_row=mysql_fetch_array($product_query);
												$user_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`=$work_waiting_row[user_id]");
												$user_row=mysql_fetch_array($user_query);
											    $deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD('$work_waiting_row[order_date]', INTERVAL $product_row[product_turnaroundtime] DAY),NOW() AS `today`"));
											 ?>
											<tr>
												<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=$work_waiting_row['order_id'];?>
												</td>
                                                <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><? echo date("m-d-Y",strtotime($work_waiting_row['order_date']));?>
												</td>
												<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=date("m-d-Y",strtotime($deadline[0]));?>
												</td>
                                                <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=$user_row['user_fname'];?>
												</td>
                                            	<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; <? if($deadline[0]<$deadline['today']) {?>color:#FF0000<? }else {?> color:#000000;<? }?>"><?=number_format($work_waiting_row['order_wholesale_price'],2)?>
												</td>
												<td align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><a target="_blank" href="order-d.php?ord_id=<?=$work_waiting_row['order_id'];?>"><img src="images/view.gif" style="border:none;" alt="view" title="View" /></a>&nbsp;
                                                <?
                                                if($user_row['user_delete']==0)
												{
													$is_unread = mysql_num_rows(mysql_query("SELECT * FROM `toon_messages` WHERE `order_id`='".$work_waiting_row['order_id']."' AND `user_id`!='".$_SESSION['sess_tt_uid']."' AND `msg_read`=0"));
													if($is_unread)
														$img_name_append = '_unread';
													else
														$img_name_append = '';
												?>
												<a href="mess.php?ord_id=<?=$work_waiting_row['order_id'];?>"><img src="images/mail<?=$img_name_append?>.gif" width="20" border="0" title="Messages"/></a>
                                                <?
                                                }
												?>
                                                </td>
											</tr>
											<? }?>
										</table>
								</td>
								<? }else{?>
								<td bgcolor="#FFFFFF" align="center" height="50" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;">No proofs submited for any work</td>
									<? }?>
								<td class="artist_right">&nbsp;</td>
							</tr>
							<tr>
								<td><img src="images/contact_btm_left_curve.gif"></td>
								<td class="artist_bottom">&nbsp;</td>
								<td colspan="2" align="right"><img src="images/contact_btm_right_curve.gif"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="20">
					</td>
				</tr>
				<tr>
					<td>
						<table  cellpadding="0" cellspacing="0"  width="100%" >
							<tr>
								<td width="23"><img src="images/topleft.gif"></td>
								<td class="artist_top" valign="middle" align="center"><span class="text_blue"><b>Completed</b></span></td>
								<td align="right" width="23"><img src="images/top_right.gif"></td>
							</tr>
							<tr>
								<td class="artist_left">&nbsp;</td>
								<? if($number_completed>0){?>
								<td><table id="worktable" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF">
										<tr>
											<td align="center"><span class="text_blue" style="font-weight:bold;">Order Id</span>
											</td>
                                            <td align="center"><span class="text_blue" style="font-weight:bold;">Order Date</span>
											</td>
											<td align="center" ><span class="text_blue" style="font-weight:bold;">Due Date</span>
											</td>
                                            <td align="center" ><span class="text_blue" style="font-weight:bold;">Customer</span>
											</td>
                                            <td align="center" ><span class="text_blue" style="font-weight:bold;">Wholesale Price</span>
											</td>
											<td align="center" class="text_blue" style="font-weight:bold;">Action
											</td>
										</tr>
										<? while($completed_row=mysql_fetch_array($completed_query))
											{
											$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`=$completed_row[product_id]");
											$product_row=mysql_fetch_array($product_query);
											$user_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`=$completed_row[user_id]");
											$user_row=mysql_fetch_array($user_query);
											$deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD('$completed_row[order_date]', INTERVAL $product_row[product_turnaroundtime] DAY),NOW() AS `today`"));
										 ?>
										<tr>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=$completed_row['order_id'];?>
											</td>
                                            <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=date("m-d-Y",strtotime($completed_row['order_date']));?>
											</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=date("m-d-Y",strtotime($deadline[0]));?>
											</td>
                                            <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=$user_row['user_fname'];?>
											</td>
                                            <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=number_format($completed_row['order_wholesale_price'],2)?>
												</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><a target="_blank" href="order-d.php?ord_id=<?=$completed_row['order_id'];?>"><img src="images/view.gif" style="border:none;" alt="view" title="View" /></a>
											 <?
						                                                if($user_row['user_delete']==0)
												{
													$is_unread = mysql_num_rows(mysql_query("SELECT * FROM `toon_messages` WHERE `order_id`='".$completed_row['order_id']."' AND `user_id`!='".$_SESSION['sess_tt_uid']."' AND `msg_read`=0"));
													if($is_unread)
														$img_name_append = '_unread';
													else
														$img_name_append = '';
												?>
												<a href="mess.php?ord_id=<?=$completed_row['order_id'];?>"><img src="images/mail<?=$img_name_append?>.gif" border="0" width="20" title="Messages"/></a>
						                                                <?
						                                                }
											?>
											</td>
										</tr>
										<? }?>
									</table></td>
								<? }else{?>
								<td bgcolor="#FFFFFF" align="center" height="50" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;">No Work completed</td>
									<? }?>
								<td class="artist_right">&nbsp;</td>
							</tr>
							<tr>
								<td><img src="images/contact_btm_left_curve.gif"></td>
								<td class="artist_bottom">&nbsp;</td>
								<td colspan="2" align="right"><img src="images/contact_btm_right_curve.gif"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="20">
					</td>
				</tr>
                <tr>
					<td>
						<table  cellpadding="0" cellspacing="0"  width="100%" >
							<tr>
								<td width="23"><img src="images/topleft.gif"></td>
								<td class="artist_top" valign="middle" align="center"><span class="text_blue"><b>Artist Paid</b></span></td>
								<td align="right" width="23"><img src="images/top_right.gif"></td>
							</tr>
							<tr>
								<td class="artist_left">&nbsp;</td>
								<? if($number_artist_paid>0){?>
								<td><table id="worktable" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF">
										<tr>
											<td align="center"><span class="text_blue" style="font-weight:bold;">Order Id</span>
											</td>
											<td align="center" ><span class="text_blue" style="font-weight:bold;">Payment Number</span>
											</td>
											<td align="center"><span class="text_blue" style="font-weight:bold;">Payment Date</span>
											</td>
											<td align="center" class="text_blue" style="font-weight:bold;">Action
											</td>
										</tr>
										<? while($artist_paid_row=mysql_fetch_array($artist_paid_query))
											{
											$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`=$artist_paid_row[product_id]");
											$product_row=mysql_fetch_array($product_query);
											$user_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`=$artist_paid_row[user_id]");
											$user_row=mysql_fetch_array($user_query);
										 ?>
										<tr>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=$artist_paid_row['order_id'];?>
											</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=$artist_paid_row['order_artist_payment_no'];?>
											</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=date("m-d-Y",strtotime($artist_paid_row['order_artistpayment_date']));?>
											</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><a target="_blank" href="order-d.php?ord_id=<?=$artist_paid_row['order_id'];?>"><img src="images/view.gif" style="border:none;" alt="view" title="View" /></a>
											<?
                                                if($user_row['user_delete']==0)
												{
													$is_unread = mysql_num_rows(mysql_query("SELECT * FROM `toon_messages` WHERE `order_id`='".$artist_paid_row['order_id']."' AND `user_id`!='".$_SESSION['sess_tt_uid']."' AND `msg_read`=0"));
													if($is_unread)
														$img_name_append = '_unread';
													else
														$img_name_append = '';
												?>
												<a href="mess.php?ord_id=<?=$artist_paid_row['order_id'];?>"><img src="images/mail<?=$img_name_append?>.gif" border="0" width="20" title="Messages"/></a>
                                                <?
                                                }
												?>
											</td>
										</tr>
										<? }?>
									</table></td>
								<? }else{?>
								<td bgcolor="#FFFFFF" align="center" height="50" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;">No Payments Done</td>
									<? }?>
								<td class="artist_right">&nbsp;</td>
							</tr>
							<tr>
								<td><img src="images/contact_btm_left_curve.gif"></td>
								<td class="artist_bottom">&nbsp;</td>
								<td colspan="2" align="right"><img src="images/contact_btm_right_curve.gif"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="20">
					</td>
				</tr>
                <tr>
					<td>
						<table  cellpadding="0" cellspacing="0"  width="100%" >
							<tr>
								<td width="23"><img src="images/topleft.gif"></td>
								<td class="artist_top" valign="middle" align="center"><span class="text_blue"><b>Refunded</b></span></td>
								<td align="right" width="23"><img src="images/top_right.gif"></td>
							</tr>
							<tr>
								<td class="artist_left">&nbsp;</td>
								<? if($number_refunded>0){?>
								<td><table id="worktable" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF">
										<tr>
											<td align="center"><span class="text_blue" style="font-weight:bold;">Order Id</span>
											</td>
											<td align="center" ><span class="text_blue" style="font-weight:bold;">Payment Number</span>
											</td>
											<td align="center"><span class="text_blue" style="font-weight:bold;">Payment Date</span>
											</td>
											<td align="center" class="text_blue" style="font-weight:bold;">Action
											</td>
										</tr>
										<? while($refunded_row=mysql_fetch_array($refunded_query))
											{
											$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`=$refunded_row[product_id]");
											$product_row=mysql_fetch_array($product_query);
											$user_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`=$refunded_row[user_id]");
											$user_row=mysql_fetch_array($user_query);
										 ?>
										<tr>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=$refunded_row['order_id'];?>
											</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=$refunded_row['order_refunded_number'];?>
											</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><?=date("m-d-Y",strtotime($refunded_row['order_refunded_date']));?>
											</td>
											<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;"><a target="_blank" href="order-d.php?ord_id=<?=$refunded_row['order_id'];?>"><img src="images/view.gif" style="border:none;" alt="view" title="View" /></a>
		                                    <?
                                                if($user_row['user_delete']==0)
												{
													$is_unread = mysql_num_rows(mysql_query("SELECT * FROM `toon_messages` WHERE `order_id`='".$refunded_row['order_id']."' AND `user_id`!='".$_SESSION['sess_tt_uid']."' AND `msg_read`=0"));
													if($is_unread)
														$img_name_append = '_unread';
													else
														$img_name_append = '';
												?>
												<a href="mess.php?ord_id=<?=$refunded_row['order_id'];?>"><img src="images/mail<?=$img_name_append?>.gif" border="0" width="20" title="Messages"/></a>
                                                <?
                                                }
												?>
											</td>
										</tr>
										<? }?>
									</table></td>
								<? }else{?>
								<td bgcolor="#FFFFFF" align="center" height="50" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;">No Work Refunded</td>
									<? }?>
								<td class="artist_right">&nbsp;</td>
							</tr>
							<tr>
								<td><img src="images/contact_btm_left_curve.gif"></td>
								<td class="artist_bottom">&nbsp;</td>
								<td colspan="2" align="right"><img src="images/contact_btm_right_curve.gif"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="20">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>

<?
	include (DIR_INCLUDES.'artist_footer.php');

?>