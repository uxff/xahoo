<!--/coolie-->
<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/mine.css" />
<!--/coolie-->
<header class="list-header">{$pageTitle}</header>
<section class="task-list">
    <div class="mine_top">
        <img src="../../../../../resource/xahoo3.0/images/integral/mine_bg.jpg" alt="">
        <div class="mine_top_con">
            <div class="fl">
                <div class="mine_icon">
                    <a href="{yii_createurl c=my a=editprofile}">
                    {if !empty($memberInfo.member_avatar)}
                        <img src="{$memberInfo.member_avatar}" alt="" coolieignore>
                    {else}
                        <img src="../../../../../resource/xahoo3.0/images/integral/friend_icon.png" alt="">
                    {/if}
                    </a>
                </div>
                <div class="mine_info">
                    <p class="mine_name">{$member_nickname}</p>
                    <p class="mine_rank">{$levelList[$totalInfo.level].title}</p>
                    <div class="rank_bar">
                        <div class="bar" style="width: {$percentLevelUp}%"></div>
                        <span class="rank_num">LV{$totalInfo.level*1}</span>
                    </div>
                </div>
            </div>
            <div class="check_in">
                <a href="{yii_createurl c=my a=checkin}" class="sm-btn">{$checkBtnText}</a>
            </div>
        </div>
    </div>
    <div class="mine_cont">
        <a href="{yii_createurl c=myPoints a=index}" class="mine_item">
            <span class="iconfont left_icon">&#xe611;</span>我的积分({$totalInfo.points_total})
            <span class="right_icon iconfont">&#xe600;</span>
        </a>
        <a href="{yii_createurl c=myHaibao a=myreward}" class="mine_item">
            <span class="iconfont left_icon">&#xe616;</span>我的奖励({$totalInfo.money_total}元)
            <span class="right_icon iconfont">&#xe600;</span>
        </a>        
        <a href="{yii_createurl c=my a=task}" class="mine_item">
            <span class="iconfont left_icon">&#xe60e;</span>我的任务
            <span class="right_icon iconfont">&#xe600;</span>
        </a>
        <a href="{yii_createurl c=my a=myfriend}" class="mine_item">
            <span class="iconfont left_icon">&#xe607;</span>我的好友
            <span class="right_icon iconfont">&#xe600;</span>
        </a>
        <a href="{yii_createurl c=site a=invite invite_code=$invite_code}" class="mine_item">
            <span class="iconfont left_icon">&#xe60f;</span>邀请好友
            <span class="right_icon iconfont">&#xe600;</span><i class="icon_info">邀请好友享更多优惠</i>
        </a>
        <a href="javasrcipt:;" class="mine_item">
            <span class="iconfont left_icon">&#xe60d;</span>积分商城
            <span class="wait">敬请期待</span>
        </a>
    </div>
    <div class="mine_cont">
        <a href="tel:400 0000 0000" class="mine_item"><span class="iconfont left_icon">&#xe60a;</span>联系我们<span class="right_icon iconfont">&#xe600;</span></a>
        <a href="{yii_createurl c=site a=aboutus}" class="mine_item"><span class="iconfont left_icon">&#xe60c;</span>关于我们<span class="right_icon iconfont">&#xe600;</span></a>
    </div>
    <div class="btn-link">
        <a href="{yii_createurl c=my a=logout logout_return_url=$logout_return_url}" class="btn lot-btn" type="button">退出登录</a>
    </div>
</section>
<footer class="index-footer">
    <nav class="footer-nav">
        <ul>
            <li><a href="{yii_createurl c=site a=index}"><i class="iconfont index-iconfont">&#xe602;</i>首页</a></li>
            <li><a href="{yii_createurl c=lizhuan a=index}"><i class="iconfont index-iconfont">&#xe606;</i>任务</a></li>
            <li class="active"><a href="javasrcipt:;"><i class="iconfont index-iconfont">&#xe610;</i>我的</a></li>
        </ul>
    </nav>
</footer>
