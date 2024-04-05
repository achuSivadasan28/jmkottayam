function fetch_all_payment_option(){
$.ajax({
	url:"action/fetch_all_payment_option.php",
	success:function(result){
		let result_json = jQuery.parseJSON(result)
		let siNo = 0;
		$('#tbl_details tbody').empty()
		if(result_json.length !=0){
			$('.elseDesign').css('display','none')
		for(let x=0;x<result_json.length;x++){
			siNo++;
			$('#tbl_details tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${siNo}</p>
                                                    </td>
                                                    <td data-label="Payment Option">
                                                        <p>${result_json[x]['payment_option']}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="tableDeleteBtn" title="Delete" data-id=${result_json[x]['id']}>
                                                                <i class="uil uil-trash"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>`)
		}
		}else{
			$('.elseDesign').css('display','flex')
		}
	}
})
}
fetch_all_payment_option();

			let data_id = 0;
			$('body').delegate('.tableDeleteBtn','click',function(e){ 
				e.preventDefault();
				data_id = $(this).attr('data-id')
				$('.deleteAlert').fadeIn();
				$('.shimmer').fadeIn();
			});
			$('.closedeleteAlert').click(function(){
				$('.deleteAlert').fadeOut();
				$('.shimmer').fadeOut();
			});
			$('.confirmdeleteAlert').click(function(){
				$.ajax({
					url:"action/delete_payment_option.php",
					type:"POST",
					data:{data_id:data_id},
					success:function(result_data){
							$('.deleteAlert').fadeOut();
							$('.shimmer').fadeOut();
						fetch_all_payment_option()
					}
				})

			});