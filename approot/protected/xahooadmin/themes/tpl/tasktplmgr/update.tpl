<div class="page-content-area">
    <div class="page-header">
        <h1>
            <a href="backend.php?r=taskTplMgr">任务管理</a>
            <small> <i class="ace-icon fa fa-angle-double-right"></i>
                编辑
            </small>
            <small> <strong>提示信息：以下均为必选项</strong>
            </small>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="row task-cont">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            {if $errormsgs}
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i>
                </button>
                {$errormsgs}
            </div>
            {/if}
            <form class="form-horizontal" id="taskTplMgr-form" role="form" action="backend.php?r=taskTplMgr/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group col-xs-12">
                    <div class="form-group col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right" for="TaskTplModel_task_name">任务名称</label>
                        <div class="col-sm-6">
                            <input type="text" id="TaskTplModel_task_name" name="TaskTplModel[task_name]" size="60" maxlength="200" class="col-xs-12 col-sm-12" value="{$dataObj.task_name}" />
                        </div>
                        <div class="col-sm-0">
                            <span class="help-inline middle" id="TaskTplModel_task_name_em_"></span>
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right" for="TaskTplModel_task_name">奖励类型</label>                        
                        <div class="col-sm-7">
                            <span style="margin-right:10px ">
                                <input type="checkbox" class="reward_type_money" name="TaskTplModel[reward_type_money]" {if $dataObj.reward_type_money}checked{/if}  value="2"/>
                            </span>                        
                                现金&nbsp;&nbsp;<input type="text" class="reward_val" name="TaskTplModel[reward_money]" value="{$dataObj.reward_money}" size="7" style="margin-right:10px " />元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                上限&nbsp;&nbsp;<input type="text" class="reward_val" name="TaskTplModel[money_upper]" value="{$dataObj.money_upper}" size="7" style="margin-right:10px " />元
                            <br /><br />
                            <span style="margin-right:10px ">
                                <input type="checkbox" class="reward_type" name="TaskTplModel[reward_type]" {if $dataObj.reward_type}checked{/if} value="1"/>
                            </span>
                                积分&nbsp;&nbsp;<input type="text" class="reward_val" name="TaskTplModel[reward_points]" value="{$dataObj.reward_points}" size="7" style="margin-right:10px " />分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                上限&nbsp;&nbsp;<input type="text" class="reward_val" name="TaskTplModel[integral_upper]" value="{$dataObj.integral_upper}" size="7" style="margin-right:10px " />分
                            <span class="radio_text"></span>
                        </div>
                        <div class="col-sm-0">
                            <span class="help-inline middle" id="TaskTplModel_task_name_em_"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="form-group col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right" for="TaskTplModel_act_type">任务分类</label>
                        <div class="col-sm-6">
                            <select class="form-control col-xs-12 col-sm-12" id="TaskTplModel_act_type" name="TaskTplModel[act_type]">
                                <option value="1"{if $dataObj.act_type eq "1"} selected="selected"{/if}>活动分享</option>
                                <option value="2"{if $dataObj.act_type eq "2"} selected="selected"{/if}>项目分享</option>
                                <option value="3"{if $dataObj.act_type eq "3"} selected="selected"{/if}>企业资讯</option>
                                <option value="4"{if $dataObj.act_type eq "4"} selected="selected"{/if}>其他</option>
                            </select>
                        </div>
                        <div class="col-sm-0">
                            <span class="help-inline middle" id="TaskTplModel_act_type_em_"></span>
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right" for="TaskTplModel_status">任务状态</label>
                        <div class="col-sm-6">
                            <select class="form-control col-xs-12 col-sm-12" id="TaskTplModel_status" name="TaskTplModel[status]">
                                <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>未发布</option>
                                <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>已发布</option>
                                <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>已撤销</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <span class="help-inline middle" id="TaskTplModel_status_em_"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="form-group col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right" for="TaskTplModel_task_type">目标分类</label>
                        <div class="col-sm-6">
                            <select class="form-control col-xs-12 col-sm-12" id="TaskTplModel_task_type" name="TaskTplModel[task_type]" disabled>
                                <option value="1"{if $dataObj.task_type eq "1"} selected="selected"{/if}>分享任务</option>
                                <option value="2"{if $dataObj.task_type eq "2"} selected="selected"{/if}>完善信息</option>
                                <option value="3"{if $dataObj.task_type eq "3"} selected="selected"{/if}>邀请注册</option>
                            </select>
                        </div>
                        <div class="col-sm-0">
                            <span class="help-inline middle" id="TaskTplModel_task_type_em_"></span>
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right" for="TaskTplModel_step_need_count">目标数量</label>
                        <div class="col-sm-6">
                            <input type="text" id="TaskTplModel_step_need_count" name="TaskTplModel[step_need_count]" size="60" maxlength="200" class="col-xs-12 col-sm-12" value="{$dataObj.step_need_count}" />
                        </div>
                        <div class="col-sm-0">
                            <span class="help-inline middle" id="TaskTplModel_step_need_count_em_"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="form-group col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right" for="TaskTplModel_task_url">URL</label>
                        <div class="col-sm-6">
                            <input type="text" id="TaskTplModel_task_url" name="TaskTplModel[task_url]" size="60" maxlength="200" class="col-xs-12 col-sm-12" value="{$dataObj.task_url}" />
                        </div>
                        <div class="col-sm-0">
                            <span class="help-inline middle" id="TaskTplModel_task_url_em_"></span>
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right" for="TaskTplModel_weight">权重</label>
                        <div class="col-sm-6">
                            <input type="text" id="TaskTplModel_weight" name="TaskTplModel[weight]" size="60" maxlength="200" class="col-xs-12 col-sm-12" value="{$dataObj.weight}" title="越小排序越前"/>
                        </div>
                        <div class="col-sm-0">
                            <span class="help-inline middle" id="TaskTplModel_weight_em_"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="form-group col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right" for="TaskTplModel_surface_url">封面图</label>
                    </div>
                </div>
                <div class="form-group col-xs-12" style="margin-top: -35px;">
                    <img id="img_TaskTplModel_surface_url" class="col-xs-3" src="{$dataObj.surface_url}" style="height:173px; margin-left: 160px;"/>
                    <input type="hidden" id="TaskTplModel_surface_url" name="TaskTplModel[surface_url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.surface_url}" />
                    <!--上传图片插件 开始-->
                    <div class="form-group col-xs-3">
                        <div id="container" style="margin-top: 10px;">
                            <div id="uploader">
                                <div class="statusBar" style="display:none;">
                                    <div class="info"></div>
                                    <div class="btns">
                                        <div id="filePicker2"></div>
                                        <div class="uploadBtn">开始上传</div>
                                    </div>
                                </div>
                                <div class="queueList">
                                    <div id="dndArea" class="placeholder">
                                        <div id="filePicker"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--上传图片插件 结束-->
                    <div class="col-sm-0">
                        <span class="help-inline middle" id="TaskTplModel_surface_url_em_"></span>
                    </div>
                </div>
                <div class="clearfix form-actions col-xs-12" style="background: #ddd; padding: 15px 0;">
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn btn-info" type="submit">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            提交
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){

        var radio = $('.radio_status').val();
        if(radio == 2){
            $(".radio_2").attr("checked",true);
            $(".radio_text").text("元");
            $('.reward_val').attr('name',"TaskTplModel[reward_money]");
        }else if (radio == 1){
            $(".radio_1").attr("checked",true);
            $(".radio_text").text("分");
            $('.reward_val').attr('name',"TaskTplModel[reward_points]"); 
        }
        $('.reward_type').on('change',function(){
            var radio_class = $(this).attr('class');
            if(radio_class == 'reward_type radio_1'){
                console.log(radio_class);
                $(".radio_text").text("分");
                $('.reward_val').attr('name',"TaskTplModel[reward_points]"); 
                $('.reward_val').val('{$dataObj.reward_points}');
            }
            if(radio_class == 'reward_type radio_2'){
                 $(".radio_text").text("元");
                $('.reward_val').attr('name',"TaskTplModel[reward_money]"); 
                $('.reward_val').val('{$dataObj.reward_money}');
            }
        });
    });
</script>
{if !empty($jsShell)}
    {$jsShell}
{/if}
<!-- /.page-content-area -->
{include file='./create.js.tpl'}
<style type="text/css">
    .task-cont{ padding-top: 10px; }
    .form-actions { background-color: #fff; border-top: 0; }
    #uploader .placeholder .webuploader-pick { margin: 0; }
    #uploader .statusBar .btns { left: 45px; top: -13px; }
    #uploader .statusBar .info { padding-top: 20px; }
    #filePicker { position: absolute; left: 36px; top: -10px; }
    #container { border:0!important; }
    #uploader .filelist li p.progress{ bottom: -20px; }
    #uploader .filelist { margin-top: 5px; }
</style>