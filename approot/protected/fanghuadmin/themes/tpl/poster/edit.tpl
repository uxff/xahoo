<style>
.none-padding {
	padding-left: 0 !important;
	padding-right: 0 !important;
}
.padding-bottom {
	padding-bottom: 15px;
}
.table-header {
	background-color: #eee;
	color: #000;
	border-radius: 5px;
	margin-bottom: 5px;
}
.table-header .pull-right {
	margin-right: 10px;
	cursor: pointer
}
.thumbnail {
	position: relative;
}

.thumbnail .success {
	background: rgba(0, 0, 0, 0) url("{$resourcePath}/images/success.png") no-repeat scroll right bottom;
	bottom: 0;
	display: block;
	height: 40px;
	left: 0;
	position: absolute;
	width: 100%;
	z-index: 200;
}
.webuploader-container {
	float: left;
}
span.picture-size {
	line-height: 32px
}
.box_base {
	padding-left: 10%;
	padding-right: 12%;
}
.building_info_title {
	border-bottom: 1px solid #ccc;
	margin-bottom: 10px;
}
.building_info_title span {
	line-height: 36px;
	font-weight: bold;
	font-size: 14px;
}
.table thead tr th, .table tbody tr td {
	padding-top: 2px;
	padding-bottom: 2px;
}
 .poster_baseinfo .table thead tr th, . poster_baseinfo .table tbody tr td {
text-align:center;
}
.table td input, .table td textarea {
	width: 100%;
}
.building_info_title button, .table td button, .thumb_info_btn {
	padding: 5px 15px
}
.thumb_info_btn {
	margin-bottom: 10px;
}
.building_introduce .table {
}
.building_introduce .table tr td {
	height: 290px
}
.building_introduce .table tr td div.col-xs-12 {
	padding-top: 10px;
}
.board4_upload_btn div.col-xs-6 {
	padding: 5px 0;
}
.board4_upload_pic {
	width: 100%;
	height: 150px;
	margin-top: 10px;
	margin-bottom: 10px;
}
.xqsj_label ul {
	padding-left: 30px;
}
.show_label ul {
	display: block;
}
.show_label ul label {
	width: 100%
}
.del_property_box {
	margin-right: 10px;
}
.uploader-container-single button.new-default,.table td button.new-default { margin-left:5px; padding-top:8px;}
.uploaded_list ul li { width:100px;}

.btn-group > .btn + .btn.dropdown-toggle {
	padding-left:10px; padding-right:10px;	
}
.btn-add { font-style: normal; font-size: 24px; color: #428bca; line-height: 24px; margin-left: 10px; cursor: pointer; font-weight: bold; }
.pop-create { display: none; position: absolute; left: 50%; top: 200px; margin-left: -348.5px; border:1px solid #dcdcdc; background: #fff; padding-bottom:20px; }
.pop-create h1{ font-size: 18px; border-bottom: 1px solid #dcdcdc; padding: 10px 12px; margin:0 -12px; margin-bottom: 15px;  }
.create-title { line-height: 34px; text-align: right; }
.create-checkbox { line-height: 34px; }
.create-pic { padding:0;  }
.pop-close { float: right; cursor: pointer; font-weight: bold; color: #428bca; }
</style>

<div class="page-content-area">
  <div class="page-header">
    <h1> <a href="backend.php?r=poster">海报管理</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1>
    {*
    <h1> 提示信息： <small> 以下均为必选项 </small> </h1>
    *} </div>
  <!-- /.page-header -->
  
  <div class="row">
    <div class="col-xs-12"> 
      <form class="form-horizontal"  id="poster_form" role="form" onsubmit="return check_form_two();" action="backend.php?r=Poster/Update&id={$poster['id']}" method="POST"  autocomplete="off">
        <br />
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="advert_title">选择公众号</label>
              <div class="col-sm-8">
                <select id="poster_accounts_id" name="poster[accounts_id]" class="col-xs-12 col-sm-12">
                  <option value='0'>请选择</option>  
                  {foreach from=$accountsData key=i item=project}                       
                  <option value='{$project['id']}' {if $poster.accounts_id == $project['id']} selected {/if}>{$project['accounts_name']}</option>                                          
                  {/foreach}
                </select>
              </div>
              <div class="col-sm-1"> <span class="help-inline middle" id="poster_accounts_id_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="advert_title">选择项目*</label>
              <div class="col-sm-8">
                <select id="poster_project" name="poster[project]" class="col-xs-12 col-sm-12">
                  <option value='0'>请选择</option>  
                  {foreach from=$projectDatas key=i item=project}                       
                  <option value='{$project['project_id']}' {if $poster.project_id == $project['project_id']} selected {/if}>{$project['project_name']}</option>                                          
                  {/foreach}
                </select>
              </div>
              <div class="col-sm-1"> <span class="help-inline middle" id="poster_project_em_"> </span> </div>
            </div>
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="subscribe_rewards">首次关注奖励*</label>
              <div class="col-sm-8">
                <input type="text" id="subscribe_rewards" name="poster[subscribe_rewards]" size="60" maxlength="20" class="col-xs-10 col-sm-12" placeholder="请设置首次关注奖励金额" value="{$poster.subscribe_rewards}" />
              </div>
              <label class="control-label no-padding-right" for="subscribe_rewards">元</label>
              <div class="col-sm-1"> <span class="help-inline middle" id="subscribe_rewards_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="direct_fans_rewards">直接粉丝奖励*</label>
              <div class="col-sm-8">
                <input type="text" id="direct_fans_rewards" name="poster[direct_fans_rewards]" size="60" maxlength="20" class="col-xs-10 col-sm-12" placeholder="请设置直接粉丝奖励金额" value="{$poster.direct_fans_rewards}" />
              </div>
              <label class="control-label no-padding-right" for="direct_fans_rewards">元</label>
              <div class="col-sm-1"> <span class="help-inline middle" id="direct_fans_rewards_em_"> </span> </div>
            </div>
            
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="indirect_fans_rewards">间接粉丝奖励*</label>
              <div class="col-sm-8">
                <input type="text" id="indirect_fans_rewards" name="poster[indirect_fans_rewards]" size="60" maxlength="20" class="col-xs-10 col-sm-12" placeholder="请设置间接粉丝奖励金额" value="{$poster.indirect_fans_rewards}" />
              </div>
              <label class="control-label no-padding-right" for="indirect_fans_rewards">元</label>
              <div class="col-sm-1"> <span class="help-inline middle" id="indirect_fans_rewards_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="project_bonus_ceiling">项目奖金上限*</label>
              <div class="col-sm-8">
                <input type="text" id="project_bonus_ceiling" name="poster[project_bonus_ceiling]" size="60" maxlength="20" class="col-xs-10 col-sm-12" placeholder="请设置单个项目的最高奖励金额" value="{$poster.project_bonus_ceiling}" />
              </div>
              <label class="control-label no-padding-right" for="project_bonus_ceiling">元</label>
              <div class="col-sm-1"> <span class="help-inline middle" id="project_bonus_ceiling_em_"> </span> </div>
            </div>
            
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="project_fans_ceiling">项目粉丝上限</label>
              <div class="col-sm-8">
                <input type="text" id="project_fans_ceiling" name="poster[project_fans_ceiling]" size="60" maxlength="20" class="col-xs-10 col-sm-12" placeholder="请设置单个项目的最高粉丝人数" value="{$poster.project_fans_ceiling}" />
              </div>
              <label class="control-label no-padding-right" for="project_fans_ceiling">人</label>
              <div class="col-sm-1"> <span class="help-inline middle" id="project_fans_ceiling_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        
        
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="lowest_withdraw_sum">最低提现金额*</label>
              <div class="col-sm-8">
                <input type="text" id="lowest_withdraw_sum" name="poster[lowest_withdraw_sum]" size="60" maxlength="20" class="col-xs-10 col-sm-12" placeholder="单个用户提现的最低金额" value="{$poster.lowest_withdraw_sum}" />
              </div>
              <label class="control-label no-padding-right" for="lowest_withdraw_sum">元</label>
              <div class="col-sm-1"> <span class="help-inline middle" id="lowest_withdraw_sum_em_"> </span> </div>
            </div>
            
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="highest_withdraw_sum">最高奖励金额*</label>
              <div class="col-sm-8">
                <input type="text" id="highest_withdraw_sum" name="poster[highest_withdraw_sum]" size="60" maxlength="20" class="col-xs-10 col-sm-12" placeholder="单个用户提现的最高金额" value="{$poster.highest_withdraw_sum}" />
              </div>
              <label class="control-label no-padding-right" for="highest_withdraw_sum">元</label>
              <div class="col-sm-1"> <span class="help-inline middle" id="highest_withdraw_sum_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="advert_title">海报有效区域</label>
              <div class="col-sm-9">
                        <div class="input-group lablediv1" style="width:304px;" style="float:right;">
                            <div class='multi_select'></div>
                        </div>
              </div>
              <div class="col-sm-1"> <span class="help-inline middle" id="advert_title_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="advert_title">海报有效时间</label>
              <div class="col-sm-9">
                        <div class="input-group lablediv1" style="width:304px;" style="float:right;">
                            <input placeholder="请选择日期" type="text" class="form-control year-picker create_time_start" data-date-format="yyyy-mm-dd"
                                   id="time_start" name="poster[valid_begintime]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" {if $poster['valid_begintime'] != '0000-00-00'}value="{$poster['valid_begintime']}"{/if}/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                            <input placeholder="请选择日期" type="text" class="form-control year-picker create_time_end" data-date-format="yyyy-mm-dd"
                                   id="time_end" name="poster[valid_endtime]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" {if $poster['valid_endtime'] != '0000-00-00'}value="{$poster['valid_endtime']}"{/if}/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                        </div>
              </div>
              <div class="col-sm-1"> <span class="help-inline middle" id="advert_title_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="poster_rules">活动规则</label>
              <div class="col-sm-9">
                        <div class="input-group lablediv1" style="width:304px;" style="float:right;">
                            <textarea name="poster[poster_rules]" id="poster_rules" cols="80" rows="5">{$poster['poster_rules']}</textarea>
                        </div>
              </div>
              <div class="col-sm-1"> <span class="help-inline middle" id="poster_rules_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-9">
              <div class="col-xs-2 control-label">封面图*</div>
              <div class="col-xs-10">
                  <div class="uploader-container-single">
                    <div id="board1_fileList" class="uploader-list">
                    <div class="file-item thumbnail" style="width:100px; height:100px; overflow:hidden"><img src="{$poster['photo_url']}" class="upload_img"><span class="success"></span></div>
                    </div>
                    <div>
                      <div id="board1_filePicker">选择图片</div>
                      <button type="button" id="board1_ctlBtn" class="new-default">开始上传</button>
                      <span class="picture-size">（尺寸：{$banner_size_arr}）</span> 
                    </div>
                  </div>
                  <input type="hidden" id="board1_pic" name="poster[photo_pic]" size="60" maxlength="200" class="col-xs-10 col-sm-5 load_img_f" value="{$poster['photo_url']}" />
              </div>
            </div>
          </div>
        </div>
        <br />
        
        </div>
        <!--  end poster_baseinfo   --> 
        </div>        
        <div class="clearfix form-actions">
          <div class="col-md-offset-5 col-md-6">
            <input type="submit" class="btn btn-info" value="提交"/>
          </div>
        </div>
      </form>
    </div>    
    <!-- /.col --> 
  </div>
  <!-- /.row --> 
</div>
