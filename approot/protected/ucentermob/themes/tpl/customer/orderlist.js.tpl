<!-- javascript -->
{literal}
    <script>
        $(function() {
            $(".hms").each(function() {
                var times = $(this).attr('alt');
                countDown(times, this);   //倒计时
            });
        })

        //倒计时
        function countDown(sys_second, id) {
            var hour, minute, second, watch = $(id),
                    timer = setInterval(function() {
                        if (sys_second > 0) {
                            sys_second -= 1;
                            hour = Math.floor((sys_second / 3600) % 24);
                            minute = Math.floor((sys_second / 60) % 60);
                            second = Math.floor(sys_second % 60);
                            hour = hour < 10 ?  hour : hour;//计算小时 
                            minute = minute < 10 ? "0" + minute : minute;//计算分钟 
                            second = second < 10 ? "0" + second : second;//计算秒杀 
                            if(hour!=0){
                                watch.text(hour).append('小时').append(minute).append("分").append(second).append("秒");
                            }else{
                                watch.text(minute).append("分").append(second).append("秒");
                            }
                        } else {
                            clearInterval(timer);
                        }
                    }, 1000);
        }


        var i = 2; //设置当前页数
        $('#more').click(function() {
    {/literal}var type = {$type};
            var pageSize = {$pageSize};

    {literal}
            $.ajax({
                type: 'GET',
                url: gYiiCreateUrl('ajax', 'orderList'),
                data: {page: i, type: type},
                dataType: 'json',
                beforeSend: function() {
                    loadMask();     //添加遮罩层
                    $('#more').html('加载中...');
                },
                success: function(data) {
                    if (data) {
                        addMore(data);
                        var f = 0;
                        $(".hmsMore").each(function() {
                            var times = $(this).attr('alt');
                            countDown(times, this);   //倒计时
                        });

                        $(".exhibit").on('click',function(){
                            $(this).parent().children('.hiding').show();
                            $(this).hide();
                        })

                        if ((parseInt(i) * pageSize) >= parseInt($('#more').attr('alt'))) {
                            $('#more').hide();
                        }
                        i++;   //+1,当再次加载时增加当前页码数
                    } else {
                        $('#more').hide();
                        //alert('没有更多内容了！'); 
                    }
                },
                error: function() {
                    alert('加载错误!');
                },
                complete: function() {
                    removeMask();   //数据加载完成后删除遮罩层
                    $('#more').html('点击加载更多');
                }
            })
        });

        function addMore(data) {
            var str = "";
            var info = "";

            $.each(data.data, function(index, array) {
                str += '<div class="h-order2 mg-t10">';
                var order_url = gYiiCreateUrl('order', 'orderdetail', 'order_id=' + array.order_id);
                var pay_url = gYiiCreateUrl('checkout', 'confirm', 'order_id=' + array.order_id);
                var cancel_url = gYiiCreateUrl('order', 'cancelOrder', 'order_id=' + array.order_id);
                var order_status = "";
                if (array.order_status == 1) {
                    order_status += '待付款';
                    info = '<div class="pay-time clearfix"><p class="red">支付剩余时间：<span class="hmsMore" alt="' + array.time_long.surplusTime + '">' + array.surplusFormateTime + '</span></p><p><a class="cancel" href="'+cancel_url+'">取消订单</a></p><a class="pinkbtn pay" href="'+pay_url+'">立即付款</a></div>';
                } else if (array.order_status == 2) {
                    order_status += '已支付';
                } else {
                    order_status += '已取消';
                }

                $.each(array.items, function(pre, m) {
                    var house_url = gYiiCreateUrl('house', 'detail', 'house_id=' + m.house.house_id);
                    if (parseInt(pre)==0){
                        str += '<p class="order-id clearfix">编号：<a href="' + order_url + '">' + array.displayOrderId +'</a><a class="detail" href="' + order_url + '">订单详情</a></p><div class="h-order-main bor-bt"><a class="tit clearfix" href="#">' + m.house.house_name + ' ' + m.house.house_type + '<span class="status pink2">' + order_status + '</span></a><div class="h-thumb2"><a href="' + order_url + '" class="thumb"><img src="' + m.house.house_thumb + '"  data-src="holder.js/130x70/auto/sky" width="130px" height="70px" alt="130x70" data-holder-rendered="true"></a><ul class="thumb-r"><li class="clearfix">' + m.house.province.sys_region_name + ' ' + m.house.city.sys_region_name + '<span>' + m.house.house_area + '平米</span></li><li class="clearfix">每份价格：<span><em class="lit">￥</em>' + m.house.house_avg_price + '万</span></li><li class="pink2 clearfix">认购份数：<span>' + m.item_quantity + '份</span></li><li class="pink2 clearfix">认购金额：<span class="red big">￥' + m.pay_total + '万</span></li></ul></div></div>';
                    }else{
                        str += '<div class="hide hiding"><div class="h-order-main bor-bt"><a class="tit clearfix" href="#">' + m.house.house_name + ' ' + m.house.house_type + '<span class="status pink2">' + order_status + '</span></a><div class="h-thumb2"><a href="' + order_url + '" class="thumb"><img src="' + m.house.house_thumb + '"  data-src="holder.js/130x70/auto/sky" width="130px" height="70px" alt="130x70" data-holder-rendered="true"></a><ul class="thumb-r"><li class="clearfix">' + m.house.province.sys_region_name + ' ' + m.house.city.sys_region_name + '<span>' + m.house.house_area + '平米</span></li><li class="clearfix">每份价格：<span><em class="lit">￥</em>' + m.house.house_avg_price + '万</span></li><li class="pink2 clearfix">认购份数：<span>' + m.item_quantity + '份</span></li><li class="pink2 clearfix">认购金额：<span class="red big">￥' + m.pay_total + '万</span></li></ul></div></div></div>';
                    }
                })

                if (array.items.length > 1) {
                    var num = array.items.length - 1;
                    str += '<div class="clearfix bor-bt exhibit"><p>显示其他'+num+'个项目</p></div>';
                }

                str += '<div class="clearfix bor-bt paying"><!--<p>已付定金：<span>2000元</span></p>--><p>应付金额：<span>￥'+array.order_num_total+'万</span></p></div>'+info +'</div>';
            });
            $(".order01").append(str);
        }
        $(document).ready(function() {
            $(".click-show-hide").click(function() {
                $(".dialog-pic-icon").toggle();
            });
        });

        $(".exhibit").on('click',function(){
            $(this).parent().children('.hiding').show();
            $(this).hide();
        })
    </script>
{/literal}