
let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let last_num = '';
let status_id = 0;
let search_val = '';
let prevPage = document.getElementById('prev_page');
let nextPage = document.getElementById('nxt_page');
let dep_id = 0;
let branch_id_f = 0;


fetch_doctor_data()
function fetch_doctor_data(){
$.ajax({
	url:"action/timeSlot/fetch_all_timeslot.php",
	success:function(result){
		let result_data_json = jQuery.parseJSON(result)
		console.log(result_data_json)
		if(result_data_json[0]['status'] == 1){
			$('.slotList').empty()
			if(result_data_json[0]['data_status'] == 1){
				for(let x2=0;x2<result_data_json.length;x2++){
					let block_display = "style='display:none'";
					if(result_data_json[x2]['time_status'] == 2){
						block_display = "style='display:block'";
					}
				$('.slotList').append(`<div class="slotListBox">
                        <div ${block_display} class="bloacedAlert">Blocked</div>
                        <h2>${result_data_json[x2]['slot_name']}</h2>
 <p>${result_data_json[x2]['start_time']} ${result_data_json[x2]['f_time_section']} - ${result_data_json[x2]['end_time']} ${result_data_json[x2]['l_time_section']}</p>
                        <p>No .of Appointments : <span>${result_data_json[x2]['total_num_slot']}</span></p>
                        <div class="slotListBoxBtnArea">
                        <a href="edit-slot.php?id=${result_data_json[x2]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                        </a>
                        <div class="tableBlockBtn" data-id = ${result_data_json[x2]['id']} title="Block">
                            <i class="uil uil-ban"></i>
                        </div>
                        <div class="tableDeleteBtn" data-id = ${result_data_json[x2]['id']} title="Delete">
                            <i class="uil uil-trash"></i>
                        </div>
                        </div>
                    </div>`)
				}
				$('.slotList').append(`<div class="dummyDiv"></div>
                    <div class="dummyDiv"></div>`)
			}else{
				$('.slotList').empty()
				$('.eleseBox').css('display','flex')
			}
		}else{
			$('.slotList').empty()
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
	}
})
}

        // delete alert 
		let slot_id = 0; 
		let parsent_div = ''; 
        $('body').delegate('.tableDeleteBtn','click',function(){
			slot_id = $(this).attr('data-id')
			parsent_div = $(this).parent().parent()
            $('.deleteAlert').fadeIn();
            $('.shimmer').fadeIn();
        });
        $('.closedeleteAlert').click(function(){
            $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
        });
        $('.confirmdeleteAlert').click(function(){
			$.ajax({
				url:"action/timeSlot/delete.php",
				type:"POST",
				data:{slot_id:slot_id},
				success:function(result_data){
					console.log(result_data)
					let result_data_json = jQuery.parseJSON(result_data);
					if(result_data_json[0]['status'] == 1){
						$('.deleteAlert').fadeOut();
            			$('.shimmer').fadeOut();
						parsent_div.remove();
					}else{
						$('.tableWraper table tbody').empty()
						$('.toasterMessage').text(result_data_json[0]['msg'])
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
            
        });



        // block slot 
        $('body').delegate('.tableBlockBtn','click',function(){
			let slot_id = $(this).attr('data-id')
			$.ajax({
				url:"action/timeSlot/block_time_slot.php",
				type:"POST",
				data:{slot_id:slot_id},
				success:function(result_data){
					let result_data_json = jQuery.parseJSON(result_data)
					$('.toasterMessage').text(result_data_json[0]['msg'])
					$('.errorTost').css('display','none')
					$('.successTost').css('display','flex')
					$('.toaster').addClass('toasterActive');
						setTimeout(function () {
							$('.toaster').removeClass('toasterActive');
						}, 2000)
				}
			})
            $(this).parent().siblings('.bloacedAlert').toggle();
        })