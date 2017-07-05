<div class="page-content-area">
        <div class="page-header">
                                <h1> 修改密码</h1><br />
                {* <h1> 提示信息： <small> 以下均为必选项 </small> </h1> *}
        </div>
        <!-- /.page-header -->



        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->

                        <form class="form-horizontal" id="adminUser-form" role="form" action="backend.php?r=adminuser/updatepassword" method="POST" onsubmit="return checkSubmit()">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysAdminUser_account">用户名</label>
                    <div class="col-sm-7"><input type="text" id="SysAdminUser_account" name="SysAdminUser[account]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.account}" readonly /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysAdminUser_account_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysAdminUser_password">新密码</label>
                    <div class="col-sm-7"><input type="password" id="SysAdminUser_password" name="SysAdminUser[password]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="" onchange="checkPwd()" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysAdminUser_password_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysAdminUser_name">确认密码</label>
                    <div class="col-sm-7"><input type="password" id="SysAdminUser_repassword" name="" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="" onchange="checkRePwd()" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysAdminUser_repassword_em_">  </span> </div>
                </div>
                <div class="clearfix form-actions">
                                        <div class="text-center">
                                                <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 提交 </button>
                                        </div>
                                </div>
                        </form>
                </div>
                <!-- /.col --> 
        </div>
        <!-- /.row --> 
</div>
<script>
    function checkPwd(){
        var a = $('#SysAdminUser_password').val();
        var b = $('#SysAdminUser_repassword').val();
        if(a.length < 6 ){
            $('#SysAdminUser_password_em_').text('密码长度不得少于6位，请重试');
        }else{
            $('#SysAdminUser_password_em_').text('');
        }
        if(b.length > 0){
            checkRePwd();
        }
    }

    function checkRePwd(){
        var a = $('#SysAdminUser_repassword').val();
        var b = $('#SysAdminUser_password').val();
        if(a !== b ){
            $('#SysAdminUser_repassword_em_').text('两次输入的密码不一致，请重试');
        }else{
            $('#SysAdminUser_repassword_em_').text('');
        }
    }

    function checkSubmit(){
        var a = $('#SysAdminUser_repassword').val();
        var b = $('#SysAdminUser_password').val();
        if(a.length == 0 || b.length == 0){
            alert('密码不能为空，请输入!');
        }
        if(a.length >= 6 && b.length >= 6 && a === b){
            return true;
        }
        return false;
    }
{if $cResult == 1}
    if(confirm('密码修改成功，请使用新密码重新登录系统')){
        location.href='./backend.php?r=site/logout';
    }
    {/if}

</script>
<!-- /.page-content-area --> 