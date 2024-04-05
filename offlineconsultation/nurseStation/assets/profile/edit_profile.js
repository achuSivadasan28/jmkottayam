fetch_doctor_profile_data()
function fetch_doctor_profile_data(){
	$.ajax({
		url:"action/profile/profile_data.php",
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
			console.log(profile_result_json)
			if(profile_result_json[0]['status'] == 1){
				console.log(profile_result_json[0]['proPic'])
				$('#name').text(profile_result_json[0]['doctor_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				if(profile_result_json[0]['proPic'] != ''){
				$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				}
			}
		}
	})
}
$.ajax({
	url:"action/profile/profile_details.php",
	success:function(profile_result_data){
		let profile_result_data_json = jQuery.parseJSON(profile_result_data)
		console.log(profile_result_data_json)
		if(profile_result_data_json[0]['status'] == 1){
			$('#doctor_name').val(profile_result_data_json[0]['doctor_name'])
			$('#phn_no').val(profile_result_data_json[0]['phone_no'])
			$('#email').val(profile_result_data_json[0]['email'])
			if(profile_result_data_json[0]['proPic'] !=''){
			$('#image_data').attr('src','assets/images/profile_pic/'+profile_result_data_json[0]['proPic'])
			}
		}
	}
})

$('#phn_no').keyup(function(){
	$('#phn_Error').text(' ')
})
$('#email').keyup(function(){
	$('#email_error').text(' ')
})

$('#update_profile').submit(function(e){
	e.preventDefault()
	let doctor_name = $('#doctor_name').val()
	let phn_no = $('#phn_no').val()
	let email = $('#email').val()
	let propic = $('#doctor_pro_pic').val().replace("C:\\fakepath\\", "");
	$('#phn_Error').text('')
	$('#email_error').text('')
	button_loader('change_upd')
	$.when(update_profile(doctor_name,email,phn_no,propic)).then(function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			if(result_data_json[0]['status'] == 1){
			if(result_data_json[0]['error_status'] !=1){
				stop_loader('change_upd')
				if(result_data_json[0]['phn_status'] == 1){
					$('#phn_Error').text('*Phone Number Already Exist!')
				}
				if(result_data_json[0]['mail_status'] == 1){
					$('#email_error').text('*Email Number Already Exist!')
				}
			}else{
				$.when(upload_file()).then(function(daat){
					console.log(daat)
				$('.toasterMessage').text(result_data_json[0]['msg'])
				$('.successTost').css('display','flex')
				$('.errorTost').css('display','none')
				setTimeout(function(){
					//window.location.href="profile.php"
				},1500)
					})
			}
										   
			}else{
				//window.location.href="../login.php"
			}
	})

	
})

function upload_file(){
	let fd = new FormData();
	fd.append("files[]",document.getElementById('doctor_pro_pic').files[0])
	return $.ajax({
           url:"action/file/Upload_file.php",
           type:"POST",
           data:fd,
           contentType:false,
           processData:false,
       })  
}

function update_profile(doctor_name,email,phn_no,propic){
	return $.ajax({
		url:"action/profile/update_profile.php",
		type:"POST",
		data:{doctor_name:doctor_name,
			 phn_no:phn_no,
			  email:email,
			  propic:propic
			 },
	})
}
/**
let btn_text = '';
let Loading_text = "Loading...";
let Success_text = "Success";
let Error_text = "Error";
function button_loader(btn_id){
	let btn_id_compain = $('#'+btn_id)
	btn_text = btn_id_compain.text()
	btn_id_compain.text(Loading_text)
	btn_id_compain.attr('disabled',true)
}

function button_loader_success(btn_id){
	let btn_id_compain = $('#'+btn_id)
	btn_id_compain.css('background-color','blue')
	btn_id_compain.text(Success_text)
	btn_id_compain.attr('disabled',false)
}

function button_loader_Error(btn_id){
	let btn_id_compain = $('#'+btn_id)
	btn_id_compain.css('background-color','red')
	btn_id_compain.text(Error_text)
	btn_id_compain.attr('disabled',false)
}

function stop_loader(btn_id){
	let btn_id_compain = $('#'+btn_id)
	btn_id_compain.text(btn_text)
	btn_id_compain.attr('disabled',false)
}**/