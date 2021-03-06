$jq(document).ready(function(){
	$jq('#yzform').validate({
		rules:{
			title:{
				required:true
			},
			content:{
				required:true
			},
			name:{
				required:true
			},
			tel:{
				required:true
			}
		},
		messages:{
			title:{
				required:"标题不得为空！"
			},
			content:{
				required:"内容不能为空！"
			},
			name:{
				required:"姓名不能为空！"
			},
			tel:{
				required:"电话不能为空!"
			}
		}

	});
});