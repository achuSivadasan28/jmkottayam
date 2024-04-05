$('#add-api').submit(function(e){
	e.preventDefault();
	let w_api = $('#w_api').val()
	if(w_api != ''){
		$('#submit_btn').text('Loading..')
		$('#submit_btn').attr('disabled',true)
		$.ajax({
			url:"action/add_whatsapp_api.php",
			type:"POST",
			data:{w_api:w_api},
			success:function(result_data){
				$('#submit_btn').text('Success')
				$('#submit_btn').css('background-color','blue')
				setTimeout(function(){
					window.location.href="add-api.php"
				},1300)
				
			}
		})
	}
})