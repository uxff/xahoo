	//add by coderdyc
	function uploadFile(opts){
		this.options = $.extend({
        //uploader = WebUploader.create({
            formData: {
                source:'project',
				picSizeArr:''
            },
            fileVal: 'upfile', //上传的文件域 name
            // 自动上传。
            auto: false,
            // swf文件路径
            swf: './Uploader.swf',
            // 文件接收服务端。
            server: zhff.uploadImageUri,
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',
            // 只允许选择文件，可选。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
			fileSingleSizeLimit:200*1024,   //设定单个文件大小
			state:'pending',
			uploadone:true,//上传一张图片,
			list:'#list',//列表元素 
			btn:'#btn',
			imgurl:'#imgurl',
			thumbnailWidth : 110 * (window.devicePixelRatio ? window.devicePixelRatio: 1),
            thumbnailHeight : 110 * (window.devicePixelRatio ? window.devicePixelRatio: 1),
			
        },opts);
		
		this.options.list.hide();		
		this.options.btn.hide();
		
		var uploader = new WebUploader.Uploader(this.options);


        // 当有文件添加进来的时候
        uploader.on('fileQueued', function (file) {
			this.options.list.show();
			if(this.options.uploadone==true){
				this.options.list.show();
				this.options.list.html("");
			}
            var $li = $(
                            '<div id="' + file.id + '" class="file-item thumbnail">' +
                                    '<img>' +
                                    '</div>'
                    ),$img = $li.find('img');

            this.options.list.append($li);

            // 创建缩略图
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr('src', src);
            }, this.options.thumbnailWidth, this.options.thumbnailHeight);
            this.options.btn.show();
            //this.options.pick.hide();
        });
		
		
		
		//上传图片触发按钮
		var state=this.options.state;
		this.options.btn.on('click', function () {
			$(this).html("上传中");
            if (state=== 'uploading') {
                uploader.stop();
            } else {
                uploader.upload();
            }
        });
		
		uploader.on('uploadError', function (file, reason) {
			alert("上传出错，请重试 错误："+reason);
		});
		
		// 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, response) {
            //console.log(file);
			this.options.btn.html("开始上传");
            this.options.imgurl.val(response.url);
            //$('#' + file.id).addClass('upload-state-done');
			
			$('#' + file.id).append( '<div style="height: 30px;" class="file-panel"><span class="cancel">删除</span></div><span class="success"></span>' );
			var currentOptions=this.options;
			$('#' + file.id).find("div.file-panel span.cancel").on( 'click', function() {
							//$(this).val();
				if(confirm("是否删除？")==false){ return ;}
				currentOptions.imgurl.val("");
				currentOptions.list.hide();
				currentOptions.list.html("");
				location.reload();
			});
			
            //$hiddenInput.val(response.url);
            this.options.btn.hide();
            this.options.pick.show();
        });
		
			
		uploader.on("error",function (type){
			if (type=="Q_TYPE_DENIED"){
				alert("上传失败，可上传的文件格式为"+this.options.accept.extensions);
			}else if(type=="F_EXCEED_SIZE"){
				var currentFileStr="";
				var currentFileSize=this.options.fileSingleSizeLimit/1024;
				if(currentFileSize<1000){
					currentFileStr=currentFileSize+"KB";
				} else {
					currentFileStr=currentFileSize/1024+"MB";
				}
				alert("上传失败，上传文件不得大于"+currentFileStr+"，请重试");
			}
		});

		return uploader;
	}
	

	