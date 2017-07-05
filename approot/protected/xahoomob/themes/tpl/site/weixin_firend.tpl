{literal}
<script>
	_mwx=window._mwx||{};
    _mwx.siteId=8000228;
    _mwx.openId=''; //OpenID为微信提供的用户唯一标识,需要开发者传入，如果没有OpenID，去掉该代码即可。
</script>
{/literal}
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
	var paths = '{$resourcePath}';

	// 微信分享所需数据
	var currentUrl = '{$currentUrl}';
	var wxtitle = '邀请好友注册有礼，现在就来邀请吧！';
	var wxdesc = '邀请好友注册有礼，现在就来邀请吧！';
	var wximg = paths+'/images/lib/icon.png';
    var appid = '{$signPackage["appId"]}';
    var timestamp = '{$signPackage["timestamp"]}';
    var nonceStr = '{$signPackage["nonceStr"]}';
    var signature = '{$signPackage["signature"]}';
</script>
{literal}
<script>
	//通过config接口注入权限验证配置
	wx.config({
		debug: false,
		appId: appid,
		timestamp: timestamp,
		nonceStr: nonceStr,
		signature: signature,
		jsApiList: [
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage'
		]
	});
	
	wx.ready(function (){
		//判断当前客户端版本是否支持指定JS接口
		wx.checkJsApi({
		    jsApiList: [
			    'checkJsApi',
			    'onMenuShareTimeline',
			    'getLocation',
			    'onMenuShareAppMessage'
		    ], // 需要检测的JS接口列表，所有JS接口列表见附录2,
		    success: function(res) {
		    }
		});
		
		//分享给朋友
  		wx.onMenuShareAppMessage({
		    title: wxtitle,
		    link: currentUrl,
		    desc: wxdesc,
		    imgUrl: wximg,
   			//用户确认分享后的回调
		    success: function (res) {
		        layer.msg('分享成功！');
		    },
			//用户取消分享后的回调
		    cancel: function (res) {
		    	layer.msg('您取消了分享操作！');
		    },
		    fail: function (res) {
		    	layer.msg('出现错误，请重试！');
		    }
  		});
		
		//朋友圈
  		wx.onMenuShareTimeline({
		    title: wxtitle,
		    link: currentUrl,
		    desc: wxdesc,
		    imgUrl: wximg,
   			//用户确认分享后的回调
		    success: function (res) {
		        layer.msg('分享成功！');
		    },
			//用户取消分享后的回调
		    cancel: function (res) {
		    	layer.msg('您取消了分享操作！');
		    },
		    fail: function (res) {
		    	layer.msg('出现错误，请重试！');
		    }
  		});

		wx.error(function(res){
		    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
		    //alert("errorMSG:"+res);
		});
	});
</script>
{/literal}