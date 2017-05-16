<script>
$(function(){
    $("#J_invite").on("click",function(){
        $("#invite_list").hide();
        $("#invite_img").show();
    })
    $("#l_invite").on("click",function(){
        $("#invite_img").hide();
        $("#invite_list").show();
    })
    
    $("#J_shut").on("click",function(){
        $("#J_firend").hide();
    })
});
</script>