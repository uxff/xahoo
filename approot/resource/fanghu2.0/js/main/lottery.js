define(function(require){
require('../lib/jquery/jquery-1.10.1.min.js');
var Swiper = require('../lib/swiper/swiper-3.3.0.jquery.min.js');
  //layer模块
  var css = require('../lib/layer/skin/layer.css','css|url');
  var linkTag = $('<link href="' + css + '" rel="stylesheet" type="text/css" />');
  $($('head')[0]).find('title').after(linkTag);
  require('../lib/layer/layer.js');

/********************
 * 积分抽奖页面
 * @author sichaoyun
 * date : 2016-08-29
 * ******************
 */
   var lottery = {
          index : 2, //当前位置
          times : 3, //计抽奖次数
          total : 0,//剩余积分
          count : 8, //奖品数量
          btn : $('.start-btn'), // 抽奖按钮
          prev : 1, //上一个位置
          speed : 200, // 初始速度
          timer : '', // 定时器
          end : 2, // 决定在哪格变慢
          cycle : 0, //  转到圈数
          num : 0, //  计算圈数
          flag : false, // 结束标志
          quick : 0, //  加速
          order : [2,5,3,6,4,1,7,0], //对应奖品顺序
          win : 0, //中奖号码
          msg : '', // 中奖后提示信息
          betUrl : '', // 提交抽奖的url
          init : function () {
             var _this = lottery;
                 _this.cycle = 0;
                 _this.quick = 0;
                 _this.flag = false;
                 _this.end = Math.floor(Math.random() * 8) + 1;
                 _this.num = Math.floor(Math.random() * 5) + 5;
                 _this.btn.one('click', _this.go);
                 _this.betUrl = _this.btn.attr('bet-url');
          },
          go : function (e) {
            e.preventDefault();
             var _this = lottery;
                 
                 //ajax这里请求获取奖级
                  var url = _this.betUrl;
                     $.ajax({
                          url: url,
                          type: 'post',
                          dataType: 'json',
                          data : {
                            token : $('#token').val()
                          },
                         success: function (res) {
                            $('#token').val(res.value.token);
                             if(res.code==1){
                              var status =res.value.status;
                              if(status == 1){
                                  var url = res.value.redirect_url;
                                   layer.open({
                                        title: '提示',
                                        skin: 'lot-class',
                                        closeBtn : 2,
                                        area: ['350px'],
                                        content: '<p>'+ res.msg +'</p>',
                                        btn: ['登录','取消'],
                                        shadeClose: true,
                                        yes: function(){
                                           layer.closeAll();
                                           location.href = url;
                                        }
                                    });
                                  _this.btn.one('click', _this.go);
                                }else if(status == 2){
                                   
                                layer.open({
                                    title: '提示',
                                    skin: 'lot-class',
                                    closeBtn : 2,
                                    area: ['350px'],
                                    content: '<p>'+  res.msg +'</p>',
                                    btn: '确定',
                                    shadeClose: true,
                                    yes: function(){
                                       layer.closeAll();
                                       location.reload();
                                    }
                                  });

                                }else{
                                layer.open({
                                    title: '提示',
                                    skin: 'lot-class',
                                    closeBtn : 2,
                                    area: ['350px'],
                                    content: '<p>'+  res.msg +'</p>',
                                    btn: '确定',
                                    shadeClose: true,
                                    yes: function(){
                                       layer.closeAll();
                                    }
                                  });
                                  _this.btn.one('click', _this.go);
                                }
                             }else{
                                 _this.msg = res.msg;
                                 _this.win = res.value.item_id || 0;
                                 _this.timer = setInterval(_this.star, _this.speed);
                                 _this.times = res.value.remain_times;
                                 _this.total = res.value.ponts_total;

                               }
                           },
                          error: function (err) {
                            layer.msg('出现错误，请重试');
                          }
                   });

          },
          star : function () {
            var _this = lottery,p,w = _this.win;
            if (_this.flag == false) {
              if (_this.quick == 5) {
                  clearInterval(_this.timer);
                  _this.speed = 60;
                 _this.timer = setInterval(_this.star, _this.speed);
              }
             if (_this.cycle == _this.num + 1 && _this.index == _this.end) {
                 clearInterval(_this.timer);
                 _this.speed = 300;
                 _this.flag = true;
                 _this.timer = setInterval(_this.star, _this.speed);
              }
            }
            if (_this.index >= _this.count) {
                 _this.index = 0;
                 _this.cycle++;
            }
            if (w == "" || typeof w == "undefined" || w < 0 || w > 7) {
                p = 2;
            } else {
                p =  _this.order[w];
            }
            if (_this.flag == true && _this.index == p) {
              _this.quick = 0;
              clearInterval(_this.timer);
              lottery.init();
              setTimeout(function () {
                layer.open({
                  title: '提示',
                  skin: 'lot-class',
                  closeBtn : 2,
                  area: ['350px'],
                  content: _this.msg,
                  btn: '确定',
                  shadeClose: true,
                  yes: function(){
                     layer.closeAll();
                  }
                });
              $('.ponts_total').text(_this.total);
              $('.remain_times').text(_this.times);    
               }, 500);
            }
            $('.start-list>li').eq(_this.index).addClass('cur');
             _this.prev = _this.index > 0 ? _this.index - 1 : _this.count - 1;
            $('.start-list>li').eq(_this.prev).removeClass('cur');
            _this.index++;
            _this.quick++;
       }
  };

   lottery.init();

 //默认事件
var  default_event = {
     init : function(){
        new Swiper('.swiper-container',{
              pagination: '.pagination',
              loop:true,
              grabCursor: true,
              paginationClickable: true,
              prevButton:'.arrow-left',
              nextButton:'.arrow-right'
        });
      }
   }
    default_event.init();
})
