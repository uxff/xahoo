hello
<input type="button" value="share" onclick="share()"/>
<input type="button" value="close" onclick="close_me()"/>
<pre>
<br/>
appId={$signPackage["appId"]}<br/>
nonceStr={$signPackage["nonceStr"]}<br/>
signature={$signPackage["signature"]}<br/>
signUrl={$signPackage["url"]}<br/>
timestamp={$signPackage["timestamp"]}<br/>
rawString={$signPackage["rawString"]}<br/>
visitUrl={$visitUrl}<br/>
<br/>
</pre>
<span id="markinfo"></span>
{literal}
<script type="text/javascript" >
    _mwx=window._mwx||{};
    _mwx.siteId=8000228;
    _mwx.openId=''; //OpenID为微信提供的用户唯一标识,需要开发者传入，如果没有OpenID，去掉该代码即可。
    //_mz_wx_view(1);
</script>
{/literal}
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
wx.config({
  debug: true,
  appId: '{$signPackage["appId"]}',
  timestamp: '{$signPackage["timestamp"]}',
  nonceStr: '{$signPackage["nonceStr"]}',
  signature: '{$signPackage["signature"]}',
  jsApiList: [
  'checkJsApi',
  'onMenuShareTimeline',
  'onMenuShareAppMessage'
  ]
});
// 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
var currentUrl = '{$currentUrl}';
var wxtitle = '房乎 一呼百应，因友尽有';
var wxdesc = '房源差，赚的少，累成狗，来房乎吧！超多房源轻松玩出钱，让你人脉变钱脉。';
var wximg = '{$resourcePath}/imgs/wxfangfull.png';
wx.ready(function () {
    console.log('wx is ready!');
  wx.checkJsApi({
    jsApiList: [
    'checkJsApi',
    'onMenuShareTimeline',
    'getLocation',
    'onMenuShareAppMessage'
    ],
    success: function (res) {
        document.getElementById('markinfo').innerHTML = ('browser is weixin');
        alert('checkJsApi:--'+JSON.stringify(res));
    }
  });
  wx.onMenuShareTimeline({
    title: wxtitle,
    link: currentUrl,
    desc: wxdesc,
    imgUrl: wximg,
    trigger: function (res) {
      alert('用户点击分享到朋友圈');
    },
    success: function (res) {
               //_mz_wx_timeline();
                 alert('已分享');
             },
    cancel: function (res) {
               alert('已取消');
            },
    fail: function (res) {
             alert('onMenuShareTimeline fail:'+JSON.stringify(res));
      }
  });

  wx.onMenuShareAppMessage({
    title: wxtitle,
    link: currentUrl,
    desc: wxdesc,
    imgUrl: wximg,
    trigger: function (res) {
        alert('用户点击分享到朋友圈');
    },
    success: function (res) {
               //_mz_wx_friend();
                 alert('已分享');
             },
    cancel: function (res) {
               alert('已取消');
            },
    fail: function (res) {
             alert('onMenuShareAppMessage fail:'+JSON.stringify(res));
          }
  });


  wx.error(function(res){
    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
      alert("wx error errorMSG:"+JSON.stringify(res));
      alert(location.href.split('#')[0]);
  });
});


var share = function() {
  wx.onMenuShareAppMessage({
    title: wxtitle,
    link: currentUrl,
    desc: wxdesc,
    imgUrl: wximg,
    trigger: function (res) {
      alert('用户点击分享到朋友圈');
    },
    success: function (res) {
               //_mz_wx_friend();
                 alert('已分享');
             },
    cancel: function (res) {
               alert('已取消');
            },
    fail: function (res) {
             alert('onMenuShareAppMessage fail:'+JSON.stringify(res));
          }
  });


}

var close_me = function () {
    wx.closeWindow();
}
</script>
