<script src="{$resourcePath}/js/jquery-ui.custom.min.js"></script>
<script src="{$resourcePath}/js/jquery.ui.touch-punch.min.js"></script>
<script src="{$resourcePath}/js/bootbox.min.js"></script>
<script>

			$(function(){

				// check1 点击的时候
					$('.check1').click(function(){
						var ok=$(this).prop("checked")
						$(this).parents('tr').find('.check2').prop("checked",ok)
						$(this).parents('tr').find('.check3').prop("checked",ok)
					})
				
				// check2 点击的时候
					$('.check2').click(function(){
						var ok=$(this).prop("checked");
						$(this).parents('.listleft').siblings().andSelf().find('.check3').prop("checked",ok)
						var oCheck2=$(this).parents('.listbox').siblings().andSelf().find(".check2")	
						$(this).parents('tr').find('.check1').prop("checked",trueorfalse(oCheck2))

					})
				// check3 点击的时候
					$('.check3').click(function(){

						var oCheck3=$(this).parent().siblings().andSelf().find(".check3");
						$(this).parents('.listbox').find('.check2').prop("checked",trueorfalse(oCheck3));
						var oCheck1=$(this).parents('.listbox').siblings().andSelf().find('.check2')
						$(this).parents('tr').find('.check1').prop("checked",trueorfalse(oCheck1))
					})
				// 找同级元素的checked状态
					function trueorfalse(obj)
					{
						var bool = false;

						$(obj).each(function(){

							if($(this).prop("checked"))
							{
								bool= true;
							}
						})
						return bool;
					}

			})
			
		</script>
{literal}
<!-- inline scripts related to this page -->
<script type="text/javascript">
    function delConfirm(callbackUrl) {
        bootbox.confirm("确认删除吗?", function(result) {
            if(result) {
                window.location.href=callbackUrl;
            }
        });
    }
</script>
{/literal}