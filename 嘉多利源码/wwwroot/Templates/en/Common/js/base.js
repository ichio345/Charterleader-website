
//鼠标经过预览图片函数
function preview(img){
	$("#preview .jqzoom img").attr("src",$(img).attr("src"));
	$("#preview .jqzoom img").attr("jqimg",$(img).attr("bimg"));
	var pic2=$("#preview .jqzoom img");
// Create new offscreen image to test
	var theImage2 = new Image();
	theImage.src = pic2.attr("src");
// Get accurate measurements from that.
	var picwidth2 = theImage2.width;
	var width=$('#preview ').width();
	if(picwidth2>width){
		pic2.css('width',width);
	}else{
		pic2.removeAttr('style');
	}

	
}
//图片放大镜效果
$(function(){
	var pic=$("#preview .jqzoom img");
// Create new offscreen image to test
	var theImage = new Image();
	theImage.src = pic.attr("src");
// Get accurate measurements from that.
	var picwidth = theImage.width;
	var width=$('#preview ').width();
	if(picwidth>width){
		pic.css('width',width);
	}else{
		pic.removeAttr('style');
	}

	$(".jqzoom").jqueryzoom({xzoom:350,yzoom:300});
});

//图片预览小图移动效果,页面加载时触发
$(function(){
	var tempLength = 0; //临时变量,当前移动的长度
	var viewNum = 5; //设置每次显示图片的个数量
	var moveNum = 2; //每次移动的数量
	var moveTime = 300; //移动速度,毫秒
	var scrollDiv = $(".spec-scroll .items ul"); //进行移动动画的容器
	var scrollItems = $(".spec-scroll .items ul li"); //移动容器里的集合
	var moveLength = scrollItems.eq(0).width() * moveNum; //计算每次移动的长度
	var countLength = (scrollItems.length - viewNum) * scrollItems.eq(0).width(); //计算总长度,总个数*单个长度
	  
	//下一张
	$(".spec-scroll .next").bind("click",function(){
		if(tempLength < countLength){
			if((countLength - tempLength) > moveLength){
				scrollDiv.animate({left:"-=" + moveLength + "px"}, moveTime);
				tempLength += moveLength;
			}else{
				scrollDiv.animate({left:"-=" + (countLength - tempLength) + "px"}, moveTime);
				tempLength += (countLength - tempLength);
			}
		}
	});
	//上一张
	$(".spec-scroll .prev").bind("click",function(){
		if(tempLength > 0){
			if(tempLength > moveLength){
				scrollDiv.animate({left: "+=" + moveLength + "px"}, moveTime);
				tempLength -= moveLength;
			}else{
				scrollDiv.animate({left: "+=" + tempLength + "px"}, moveTime);
				tempLength = 0;
			}
		}
	});
});
