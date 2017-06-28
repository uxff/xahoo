<script src="{$resourcePath}/js/jquery-ui.custom.min.js"></script>
<script src="{$resourcePath}/js/jquery.ui.touch-punch.min.js"></script>
<script src="{$resourcePath}/js/bootbox.min.js"></script>
<script src="{$resourceBasePath}/laydate/laydate.js"></script>
<script>
    function setStatus(id){
        $.ajax({
            type: 'POST',
            url: 'backend.php?r=Poster/SetStatus&id='+id,
            dataType: 'json',
            success: function (data){
                if(data == true){
                    location.reload();
                }
            }            
        })        
    }
    function setStatusTwo(id){
        $.ajax({
            type: 'POST',
            url: 'backend.php?r=Poster/SetStatusTwo&id='+id,
            dataType: 'json',
            success: function (data){
                if(data == true){
                    location.reload();
                }
            }            
        })        
    }
</script>