# Xahoo - A demo website with membership system

English | [中文](README.zhCN.md)

Xahoo website is a demo website, used to show a set of member management system. Including member function, points system, points level, sign in, share earn points, points games, information, posters, wechat red envelope, invite friends and other functions.

The front-end interface uses the Yii framework, and the back-end information data uses golang to subscribe to rss.


Demo: http://xahoo.xenith.top/

Test Users(10)： 15011111120-15011111129 a123456

Management: http://b.xahoo.xenith.top/


## Configuration
Copy this project to webroot of nginx. e.g. `/data/wwwroot/`.

Copy `approot/protected/xahoomob/config/main.php.bak` as `approot/protected/xahoomob/config/main.php` and fill the specific parameters for database or cache server.

Copy `approot/protected/xahooadmin/config/main.php.bak` as `approot/protected/xahooadmin/config/main.php` and fill the specific parameters for database or cache server.

Config the database paremeters in `approot/protected/commands/config/consoleConfig.php`.

`approot/frontendmob.php` is the entrance of guest side which relates dir `approot/protected/xahoomob/`.

`approot/backend.php` is the entrance of management side which uses dir `approot/protected/xahooadmin/`.

nginx configuration：
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
It is prefered to use MySql as the database provider. Please import `approot/data/xahoo_20170604.sql` which includes testing data.

Then please execute `approot/install.sh` to add permissions for the log directories.

Build gofeed under the directory `gofeed`. Go environment should be installed. [See go here](https://studygolang.com/articles/1605)

```
$ cd gofeed
$ go build main.go

```
Run `./main` to start getting news from feed sources.


## crontab 
```
# scheduled to scrap news and storage into local database
1 8 * * * /data/wwwroot/xahoo/gofeed/main -url http://www.ftchinese.com/rss/feed >/dev/null 2>&1
# scheduled to cound reading data
1 10 * * * /usr/local/php/bin/php /data/wwwroot/xahoo/approot/protected/commands/console.php stastic stasticArticle --dur=-1  >/dev/null 2>&1
```

