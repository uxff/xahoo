<style>
.listbox {
	width: 100%;
	border: 1px solid #ccc;
	overflow: hidden;
	margin-bottom: 5px;
}

.listleft {
	float: left;
	border-right: 1px solid #ccc;
	width: 200px;
	padding: 5px 10px;
}

.listright {
	float: left;
	width: auto;
	padding: 5px 10px;
}
</style>
<div class="page-content-area">
<div class="page-header">
<h1>权限配置 <small> <i class="ace-icon fa fa-angle-double-right"></i>
列表 </small></h1>
</div>
<!-- /.page-header -->

<div class="row">
<div class="col-xs-12">
<div class="table-header">[{$roleModel.name}]角色的权限设置 <span class="pull-right"><a href="#"
	class="btn btn-xs btn-success">确定</a></span></div>
<div>
<form action="backend.php?r=access/update&roleid={$role_id}" method="post">
<div id="sample-table-2_wrapper" class="form-inline no-footer">
<table id="sample-table-1"
	class="table table-striped table-bordered table-hover dataTable">
	<thead id="checkwrap">
		<tr>
			<th class="center ">题目</th>
			<th>小题目</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$allNodes key=myId item=result}
		<tr>
			<td class="center"><label class="position-relative">
			{$result.title}&nbsp;&nbsp;&nbsp;全选 <input type="checkbox" class="ace check1"
				name="node_ids[]" value="{$result.id}" {if in_array($result.id,$allNode)}checked{/if}> <span class="lbl"></span> </label></td>

			<td>
			{foreach from=$result.child item=list}
			<div class="listbox">
			<div class="listleft">{$list.title} <label class="position-relative"> <input
				type="checkbox" class="ace check2" name="node_ids[]" value="{$list.id}" {if in_array($list.id,$allNode)}checked{/if}> <span
				class="lbl"></span> </label></div>
			{foreach from=$list.child item=i}
			<div class="listright">{$i.title}<label class="position-relative"> <input
				type="checkbox" class="ace check3" name="node_ids[]" value="{$i.id}" {if in_array($i.id,$allNode)}checked{/if} > <span
				class="lbl"></span> </label></div>
			{/foreach}
			</div>
			{/foreach}
			</td>

		</tr>

		{/foreach}
	</tbody>
</table>
<input type="submit"></div>
</form>
</div>
</div>
</div>
<!-- /.row --></div>
<!-- /.page-content-area -->
