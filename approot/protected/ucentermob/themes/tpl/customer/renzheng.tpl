
    <form id="myform" action="{yii_createurl c=customer a=renzheng order_id=$where.order_id step=$step+1 }" method="post" >
    <section>
        <ul class="tab-order list-unstyled">
            <li {if $step == 1}class="active"{/if} ><a href="javascript:void(0)">设置交易密码</a></li>
            <li {if $step == 2}class="active"{/if} ><a href="javascript:void(0)">绑定银行卡</a></li>
        </ul>

        <!--设置交易密码--> 
        {if $step == 1}
		<div class="commont-style">
			<div class="h-import-style ">
				<span>设置密码</span>
				<input id="pwd" type="password" name="pwd" class="comment-input" value="" placeholder="6-18位字母数字组合"/>
			</div>
			<div class="h-import-style">
				<span>确认密码</span>
				<input id="pwd1" type="password" name="pwd1" type="text" class="comment-input" value="" placeholder="6-18位字母数字组合"/>
			</div>
		</div>
		
		<p class="container mg-t20 rede4" style="color:#e43b3e"><i class="icon-exclamation-sign"></i> 6-18位字母数字组合。</p>
		{/if }
		{if $step == 2}
        <!--绑定银行卡--> 
		<div class="commont-style">
			<div class="h-import-style ">
				<span>真实姓名</span>
				<input {if $platinfo.bind_status ==1 }readonly=""{/if} value="{if $platinfo.bind_status ==1 }{$platinfo.real_name}{else}{$userbaseinfo.member_fullname}{/if}" id="real_name" name="real_name" type="text" class="comment-input"  placeholder="请输入真实姓名" />
			</div>
			<div class="h-import-style">
				<span>身份证号</span>
				<input {if $platinfo.bind_status ==1 }readonly=""{/if} value="{$userbaseinfo.member_id_number}" id="id_no" name="id_no" type="text" class="comment-input"  placeholder="请输入身份证号"/>
			</div>
			<div class="h-import-style ">
				<span name="bank_name">选择银行</span>
				<select style="width:50%" name="card_code" >
				{foreach from=$bank_list item=blist key="key"}
				<option {if $blist == $platinfo.bank_code && $platinfo.bind_status ==0 }{/if} value="{$key}">{$blist}</option>
				{/foreach}
				
				</select>
				<i class="icon-angle-right icon-left h-right"></i>
			</div>
			<div class="h-import-style ">
				<span>银行卡号</span>
				<input id="platform_account" name="platform_account" type="text" class="comment-input" value="{$platinfo.platform_account}" placeholder="请输入银行卡号"/>
			</div>
			<div class="h-import-style ">
				<span>留存手机号</span>
				<input id="member_mobile" name="member_mobile"  type="text" class="comment-input" value="{$platinfo.member_mobile}" placeholder="请输入银行留存手机号"/>
			</div>
		</div>
		{/if }
        <div class="container mg-t20">
        	<input type="hidden" name="act" value="do_save" />
           
        	<a onclick="submit_renzheng({$step})"  href="javascript:void(0)" class="btn-red">提交</a>
        </div>
    </section>
</form>