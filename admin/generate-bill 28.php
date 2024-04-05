<?php
session_start();
if(isset($_SESSION['adminLogId'])){
require_once '../_class/query.php';
$obj=new query();
$head = '';
$address = '';
$phn_details = '';
$gst_data = '';
$invoice_type = '';
$select_address = $obj->selectData("head,address,phn_details,gst_data,invoice_type","tbl_address","");
if(mysqli_num_rows($select_address)){
	while($select_address_row = mysqli_fetch_array($select_address)){
		$head = $select_address_row['head'];
		$address = $select_address_row['address'];
		$phn_details = $select_address_row['phn_details'];
		$gst_data = $select_address_row['gst_data'];
		$invoice_type = $select_address_row['invoice_type'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->

<body>
	 <!-- print design  -->
        <div class="printDesign">
            <div class="printDesignHead">
                <div class="printDesignHeadLogo">
                    <img src="assets/images/johnmariansLogo.png" alt="">
                </div>
                <div class="printDesignHeadAddress">
					<h2><?php echo $head;?></h2>
					<p><?php echo $address;?></p>
                    <p><?php echo $phn_details;?></p>
                    <p><b><?php echo $gst_data;?></b></p>
					<h2><?php echo $invoice_type;?></h2>
                </div>
            </div>
            <div class="printDesignProfile">
                <div class="printDesignProfileBox">
                    <ul>
                        <li>
                            <span>Invoice No <b>:</b></span>
                            <p id="unique_id_text"></p>
                        </li>
                        <li>
                            <span>Customer Name <b>:</b></span>
                            <p id="customer_name_text"></p>
                        </li>
                        <li>
                            <span>Mobile No <b>:</b></span>
                            <p id="mob_num_text"></p>
                        </li>
                    </ul>
                </div>
                <div class="printDesignProfileBox">
                    <ul>
                        <li id="invoice_data_details" style="display:none">
                            <span>Invoice Id <b>:</b></span>
                            <p id="tax_id_text"></p>
                        </li>
                        <li>
                            <span>Order Date & Time<b>:</b></span>
                            <p id="order_date_text"></p>
                        </li>
                    </ul>
                </div> 
            </div>
            <div class="printDesignTable">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>HSN <br>Code</th>
                            <th>Batch No</th>
                            <th>Expire Date</th>
                            <th>QTY</th>
                            <th>Taxable Value</th>
							<th>Tax %</th>
							<th>CGST</th>
							<th>SGST</th>
                            <th>MRP</th>
                        </tr>
                    </thead>
                    <tbody class="tableInvoice">
                           <!--<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>1</td>
                            <td>Paracetamol, Medicin Category</td>
                            <td>2</td>
                            <td>₹ 200</td>
                            <td>₹ 200</td>
                            <td>₹ 20</td>
                            <td>₹ 10</td>
                            <td>₹ 190</td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>2</td>
                            <td>Paracetamol, Medicin Category</td>
                            <td>2</td>
                            <td>₹ 200</td>
                            <td>₹ 200</td>
                            <td>₹ 20</td>
                            <td>₹ 10</td>
                            <td>₹ 190</td>
                        </tr>-->

                    </tbody>
					
					<tbody class="taxDiv" style="border-top: 1px solid black;">
						<!--<tr style="page-break-inside: avoid; page-break-after: auto; border-bottom: 1px dashed black;">
                            <td colspan="5" class="tax_val_dis1"><b></b></td>
                            <td colspan="1"><b id="quantity_class1"></b></td>
							<td colspan="1"><b id="tax_in_per_data">@18%</b></td>
							<td colspan="1"><b id="tax_in_per_data"></b></td>
							 <td colspan="1"><b id="total_cgst_in_per">₹ 12</b></td>
							 <td colspan="1"><b id="total_sgst_in_per">₹ 12</b></td>-->
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                           <!-- <td colspan="0" style="text-align: left;"><b id="total_amt_11"></b></td>-->
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>
                            <td colspan="1"><b id="g_total_amt"></b></td>-->
                       <!-- </tr>-->
					</tbody>
                    <tfoot>
						<tr style="page-break-inside: avoid; page-break-after: auto; display:none;" class="delivery_charge_section">
							<td colspan="9"></td>
                            <td style="text-align: left;" class="tax_val_dis1"><b>Delivery Charge</b></td>
                            <td style="text-align: left;"><b id="total_amt_1_delivery"></b></td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="5" class="tax_val_dis"><b>Total</b></td>
                            <td colspan="3"><b id="quantity_class"></b></td>
							 <td colspan="1"><b id="cgst"></b></td>
							 <td colspan="1"><b id="sgst"></b></td>
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                            <td colspan="0" style="text-align: left;"><b id="total_amt_1"></b></td>
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>
                            <td colspan="1"><b id="g_total_amt"></b></td>-->
                        </tr>
                       <!-- <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="7" style="border: none; text-align: right; padding-right: 10px;"><b>Total Amount</b></td>
                            <td colspan="1" style="border: none;"><b id="g_total_amt">₹ 380</b></td>
                        </tr>-->
                        <tr style="page-break-inside: avoid; page-break-after: auto; border-top: 1px solid black;">
                            <td colspan="12"><b id="amt_in_words"></b> - Inclusive Of All Taxes</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="printDesignTC" style="page-break-inside: avoid; page-break-after: auto;">
				<!--<h2>Bank Details</h2>
				<p>Account Name : JOHNMARIAN WELLNESS CLINIC</p>
				<p>Account Number : 306530123456789</p>
				<p>Branch: KALAMASSERY</p>
				<p>Account Type : Current Account</p>
				<p>IFSC Code : TMBL0000306</p>
				<p>MICR Code : 682060003</p>-->
                <h2>Terms & Conditions</h2>
                <p>You should not make any change in your current medications or health regimen before consulting a registered medical practitioner</p>
            </div>
        </div>
        <!-- print design close -->
    
    <main>
		
		<style>
			.check-box {
				  display: flex;
				  column-gap: .3em;
				  align-items: center;
				  font-family: sans-serif;
				/* Прописываем размер шрифта, ч-б меняет свой размер */
				  font-size: 18px;
				  margin-bottom: 5px;
				  --checked-color: hotpink;
				  --unchecked-color: #aaa;
				  --checked-disabled-color: #ffb4d9;
				  --unchecked-disabled-color: #ddd;
				}

				.check-box__switcher {
				  font-size: inherit;
				  appearance: none;
				  height: 1em;
				  width: 1.5em;
				  margin: 0;
					font-size: 30px;
					margin-right: 10px;
				  border-radius: 1em;
				  background-color: var(--unchecked-color);
				  background-image: url('data:image/svg+xml,%3C%3Fxml version="1.0"%3F%3E%3Csvg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"%3E%3Ccircle cx="10" cy="10" fill="%23ffffff" r="10"/%3E%3C/svg%3E');
				  background-repeat: no-repeat;
				  background-size: auto calc(100% - 4px);
				  background-position: center left 2px;
				  transition: background-position .2s ease-in, background-color 0s .1s;
				  cursor: pointer;
				}

				.check-box__switcher:checked {
				  background-position: center right 2px;
				  background-color: var(--checked-color);
				}

				.check-box__switcher:disabled:checked {
				  background-position: center right 2px;
				  background-color: var(--checked-disabled-color);
				  cursor: pointer;
				}

				.check-box__switcher:disabled {
				  background-position: center left 2px;
				  background-color: var(--unchecked-disabled-color);
				  cursor: pointer;
				}
			.formGroupBox{
				width: 100%;
				padding: 20px;
				border-radius: 5px;
				display: flex;
				flex-direction: column;
				background: linear-gradient(45deg, #2161ed, #42bbc8);
			}
			.formGroupBox label{
				color: white;
			}
			.formGroupBox input{
				background: none;
				border: none !important;
				width: inherit;
				height: auto;
				padding: 0;
				margin-top: 15px;
				font-size: 25px !important;
				color: white;
				font-weight: 600;
			}
		</style>

        <!-- shimmer -->
        <div class="shimmer"></div>
        <!-- shimmer close -->
	
		<div class="billLoading" style="z-index:1000">
			<div class="billLoadingMain">
				<div class="billLoadingThumbnail">
					<img src="assets/images/icon/prebilling.gif">
				</div>
				<p>Preparing bill...</p>
			</div>
		</div>

       
        
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
                        <h1>Generate Bill</h1>
                        <div class="breadCrumbs">
                            <a href="index.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="index.php">Dashboard</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                <div class="viewPriscription">
					<div class="viewPriscriptionBtn">View Prescription</div>
				</div>
				<div class="viewPriscriptionPopup">
					<div class="closeViewPriscriptionPopup">
						<i class="uil uil-multiply"></i>
					</div>
					<ul class="prescription_details">
					<!--	<li>
							<h2>Digestive</h2>
							<p>1-0-1 15 days</p>
							<span>AF</span>
						</li>
						<li>
							<h2>helacid</h2>
							<p>1-0-1 15 days</p>
							<span>BF</span>
						</li>-->
					</ul>
				</div>
                <!-- form wraper  -->
                <div class="formWraper">
                    <h2>Customer Details</h2>
                    <form action="">
                        <div class="formGroup">
                            <label for="">Customer Name</label>
                            <input type="text" value="" id="customer_name">
                            <span id="customer_name_error" style="color:red"></span>
                        </div>
                        <div class="formGroup">
                            <label for="">Phone</label>
                            <input type="number" value="" id="phone">
                            <span id="phone_error" style="color:red"></span>
                        </div>
                        <div class="formGroup">
                            <label for="">Place</label>
                            <input type="text" value="" id="place">
                        </div>
						<div class="formGroup">
                            <label for="">Date</label>
                            <input type="date" value="" id="date">
                        </div>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down -->
                    </form>
                </div>
                <!-- form section close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
                    <h2>Product Details</h2>
                    <form action="" id="form_details">
										
                    <div class="customeInputArea">
                            <div class="formGroup">
                                <label>Product Name</label>
								<div class="customDropDown product_name_drop">
									<input type="text" placeholder="Select" class="customDropInput ProductName" id="searchbox">
									<input type="hidden" class="ProductName_id">
									<ul >
										
									</ul>
								</div>
								
								
                                <!--<input type="text" placeholder="Product Name"  list="ProductName" class="ProductName">
                                <input type="hidden" placeholder="ProductName" required>
                                <span id="product_error" style="color:red"></span>
                                <datalist class="ProductName" id="ProductName">
                                </datalist>-->
                            </div>
						
							<div class="formGroup">
                                <label>No.of Pills</label>
								<div class="customDropDown product_no_pill">
									<input type="text" placeholder="Select" class="customDropInput Productnopill" id="searchbox" readonly>
									<input type="hidden" class="Productnopill_id" id="searchbox">
									<ul class="Productnopill1ul">
										
									</ul>
								</div>
                            </div>
                            
                            <!--<div class="formGroup">
                                <label>Category Name</label>
                                <input type="search" placeholder="Category Name"  list="CategoryName"  class="CategoryName">
                                <input type="hidden" placeholder="Category Name">
                                <span id="category_error" style="color:red"></span>
                                <datalist class="CategoryName" id="CategoryName">-->
                                    <!-- <option value="Medicin Category 1">Medicin Category 1</option>
                                    <option value="Medicin Category 2">Medicin Category 2</option>
                                    <option value="Medicin Category 3">Medicin Category 3</option> -->
                                <!--</datalist>
                            </div>-->
                            <input type="hidden" disabled class="product_id" id="product_id">  
                           
                            <div class="formGroup">
                                <label>Rate</label>
                                <input type="number" disabled class="Price">                                    
                            </div>
                            
                            <div class="formGroup qnt" style="display:none">
                                <label>Discount Per Piece</label>
                                <input type="text" class="discount"> 
                                <span style="color:red" id="discount_error"></span>                                   
                            </div>
                            <input type="hidden" disabled class="disc" id="disc">
							<input type="hidden" disabled class="stock_error_status">
						    <input type="hidden" disabled class="dis_error_status">
                            <div class="formGroup">
                                <label>Quantity</label>
                                <input type="number" class="Quantity" id="Quantity" >
                                <span id="quantity_err" style="color:red"></span> 
								<span class="quantity_err1" style="color:red"></span>
                            </div>
                            <input type="hidden" disabled class="gross" id="gross">
						<div class="formGroup">
                                <label>Tax in %</label>
                                <input type="number" disabled class="tax_in_per" id="tax_in_per">                                    
                            </div>
						<div class="formGroup">
                                <label>Total Tax</label>
                                <input type="number" disabled class="tax_data" id="tax_data">                                    
                            </div>
                            <div class="formGroup">
                                <label>Total Price</label>
                                <input type="number" disabled class="Rate" id="Rate">                                    
                            </div>
						<!--<div class="removeBtn"></div>-->

                            <!-- dont remove the div, put it down -->
                            <div class="dummyDiv"></div>
                        	<div class="dummyDiv"></div>
                            <!-- dont remove the div, put it down -->
						
						

                        </div>

                        <div class="dynamicProductDetails"></div>

                        <div id="addnewBtn" class="addNewFormGroup">
                            <a href="" class="addNewFormGroupBtn">Add More </a>
                        </div>
						
						<div class="formGroup">
                           <label for="">Payment Option</label>
							<select id="payment_option">
								<!--<option>Google Pay</option>
								<option>Phone Pay</option>
								<option>Cash</option>-->
							</select>
							<span id="payment_option_data" style="color:red"></span>
                        </div>
						
						<div class="formGroup">
                            <label for="">Received Amount</label>
                            <input type="text" value="" id="Recived_amt">
                        </div>
						<div class="formGroup">
                            <label for="">Bill Amount</label>
                            <input type="text" value="" id="bill_amt" disabled style="color: #47d100; font-weight: 600; font-size: 20px;">
                        </div>
						<div class="formGroup">
                            <label for="">Balance Amount</label>
                            <input type="text" value="" id="balance_amt" disabled>
                        </div>
                    </form>
                </div>
                <!-- form section close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
					<!--<h2>Tax Calculation</h2>
					<div class="formGroupCheckBox" style="margin: 30px 0px;">
						<label class="check-box">
							<input type="checkbox" id="tax_ch" class="tax_ch check-box__switcher" value="1">Tax
						</label>
                        </div>-->
                    <h2>Price Details</h2>
                    <form action="" id="form_details">
                        <div class="formGroup">
							<div class="formGroupBox">
								<label for="">Total Price</label>
								<input type="text"  id="Tprice" class="Tprice" disabled value="0">
							</div>
                        </div>
                        <div class="formGroup">
							<div class="formGroupBox">
								<label for="">Total Discount</label>
								<input type="text" id="Tdiscount" class="Tdiscount" disabled value="0">
							</div>
                        </div>
						<div class="formGroup" id="tax_split_amt" style="display:none">
							<div class="formGroupBox">
								<label for="">Actual Amount (Excluding Tax)</label>
								<input type="text" id="aAmt" class="aAmt" disabled value="0">
							</div>
                        </div>
						<div class="formGroup" id="tax_split_cgst" style="display:none">
							<div class="formGroupBox">
								<label for="">CGST (9%)</label>
								<input type="text" id="total_tax_amt_cgst" value="0">
							</div>
                        </div>
						<div class="formGroup" id="tax_split_sgst" style="display:none">
							<div class="formGroupBox">
								<label for="">SGST (9%)</label>
								<input type="text" id="total_tax_amt_sgst" value="0">
							</div>
                        </div>
                        <div class="formGroup" id="tax_split" style="display:none">
							<div class="formGroupBox">
								<label for="">Total Tax (18%)</label>
								<input type="text" id="total_tax_amt" value="0">
							</div>
                        </div>
                        <div class="formGroup">
							<div class="formGroupBox">
								<label for="" id="tax_including_data_text">Total Amount</label>
								<input type="number" value=0 id="tamount" class="tamount"  disabled >
							</div>
                        </div>
						<div class="formGroup">
							<label for="" id="tax_including_data_text">Delivery Charge</label>
							<input type="checkbox" style="width: 25px; height: 25px;" class="deliveryChargeBtn">
							<input type="number" placeholder="Enter Delivery Charge" class="deliveryChargeInput" style="display: none;">
                        </div>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down -->

                        <div class="formBtnArea">
                            <button class="printBillBtn aBtn">Save</button>
							
                        </div>
						<span id="common_error_data" style="color:red"></span>
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
	
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

    <script src="js/generatebills.js"> </script>

    <script>	
		
		
		
		
        $(document).ready(function() {
			
			// customDropdown
			$('body').on('click','.customDropInput',function(e) {
				$(this).siblings('.customDropDown ul').show();
			})
			$('body').on('click','.customDropDown ul li',function(e) {
				$(this).parent('.customDropDown ul').hide();
			})
			$(document).mouseup(function(e) 
								{
				var container = $(".customDropDown ul");

				// if the target of the click isn't the container nor a descendant of the container
				if (!container.is(e.target) && container.has(e.target).length === 0) 
				{
					container.hide();
				}
			});
			function fetch_all_product_data(){
				let drop_down = '';
				return $.ajax({
					url:"action/fetch-product.php",
					
				})
			}
			
			
			
            $(".addNewFormGroupBtn").click(function(e) {
                e.preventDefault();
				$.when(fetch_all_product_data()).then(function(product_result){
					let product_result_json = jQuery.parseJSON(product_result)
					console.log(product_result_json)
					 //$(".dynamicProductDetails").append
					
                let template_data = `<div class="customeInputArea"> 
<div class="formGroup"> 
<div class="customDropDown product_name_drop">
<input type="text" placeholder="Select" class="customDropInput ProductName" id="searchbox">
<input type="hidden" class="ProductName_id">
<ul >`;
for(let y1=0;y1<product_result_json.length;y1++){
	template_data += `<li data-id="${product_result_json[y1]['id']}">${product_result_json[y1]['product_name']}</li>`
}
template_data += `</ul>
</div>
</div> 
<div class="formGroup"> 
<div class="customDropDown product_no_pill">
<input type="text" placeholder="Select" class="customDropInput Productnopill" id="searchbox" readonly>
<input type="hidden" class="Productnopill_id" id="searchbox">
<ul class="Productnopill1ul">
</ul>
</div>
</div>
<input type="hidden" disabled class="product_id" id="product_id"> 
<div class="formGroup">  
<input type="number" disabled class="Price"> </div> 

<div class="formGroup" style="display:none"> 
<label>Discount Per Piece</label> 
<input type="text" class="discount"> 
<span style="color:red" id="discount_error"></span>  
</div>  

<div class="formGroup">  
<input type="number" class="Quantity" id="quant"> <span id="quantity_err" style="color:red"></span> <span class="quantity_err1" style="color:red"></span> </div> 
<input type="hidden" disabled class="gross" id="gross">
<div class="formGroup">
     <label>Tax in %</label>
     <input type="number" disabled class="tax_in_per" id="tax_in_per">                                    
</div>
<div class="formGroup">
    <label>Total Tax</label>
    <input type="number" disabled class="tax_data" id="tax_data">                                    
</div>
<div class="formGroup"> 
    <label style="opacity: 0;">Total Tax</label><input type="number" disabled class="Rate"> </div>
<div class="removeBtn">
<button class="inputRemove"><i class="uil uil-trash"></i></button>
		</div> 
<div class="dummyDiv"></div>
						
						</div>`;
					$(".dynamicProductDetails").append(template_data);
			})
            });
            $('body').on('click','.inputRemove',function(e) {
                e.preventDefault();
                $(this).parent().parent().remove()
				
				$.when(update_total_Price()).then(function(){
					let g_total_price = $('.tamount').val()
					if(g_total_price != ''){
						tax_calculation_data(g_total_price)
					}
				})
            });
        });
		
		function update_total_Price(){
			let A_total_amt = 0;
			let G_total_amt = 0;
			let G_total_dis = 0;
			let btn_disabled_status = 0;
			$('.customeInputArea').each(function(){
				if($(this).find('.Price').val() != undefined || $(this).find('.discount').val() != undefined || $(this).find('.Quantity').val() != undefined){
						let total_rate = $(this).find('.Price').val()
						let total_dis = $(this).find('.discount').val()
						let total_Qu = $(this).find('.Quantity').val()
					
						console.log(total_rate)
						if(total_Qu == ''){
							total_Qu = 1;
						}
						if(total_dis  == ''){
							total_dis = 0;
						}
						A_total_amt += total_rate*total_Qu
						G_total_amt += (total_rate-total_dis)*total_Qu
						G_total_dis += total_dis*total_Qu
							//console.log(total_rate)
				}
					
						
			})
			$('.Tprice').val(A_total_amt)
			$('.Tdiscount').val(G_total_dis)
			$('.tamount').val(G_total_amt)
			$('#bill_amt').val(G_total_amt)
		}

        $('.printBillBtn').click(function(e){
            e.preventDefault();
			//this.setAttribute('disabled',true);
        })
    </script>
    
    <script>
    fetch('action/dashboard.php')
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
        $('.navProfileName p').append(`${data[0]['sname']}`)
        $('.navProfileName span').append(`${data[0]['srole']}`)
    })
    </script>

<script>
    //session handling
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
	
	//add count
	$(document).ready(function() {
			$('.minus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 1 ? 0 : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$('.plus').click(function () {
				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);
				$input.change();
				return false;
			});
		});
	
	//delivery charge
	$('.deliveryChargeBtn').click(function (event) {
		if (this.checked) {
			$('.deliveryChargeInput').show();
		} else {
			$('.deliveryChargeInput').hide();
		}
	});
  </script> 
</body>
</html> 
<?php
}else{
header("Location:../login.php");
}	
?>