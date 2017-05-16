 <header class="header">
        <div class="h-topbox">
            <p class="h-top">绑定银行卡</p>
            <a href="" class="h-item-left icon-angle-left"></a>
        </div>
    </header>
    <section>
		<div class="container mg-t10">
			<div class="h-annotation">
				<p>我们已经发送短信验证码至{$maskphone}，请在输入框内填写验证码，若未收到请耐心等待</p>
			</div>
		</div>
		<div class="commont-style mg-t10">
			<div class="h-import-style">
				<input id="code" name="code" type="text" class="comment-input h-left width-max" placeholder="请输入验证码"  autocomplete="off"/>
				<font id="send" class="h-right blue5c h-fs14">获取验证码</font>
			</div>
		</div>
		<div class="container">
		    <input type="hidden" id="requestid" value="{$where.requestid}" />
		    <input type="hidden" id="plat_id" value="{$where.plat_id}" />
			<a onclick="send_verifycode()" href="javascript:void(0);" class="btn-red  mg-t20 mg-b20">确认</a>
		</div>
    </section>