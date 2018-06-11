// 图片上传demo
jQuery(function() {
    var $ = jQuery,
        $list = $('#fileList'),
        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 120 * ratio,
        thumbnailHeight = 100 * ratio,
        supportTransition = (function(){
            var s = document.createElement('p').style,
                r = 'transition' in s ||
                      'WebkitTransition' in s ||
                      'MozTransition' in s ||
                      'msTransition' in s ||
                      'OTransition' in s;
            s = null;
            return r;
        })(),

        // Web Uploader实例
        uploader;

    // 初始化Web Uploader
    uploader = WebUploader.create({

        // 自动上传。
        auto: true,

        // swf文件路径
        swf: BASE_URL + '/Uploader.swf',

        // 文件接收服务端。
        server:SERVER_URL,

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        // pick: '#filePicker',
        pick: {
            id: '#filePicker',
            label: '点击上传图片'
        },

        // 只允许选择文件，可选。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        compress:null,
        fileNumLimit :CanPicnum,
        fileSizeLimit: 3 * 1024*1024,    // 3 M
        fileSingleSizeLimit:PicSize // 1 M
    });



$(".tlist").hover(
    function(){
        $(this).append("<div class='delpic'>删除</div>")
        $(this).find(".delpic").click(function(){ 
            var mythis=$(this);
            var delpath=mythis.siblings("input").val()
            var del_tlist=mythis.parents(".tlist");
            if(confirm("确认要删除此图片吗？")){               
                $.post(PRO_DEL_PIC,
                    {
                        picpath:delpath,
                        pid:PID
                    },
                    function(data){  
                        if(data){
                            //console.log(mythis)
                            del_tlist.remove();
                        }
                    }
                )  
            }

        });
    },
    function(){
        $(this).find(".delpic").remove();
    }
); 


    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) { 
        var fielid=file.id  
        var $li = $(
                '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img title='+file.name+'>' +
                    // '<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
            $img = $li.find('img');

        var $del=$("<div class='delpic' style='display:none'>删除</div>") ;   

        $list.append( $li );
        $li.append($del);
        $li.hover(
            function(){
                $(this).find(".delpic").show();
                $(this).find(".delpic").click(function(){   
                    uploader.removeFile( fielid, true )
                    $li.off().find('.file-panel').off().end().remove();
                })
            },
            function(){
                $(this).find(".delpic").hide();
            }
        )


        // 创建缩略图
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );

    });

     // 负责view的销毁
    function removeFile( file ) {
        var $li = $('#'+file.id);

        delete percentages[ file.id ];
        updateTotalProgress();
        $li.off().find('.file-panel').off().end().remove();
    }

    //文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {

        // var $li = $( '#'+file.id ),
        //     $percent = $li.find('.progress span');

        // // 避免重复创建
        // if ( !$percent.length ) {
        //     $percent = $('<p class="progress"><span></span></p>')
        //             .appendTo( $li )
        //             .find('span');
        // }

        // $percent.css( 'width', percentage * 100 + '%' );
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file ,response ) {
        $( '#'+file.id ).addClass('upload-state-done');
        var parsedJson =jQuery.parseJSON(response._raw)
           var $li = $( '#'+file.id ),
                $success = $li.find('div.success');
            // 避免重复创建
            if ( !$success.length ) {
                $success = $('<div class="success"></div>').appendTo( $li );
            }
            $success.text('上传成功');
            //$hideInput=$li.find('div.filepath');
            $("<input type='hidden' name='filepath[]' value='"+parsedJson.path+"'>").appendTo($li);
    });

    uploader.on('error',function(code){
        switch(code){
            case 'Q_EXCEED_NUM_LIMIT':
                alert('最多能上传'+PICNUM+'张图片');
                break;
            case 'Q_TYPE_DENIED' :
                alert('仅能上传图片类型文件');
                break;
            case 'F_DUPLICATE' :
                alert('此图片已选');
                break;
            case 'F_EXCEED_SIZE' :
                alert('仅能上传'+PicSize/1024+'k以内的图片');
                break;    
        }
        
    });

    // 文件上传失败，现实上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }
        $error.text('上传失败');
    });

    uploader.on( 'uploadAccept', function( object ,ret  ) {
        var parsedJson =jQuery.parseJSON(ret._raw)
        if(!(parsedJson.path).length>0){
              return false;
        }
               
    });

    //完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
       // $( '#'+file.id ).find('.progress').remove();
       
    });
    function writeObj(obj){ 
            var description = ""; 
            for(var i in obj){   
                var property=obj[i];   
                description+=i+" = "+property+"\n";  
            }   
            alert(description); 
        }
});



