<!DOCTYPE html>
<?php 
session_start();
if(isset($_SESSION['adminLogId'])){
	require_once '../_class/query.php';
$obj=new query();
$version_variable = '';
$select_version = $obj->selectData("id,version_id","tbl_version","");
	if(mysqli_num_rows($select_version)){
	while($select_version_row = mysqli_fetch_array($select_version)){
$version_variable = $select_version_row['version_id'];
		
	}
	}
?>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->

<body>
    
    <main>

        <!-- shimmer -->
        <div class="shimmer"></div>
        <!-- shimmer close -->
        
        <!-- dashboard  -->
        <section id="dashboard">

            <!-- nav -->
            <?php
                include "assets/includes/nav/nav.php";
            ?>
            <!-- nav close -->

            <!-- sidemenu  -->
            <?php
                include "assets/includes/sidemenu/sidemenu.php";
            ?>
            <!-- sidemenu close -->

            <!-- canvas  -->
            <div class="canvas">
            
                <!-- canvas head  -->
                <div class="canvasHead">
                    <div class="canvasHeadBox1">
                        <h1>Add Staff</h1>
                        <div class="breadCrumbs">
                            <a href="staff-management.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="staff-management.php">Staff Management</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
                    <form action="" id="form_act">
                        <div class="formGroup">
                            <label for="">Staff Name</label>
                            <input type="text" id="sname" required>
                        </div>
                        <div class="formGroup">
                            <label for="">Phone</label>
                            <input type="number" id="phone" required>
                        </div>
                        <div class="formGroup">
                            <label for="">Branch Name</label>
                            <div class="formSelect ">
                                <select name="" id="" class="search_drop">
                                    <option value="" selected disabled></option>
                                    <option value="1">Palakkad</option>
                                    <option value="2">Ernakulam</option>
                                    <option value="3">Kottayam</option>
                                    <option value="4">Idukki</option>
                                </select>
                            </div>
                        </div>
                        <div class="formGroup">
                            <label for="">Email</label>
                            <input type="email" id="email" required>
                        </div>
						<div class="formGroup">
                            <label for="">Role</label>
							<select name="" id="role_data" required>
								<option value="" selected disabled></option>
								<option value="1">Counter Staff</option>
								<option value="2">Inventory Manager</option>
							</select>
                        </div>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down -->

                        <div class="formBtnArea">
                            <button type="submit" class="submitBtn" >Save</button>
                        </div>
                    </form>
                </div>
                <!-- form section close -->

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
    <?php
    include "assets/includes/script/script.php";
    ?>
    <!-- script close -->
    
    <script>
        
        
        // custome select box 
        function create_custom_dropdowns() {
            $('.search_drop').each(function (i, select) {
                if (!$(this).next().hasClass('dropdown-select')) {
                    $(this).after('<div class="dropdown-select wide ' + ($(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="list"><ul></ul></div></div>');
                    var dropdown = $(this).next();
                    var options = $(select).find('option');
                    var selected = $(this).find('option:selected');
                    dropdown.find('.current').html(selected.data('display-text') || selected.text());
                    options.each(function (j, o) {
                        var display = $(o).data('display-text') || '';
                        dropdown.find('ul').append('<li class="option ' + ($(o).is(':selected') ? 'selected' : '') + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>');
                    });
                }
            });
        
            $('.dropdown-select ul').before('<div class="dd-search"><input autocomplete="off" onkeyup="filter()" class="txtSearchValue dd-searchbox" type="text" placeholder="Search..."></div>');
        }
        
        // Open/close
        $(document).on('click', '.dropdown-select', function (event) {
            if($(event.target).hasClass('dd-searchbox')){
                return;
            }
            $('.dropdown-select').not($(this)).removeClass('open');
            $(this).toggleClass('open');
            if ($(this).hasClass('open')) {
                $(this).find('.option').attr('tabindex', 0);
                $(this).find('.selected').focus();
            } else {
                $(this).find('.option').removeAttr('tabindex');
                $(this).focus();
            }
        });
        
        // Close when clicking outside
        $(document).on('click', function (event) {
            if ($(event.target).closest('.dropdown-select').length === 0) {
                $('.dropdown-select').removeClass('open');
                $('.dropdown-select .option').removeAttr('tabindex');
            }
            event.stopPropagation();
        });
        
        function filter(){
            var valThis = $('.txtSearchValue').val();
            $('.dropdown-select ul > li').each(function(){
                var text = $(this).text();
                (text.toLowerCase().indexOf(valThis.toLowerCase()) > -1) ? $(this).show() : $(this).hide();         
            });
        };
        
        // Option click
        $(document).on('click', '.dropdown-select .option', function (event) {
            $(this).closest('.list').find('.selected').removeClass('selected');
            $(this).addClass('selected');
            var text = $(this).data('display-text') || $(this).text();
            $(this).closest('.dropdown-select').find('.current').text(text);
            $(this).closest('.dropdown-select').prev('select').val($(this).data('value')).trigger('change');
        });
        
        // Keyboard events
        $(document).on('keydown', '.dropdown-select', function (event) {
            var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
            // Space or Enter
            //if (event.keyCode == 32 || event.keyCode == 13) {
            if (event.keyCode == 13) {
                if ($(this).hasClass('open')) {
                    focused_option.trigger('click');
                } else {
                    $(this).trigger('click');
                }
                return false;
                // Down
            } else if (event.keyCode == 40) {
                if (!$(this).hasClass('open')) {
                    $(this).trigger('click');
                } else {
                    focused_option.next().focus();
                }
                return false;
                // Up
            } else if (event.keyCode == 38) {
                if (!$(this).hasClass('open')) {
                    $(this).trigger('click');
                } else {
                    var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
                    focused_option.prev().focus();
                }
                return false;
                // Esc
            } else if (event.keyCode == 27) {
                if ($(this).hasClass('open')) {
                    $(this).trigger('click');
                }
                return false;
            }
        });
        
        $(document).ready(function () {
            create_custom_dropdowns();
        });
    </script>
    <script src="js/add-staff.js?v=<?php echo $version_variable;?>"> </script>
    <script>
        fetch('action/dashboard.php')
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
        $('.navProfileName p').append(`${data[0]['user']}`)
        $('.navProfileName span').append(`${data[0]['srole']}`)
    })
    </script>

<script>

//session checking
fetch('action/logincheck.php')
.then(Response=>Response.json())
.then(data=>{
console.log(data)
if(data!=1)
{
location.replace('../login.php')
}
})
$('body').delegate('#logout','click', function(e){
e.preventDefault()
fetch('action/logout.php')
.then(Response=>Response.text())
.then(data=>{
if(data == 1){
 location.replace('../login.php');
}
})
})
</script>
</body>
</html>
<?php
}else{
	header('Location:../login.php');
}
?>