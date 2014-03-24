	$(function(){
		$("#submit").attr('disabled','disabled');
		$("#tips").html("你还可以输入<strong style='font-size:24px;'>130</strong>个字");
		$("#content").focus(function(){
			if($(this).val()==this.defaultValue) {
				$(this).val("");
			}
			var $word_num = $(this).val().length;
			if($word_num == 0){
				$("#tips").html("你还可以输入<strong style='font-size:24px;'>140</strong>个字");
			}
		}).blur(function(){
			if($(this).val()=='') {
				$(this).val(this.defaultValue);
				$("#tips").html("你还可以输入<strong style='font-size:24px;'>130</strong>个字");
				$("#submit").attr('disabled','disabled');
			}
		});
		$("#content").keyup(function(){
			var $word_num = 140 - $(this).val().length;
			if ($word_num < 0){
				$("#tips").css('color','red').html("你还可以输入<strong style='font-size:24px;'>"+$word_num+"</strong>个字");
				$("#submit").attr('disabled','disabled');
			}else{
				$("#tips").css('color','black').html("你还可以输入<strong style='font-size:24px;'>"+$word_num+"</strong>个字");
				$("#submit").prop('disabled',false);
			}
		});
	});