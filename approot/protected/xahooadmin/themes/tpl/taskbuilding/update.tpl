<link rel="stylesheet" type="text/css" href="resource/thirdvendor/aceadmin1.3.1/css/webuploader.css">
<div class="page-content-area">
    <div class="page-header">
        <h1><a href="backend.php?r=taskBuilding">TaskBuilding</a>
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

            <form class="form-horizontal" id="taskBuilding-form" role="form"
                  action="backend.php?r=taskBuilding/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_task_title">任务标题</label>

                    <div class="col-sm-7"><input type="text" id="TaskBuilding_task_title"
                                                 name="TaskBuilding[task_title]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.task_title}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="TaskBuilding_task_title_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_task_url">任务URL</label>

                    <div class="col-sm-7"><input type="text" id="TaskBuilding_task_url" name="TaskBuilding[task_url]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.task_url}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="TaskBuilding_task_url_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_task_img">任务配图</label>

                    <div class="col-sm-7">
                        <div class="uploader-container-single">
                            <div id="fileList" class="uploader-list">
                                <div id="WU_FILE_0" class="file-item thumbnail"><img src="{$dataObj.task_img}"></div>
                            </div>
                            <div>
                                <div id="filePicker" class="webuploader-container">
                                    <div class="webuploader-pick">选择图片</div>
                                    <div id="rt_rt_19blisudrfqme9b19vknr33to1"
                                         style="position: absolute; top: 0px; left: 0px; width: 70px; height: 35px; overflow: hidden; bottom: auto; right: auto;">
                                        <input type="file" name="file" class="webuploader-element-invisible"
                                               multiple="multiple" accept="image/*"><label
                                                style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label>
                                    </div>
                                </div>
                                <button type="button" id="ctlBtn" class="new-default" style="display: none;">开始上传
                                </button>
                            </div>
                        </div>
                        <input type="text" hidden id="TaskBuilding_task_img" name="TaskBuilding[task_img]"
                               size="60" maxlength="200" class="col-xs-10 col-sm-5"
                               value="{$dataObj.task_img}"/>
                    </div>
                    <div class="col-sm-2"><span class="help-inline middle" id="TaskBuilding_task_img_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_building_id">楼盘ID</label>

                    <div class="col-sm-7"><input type="text" id="TaskBuilding_building_id"
                                                 name="TaskBuilding[building_id]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.building_id}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="TaskBuilding_building_id_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_building_name">楼盘名称</label>

                    <div class="col-sm-7"><input type="text" id="TaskBuilding_building_name"
                                                 name="TaskBuilding[building_name]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.building_name}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="TaskBuilding_building_name_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"
                           for="TaskBuilding_building_address">楼盘地址</label>

                    <div class="col-sm-7"><input type="text" id="TaskBuilding_building_address"
                                                 name="TaskBuilding[building_address]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.building_address}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle"
                                                id="TaskBuilding_building_address_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"
                           for="TaskBuilding_building_open_time">楼盘开盘时间</label>

                    <div class="col-sm-7">
                        {*<input type="text" id="TaskBuilding_building_open_time"*}
                        {*name="TaskBuilding[building_open_time]" size="60" maxlength="200"*}
                        {*class="col-xs-10 col-sm-5" value="{$dataObj.building_open_time}"/>*}
                        <input class="date-picker" id="TaskBuilding_building_open_time"
                               name="TaskBuilding[building_open_time]" type="text"
                               data-date-format="yyyy-mm-dd" value="{$dataObj.building_open_time}"/>
                        <span class="">
                                <i class="fa fa-calendar bigger-110"></i>
                        </span>
                    </div>
                    <div class="col-sm-2"><span class="help-inline middle"
                                                id="TaskBuilding_building_open_time_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"
                           for="TaskBuilding_building_price">楼盘单价</label>

                    <div class="col-sm-7"><input type="text" id="TaskBuilding_building_price"
                                                 name="TaskBuilding[building_price]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.building_price}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle"
                                                id="TaskBuilding_building_price_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"
                           for="TaskBuilding_building_detail">楼盘详情</label>

                    <div class="col-sm-7"><textarea id="TaskBuilding_building_detail"
                                                    name="TaskBuilding[building_detail]" class="col-xs-10 col-sm-5"
                                                    placeholder="楼盘详情">{$dataObj.building_detail}</textarea></div>
                    <div class="col-sm-2"><span class="help-inline middle"
                                                id="TaskBuilding_building_detail_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_project">所属项目</label>

                    <div class="col-sm-7"><select class="form-control" id="TaskBuilding_project"
                                                  name="TaskBuilding[project]" style="width:120px;">
                            {*<option value="1"{if $dataObj.project eq "1"} selected="selected"{/if}>个人中心</option>*}
                            <option value="2"{if $dataObj.project eq "2"} selected="selected"{/if}>众筹</option>
                            <option value="3"{if $dataObj.project eq "3"} selected="selected"{/if}>分权</option>
                            <option value="4"{if $dataObj.project eq "4"} selected="selected"{/if}>房乎</option>
                        </select></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="TaskArticle_status_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_brokerage_max">最高佣金</label>

                    <div class="col-sm-7"><input type="text" id="TaskBuilding_brokerage_max"
                                                 name="TaskBuilding[brokerage_max]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.brokerage_max}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="TaskBuilding_brokerage_max_em_">  </span>
                    </div>
                </div>
                {*<div class="form-group">*}
                    {*<label class="col-sm-2 control-label no-padding-right"*}
                           {*for="TaskBuilding_dividend_ratio">佣金比例</label>*}

                    {*<div class="col-sm-7"><input type="text" id="TaskBuilding_dividend_ratio"*}
                                                 {*name="TaskBuilding[dividend_ratio]" size="60" maxlength="200"*}
                                                 {*class="col-xs-10 col-sm-5" value="{$dataObj.dividend_ratio}"/></div>*}
                    {*<div class="col-sm-2"><span class="help-inline middle"*}
                                                {*id="TaskBuilding_dividend_ratio_em_">  </span></div>*}
                {*</div>*}
                {*<div class="form-group">*}
                    {*<label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_point_amount">积分数量</label>*}

                    {*<div class="col-sm-7"><input type="text" id="TaskBuilding_point_amount"*}
                                                 {*name="TaskBuilding[point_amount]" size="60" maxlength="200"*}
                                                 {*class="col-xs-10 col-sm-5" value="{$dataObj.point_amount}"/></div>*}
                    {*<div class="col-sm-2"><span class="help-inline middle" id="TaskBuilding_point_amount_em_">  </span>*}
                    {*</div>*}
                {*</div>*}
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_status">状态</label>

                    <div class="col-sm-7"><select class="form-control" id="TaskBuilding_status"
                                                  name="TaskBuilding[status]" style="width:120px;">
                            <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>
                            <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option>
                        </select></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="TaskBuilding_status_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskBuilding_flag">类型</label>

                    <div class="col-sm-7"><select class="form-control" id="TaskBuilding_flag" name="TaskBuilding[flag]"
                                                  style="width:120px;">
                            <option value="1"{if $dataObj.flag eq "1"} selected="selected"{/if}>普通</option>
                            <option value="2"{if $dataObj.flag eq "2"} selected="selected"{/if}>热推</option>
                            <option value="3"{if $dataObj.flag eq "3"} selected="selected"{/if}>默认</option>
                        </select></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="TaskBuilding_flag_em_">  </span></div>
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