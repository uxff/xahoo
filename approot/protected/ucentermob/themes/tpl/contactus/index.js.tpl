<script>

$(function(){
   fnMaskAlert('#imgalert','#alert');
   fnMaskAlert('#imgalert2','#alert');
   fnMaskAlert('#imgalert3','#alert3');
    function fnMaskAlert(oCli,oALt){
        $(oCli).click(function(event){
            var str = '<div id="maskBox"><div id="gLoadingMask" class="h-mask-container"></div></div>';
            $(str).appendTo($(document.body));
            $('#gLoadingMask').css('display','block');
            $(oALt).css('display','block');
            // stopBubble(event);
            $('#gLoadingMask').on('click',function(){
                $('#gLoadingMask').remove();
                $(oALt).css('display','none');
            })
        })
		
		$('.closeBtn').on({
			'click'         :       function() {
				$('#gLoadingMask').remove();
				$(oALt).css('display','none');
			}
		});	
		
		
    }

    $('.closeBtn').on({
        'click'         :       function() {
            $('#gLoadingMask').remove();
            $('#alert').css('display','none');
        }
    });


})

</script>