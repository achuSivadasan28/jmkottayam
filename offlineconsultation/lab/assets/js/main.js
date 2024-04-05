
// sidemenu 
$('.navBarBox').click(function(){
	$('.sidemenu').toggleClass('sidemenuFullActive');
	$('.navBarBox').toggleClass('navBarBoxActive');
	$('.canvas').toggleClass('canvasActive');
})

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
}


//sckelly
$(window).load(function() {
	$('.sckelly').css({
		display: 'none',
	});
});

//nav dropdown
$('.navProfileBox').click(function(){
	$('.navDropdown').toggleClass('navDropdownActive');
	$('.navProfileDown').toggleClass('navProfileDownActive');
});