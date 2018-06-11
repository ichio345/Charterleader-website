$(document).ready(function(){	
	$(".his-btn li").click(function(){		
		var obj_box=$(".his-list");
		var index=$(this).index();
		obj_box..eq(index).addClass("hover").siblings().removeClass("hover");
	})
});