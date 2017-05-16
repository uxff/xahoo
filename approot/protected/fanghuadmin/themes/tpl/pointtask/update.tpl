<link rel="stylesheet" type="text/css" href="resource/thirdvendor/aceadmin1.3.1/css/webuploader.css">
<div class="page-content-area">
    <div class="page-header">
        <h1><a href="fanghuadmin.php?r=pointTask">PointTask</a>
            <small><i class="ace-icon fa fa-angle-double-right"></i> 编辑</small>
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
            {if $errormsgs}
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    {$errormsgs}
                </div>
            {/if}

            <form class="form-horizontal" id="pointTask-form" role="form"
                  action="fanghuadmin.php?r=pointTask/update&id={$model[$primaryKey]}" method="POST">
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

                   {**}
                    {*<div class="col-sm-2"><span class="help-inline middle" id="PointTask_task_img_em_">  </span>*}
                    {*</div>*}
                {*</div>*}
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointTask_task_img">资讯默认配图</label>

                    <div class="col-sm-7">
                        <div class="uploader-container-single">
                            <div id="fileList" class="uploader-list">
                                <div id="WU_FILE_0" class="file-item thumbnail"><img src="{$dataObj.task_img}"></div>
                            </div>
                            <div>
                                <div id="filePicker" class="webuploader-container"><div class="webuploader-pick">选择图片</div><div id="rt_rt_19blisudrfqme9b19vknr33to1" style="position: absolute; top: 0px; left: 0px; width: 70px; height: 35px; overflow: hidden; bottom: auto; right: auto;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
                                <button type="button" id="ctlBtn" class="new-default" style="display: none;">开始上传</button>
                            </div>
                        </div>


                        <input type="hidden" id="PointTask_task_img" name="PointTask[task_img]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="">
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