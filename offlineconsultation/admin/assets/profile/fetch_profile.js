
fetch_branch_data()
function fetch_branch_data(){
$.ajax({
	url:"action/profile/fetch_profile.php",
	success:function(result){
		
		let result_data_json = jQuery.parseJSON(result)
		console.log(result_data_json[0]['status'])
		if(result_data_json[0]['status'] == 1){
			$('.tableWraper table tbody').empty()
			if(result_data_json[0]['data_status'] == 1){
				$('.elseDesign').css('display','none')
				console.log(result_data_json[0]['phn'])
				if(result_data_json[0]['user_name'] != ''){
					$('#user_name').text(result_data_json[0]['user_name'])
				}
				if(result_data_json[0]['phn'] != ''){
					$('#phn').text(result_data_json[0]['phn'])
				}
				if(result_data_json[0]['email'] != ''){
					$('#email').text(result_data_json[0]['email'])
				}
				if(result_data_json[0]['address'] != ''){
					$('#address').text(result_data_json[0]['address'])
				}
				if(result_data_json[0]['place'] != ''){
					$('#place').text(result_data_json[0]['place'])
				}
				
			}else{
				$('.elseDesign').css('display','flex')
			}
		}else{
			$('.tableWraper table tbody').empty()
			$('.toasterMessage').text(result_data_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			/*setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)*/
			}
	}
})
}
