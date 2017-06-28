<link rel="stylesheet" type="text/css" href="resource/thirdvendor/aceadmin1.3.1/css/webuploader.css">
<div class="page-content-area">
    <div class="page-header">
        <h1><a href="backend.php?r=pointTask">PointTask</a>
            <small><i class="ace-icon fa fa-angle-double-right"></i> 新增</small>
        </h1>
        <br/>

        <h1> 提示信息：
            <small> 以下均为必选项</small>
        </h1>
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

            <form class="form-horizontal" id="pointTask-form" role="form" action="backend.php?r=pointTask/create"
                  method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointTask_task_title">任务标题</label>

                    <div class="col-sm-7"><input type="text" id="PointTask_task_title" name="PointTask[task_title]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.task_title}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointTask_task_title_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointTask_task_detail">任务详情</label>

                    <div class="col-sm-7"><textarea id="PointTask_task_detail" name="PointTask[task_detail]"
                                                    class="col-xs-10 col-sm-5"
                                                    placeholder="任务详情">{$dataObj.task_detail}</textarea></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointTask_task_detail_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointTask_task_url">任务URL</label>

                    <div class="col-sm-7"><input type="text" id="PointTask_task_url" name="PointTask[task_url]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.task_url}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointTask_task_url_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointTask_task_reward">任务奖历/待定</label>

                    <div class="col-sm-7"><input type="text" id="PointTask_task_reward" name="PointTask[task_reward]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.task_reward}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointTask_task_reward_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointTask_task_category">任务类型</label>

                    <div class="col-sm-7"><select class="form-control" id="PointTask_task_category" name="PointTask[task_category]"
                                                  style="width:120px;">
                            <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>资讯</option>
                            <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>房源</option>
                        </select></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointTask_status_em_">  </span></div>
                </div>
                {*<div class="form-group">*}
                    {*<label class="col-sm-2 control-label no-padding-right" for="PointTask_task_img">任务配图</label>*}

                    {*<div class="col-sm-7"><input type="text" id="PointTask_task_img" name="PointTask[task_img]"*}
                                                 {*size="60" maxlength="200" class="col-xs-10 col-sm-5"*}
                                                 {*value="{$dataObj.task_img}"/></div>*}
                    {*<div class="col-sm-2"><span class="help-inline middle" id="PointTask_task_img_em_">  </span>*}
                    {*</div>*}
                {*</div>*}
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointTask_task_img">任务配图</label>

                    <div class="col-sm-7">
                        <div class="uploader-container-single">
                            <div id="fileList" class="uploader-list"></div>
                            <div>
                                <div id="filePicker">选择图片</div>
                                <button type="button" id="ctlBtn" class="new-default">开始上传</button>
                            </div>
                        </div>
                        <input type="hidden" id="PointTask_task_img" name="PointTask[task_img]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.task_img}" />
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointTask_task_img_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointTask_status">状态</label>

                    <div class="col-sm-7"><select class="form-control" id="PointTask_status" name="PointTask[status]"
                                                  style="width:120px;">
                            <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>
                            <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option>
                        </select></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointTask_status_em_">  </span></div>
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
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn btn-info" type="submit"><i class="ace-icon fa fa-check bigger-110"></i> 提交
                        </button>
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