
<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="backend.php?r=hotArticle">热门推荐</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 新增 </small> </h1><br />
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

                        <form class="form-horizontal"  id="hotArticle-form" role="form" action="backend.php?r=hotArticle/create" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="HotArticleModel_title">推荐名称</label>
                    <div class="col-sm-7"><input type="text" id="HotArticleModel_title" name="HotArticleModel[title]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.title}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="HotArticleModel_title_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="HotArticleModel_tips">标签</label>
                    <div class="col-sm-7"><input type="text" id="HotArticleModel_tips" name="HotArticleModel[tips]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.tips}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="HotArticleModel_tips_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="HotArticleModel_act_type">活动分类</label>
                    <div class="col-sm-7">
                    <select class="form-control" id="HotArticleModel_act_type" name="HotArticleModel[act_type]" style="width:120px;">
                    <option value="">请选择</option>
                    <option value="1"{if $dataObj.act_type eq "1"} selected="selected"{/if}>活动分享</option>
                    <option value="2"{if $dataObj.act_type eq "2"} selected="selected"{/if}>项目分享</option>
                    <option value="3"{if $dataObj.act_type eq "3"} selected="selected"{/if}>企业资讯</option>
                    <option value="4"{if $dataObj.act_type eq "4"} selected="selected"{/if}>其他</option>
                    </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="HotArticleModel_act_type_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="HotArticleModel_status">推荐状态</label>
                    <div class="col-sm-7">
                    <select class="form-control" id="HotArticleModel_status" name="HotArticleModel[status]" style="width:120px;">
                    <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>未发布</option>
                    <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>已发布</option>
                    <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>已撤销</option>
                    </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="HotArticleModel_status_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="HotArticleModel_url">URL</label>
                    <div class="col-sm-7"><input type="text" id="HotArticleModel_url" name="HotArticleModel[url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.url}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="HotArticleModel_url_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="HotArticleModel_weight">权重</label>
                    <div class="col-sm-7"><input type="text" id="HotArticleModel_weight" name="HotArticleModel[weight]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.weight}" title="越小排序越前"/></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="HotArticleModel_weight_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="HotArticleModel_surface_url">封面图</label>
                    <div class="col-sm-7">
                        <img id="img_HotArticleModel_surface_url" src="{$dataObj.surface_url}" style="width:250px;height:173px"/>
                        <input type="hidden" id="HotArticleModel_surface_url" name="HotArticleModel[surface_url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.surface_url}" />
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="HotArticleModel_surface_url_em_">  </span> </div>
                </div>
<!--上传图片插件 开始-->
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
<!--上传图片插件 结束-->
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