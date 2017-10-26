# Xahoo 一个小型会员系统demo。

Xahoo网站是一个demo网站，用于展示一套会员经营系统。包括会员功能，积分系统，积分等级，签到，分享赚积分，积分游戏，资讯，海报，微信红包，邀请好友等功能展示。


前端界面使用Yii框架，后端资讯数据使用golang订阅rss。

展示地址: http://xahoo.xenith.top/

测试账号(10个)： 15011111120-15011111129 a123456

后台展示地址： http://b.xahoo.xenith.top/

## crontab 
```
# 定时爬取资讯
1 8 * * * /data/wwwroot/xahoo/gofeed/main -url http://www.ftchinese.com/rss/feed >/dev/null 2>&1
# 定时统计资讯数据
1 10 * * * /usr/local/php/bin/php /data/wwwroot/xahoo/approot/protected/commands/console.php stastic stasticArticle --dur=-1  >/dev/null 2>&1
```

