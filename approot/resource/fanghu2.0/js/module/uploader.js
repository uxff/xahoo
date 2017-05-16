$('.filePicker').each(function(){
	//设定需要用到的变量
	var fileBtn,
		$list = $(this).siblings('.uploader-list'),
		$lodings = $('#imgUri').val()+'/images/uploader/lodings.gif';
	
	// 初始化Web Uploader
	var uploader = new WebUploader.Uploader({
	    // 选完文件后，是否自动上传。
	    auto: true,
	    // swf文件路径
	    swf:'js/Uploader.swf',
	    // 文件接收服务端。
	    //server:'http://my.xqshijie.com/xqsjfqpc.php?r=customer/post&data_type=1&borrow_id=420',
		server:$('#urlUploadAvatar').val(),
	    // 选择文件的按钮。可选。
	    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
	   	pick: this,
        //可以上传同样的文件
        duplicate : true,
        //是否已二进制的流的方式发送文件
		sendAsBinary:true,
	    // 只允许选择图片文件。
	    accept: {
	        title: 'Images',
	        extensions: 'jpg,jpeg,png',
	        mimeTypes: 'image/*'
	    },
	    //压缩配置
	    compress:{
	    	width:400,
	    	height:400,
	    	quality:60,
	    	 // 图片质量，只有type为`image/jpeg`的时候才有效。
		    // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
		    allowMagnify: true,
		
		    // 是否允许裁剪。
		    crop: true,
		
		    // 是否保留头部meta信息。
		    preserveHeaders: true,
		
		    // 如果发现压缩后文件大小比原来还大，则使用原来图片
		    // 此属性可能会影响图片自动纠正功能
		    noCompressIfLarger: false,
		
		    // 单位字节，如果图片大小小于此值，不会采用压缩。
		    compressSize: 500*1024
	    },
	    //单个文件大小500KB
	    fileSingleSizeLimit:5000*1024
	});
	
	// 当有文件添加进来的时候
	uploader.on( 'fileQueued', function( file ) {
		fileBtn = $(file.source._refer);
		//删除预设图片
        $list.find('img').remove();
//      $list.find('.file-item.thumbnail').remove();
	    var $li = $(
	            '<div id="' + file.id + '" class="file-item thumbnail">' +
	                '<img>'+
	            '</div>'
	            ),
        $img = $li.find('img');
		$img.attr({'src':$lodings}).css({'width':'50%','height':'50%','margin-top':'.4375rem'});
	    // $list为容器jQuery实例
	    $list.append( $li );
	    $('.lot-btn').prop('disabled',true).addClass('disabled');
	    // 创建缩略图
	    // 如果为非图片文件，可以不用调用此方法。
	    // thumbnailWidth x thumbnailHeight 为 100 x 100
	    uploader.makeThumb( file, function( error, src ) {
	        if ( error ) {
	            $img.replaceWith('<span>不能预览</span>');
	            return;
	        }
			
	    }, 100, 61 );
	});
	
	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
	    var $li = $( '#'+file.id ),
	        $percent = $li.find('.bar'),
	        $state = $li.find("div.state");
	
	    // 避免重复创建
	     if (!$percent.length) {
                $percent = $('<span class="progress">' +
                    '<span class="text"></span>' +
                  '<span class="bar" role="progressbar" style="width: 0%">' +
                  '</span>' +
                '</span>').appendTo($li).find('.bar');
            }
            $li.find(".text").text(Math.round(percentage * 100) + '%');
            $percent.css('width', percentage * 100 + '%');
	});
	
	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on( 'uploadSuccess', function( file,res ) {
		if(res === undefined || res === null) return;
		if(res.state !== undefined) {
            if (res.state === 'SUCCESS'){
                
                $list.length && $list.find('img').attr({'src':res.url}).css({'width':'3.83rem','height':'3.83rem','margin-top':'.0'});
            }
        } else {
            alert('网络传输出现问题，请稍后再试！');
            //window.location.reload();
        }
	    $('.lot-btn').prop('disabled',false).removeClass('disabled');
	});
	
	// 文件上传失败，显示上传出错。
	uploader.on( 'uploadError', function(file,res) {
		if(res === undefined || res === null) return;
		if(res.state !== undefined && res.state === 'FAILED'){
        	
        	$list.length && $list.find('img').attr({'src':res.url}).css({'width':'3.83rem','height':'3.83rem','margin-top':'.0'});
        	
        	layer.msg('图片上传失败,请重试');
        }
	});
	
	// 完成上传完了，成功或者失败，先删除进度条。
	uploader.on( 'uploadComplete', function( file ) {
	$( '#'+file.id ).find('.progress').remove();
	});
	//文件发送前是否需要添加附带参数
	uploader.on('uploadBeforeSend', function (block, data) {
    	data.data_type2 = $list.siblings('.filePicker').find('input[name="data_type2"]').val();
	});
	
	//文件上传前的判断
	uploader.on('error',function(handler){
		if(handler == "Q_TYPE_DENIED"){
			layer.msg("您上传的文件格式错误，当前允许上传的格式有：jpg,jpeg,png！");
		}
		if(handler == "F_EXCEED_SIZE"){
			layer.msg("您上传的文件大小已超出500KB，请修改后上传！");
		}
	});
});