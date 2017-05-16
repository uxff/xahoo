{literal}
<script type="text/javascript">

    $(document).ready(function() {

        // login form
        $('#idCashForm input').on('focus', function() {
            $('.errTip').text('');
        });
        $('#idCashForm').on('submit', function() {
            // remove error tips
            $('.errTip').text('');

            //check form
            //TODO 封装为checkForm公用方法
            var cash_amount = $('#cashAmount').val().trim();
            var numRule = /^[0-9]*$/;
            if (cash_amount == '') {
                $('#cashAmount').parent().parent().next('.errTip').text('充值金额不能为空');
                return false;
            } 
            
            if(!numRule.test(cash_amount)){
                $('#cashAmount').parent().parent().next('.errTip').text('请输入有效的金额');
                return false;
            }

            // disable submit button
            $('#idSmtBtn').attr({'value':'正在处理中...', 'class':'processing', 'disabled':true});
            
            //loading mask

            //submit
            $('#idSmtBtn').submit();
        });
    });
</script>
{/literal}