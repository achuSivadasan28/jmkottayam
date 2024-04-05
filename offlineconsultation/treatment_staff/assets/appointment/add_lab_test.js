let url = window.location.href;
let url_val = url.split("=")
let url_id_data = url_val[1]
let url_id_split = url_id_data.split('-')
let url_id = url_id_split[0]
let branch = url_id_split[1]
console.log(url_id)
$('#changePwd_btn').click(function(e){
			
			let temp_count = $('.templateDiv').length;
			let temp_data = 0;
			e.preventDefault()
				let fd = new FormData();
				let file_name = $('.uploadInputFile').val().replace("C:\\fakepath\\", "");
				if(file_name != ''){
					$(this).text('Loading...')
				fd.append("file_name",file_name);
				fd.append("url_id",url_id);
				fd.append("branch",branch);
				fd.append("files[]", $('.uploadInputFile')[0].files[0]);
				$.ajax({
				  url:"action/upload_data/Upload_file1.php",
                  type:"POST",
                  data:fd,
                  contentType:false,
                  processData:false,
				  success:function(result_data){
					  		history.back()
				  }
				})
				}
			
		})

fetch_doctor_profile_data()
function fetch_doctor_profile_data(){
	$.ajax({
		url:"action/profile/profile_data.php",
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
			if(profile_result_json[0]['status'] == 1){
				$('#name').text(profile_result_json[0]['doctor_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				if(profile_result_json[0]['proPic'] != ''){
				$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				}
			}
		}
	})
}