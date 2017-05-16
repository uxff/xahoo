<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title>确认银行卡绑定接口演示</title>
	</head>
	<body>
		<form method="post" action="sendBindBankcardConfirm.php" target="_blank" accept-charset="UTF-8">
			<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
				<tr>
					<th align="center" height="20" colspan="5" bgcolor="#6BBE18">
						请输入确认参数	
					</th>
				</tr> 
				<tr >
					<td width="20%" align="left">&nbsp;绑卡请求号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="requestid" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">requestid</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;短信验证码</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="validatecode" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">validatecode</td> 
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