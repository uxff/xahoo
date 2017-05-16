{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
                function r_submit() {
                        var newName = $.trim($("#newName").val());
						var Rule = /^[\u4E00-\u9FA5A-Za-z0-9]+$/;
						var cArr = newName.match(/[^\x00-\xff]/ig);  
    					var length = newName.length + (cArr == null ? 0 : cArr.length);
                        if (length <= 2 || length > 10)
                        {
                                alert('请输入2-5个中文字符或2-10个英文字符');
                                return false;
                        } else if (!Rule.test(newName) ) {
                                alert('您输入的昵称格式不正确');;
                                return false;
                        }
                        frm.submit();

                }
        </script>
{/literal}