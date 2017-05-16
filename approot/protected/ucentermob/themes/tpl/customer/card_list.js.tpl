<script>
    var type ={$type};
    var pageSize = {$pageSize};
    {literal}
        var i = 2; //设置当前页数
        $('#more').click(function() {
            $.ajax({
                type: 'GET',
                url: gYiiCreateUrl('ajax', 'cardList'),
                data: {page: i, type: type},
                dataType: 'json',
                beforeSend: function() {
                    loadMask();     //添加遮罩层
                    $('#more').html('加载中...');
                },
                success: function(data) {
                    if (data) {
                        addMore(data);
                        if ((parseInt(i) * parseInt(pageSize)) >= parseInt($('#more').attr('alt'))) {
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
            $.each(data, function(index, array) {
                var url = gYiiCreateUrl('house', 'detail', 'house_id=' + array.house.house_id);
                var detail_url = gYiiCreateUrl('customer', 'cardDetail', 'card_id=' + array.card_id);
                var btn = "";
                if (array.type == 1) {
                    btn = '<div class="pay-time clearfix mg-t10"><a class="pinkbtn h-right" href="">交易</a></div>';
                }
                str += '<div class="h-order mg-t10"><p class="order-id clearfix">卡号：NO:' + array.identity_id + ' <a class="detail" href="' + url + '">项目详情</a></p><div class="h-order-main h-border-b"><a class="tit clearfix" href="' + detail_url + '">' + array.house.house_name + '' + array.house.house_type + '<span class="status pink2">' + array.card_status_chinese + '</span></a><div class="h-thumb2 clearfix"><a href="' + detail_url + '" class="thumb"><img src="' + array.house.house_thumb + '"  data-src="holder.js/130x70/auto/sky" width="130px" height="70px" alt="130x70" data-holder-rendered="false"></a><ul class="thumb-r"><li class="clearfix">'+array.house.province.sys_region_name +' '+ array.house.city.sys_region_name +'<span>' + array.house.house_area + '平米</span></li><li class="clearfix">认购价格：<span><em class="lit">￥</em>' + array.house.house_avg_pricemillion + '万</span></li><li class="clearfix">有效期至：<span>' + array.end_time + '</span></li></ul></div></div>' + btn + '</div>';
            });
            $(".order01").append(str);
        }
        //点击控制按钮弹出众筹 分权  我的主菜单

        $(document).ready(function() {
            $(".click-show-hide").click(function() {
                $(".dialog-pic-icon").toggle();
            });
        });
    {/literal}
</script>
