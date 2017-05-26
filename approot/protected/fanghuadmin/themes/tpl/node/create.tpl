
<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="fanghuadmin.php?r=node">节点管理</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 新增 </small> </h1><br />
                <h1> 提示信息： <small> 以下均为必选项 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <!--
                        <div class="alert alert-block alert-success">
                                <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                </button>
                                <i class="ace-icon fa fa-check green"></i>
            
                        </div>
                        -->
                        {if $errormsgs}
                            <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">
                                            <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    {$errormsgs}
                            </div>
                        {/if}

                        <form class="form-horizontal"  id="node-form" role="form" action="fanghuadmin.php?r=node/create" method="POST">
                                <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="SysNode_pid">父级</label>
                                        <div class="col-sm-7">
                                            <input type="text" value="{$parentNode['title']}({$parentNode['name']})" readonly/>
                                            <input type="hidden" id="SysNode_pid" name="SysNode[pid]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$pid}" readonly />
                                        </div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_pid_em_">  </span> </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="SysNode_url">URL</label>
                                        <div class="col-sm-7"><input type="text" id="SysNode_url" name="SysNode[url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.url}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_url_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="SysNode_name">名字</label>
                                        <div class="col-sm-7"><input type="text" id="SysNode_name" name="SysNode[name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.name}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_name_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="SysNode_title">显示名称</label>
                                        <div class="col-sm-7"><input type="text" id="SysNode_title" name="SysNode[title]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.title}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_title_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="SysNode_status">状态</label>
                                        <div class="col-sm-7"><select class="form-control" id="SysNode_status" name="SysNode[status]" style="width:120px;">   <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>   <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>无效</option></select></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_status_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="SysNode_remark">备注</label>
                                        <div class="col-sm-7"><input type="text" id="SysNode_remark" name="SysNode[remark]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.remark}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_remark_em_">  </span> </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="SysNode_sort">排序</label>
                                        <div class="col-sm-7"><input type="text" id="SysNode_sort" name="SysNode[sort]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.sort}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_sort_em_">  </span> </div>
                                </div>
                                 <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="SysNode_icon">图标</label>
                                        <div class="col-sm-7"><input type="text" id="SysNode_icon" name="SysNode[icon]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.icon}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_icon_em_">  </span> </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="SysNode_level">级别</label>
                                        <div class="col-sm-7"><select class="form-control" id="SysNode_level" name="SysNode[level]" style="width:120px;">   <option value="1"{if $dataObj.level eq "1"} selected="selected"{/if}>分组</option>   <option value="2"{if $dataObj.level eq "2"} selected="selected"{/if}>controller</option>   <option value="3"{if $dataObj.level eq "3"} selected="selected"{/if}>action</option></select></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_level_em_">  </span> </div>
                                </div>
                                <div class="form-group">
				                    <label class="col-sm-2 control-label no-padding-right" for="SysNode_display">是否显示</label>
				                    <div class="col-sm-7"><select class="form-control" id="SysNode_display" name="SysNode[display]" style="width:120px;">   <option value="1" {if $dataObj.display eq "1"} selected="selected"{/if}>显示</option>   <option value="0" {if $dataObj.display eq "0"} selected="selected"{/if}>不显示</option></select></div>
				                    <div class="col-sm-2"> <span class="help-inline middle" id="SysNode_display_em_">  </span> </div>
				                </div>
				                <!--
                                {foreach from=$FormElements key=attributeName item=item}
                                    {if !$item.autoIncrement}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="{$modelName}_{$attributeName}"> {$item.comment}: </label>
                                        <div class="col-sm-7">
                                            <input type="text" id="{$modelName}_{$attributeName}" name="{$modelName}[{$attributeName}]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="" />
                                        </div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="{$modelName}_{$attributeName}_em_"> </span> </div>
                                    </div>
                                    {/if}
                                {/foreach}
                                -->
                                <div class="clearfix form-actions">
                                        <div class="text-center">
                                                <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 提交 </button>
                                        </div>
                                </div>
                        </form>
                </div>
                <!-- /.col --> 
        </div>
        <!-- /.row --> 
</div>
{if !empty($jsShell)}
    {$jsShell}
{/if}
<!-- /.page-content-area --> 