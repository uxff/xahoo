{literal}
        <script>
                //分页
                var i = 2; //设置当前页数
                $('#moreArticle').click(function() {
                        var cid = $("#cid").val();
                        $.ajax({
                                type: 'GET',
                                url: gYiiCreateUrl('Ajax', 'ListFavoriteArticle'),
                                data: {page: i},
                                dataType: 'json',
                                beforeSend: function() {
                                        //alert('before');
                                        loadMask();     //添加遮罩层
                                        $('#moreArticle').html('加载中...');
                                },
                                success: function(data) {
                                        if (data) {
                                                addArticleMore(data);
                                                if ((parseInt(i) * 3) >= parseInt($('#moreArticle').attr('alt'))) {
                                                        $('#moreArticle').hide();
                                                }
                                                i++;   //+1,当再次加载时增加当前页码数
                                        } else {
                                                $('#moreArticle').hide();
                                                //alert('没有更多内容了！'); 
                                        }
                                },
                                error: function() {
                                        alert('加载错误!');
                                },
                                complete: function() {
                                        removeMask();   //数据加载完成后删除遮罩层
                                        $('#moreArticle').html('点击加载更多');
                                }
                        })
                });

                function addArticleMore(data) {
                        var str = "";
                        $.each(data, function(index, array) {
                                str += '<li><a href="' + gYiiCreateUrl('task', 'articleView', 'id=' + array.task_id) + '" class="h-thumb"><img src="' + array.task_article.task_img + '" class="img-responsive" data-src="holder.js/90x70/auto/sky" alt=""></a><div class="list-r"><h3 class="desc"><a href="' + gYiiCreateUrl('task', 'articleView', 'id=' + array.task_id) + '">' + array.task_article.task_title + '</a></h3><span class="orange">5积分</span><a class="btn-ora-line" href="' + gYiiCreateUrl('task', 'articleView', 'id=' + array.task_id) + '"><i class="icon-share"></i> 马上分享</a></div</li>';
                        });
                        //alert($(".h-hou-list li:last-child"));
                        //$(".h-hou-list").append(str);
                        $(".h-hou-list").append(str);
                }

        </script>
{/literal}
{literal}
        <script>
                //分页
                var j = 2; //设置当前页数
                $('#moreBuilding').click(function() {
                        $.ajax({
                                type: 'GET',
                                url: gYiiCreateUrl('Ajax', 'ListFavoriteBuilding'),
                                data: {page: j},
                                dataType: 'json',
                                beforeSend: function() {
                                        //alert('before');
                                        loadMask();     //添加遮罩层
                                        $('#moreBuilding').html('加载中...');
                                },
                                success: function(data) {
                                        if (data) {
                                                addBuildingMore(data);
                                                if ((parseInt(j) * 3) >= parseInt($('#moreBuilding').attr('alt'))) {
                                                        $('#moreBuilding').hide();
                                                }
                                                j++;   //+1,当再次加载时增加当前页码数
                                        } else {
                                                $('#moreBuilding').hide();
                                                //alert('没有更多内容了！'); 
                                        }
                                },
                                error: function() {
                                        alert('加载错误!');
                                },
                                complete: function() {
                                        removeMask();   //数据加载完成后删除遮罩层
                                        $('#moreBuilding').html('点击加载更多');
                                }
                        })
                });

                function addBuildingMore(data) {
                        var str = "";
                        $.each(data, function(index, array) {
                                str += '<li><a class="h-link" href="' + gYiiCreateUrl('task', 'buildingView', 'id=' + array.task_id) + '"><img src="' + array.task_building.task_img + '" data-src="holder.js/100%x160/auto/sky" alt="" class="img-responsive"></a><span class="tag"><em>最高佣金</em>￥<strong>' + array.task_building.brokerage_max + '</strong></span><p class="container desc clearfix">' + array.task_building.building_name + '<span class="price">均价：' + array.task_building.building_price + '万元/平米</span></p></li>';
                        });
                        //alert($(".h-hou-list li:last-child"));
                        //$(".h-hou-list").append(str);
                        $(".h-img-list").append(str);
                }
        </script>
{/literal}
<script>
// JS实现选项卡切换
        window.onload = function() {
                var tab = document.getElementById('tab').getElementsByTagName('li'),
                        panel = document.getElementById('panel').getElementsByTagName('ul'),
                        i, j, len = tab.length, bindclick;
                bindclick = function(i) {
                        tab[i].onclick = function() {
                                for (j = 0; j < len; j++) {
                                        tab[j].className = tab[j].className.replace('active', '');
                                        panel[j].style.display = 'none';
                                }
                                panel[i].style.display = 'block';
                                tab[i].className += 'active';
                        }
                };
                for (i = 0; i < len; i++) {
                        bindclick(i);
                }
        }
</script>