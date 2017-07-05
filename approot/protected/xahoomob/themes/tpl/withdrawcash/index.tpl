		<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/cash.css" />
		<section class="form-box cash-box">
			<ul>
				<li>
					<span>￥</span>
					<input type="text" id="cash" name="cash" class="form-input cash-input" maxlength="4" placeholder="最多可提现金{$last_cash}元" />
                    <input type="hidden" id="project_id" value="{$project_id}" name="project_id"/>
                    <input type="hidden" id="allcash" value="{$last_cash}"/>
                    <input type="hidden" id="withdraw_min" value="{$withdraw_min}"/>
                    <input type="hidden" id="token" value="{$token}"/>
					<em class="all_cash">全部提现</em>
				</li>
			</ul>
			<p>红包到账时间：申请提现之日起的2-3个工作日到帐</p> 
		</section>
		<section class="btn-link">
			<button class="btn lot-btn" type="submit">确定</button>
		</section>
		<section class="cash-pop"></section>
	</body>
	<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js" data-config="../../conf/coolie-config.js" data-main="../main/cash_main.js"></script>
