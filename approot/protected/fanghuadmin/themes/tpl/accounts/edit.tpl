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
    <h1> <a href="backend.php?r=poster">海报管理</a> <small> <i class="ace-icon fa fa-angle-double-right"></i>编辑公众号 </small> </h1>
    {*
    <h1> 提示信息： <small> 以下均为必选项 </small> </h1>
    *} </div>
  <!-- /.page-header -->
  
  <div class="row">
    <div class="col-xs-12"> 
      <form class="form-horizontal"  id="poster_form" role="form" onsubmit="return check_form_two();" action="backend.php?r=Accounts/update&id={$accountsData['id']}" method="POST"  autocomplete="off">
        <br /><br />        
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="accounts_name">公众号名称*</label>
              <div class="col-sm-8">
                <input type="text" id="accounts_name" name="poster[accounts_name]" size="60"  class="col-xs-10 col-sm-12" placeholder="输入公众号名称" value="{$accountsData['accounts_name']}" />
              </div>
              <label class="control-label no-padding-right" for="accounts_name"></label>
              <div class="col-sm-1"> <span class="help-inline middle" id="accounts_name_em_"> </span> </div>
            </div>
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="token">token*</label>
              <div class="col-sm-8">
                <input type="text" id="token" name="poster[token]" size="60"  class="col-xs-10 col-sm-12" placeholder="输入公众号的AppSecret" value="{$accountsData['token']}" />
              </div>
              <label class="control-label no-padding-right" for="token"></label>
              <div class="col-sm-1"> <span class="help-inline middle" id="token_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="appid">AppID*</label>
              <div class="col-sm-8">
                <input type="text" id="appid" name="poster[appid]" size="60"  class="col-xs-10 col-sm-12" placeholder="输入公众号的AppID" value="{$accountsData['appid']}" />
              </div>
              <label class="control-label no-padding-right" for="appid"></label>
              <div class="col-sm-1"> <span class="help-inline middle" id="appid_em_"> </span> </div>
            </div>
            
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="appsecret">AppSecret*</label>
              <div class="col-sm-8">
                <input type="text" id="appsecret" name="poster[appsecret]" size="60"  class="col-xs-10 col-sm-12" placeholder="输入公众号的AppSecret" value="{$accountsData['appsecret']}" />
              </div>
              <label class="control-label no-padding-right" for="appsecret"></label>
              <div class="col-sm-1"> <span class="help-inline middle" id="appsecret_em_"> </span> </div>
            </div>
          </div>
        </div>
        <br />
        
        <div class="box_base poster_baseinfo clearfix">
          <div class="col-xs-12">
            <div class="form-group col-xs-6">
              <label class="col-sm-3 control-label no-padding-right" for="EncodingAESKey">EncodingAESKey*</label>
              <div class="col-sm-8">
                <input type="text" id="EncodingAESKey" name="poster[EncodingAESKey]" size="60"  class="col-xs-10 col-sm-12" placeholder="输入公众号的EncodingAESKey" value="{$accountsData['EncodingAESKey']}" />
              </div>
              <label class="control-label no-padding-right" for="EncodingAESKey"></label>
              <div class="col-sm-1"> <span class="help-inline middle" id="EncodingAESKey_em_"> </span> </div>
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
