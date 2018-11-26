<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/reg.css" />
<!--/coolie-->
<section class="tab">
        <a href="{yii_createurl c=user a=login return_url=$return_url}" class="on active">登录</a>
        <a href="{yii_createurl c=user a=register return_url=$return_url}" class="off">注册</a>
</section>
<input type="hidden" name="return_url" value="{$return_url}" id="return_url" />
<section class="form-box reg-box">
        <ul>
                <li>
                        <span>手机号码</span>
                        <input type="tel" name="username" class="form-input" placeholder="请输入手机号码" id="phone" />
                </li>
                <li>
                        <span>登录密码</span>
                        <input type="password" name="password" class="form-input" placeholder="请输入密码" id="password" />
                </li>
                {if $wechat_auth_info}
                <li>
                        登录将绑定到微信：<img src="{$wechat_auth_info['headimgurl']}" style="width:32px;height:32px;"> &nbsp;{$wechat_auth_info['nickname']}
                </li>
                <li>
                        openid:
                         {$wechat_auth_info['openid']}
                </li>
                {/if}
                <li style="text-align:right">
                {if $wechat_auth_info}
                    <a href="{yii_createurl c=user a=logout return_url=$return_url}">我不想绑定微信</a> &nbsp;|&nbsp;
                {/if}
                    <a href="{yii_createurl c=user a=forgetMobile return_url=$return_url}">忘记密码？</a>
                </li>
        </ul>
        <input type="hidden" id="postUri" value="{yii_createurl c=user a=loginForm}"/>
</section>
<section class="btn-link">
        <button class="btn lot-btn">登录</button>
</section>
<script coolie src="../../../../../resource/xahoo3.0/js/lib/coolie/coolie.min.js"
    data-config="../../conf/coolie-config.js"
    data-main="../main/login_main.js"></script>
