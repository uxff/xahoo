<!-- javascript -->

<script>
    var pageSize = {$pageSize};
    {literal}
        var i = 2; //设置当前页数
        $('#more').click(function() {
            $.ajax({
                type: 'GET',
                url: gYiiCreateUrl('ajax', 'myFavorite'),
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
            $.each(data, function(index, array) {
                var url = gYiiCreateUrl('house', 'detail', 'house_id=' + array.house_id);
                str += '<li><a href="' + url + '" class="h-thumb"><img src="' + array.house_thumb + '"  data-src="holder.js/220x150/auto/sky" width="220px" height="150px" alt="220x150" data-holder-rendered="false" class="img-responsive"></a><div class="list-r"><h3 class="desc"><a href="' + url + '">' + array.house_name + ' ' + array.house_type + '</a></h3><p class="grey999 mg-b20">￥' + array.house_num_price + '万/套</p><p class="pink2 h-fs16">￥' + array.house_avg_price + '万/份</p></div></li>';
            });
            $(".h-fav-list").append(str);
        }
        
        $(document).ready(function() {
            $(".click-show-hide").click(function() {
                $(".dialog-pic-icon").toggle();
            });
        });
    {/literal}
</script>
