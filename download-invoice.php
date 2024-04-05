<?php
session_start();
require_once '_class/query.php';
$obj=new query();
$invoice_data = $_GET['id'];
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
	

$version_variable = '';
$select_version = $obj->selectData("id,version_id","tbl_version","");
	if(mysqli_num_rows($select_version)){
	while($select_version_row = mysqli_fetch_array($select_version)){
$version_variable = $select_version_row['version_id'];
		
	}
	}
?>
<!DOCTYPE html>
<html lang="en">

<body>
	
	<style>
	
	@import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
body {
  font-family: 'Montserrat', sans-serif;
}
  .printDesign {
    display: block;
	  padding: 15px;
  }
  .printDesign .printDesignHead {
    width: 100%;
    padding: 10px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
	  flex-direction: column;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
  }
  .printDesign .printDesignHead .printDesignHeadLogo {
    width: 110px;
  }
  .printDesign .printDesignHead .printDesignHeadLogo img {
    width: 100%;
    height: 100%;
    -o-object-fit: contain;
       object-fit: contain;
  }
  .printDesign .printDesignHead .printDesignHeadAddress {
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
    text-align: right;
  }
  .printDesign .printDesignHead .printDesignHeadAddress p {
    text-align: center;
    font-size: 12px;
    line-height: 1.5;
  }
  .printDesign .printDesignHead .printDesignHeadAddress h2 {
    text-align: center;
    font-size: 14px;
	  margin-top: 10px;
	  font-weight: 600;
  }
  .printDesign .printDesignProfile {
    width: 100%;
    border-top: 1px dashed black;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
	  flex-direction: column;
	  padding-top: 10px;
  }
  .printDesign .printDesignProfile .printDesignProfileBox {
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
  }
  .printDesign .printDesignProfile .printDesignProfileBox:nth-child(1) {
    border-left: none;
  }
  .printDesign .printDesignProfile .printDesignProfileBox ul {
    width: 100%;
  }
  .printDesign .printDesignProfile .printDesignProfileBox ul li {
    list-style: none;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
        -ms-flex-pack: justify;
            justify-content: space-between;
    margin-top: 5px;
  }
  .printDesign .printDesignProfile .printDesignProfileBox ul li:nth-child(1) {
    margin-top: 0px;
  }
  .printDesign .printDesignProfile .printDesignProfileBox ul li span {
    font-size: 10px;
    font-weight: 500;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
        -ms-flex-pack: justify;
            justify-content: space-between;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
    width: 130px;
  }
  .printDesign .printDesignProfile .printDesignProfileBox ul li p {
    width: calc(100% - 150px);
    font-size: 10px;
    font-weight: 500;
    line-height: 1.5;
  }
.printDesign .printDesignTable2{
	width :100%;
	display :flex;
	flex-direction: column;
}
.printDesign .printDesignTable2 ul{
	width :100%;	
	display :flex;
	flex-direction: column;
	border-top: 1px dashed black;
	padding: 5px 0px;
}
.printDesign .printDesignTable2 ul li{
	width :100%;
	display: flex;
	list-style: none;
	font-size: 10px;
	padding: 5px 0px;
}
.printDesign .printDesignTable2 ul li span{
	width: 40%;
}




  .printDesign .printDesignTable {
    width: 100%;
    /*border-top: 1px dashed black;*/
	  margin-top: 10px;
	  padding-top: 0px;
  }
  .printDesign .printDesignTable table {
    width: 100%;
    border-collapse: collapse;
    page-break-inside: auto;
	  table-layout: fixed;
  }
  .printDesign .printDesignTable table th, .printDesign .printDesignTable table td {
    padding: 10px 0px;
    font-size: 10px;
    text-align: left;
  }
  .printDesign .printDesignTable table th b, .printDesign .printDesignTable table td b {
    font-weight: 600;
  }
  .printDesign .printDesignTable table th {
    font-weight: 600;
    text-align: left;
    white-space: pre;
  }
  .printDesign .printDesignTable tr {
    page-break-inside: avoid;
    page-break-after: auto;
	  border-top: 1px dashed black;
  }
	.tableInvoice tr{
		width: 100%;
	}
	.tableInvoice tr td{
		/*display: flex;*/
		padding: 5px 0px !important;
		white-space: pre;
	}
.tableInvoice tr td:nth-child(1),{
		padding-top: 10px !important;
	}
.tableInvoice tr td:nth-last-child(1){
		padding-bottom: 10px !important;
	}
	.tableInvoice tr td span{
		width: 100%;
	}
  .printDesign .printDesignTable thead {
    display: table-header-group;
  }
  .printDesign .printDesignTable tfoot {
    display: table-footer-group;
	  border-top: 1px solid black;
  }
.printDesign .printDesignTC{
		border-top: 1px dashed black;
	}
  .printDesign .printDesignTC h2 {
    font-size: 10px;
    font-weight: 600;
    margin-top: 10px;
  }
  .printDesign .printDesignTC p {
    font-size: 10px;
    line-height: 1.7;
    margin-top: 3px;
  }
	
	
	</style>
	
	<!-- print design  -->
	
	<div class="printDesign">
            <div class="printDesignHead">
                <div class="printDesignHeadLogo">
                    <img src="staff/assets/images/johnmariansLogo.png" alt="">
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
				<!--<div class="printDesignTable2">
					
				</div>-->
                <table>
                    <thead>
                        <tr style="border-bottom: 1px solid black;">
                            <th>Item,<br>HSN Code,<br>Batch No</th>
                            <th>Expiry <br>Date</th>
                            <th>QTY</th>
                            <!--<th>Taxable<br> Value</th>
							<th>Tax %</th>
							<th>CGST</th>
							<th>SGST</th>-->
							<th>Amount</th>
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
					
					<!--<tbody class="taxDiv" style="border-top: 1px solid black;">-->
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
					<!--</tbody>-->
                    <thead style="border-top: 1px solid black; border-bottom: 1px solid black;">
						<tr>
							<th>Item</th>
							<th>Tax</th>
							<th>CGST</th>
							<th>SGST</th>
							<th>Total Tax</th>
						</tr>
					</thead>
					<tbody id="tax_split">
					
					</tbody>
                    <tfoot>
						<tr style="page-break-inside: avoid; page-break-after: auto; display:none;" class="delivery_charge_section">
							<td colspan="3"></td>
                            <td style="text-align: left;" class="tax_val_dis1"><b>Delivery Charge</b></td>
                            <td style="text-align: left;"><b id="total_amt_1_delivery"></b></td>
                        </tr>
                        <tr style="border-top: 1px solid black; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="3"></td>
                            <td class="tax_val_dis"><b>Total QTY</b></td>
                            <td ><b id="quantity_class"></b></td>
                        </tr>
                        <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="3"></td>
                            <td class="tax_val_dis"><b>Total CGST</b></td>
							 <td><b id="total_cgst"></b></td>
                        </tr>
                        <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="3"></td>
                            <td class="tax_val_dis"><b>Total SGST</b></td>
							 <td><b id="total_sgst"></b></td>
                        </tr>
                        <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="3"></td>
                            <td class="tax_val_dis"><b>Total Amount</b></td>
                            <td style="text-align: left;"><b id="total_amt_1"></b></td>
                        </tr>
						
						
                       <!-- <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="7" style="border: none; text-align: right; padding-right: 10px;"><b>Total Amount</b></td>
                            <td colspan="1" style="border: none;"><b id="g_total_amt">₹ 380</b></td>
                        </tr>-->
                        <tr style="page-break-inside: avoid; page-break-after: auto; border-top: 1px solid black;">
                            <td colspan="3"><b id="amt_in_words"></b> - Inclusive Of All Taxes</td>
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
	
	
	
	      <!-- print design  -->


    <!-- script  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
    <script src="js/jquery.js"></script>
	
	<script>
		var customer_name = '';
		window.onload = function () {
			
			
			
		};
			function generatePDF(customer_name){
				const source = document.querySelector('body');

				html2pdf(source, {
				  margin:       0,
				  filename:     customer_name+'.pdf',
				  image:        { type: 'jpeg', quality: 0.98 },
				  html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
				  jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
				});
				//html2pdf().from(source).save();
			}
			let url = window.location.href
			let url_splt = url.split("=")
            let customer_id = url_splt[1]
			$.when(dCript_check_invoice(customer_id)).then(function(response){
				let response_data = jQuery.parseJSON(response)
				if(response_data[0]['status'] == 1){
					customer_id = response_data[0]['dcy']
            	$.when(printbill(customer_id)).then(function(){
               		// window.print()
					generatePDF(customer_name)
            	});  
				}else{
					$('body').css('display','none')
				}
			})
		
		function dCript_check_invoice(customer_id){
			return $.ajax({
				url:"action/decript_data.php",
				type:"POST",
				data:{customer_id:customer_id},
				
			})
		}
			       function printbill(customer_id) {              
                     return $.ajax({
                        url: "staff/action/fetchbill.php",
                        type:"POST",
                        data:{customer_id:customer_id},
                        success: function (result) {
							if(result != 0){
								let result_json = jQuery.parseJSON(result)
								console.log(result_json)
								let tax_in_per_data = result_json[0]['tax_in_per']
								if(result_json[0]['delivery_charge'] != 0){
									$('.delivery_charge_section').css('display','contents')
									$('#total_amt_1_delivery').text(result_json[0]['delivery_charge'])
								}else{
									$('.delivery_charge_section').css('display','none')
								}
								$('#unique_id_text').text(result_json[0]['invoice_no'])
								$('#customer_name_text').text(result_json[0]['customer_name'])
								customer_name = result_json[0]['customer_name'];
								$('#mob_num_text').text(result_json[0]['phone'])
								$('#order_date_text').text(result_json[0]['date'])
								$('#invoice_data_details').css('display','none')
								if(result_json[0]['tax_apply']  == 1){
									$('#g_total_tax').text('₹ '+result_json[0]['total_tax_amt'])
									$('#invoice_data_details').css('display','flex')
									$('#tax_id_text').text(result_json[0]['tax_compained_val'])
								}else{
									$('#g_total_tax').text('₹ '+0)
								}
								$('#total_disc_val').text('₹ '+result_json[0]['total_discount'])
								$('#g_total_amt').text('₹ '+result_json[0]['total_amount'])
								$('#amt_in_words').text('('+result_json[0]['amount_words']+' only)')
								$('#quantity_class').text(result_json[0]['total_quantity'])
								$('#total_amt_1').text('₹ '+result_json[0]['total_price_1'])
								$('#total_amt_3').text('₹ '+result_json[0]['total_price_q'])
								$('#total_cgst').text('₹ '+result_json[0]['total_cgst'])
								$('#total_sgst').text('₹ '+result_json[0]['total_sgst'])
								//$('#tax_total').text('₹ '+result_json[0]['total_tax'])
								let product_details = result_json[0]['product']
								$('.printDesignTable .tableInvoice').empty();
								//$('.printDesignTable2').empty();
								
								$('.taxDiv').empty();
								let SINO = 0;
								for(let x=0;x<product_details.length;x++){
									SINO++;
									let net_total = product_details[x]['price']*product_details[x]['quantity']
									/*	$('.printDesignTable2').append(`

					<ul>
						<li>
							<p style="font-size: 20px;">${SINO} - ${product_details[x]['product_name']}</p>
						</li>
						<li>
							<span>HSN Code</span>
							<p>${product_details[x]['hsn_number']}</p>
						</li>
						<li>
							<span>Batch No</span>
							<p>${product_details[x]['batch_name']}</p>
						</li>
						<li>
							<span>Expire Date</span>
							<p>${product_details[x]['expiry_date']}</p>
						</li>
						<li>
							<span>QTY</span>
							<p>${product_details[x]['quantity']}</p>
						</li>
						<li>
							<span>Taxable Value</span>
							<p>₹ ${net_total-product_details[x]['tax_data']}</p>
						</li>
						<li>
							<span>Tax %</span>
							<p>${product_details[x]['tax_in_per']} %</p>
						</li>
						<li>
							<span>CGST</span>
							<p>₹ ${product_details[x]['cgst']}</p>
						</li>
						<li>
							<span>SGST</span>
							<p>₹ ${product_details[x]['sgst']}</p>
						</li>
						<li>
							<span>Amount(Incl Tax)</span>
							<p>₹ ${net_total}</p>
						</li>
					</ul>
					
`)*/
				$('.printDesignTable .tableInvoice').append(`
					<tr style="page-break-inside: avoid; page-break-after: auto; border-top: none;">
                            <!--<td>${SINO}</td>-->
                            <td>${product_details[x]['product_name']},<br>${product_details[x]['hsn_number']},<br>${product_details[x]['batch_name']}</td>
							<td>${product_details[x]['expiry_date']}</td>
                            <td>${product_details[x]['quantity']}</td>
							<td>₹ ${net_total}</td>
                            <!--<td>₹ ${net_total-product_details[x]['tax_data']}</td>-->
							<!--<td>${product_details[x]['tax_in_per']} %</td>
							<td>₹ ${product_details[x]['cgst']}</td>
							<td>₹ ${product_details[x]['sgst']}</td>
							
                            <td>₹ ${net_total}</td>-->
                        </tr>`)
								}
								let si_no = 1;
								$('#tax_split').empty()
							for(let x1 = 0;x1<tax_in_per_data.length;x1++){
								$('#tax_split').append(`
								<tr>
							<td>${si_no}</td>
							<td>${tax_in_per_data[x1]['tax_per']}%</td>
							<td>₹ ${tax_in_per_data[x1]['total_cgst_in']}</td>
							<td>₹ ${tax_in_per_data[x1]['total_sgst_in']}</td>
							<td>₹ ${tax_in_per_data[x1]['total_cgst_in']+tax_in_per_data[x1]['total_sgst_in']}</td>
							</tr>`)
								si_no++
								$('.taxDiv').append(`<tr>
                            <--<td colspan="2" class="tax_val_dis1"><b></b></td>
                            <td colspan="1"><b id="quantity_class1"></b></td>
							<td colspan="1"><b id="tax_in_per_data"></b></td>-->
							<td colspan="1"><b id="tax_in_per_data">@${tax_in_per_data[x1]['tax_per']}%</b></td>
							
							 <td colspan="1"><b id="total_cgst_in_per">₹ ${tax_in_per_data[x1]['total_cgst_in']}</b></td>
							 <td colspan="1"><b id="total_sgst_in_per">₹ ${tax_in_per_data[x1]['total_sgst_in']}</b></td>
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                            <td colspan="0" style="text-align: left;"><b id="total_amt_11"></b></td>
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>
                            <td colspan="1"><b id="g_total_amt"></b></td>-->
                        </tr>`)
									/*}
							for(let x1 = 0;x1<tax_in_per_data.length;x1++){
								let tax_temp = '';
								if(x1 == 0){	
									tax_temp = `<tr>
                            <td colspan="1"></td>
                            <td colspan="1">CGST</td>
                            <td colspan="1">SGST</td>
						</tr>`
						}
						tax_temp +=`<tr>
                            
							<td colspan="1"><b id="tax_in_per_data">Tax @ ${tax_in_per_data[x1]['tax_per']}%</b></td>
							
							 <td colspan="1"><b id="total_cgst_in_per">₹ ${tax_in_per_data[x1]['total_cgst_in']}</b></td>
							 <td colspan="1"><b id="total_sgst_in_per">₹ ${tax_in_per_data[x1]['total_sgst_in']}</b></td>
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                            <!--<td colspan="0" style="text-align: left;"><b id="total_amt_11"></b></td>-->
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>-->
                            <!--<td colspan="1"><b id="g_total_amt"></b></td>-->
                        </tr>`						
						$('.taxDiv').append(tax_temp)*/
							}
								
							}
                           
                        } 
                    });
                }
                function printbill1(customer_id) {
                    console.log(customer_id)
                    return $.ajax({
                        url: "staff/action/billprint.php",
                        type:"POST",
                        data:{
                            customer_id:customer_id,
                        },
                        success: function (result) {
                            if (result == 0) {
                                $('.printDesignProfile').empty();
                                $('.printDesignTable  table tbody').empty();
                            } else {
								let result_json = jQuery.parseJSON(result)
								
                            	$('#unique_id').text(result_json[0]['invoice_no'])
								$('#user_name').text(result_json[0]['customer_name'])
								customer_name = result_json[0]['customer_name'];
								$('#phone_num').text(result_json[0]['phone'])
								$('#order_date').text(result_json[0]['date'])
								if(result_json[0]['tax_apply']  == 1){
									$('#g_total_tax').text('₹ '+result_json[0]['total_tax_amt'])
									$('#invoice_data_details').css('display','flex')
									$('#tax_id_text').text(result_json[0]['tax_compained_val'])
								}else{
									$('#g_total_tax').text('₹ '+0)
								}
								$('#total_disc_val').text('₹ '+result_json[0]['total_discount'])
								$('#g_total_amt').text('₹ '+result_json[0]['total_amount'])
								$('#amt_in_words').text('('+result_json[0]['amount_words']+' only)')
								console.log(result_json[0]['total_quantity'])
								$('#quantity_class').text(result_json[0]['total_quantity'])
								
								$('#total_amt_1').text('₹ '+result_json[0]['total_amount'])
								$('#total_amt_3').text('₹ '+result_json[0]['total_price_q'])
								$('#tax_total').text('₹ '+result_json[0]['total_tax'])
								
								let product_details = result_json[0]['product']
								let SINO = 0;
								for(let x=0;x<product_details.length;x++){
									SINO++;
									let net_total = product_details[x]['price']*product_details[x]['quantity']
									
									$('.printDesignTable tbody').append(`
					<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>${SINO}</td>
                            <td>${product_details[x]['product_name']}</td>
                            <td>${product_details[x]['hsn_number']}</td>
							<td>${product_details[x]['batch_name']}</td>
							<td>${product_details[x]['expiry_date']}</td>
                            <td>${product_details[x]['quantity']}</td>
							<td>₹ ${product_details[x]['price']}</td> 
                            <td>${product_details[x]['tax_in_per']} %</td> 
							<td>₹ ${product_details[x]['tax_data']}</td> 
							 <td>₹ ${product_details[x]['net_total']}</td> 
                            
                        </tr>`)
								}
							
								
                            }
                        }
                    });
                }
         
	
	</script>
</body>
</html>