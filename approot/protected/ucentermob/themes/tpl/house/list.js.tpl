<script>
    var pageSize = {$pageSize};
    {literal}
        var i = 2; //设置当前页数
        $('#more').click(function() {
            $.ajax({
                type: 'GET',
                url: gYiiCreateUrl('ajax', 'houseList'),
                data: {page: i},
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
            $.each(data.data, function(index, array) {

                var url = gYiiCreateUrl('house', 'detail', 'house_id=' + array.house_id);
                var style = '';
                var status = '';
                var showStr = '<p class="h-bgtext-r">待定</p>';
                if (array.is_sell == 0) {
                    style = 'ing';
                    status += '<p class="info"><span></span></p>';
                    status += '<h1 class="status">展示中</h1>';
                } else if (array.is_sell == 1) {
                    style = 'ing';
                    status += '<p class="info"><span>已参加： ' + array.customer_total + '人</span>' + array.ratio + '%</p>';
                    status += '<h1 class="status">认购中</h1>';
                } else if (array.is_sell == 2) {
                    style = 'over';
                    status += '<p class="info"><span>已参加：  ' + array.customer_total + '人</span>' + array.ratio + '%</p>';
                    status += '<h1 class="status">已结束</h1>';
                }

                var displayProvinceCity = '';
                if (array.province && array.province.sys_region_name) {
                    displayProvinceCity += array.province.sys_region_name;
                }
                if (array.city && array.city.sys_region_name) {
                    displayProvinceCity += '&nbsp;';
                    displayProvinceCity += array.city.sys_region_name;
                }
                if (array.house_price > 0){
                    showStr ='<p class="h-bgtext-r">￥' + array.house_num_price + '万/套 <br/> 约<span class="h-fsbc">￥' + array.house_avg_price + '万/份</span></p>';
                }

                str += '<li class="h-inlist"><a href="' + url + '"><div class="h-bgtext-t ' + style + '">' + status + '</div><img src="' + array.house_thumb + '" data-src="holder.js/100%x225/auto/sky" alt=""><div class="h-bgtext"><div class="clearfix"><p class="h-bgtext-l"><span class="h-fsb">' + array.house_name + '</span><br/>' + displayProvinceCity + '&nbsp;' + array.house_area + '平米</p>'+showStr+'</div></div></a></li>';
            });
            $(".data-list").append(str);
        }
    {/literal}
</script>
