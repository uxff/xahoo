<script>
    var house_id = '{$houseDetail.house_id}';
    var house_name = '{$houseDetail.house_name}';
    var jiathis_config = {
        summary: house_name,
        shortUrl: true,
        hideMore: false,
        // pic: pic_thumb,
    }
</script>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
{literal}
<script>
    // 分享
    $('#share').on('click', function() {
        // Hopacity('block')
        $('.share_contain').css('display', 'block');
        $('.jiathis_button').on('click', function() {
            $('.share_contain').css('display', 'none');
        });
    });
    function c_favorite(tid, id, msg, cid) {
        //判断是否登录   没有登录则跳转到登录页面 
        if (parseInt(cid) == 0) {
            if (confirm("您还没有登录,是否登录？")) {
                var url = gYiiCreateUrl('house', 'detail', "house_id=" + id);
                window.location.href = gYiiCreateUrl('site', 'login', "return_url=" + encodeURIComponent(url));
            }
        } else {

            var show = $(msg).attr('class');
            if (show == 'h-item-heardred') {
                $.get(gYiiCreateUrl('ajax', 'deleteMyFavorite', "object_id=" + id + "&favorite_type=" + tid + "&customer_id=" + cid + "&source=fenquan"), function(data) {
                    if (data == "success")
                    {
                        $(msg).attr('class', 'h-item-heard');
                        alert('已取消收藏');
                    }
                });


            } else if (show == 'h-item-heard') {
                $.get(gYiiCreateUrl('ajax', 'addMyFavorite', "object_id=" + id + "&favorite_type=" + tid + "&customer_id=" + cid + "&source=fenquan"), function(data) {
                    if (data == 'success')
                    {
                        $(msg).attr('class', 'h-item-heardred');
                        alert('收藏成功');
                    }
                });

            }
        }
    }

    //点击控制按钮弹出众筹 分权  我的主菜单
    $(document).ready(function(){
        $(".click-show-hide").click(function(){
            $(".dialog-pic-icon").toggle();
        });
    });
    
    // back to TOP
    $(function(){
        $(window).scroll(function(){
        　　var scrollTop = $(this).scrollTop();
        　　var scrollHeight = $(document).height(); 
        　　var windowHeight = $(this).height();
        　　if(scrollTop + windowHeight >scrollHeight-132){
                $('#itembtnbox').css('position','relative'); 
        　　}else{
                $('#itembtnbox').css({"position":"fixed","bottom":"0","max-width":"640px","width":"100%"})
            }
        });
    });

    // 定位
    $('#lbsBtn').on('click', function() {
        //添加遮罩层
        loadMask();
        if (navigator.geolocation) {
            // navigator.geolocation.watchPosition(showPosition);
            navigator.geolocation.getCurrentPosition(locationSuccess, locationError, {
                // 指示浏览器获取高精度的位置，默认为false
                enableHighAcuracy: true,
                // 指定获取地理位置的超时时间，默认不限时，单位为毫秒
                timeout: 2000,
                // 最长有效期，在重复获取地理位置时，此参数指定多久再次获取位置。
                maximumAge: 1000
            });
        }
        else{
            alert("系统不支持定位");
            window.location.reload();
        }
    });

    // 定位成功回调函数
    function locationSuccess(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        $.ajax({
            type: 'GET',
            url: gYiiCreateUrl('ajax', 'getAddressInfo'),
            data: {'lat': lat, 'lng': lng},
            dataType: 'json',
            beforeSend: function() {
            },
            complete: function() {
                //去除遮罩层
                removeMask();
            },
            success: function(data) {
                if (data) {
                    var lbsURL = gYiiCreateUrl('lbs', 'listNearbyCompany', 'house_id='+house_id+'&address='+data.address+'&lng='+lng+'&lat='+lat+'&city_id='+data.city_id);
                    window.location.href = lbsURL;
                } else {
                    alert('网络异常，请重新尝试');
                    window.location.reload();
                }
            },
            error: function() {
                alert('网络异常，请重新尝试');
                window.location.reload();
            },
        });
    }
    // 定位失败回调函数
    function locationError() {
        var lbsURL = gYiiCreateUrl('lbs', 'listNearbyCompany', 'house_id='+house_id+'&address='+'&lng=0&lat=0&city_id=131');
        window.location.href = lbsURL;
    }
</script>
{/literal}