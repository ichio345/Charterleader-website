$jq(document).ready(function(){
	$jq('#yzform').validate({
		rules:{
			title:{
				required:true
			}
		},
		messages:{
			title:{
				required:"标题不得为空！"
			}
		}
	});

});