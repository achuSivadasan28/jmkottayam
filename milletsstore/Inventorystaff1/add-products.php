

<?php
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
                        <h1>Add Product</h1>
                        <div class="breadCrumbs">
                            <a href="products.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="inventory-management.php">Inventory Management</a>
                            <span>/</span>
                            <a href="products.php">Products</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
                    <form action="" id="form_act">
                        <div class="formGroup">
                            <label for="">Product Name</label>
                            <input type="text" id="p_name" required>
                        </div>
                        <div class="formGroup">
                            <label for="">Select Category</label>
                            <div class="formSelect">
                                <select name="" id="category">
                                    <option value="" selected disabled></option>
                                    <!-- <option value="1">Category 1</option>
                                    <option value="2">Category 2</option>
                                    <option value="3">Category 3</option> -->
                                </select>
								<span id="Cat_error" style="color:red"></span>
                            </div>
                        </div>

						<!-- dont remove the div, put it down -->
						<div class="dummyDiv"></div>
						<div class="dummyDiv"></div>
						<!-- dont remove the div, put it down -->

						<div class="formTemplateDiv">
							<div class="formGroup">
								<label for="">No.of Pills</label>
								<input type="number" class="pills_number" required>
							</div>
							<div class="formGroup">
								<label for="">Price</label>
								<input type="number" class="price" required>
							</div>
							<div class="formGroup">
								<label for="">HSN/SAC</label>
								<input type="number" class="hsn_num" required>
							</div>
							<div class="formGroup">
								<label for="">Batch</label>
								<input type="text" class="batch_name" required>
							</div>
							<div class="formGroup">
								<label for="">Expiry Date</label>
								<input type="date" class="exp_date" required>
							</div>
							<div class="formGroup">
								<label for="">Discount</label>
								<input type="number" class="discount" >
							</div>
							<div class="formGroup">
								<label for="">Quantity</label>
								<input type="number" class="quantity" required>
							</div>
							<div class="formGroup">
								<label for="">Tax In %</label>
								<input type="number" class="tax_in" required>
							</div>
							<div class="formGroup">
								<label for="">Purchased Price</label>
								<input type="number" class="purchased_price" required>
							</div>
							<div class="formGroup">
								<label for="">Purchased Date</label>
								<input type="date" class="purchase_date" required>
							</div>
							<div class="formGroup">
								<label for="">Invoice Number</label>
								<input type="text" class="invoice_num" required>
							</div>
							<!-- dont remove the div, put it down -->
							<div class="dummyDiv"></div>
							<div class="dummyDiv"></div>
							<!-- dont remove the div, put it down -->
						</div>
						
						<div class="formParentTemplateDiv"></div>
						
						<div class="addNewTemplate">
							<div class="addNewTemplateBtn">Add More</div>
						</div>

                        <div class="formBtnArea">
                            <button type="submit" class="submitBtn">Save</button>
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
		
		// addNewTemplateBtn
		$('.addNewTemplateBtn').click(function(){
			var formParentTemplateDiv = $('.formParentTemplateDiv');
			var formTemplateDiv = `<div class="formTemplateDiv">
							<div class="formGroup">
								<label for="">No.of Pills</label>
								<input type="number" class="pills_number" required>
							</div>
							<div class="formGroup">
								<label for="">Price</label>
								<input type="number" class="price" required>
							</div>
							<div class="formGroup">
								<label for="">HSN/SAC</label>
								<input type="number" class="hsn_num" required>
							</div>
							<div class="formGroup">
								<label for="">Batch</label>
								<input type="text" class="batch_name" required>
							</div>
							<div class="formGroup">
								<label for="">Expiry Date</label>
								<input type="date" class="exp_date" required>
							</div>
							<div class="formGroup">
								<label for="">Discount</label>
								<input type="number" class="discount" >
							</div>
							<div class="formGroup">
								<label for="">Quantity</label>
								<input type="number" class="quantity" required>
							</div>
							<div class="formGroup">
								<label for="">Tax In %</label>
								<input type="number" class="tax_in" required>
							</div>
							<div class="formGroup">
								<label for="">Purchased Price</label>
								<input type="number" class="purchased_price" required>
							</div>
							<div class="formGroup">
								<label for="">Purchased Date</label>
								<input type="date" class="purchase_date" required>
							</div>
							<div class="formGroup">
								<label for="">Invoice Number</label>
								<input type="text" class="invoice_num" required>
							</div>
							<!-- dont remove the div, put it down -->
							<div class="dummyDiv"></div>
							<div class="dummyDiv"></div>
							<!-- dont remove the div, put it down -->

							<div class="removeTemplate">
								<div class="removeTemplateBtn">Remove</div>
							</div>
						</div>`;
			formParentTemplateDiv.append(formTemplateDiv);
		})
		$('body').delegate('.removeTemplateBtn', 'click', function(){
			$(this).parent().parent().remove();
		})
        
        
        // custome select box 
        function create_custom_dropdowns() {
            $('select').each(function (i, select) {
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
            //create_custom_dropdowns();
        });
    </script>
    <script src="js/add-products.js?v=<?php echo $version_variable;?>"> </script>
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