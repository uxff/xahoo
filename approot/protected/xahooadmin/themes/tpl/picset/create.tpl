
<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="backend.php?r=picset">图库管理</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 新增 </small> </h1><br />
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

                        <form class="form-horizontal"  id="picset-form" role="form" action="backend.php?r=picset/create" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicSetModel_title">图片标题</label>
                    <div class="col-sm-7"><input type="text" id="PicSetModel_title" name="PicSetModel[title]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.title}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicSetModel_title_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicSetModel_used_type">图片用途</label>
                    <div class="col-sm-7">
                        <select class="form-control" id="PicSetModel_used_type" name="PicSetModel[used_type]" style="width:120px;">
                        <option value="">请选择</option>
                        {foreach from=$arrUsedType key=k item=v}
                        <option value="{$k}"{if $dataObj.used_type eq $k} selected="selected"{/if}>{$v}</option>
                        {/foreach}
                        </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicSetModel_used_type_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicSetModel_type">类型</label>
                    <div class="col-sm-7">
                        <select class="form-control" id="PicSetModel_type" name="PicSetModel[type]" style="width:120px;">
                        
                        <option value="1"{if $dataObj.type eq "1"} selected="selected"{/if}>单张图片</option>
                        <option value="2"{if $dataObj.type eq "2"} selected="selected"{/if}>多张轮播</option>
                        </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicSetModel_type_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicSetModel_circle_sec">轮播间隔</label>
                    <div class="col-sm-7">
                    <select class="form-control" id="PicSetModel_circle_sec" name="PicSetModel[circle_sec]" style="width:120px;">
                    <option value="">请选择</option>
                    <option value="3"{if $dataObj.circle_sec eq "3"} selected="selected"{/if}>3s</option>
                    <option value="4"{if $dataObj.circle_sec eq "4"} selected="selected"{/if}>4s</option>
                    <option value="5"{if $dataObj.circle_sec eq "5"} selected="selected"{/if}>5s</option>
                    <option value="6"{if $dataObj.circle_sec eq "6"} selected="selected"{/if}>6s</option>
                    <option value="7"{if $dataObj.circle_sec eq "7"} selected="selected"{/if}>7s</option>
                    <option value="8"{if $dataObj.circle_sec eq "8"} selected="selected"{/if}>8s</option>
                    <option value="9"{if $dataObj.circle_sec eq "9"} selected="selected"{/if}>9s</option>
                    </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicSetModel_circle_sec_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicSetModel_pic">图片</label>
                    <div class="col-sm-7">
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicSetModel_pic_em_">  </span> </div>
                </div>
                <ul class="pic-elements">
                <!--已上传的图片 开始-->
                <li id="pic-element-tpl" style="display:none">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for=""></label>
                    <div class="col-sm-7">
                        <img src="" style="width:250px;height:173px" />
                        <label>URL<input type="text"/></label>
                        <label>权重<input type="text"/></label>
                        <input type="button" value="删除图片" onclick="deletePic(1)"/>
                        <input type="button" value="替换图片"/>
                        
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicSetModel_pic_set_em_">  </span> </div>
                </div>
                </li>
                <!--已上传循环-->
                <!--已上传的图片 结束-->
                </ul>
<div class="form-group">
    <div id="container">
        <div id="uploader">
            <div class="statusBar" style="display:none;">
                <div class="info"></div>
                <div class="btns">
                    <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
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
