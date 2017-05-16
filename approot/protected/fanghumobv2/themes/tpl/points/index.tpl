		<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/integral.css" />
		<div class="container">		
			<section class="task-list">
				<div class="integral_top">
					<div class="integral_now">
						<div class="integral_now_title">当前积分</div>
						<div class="integral_now_info">{$totalInfo.points_total}</div>
					</div>
					<a href="{yii_createurl c=myPoints a=pointsrule}" class="integral_get">如何获取积分</a>
				</div>
				<div class="integral_con">
					<div class="integral_tl">积分明细<a href="{yii_createurl c=myPoints a=pointshistory}" class="integral_more">查看全部<span class="iconfont r_bot">&#xe600;</span></a></div>
					{if !empty($pointsHistory)}
						{foreach from=$pointsHistory item=item}
							<a href="javasrcipt:;" class="integral_item">
								<div class="fl">
									<p class="ig_tl">{$item.remark}</p>
									<p class="ig_time">{$item.last_modified}</p>
								</div>
								<div class="fr"><span class="{$item.class}">{$item.points}</span></div>
							</a>
						{/foreach}
					{/if}
					
				</div>
				{if !empty($actPicsModel)}
				<h3 class="exchange_tl">积分活动</h3>
				<div class="sm_banner">
					<div class="sm-swiper-container">
					    <div class="swiper-wrapper sm-swiper-wrapper">
							{foreach from=$actPicsModel.pics key=picsId item=picObj}
								<a href="{$picObj.link_url}"class="swiper-slide">
								<img src="{$picObj.file_path}" alt="" coolieignore/>
								</a>
							{/foreach}
					    </div>
					    <!-- 如果需要分页器 -->
					    <div class="sm-pagination"></div>
                        <input type="hidden" id="art_pic_circle_sec" value="{$actPicsModel.circle_sec*1000}">
					</div>
				</div>
				{/if}
			</section>
		</div>
		<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
			data-config="../../conf/coolie-config.js"
			data-main="../main/index_main.js"></script>
		