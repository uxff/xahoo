<script type='text/javascript'>
        $(function() {
                showCountDown($('#countDownContainer'), '{$indexUrl}');
        });

        //默认等待时间
        var time = 5;
        //时间判断
        function showCountDown(countDownContainer, url) {
                if (time == 0) {
                        window.location.href = url;
                        return false;
                } else {
                        countDownContainer.html(time);
                        time--;
                }
                setTimeout(function() {
                        showCountDown(countDownContainer, url)
                }, 1000);
        }
</script>