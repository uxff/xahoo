<?php
$requestid = date('YmdHis') . rand(1000000, 9000000);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title>银行卡绑定接口演示</title>
	</head>
	<body>
		<form method="post" action="sendBindBankcard.php" target="_blank" accept-charset="UTF-8">
			<table width="80%" style="border:1px #CCC solid;" align="center" cellpadding="5" cellspacing="0">
				<tr>
					<th align="center" height="20" colspan="5" bgcolor="#6BBE18">
						请输入银行卡绑定参数	
					</th>
				</tr> 
				<tr >
					<td width="20%" align="left">&nbsp;绑卡请求号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="requestid" value="<?php echo $requestid; ?>"/>
						<span style="color:#FF0000;font-weight:100;">*</span>
						<br />随机生成
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">requestid</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户标识类型</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="identitytype" value="2" />
						<span style="color:#FF0000;font-weight:100;">*</span>
						<br />
						0：IMEI<br>
						1：MAC地址<br>
						2：用户 ID<br>
						3：用户 Email<br>
						4：用户手机号<br>
						5：用户身份证号<br>
						6：用户纸质订单协议号<br>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">identitytype</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户标识</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="identityid" value="<?php echo md5($requestid); ?>" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">identityid</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;银行卡号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="cardno" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">cardno</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;证件类型</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="idcardtype" value="01" />
						<span style="color:#FF0000;font-weight:100;">*</span>
						<br />
						固定值
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">idcardtype</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;证件号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="idcardno" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
						<br/> 身份证号
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">idcardno</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;持卡人姓名</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="username" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">username</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;银行预留手机号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="phone" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">phone</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户注册手机号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="registerphone" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">registerphone</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户注册日期</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="registerdate" value="2015-06-05 13:40:21" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">registerdate</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户注册ip</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="registerip" value="192.168.1.16" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">registerip</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户注册证件类型</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="registeridcardtype" value="01" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">registeridcardtype</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户注册证件号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="registeridcardno" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">registeridcardno</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户注册联系方式</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="registercontact" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">registercontact</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户使用的操作系统</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="os" value="Windows7" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">os</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;设备唯一标识</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="imei" value="SKCMSKCMSKFKSKF" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">imei</td> 
				</tr> 
				<tr >
					<td width="20%" align="left">&nbsp;用户请求ip</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="userip" value="192.168.0.1" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">userip</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;用户UA信息</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="ua" value="MSIE8" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">ua</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="55%" align="left"> 
						<input type="submit" value="单击提交" />
					</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="15%" align="left">&nbsp;</td> 
				</tr>
			</table>
		</form>
	</body>
</html>