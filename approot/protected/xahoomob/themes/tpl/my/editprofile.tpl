<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/edit.css" />
<link rel="stylesheet" href="../../../../../resource/xahoo3.0/js/lib/webuploader/webuploader.css" />
<!--/coolie-->
    <section class="task-list">
        <a class="replace" href="javasrcipt:;">
            更换头像
            <div class="rp_icon filePicker-box">
                <div id="front" class="uploader-list">
                {if !empty($memberInfo.member_avatar)}
                    <img id="imgAvatar" src="{$memberInfo.member_avatar}" alt="" coolieignore>
                {else}
                    <img id="imgAvatar" src="{$resourcePath}/images/integral/friend_icon.png" alt="" coolieignore>
                {/if}
                </div>
                <div class="filePicker"></div>
            </div>
            <!-- <form id="frmUploadAvatar" method="post" enctype="multipart/form-data" action="{yii_createurl c=my a=uploadavatar}">
                <input type="file" name="upfile" style="width:160px;" />
                <input type="hidden" name="token" value="{$csrfToken}" />
                <input type="submit" name="submit" id="btnSubmitAvatar" value="上传" />
            </form> -->
        </a>
        <h3 class="exchange_tl">基本信息</h3>
        <!--图片上传地址 start-->
        <input type="hidden" id="urlUploadAvatar" value="{yii_createurl c=my a=uploadavatar token=$token}" />
        <!--图片上传地址 end-->
        <!--信息上传地址 start-->
        <input type="hidden" id="msgUpload" value="{yii_createurl c=my a=submitprofile}" />
        <!--信息上传地址 end-->
        <div class="form-box">
            <ul>
                <li>
                    <span>昵称</span>
                    <input type="text" class="form-input" name="member_nickname" value="{$memberInfo['member_nickname']}" placeholder="请输入昵称" id="nickname">
                </li>
                <li class="user_name">
                    <span>姓名</span>
                    {if (!empty($memberInfo['member_fullname']))}
                    <input type="text" class="form-input"  readonly=true  name="member_fullname" value="{$memberInfo['member_fullname']}" placeholder="请输入姓名" id="fullname">
                    {else}
                    <input type="text" class="form-input" name="member_fullname" value="{$memberInfo['member_fullname']}" placeholder="请输入姓名" id="fullname">
                    {/if}
                    <i>请填写真实姓名，不可修改</i>
                </li>
                <li>
                    <span>手机</span>
                    <input type="text" class="form-input" value="{$memberInfo['member_mobile']}" placeholder="请输入手机号码" readonly id="phone">
                </li>
                <li>
                    <span>邮箱</span>
                    <input type="text" class="form-input" name="member_email" value="{$memberInfo['member_email']}" placeholder="请输入邮箱" id="email">
                </li>
            </ul>
            <input type="hidden" name="member_avatar" id="avatarUrl" value="">
            <input type="hidden" name="token" id="token" value="{$csrfToken}">
        </div>
        <div class="btn-link">
            <button class="btn lot-btn">保存</button>
        </div>
    </section>
<input type="hidden" id="imgUri" value="{$resourcePath}"></input>
<!--coolie-->
<script type="text/javascript" src="../../../../../resource/xahoo3.0/js/lib/jquery/jquery-1.10.1.min.js" ></script>
<script src="../../../../../resource/xahoo3.0/js/lib/webuploader/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="../../../../../resource/xahoo3.0/js/module/uploader.js" ></script>
<!--/coolie-->
<script coolie src="../../../../../resource/xahoo3.0/js/lib/coolie/coolie.min.js"
	data-config="../../conf/coolie-config.js"
	data-main="../main/edit_pro.js"></script>
