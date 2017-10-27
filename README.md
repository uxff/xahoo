# Xahoo 一个小型会员系统demo。

Xahoo网站是一个demo网站，用于展示一套会员经营系统。包括会员功能，积分系统，积分等级，签到，分享赚积分，积分游戏，资讯，海报，微信红包，邀请好友等功能展示。


前端界面使用Yii框架，后端资讯数据使用golang订阅rss。

展示地址: http://xahoo.xenith.top/

测试账号(10个)： 15011111120-15011111129 a123456

后台展示地址： http://b.xahoo.xenith.top/


## 配置安装
将 approot/protected/xahoomob/config/main.php.bak 复制为 approot/protected/xahoomob/config/main.php ,并修改对应数据库，缓存配置
将 approot/protected/xahooadmin/config/main.php.bak 复制为 approot/protected/xahooadmin/config/main.php , 并修改对应的数据库，缓存配置
修改 approot/protected/commands/config/consoleConfig.php 中的配置为对应的数据库配置

approot/frontendmob.php 前端入口，对应手机端目录，使用 approot/protected/xahoomob/ 项目
approot/backend.php 后端入口，对应后台管理目录，使用 approot/protected/xahooadmin/ 项目

nginx 配置：
```
server {
listen 80;
server_name xahoo.xenith.top;
access_log /data/logs/nginx/access.xahoo.xenith.top.log combined;
error_log /data/logs/nginx/error.xahoo.xenith.top.log;
index index.html index.php;
include other.conf;
root /data/wwwroot/xahoo/approot/;

location ~ .*\.(php|php5)?$  {
    fastcgi_pass unix:/tmp/php-cgi.sock;
    fastcgi_index index.php;
    include fastcgi.conf;
    }

location ~ .*\.(gif|jpg|jpeg|png|bmp|swf|flv|ico)$ {
    expires 30d;
    }

location ~ .*\.(js|css)?$ {
    expires 7d;
    }
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

}
# backend
server {
listen 80;
server_name b.xahoo.xenith.top;
access_log /data/logs/nginx/access.xahoo.xenith.top.log combined;
error_log /data/logs/nginx/error.xahoo.xenith.top.log;
index backend.php;
include other.conf;
root /data/wwwroot/xahoo/approot/;

location ~ .*\.(php|php5)?$  {
    fastcgi_pass unix:/tmp/php-cgi.sock;
    fastcgi_index index.php;
    include fastcgi.conf;
    }

location ~ .*\.(gif|jpg|jpeg|png|bmp|swf|flv|ico)$ {
    expires 30d;
    }

location ~ .*\.(js|css)?$ {
    expires 7d;
    }
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

}
```

## crontab 
```
# 定时爬取资讯
1 8 * * * /data/wwwroot/xahoo/gofeed/main -url http://www.ftchinese.com/rss/feed >/dev/null 2>&1
# 定时统计资讯数据
1 10 * * * /usr/local/php/bin/php /data/wwwroot/xahoo/approot/protected/commands/console.php stastic stasticArticle --dur=-1  >/dev/null 2>&1
```

