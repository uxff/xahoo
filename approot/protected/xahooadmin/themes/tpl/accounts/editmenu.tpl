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
    <h1> <a href="backend.php?r=poster">公众号管理</a> <small> <i class="ace-icon fa fa-angle-double-right"></i>编辑公众号菜单 </small> </h1>
    {*
    *} </div>
  <!-- /.page-header -->
  
  <div class="row">
    <div class="col-xs-12"> 
      <form class="form-horizontal"  id="poster_form" role="form" action="backend.php?r=mpaccounts/editmenu&id={$accountsData['id']}" method="POST"  autocomplete="off">
        <br /><br />        
        <div class="box_base poster_baseinfo clearfix">
            <div class="form-group col-xs-12">
              <div class="col-xs-6" for="accounts_name">公众号名称: {$accountsData['accounts_name']}</div>
              <div class="col-xs-6" for="appid">AppID: {$accountsData['appid']}</div>
            </div>
        </div>
        <br />
        <div class="box_base poster_baseinfo clearfix">
          <div class="form-group col-xs-12">
            <div class="col-xs-12">
              <label class="col-sm-2 control-label no-padding-right" for="mp_menu">Menu(json):</label>
              <div class="col-sm-10">
                <textarea type="text" id="mp_menu" name="mp_menu" style="min-height:400px" class="col-xs-10 col-sm-12" placeholder="输入菜单内容" value="{$mpMenu}">{$mpMenu} </textarea>
              </div>
              <label class="control-label no-padding-right" for="mp_menu"></label>
              <div class="col-sm-1"> <span class="help-inline middle" id="mp_menu_em_"> </span> </div>
            </div>
            
          </div>
        </div>
        <br />
        菜单内容样例(可参考官方技术文档：<a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141013">https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141013</a>)：
        <pre>
{
     "button":[
     {    
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {    
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
                 "type":"某某小程序",
                 "name":"wxa",
                 "url":"http://mp.weixin.qq.com",
                 "appid":"wx286b93c14bbf93aa",
                 "pagepath":"pages/lunar/index"
             },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }
        </pre>
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
