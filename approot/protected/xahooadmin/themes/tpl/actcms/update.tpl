<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="backend.php?r=actcms">文章管理</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
                <h1> 提示信息： <small> 以下均为必选项 </small> </h1>
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

                        <form class="form-horizontal" id="actcms-form" role="form" action="backend.php?r=actcms/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_title">文章名称</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_title" name="ArticleModel[title]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.title}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_title_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_type">文章分类</label>
                    <div class="col-sm-7">
                    <select class="form-control" id="ArticleModel_type" name="ArticleModel[type]" style="width:120px;">   
                    <option value="">请选择</option>
                    <option value="1"{if $dataObj.type eq "1"} selected="selected"{/if}>文章分享</option>
                    <option value="2"{if $dataObj.type eq "2"} selected="selected"{/if}>项目分享</option>
                    <option value="3"{if $dataObj.type eq "3"} selected="selected"{/if}>企业资讯</option>
                    <option value="4"{if $dataObj.type eq "4"} selected="selected"{/if}>其他</option>
                    </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_type_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="">是否使用链接</label>
                    <div class="col-sm-7">
                    <select class="form-control" id="isUseOuterUrl" name="isUseOuterUrl" style="width:120px;">   
                    <option value="0" {if $isUseOuterUrl==0}selected{/if}>不使用</option>
                    <option value="1" {if $isUseOuterUrl==1}selected{/if}>使用</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_abstract">内容简介</label>
                    <div class="col-sm-7">
                        <textarea id="ArticleModel_abstract" class="col-xs-12" placeholder="内容简介" name="ArticleModel[abstract]">{$dataObj.abstract}</textarea>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_abstract_em_">  </span> </div>
                </div>
                <div class="form-group" id="div_outer_url" style="display:none">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_outer_url">URL链接</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_outer_url" name="ArticleModel[outer_url]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.outer_url}" placeholder="必须http或https开头" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_outer_url_em_">  </span> </div>
                </div>
                <div class="form-group" id="div_content">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_content">文章详情</label>
                    <div class="col-sm-7">
                        <div style="width:800px;margin:20px auto 40px;">
                            <script type="text/plain" id="ArticleModel_content_um" name="ArticleModel[content]" style="width:100%;height:600px;"></script>
                        </div>
                        <textarea id="ArticleModel_content" class="col-xs-10 col-sm-5" placeholder="内容" style="display:none">{$dataObj.content}</textarea>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_content_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_status">文章状态</label>
                    <div class="col-sm-7">
                    <select class="form-control" id="ArticleModel_status" name="ArticleModel[status]" style="width:120px;">
                    <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>未发布</option>
                    <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>已发布</option>
                    <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>已撤销</option>
                    </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_status_em_">  </span> </div>
                </div>
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
 <!--um编辑器-->
 <link href="{$resourcePath}/js/umeditor1_2_2-utf8-php/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet">
 <script type="text/javascript">
    // umeditor 依赖的配置
    var domain_str = '{$domain_str}';
 </script>
 <script src="{$resourcePath}/js/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
 <script src="{$resourcePath}/js/umeditor1_2_2-utf8-php/umeditor.js"></script>
 
 <script src="{$resourcePath}/js/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
 
 <script type="text/javascript">
     um = UM.getEditor('ArticleModel_content_um');
     initText = $('#ArticleModel_content').val();
     um.execCommand('insertHtml', initText);
 </script>
 <script type="text/javascript">
    // 是否使用链接
    $('#isUseOuterUrl').on('change', function(){
        var isUseOuterUrl = $('#isUseOuterUrl').val();
        if (isUseOuterUrl==1) {
            $('#div_content').hide();
            $('#div_outer_url').show();
        } else {
            $('#div_content').show();
            $('#div_outer_url').hide();
        }
    });
    $('#isUseOuterUrl').trigger('change');
 </script>
