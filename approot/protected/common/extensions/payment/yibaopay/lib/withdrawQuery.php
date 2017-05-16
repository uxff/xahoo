
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title>提现查询接口演示</title>
	</head>
	<body>
		<form method="post" action="sendWithdrawQuery.php" accept-charset="UTF-8">
			<table width="80%" border="0" align="center" cellpadding="10" cellspacing="0" style="border:solid 1px #107929">
				<tr>
					<th align="center" height="20" colspan="5" bgcolor="#6BBE18">
						请输入提现请求号、易宝提现流水号	
					</th>
				</tr> 
				<tr >
					<td width="20%" align="left">&nbsp;提现请求号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="requestid" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">requestid</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;易宝提现流水号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="ybdrawflowid" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">ybdrawflowid</td> 
				</tr>
				<tr >
					<td width="20%" align="left">&nbsp;</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="55%" align="left"> 
						<input type="submit" value="单击查询" />
					</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="15%" align="left">&nbsp;</td> 
				</tr>
			</table>
		</form>
	</body>
</html>
