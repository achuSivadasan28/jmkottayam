let url_val = window.location.href
let url_split = url_val.split('=');
let last_len = url_split.length
let last_index = last_len-1;
let val = url_split[last_index];

$.ajax({
	url:"action/branch/fetch_branch_data.php",
	type:"POST",
	data:{val:val},
	success:function(branch_result){
		let branch_result_json = jQuery.parseJSON(branch_result)
		if(branch_result_json[0]['status'] == 1){
			if(branch_result_json[0]['data_status'] == 1){
				$('#branch_name').val(branch_result_json[0]['branch_name'])
			}else{
			$('.toasterMessage').text(branch_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
		}else{
			$('.toasterMessage').text(branch_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
		}
	}
})


//edit brnach
$('#edit_branch').submit(function(e){
	e.preventDefault()
	let branch = $('#branch_name').val()
	button_loader('edit_branch_btn')
	$.ajax({
		url:"action/branch/edit-branch.php",
		type:"POST",
		data:{branch:branch,
			 val:val
			 },
		success:function(branch_result){
			let branch_result_json = jQuery.parseJSON(branch_result)
			if(branch_result_json[0]['status'] == 1){
			$('.toasterMessage').text(branch_result_json[0]['msg'])
			$('.errorTost').css('display','none')
			$('.successTost').css('display','flex')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="branch-management.php";
			}, 2500)
			}else{
			$('.toasterMessage').text(branch_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
		}
	})
})