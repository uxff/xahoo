{literal}
    <script>
        $(function(){
            var partner = $('.partners');
            partner.on({
                click       :       function(){
//                    alert(11);
                    var partnerId = $(this).attr('partner_id');
//                    alert(partnerId);
                    getData(partnerId);
                }
            });
        })
    </script>
    <script>
        function getData(id){
            $.ajax({
                url     :       'fanghuadmin.php?r=member/getrelations&id='+id,
                type    :       'post',
                success :       function(data){
                    var obj = JSON.parse(data);
//                            alert(obj.data[0].member_id);
//                            alert(obj.degree);
//                            return false;
//                    var parentLevel = obj.degree - 1;
                    var htmlstr = '<div style="float: left">';
                    if(obj.state){
                        //将返回的小伙信息加载到页面中
                        $.each(obj.data, function(n,value) {
                            htmlstr +=  '<div class="" style="float: left">';
                            htmlstr +=  '<div class="partner_avatar partners" partner_id="'+value.member_id+'" onclick="getData('+value.member_id+')">';
                            htmlstr +=  '<img src="'+value.member_avatar+'" alt="会员头像" title="'+obj.degree+'度小伙伴"/>';
                            htmlstr += '<div class="partner_name">'+value.member_name;
                            htmlstr += '</div>';
                            htmlstr += '</div>';
                            htmlstr += '</div>';
                        });
                    }else{
                        //提示该会员没有小伙伴
                        htmlstr += '该会员没有小伙伴！';
                    }

                    htmlstr += '</div>';
                            var parentDomNum = $("div[partner_id='"+id+"'] ~ div").length;
                             $("div[partner_id='"+id+"'] ~ div").last().remove();
                            $("div[partner_id='"+id+"']").parent().append(htmlstr);
                }
            });
        }
    </script>
{/literal}