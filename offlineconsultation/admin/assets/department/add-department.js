$('#add-department').submit(function(e){
	e.preventDefault()
	let department_name = $('#department_name').val()
	button_loader('add-department-btn')
	$.ajax({
		url:"action/department/add_department_details.php",
		type:"POST",
		data:{department_name:department_name},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			$('.toasterMessage').text(result_data_json[0]['msg'])
			if(result_data_json[0]['status'] == 1){
				$('.successTost').css('display','flex')
				$('.errorTost').css('display','none')
			}else if(result_data_json[0]['status'] == 0){
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
			}
			$('.toaster').addClass('toasterActive');
		setTimeout(function () {
			$('.toaster').removeClass('toasterActive');
		}, 2000)
			if(result_data_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}else{
			setTimeout(function () {
				window.location.href="department-management.php";
			}, 2500)
			}
		}
	})
})