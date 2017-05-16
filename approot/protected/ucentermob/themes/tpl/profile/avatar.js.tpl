{literal}
        <script type="text/javascript" >

                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });

                function r_submit() {
                        var photo = $("#photo").val();
                        if (photo.length == 0) {
                                alert('请选择您要上传的图片');
                                // $('.msg-container').css('display', '').find('p').html('请选择您要上传的图片');
                                return false;
                        }
                        frm.submit();
                        return false;
                }

                /** 
                 * 从 file 域获取 本地图片 url 
                 */
                function getFileUrl(sourceId) {
                        var url;
                        if (navigator.userAgent.indexOf("MSIE") >= 1) { // IE 
                                url = document.getElementById(sourceId).value;
                        } else if (navigator.userAgent.indexOf("Firefox") > 0) { // Firefox 
                                url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
                        } else if (navigator.userAgent.indexOf("Chrome") > 0) { // Chrome 
                                url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
                        } else if (window.webkitURL.createObjectURL) {
                                //Chrome8+
                                url = window.webkitURL.createObjectURL(document.getElementById(sourceId).files.item(0));
                        }
                        return url;
                }

                /** 
                 * 将本地图片 显示到浏览器上 
                 */
                function preImg(sourceId, targetId) {
                        var url = getFileUrl(sourceId);
                        var imgPre = document.getElementById(targetId);
                        imgPre.src = url;
                }
        </script>
{/literal}