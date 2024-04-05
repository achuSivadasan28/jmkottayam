<?php
session_start();
if(isset($_SESSION['staff'])){
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
					<h2>JOHNMARIAN WELLNESS HOSPITAL</h2>
					<p>P.P Road Kottayam , Meenachil P.O pala ,Kottayam 686577</p>
                    <p>Ph : 9562732575 | E-mail : johnmarianwellness@gmail.com | Web : drmanojjohnson.com</p>
                    <p><b>GST Number : 32BNFPG3513BIZV</b></p>
					<h2>Tax invoice</h2>
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
				<div class="printDesignTable2">
					
				</div>
                <table>
                    <!--<thead>
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
                    </thead>-->
                    <tbody class="tableInvoice---">
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
							<td colspan="1"></td>
                            <td style="text-align: left;" class="tax_val_dis1"><b>Delivery Charge</b></td>
                            <td style="text-align: left;"><b id="total_amt_1_delivery"></b></td>
                        </tr>
                        <tr style="border-top: 1px solid black; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="1"></td>
                            <td class="tax_val_dis"><b>Total QTY</b></td>
                            <td ><b id="quantity_class"></b></td>
                        </tr>
                        <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="1"></td>
                            <td class="tax_val_dis"><b>Total CGST</b></td>
							 <td><b id="cgst"></b></td>
                        </tr>
                        <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="1"></td>
                            <td class="tax_val_dis"><b>Total SGST</b></td>
							 <td><b id="sgst"></b></td>
                        </tr>
                        <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="1"></td>
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
	
	
	
	
	
	
       <!-- <div class="printDesign">
            <div class="printDesignHead">
                <div class="printDesignHeadLogo">
                    <img src="assets/images/johnmariansLogo.png" alt="">
                </div>
                <div class="printDesignHeadAddress">
					<h2>JOHNMARIAN WELLNESS HOSPITAL</h2>
					<p>P.P Road Kottayam , Meenachil P.O pala ,Kottayam 686577</p>
                    <p>Ph : 9562732575 | E-mail : johnmarianwellness@gmail.com | Web : drmanojjohnson.com</p>
                    <p><b>GST Number : 32BNFPG3513BIZV</b></p>
					<h2>Tax invoice</h2>
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

                    </tbody>
					
					<tbody class="taxDiv" style="border-top: 1px solid black;">
					</tbody>
                    <tfoot>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="5" class="tax_val_dis"><b>Total</b></td>
                            <td colspan="3"><b id="quantity_class"></b></td>
							 <td colspan="1"><b id="cgst"></b></td>
							 <td colspan="1"><b id="sgst"></b></td>
                            <td colspan="0" style="text-align: left;"><b id="total_amt_1"></b></td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto; border-top: 1px solid black;">
                            <td colspan="12"><b id="amt_in_words"></b> - Inclusive Of All Taxes</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="printDesignTC" style="page-break-inside: avoid; page-break-after: auto;">
                <h2>Terms & Conditions</h2>
                <p>You should not make any change in your current medications or health regimen before consulting a registered medical practitioner</p>
            </div>
        </div>-->
        <!-- print design close -->
    
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
                        <h1>Bills</h1>
                        <div class="breadCrumbs">
                            <a href="index.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="index.php">Dashboard</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
                    <div class="consultAppointmentList">
                        <div class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableHead">
                                    <div class="searchBox">
                                        <input type="search" placeholder="Search..." id="search_val">
                                        <button type="submit" id="search_btn"><i class="uil uil-search"></i></button>
                                    </div>
                                    <div class="dateRange">
                                        <input type="date" id="date_val">
                                        <span></span>
                                        <input type="date" id="date_val1">
                                        <button type="submit" id="date_btn"><i class="uil uil-search"></i></button>
                                    </div>
                                </div>
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper">
										<div class="sckelly">
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>

											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
										</div>
                                        <table id="tbl_details">
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Invoice No</th>
                                                    <th>Action</th>
                                                    <th>Customer Name</th>
                                                    <th>Products Name</th>
                                                    <th>Date</th>
                                                
                                                    <th>Quantity</th>
                                                    <th>Total Amount</th>
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
					
					<!--<tbody class="taxDiv" style="border-top: 1px solid black;">
					
					</tbody>-->
                                        </table>
                                    <div class="elseDesign">
                                        <div class="elseDesignthumbnail">
                                            <img src="assets/images/empty.png" alt="">
                                        </div>
                                        <p>No Data Available</p>
                                    </div>
                                    </div>
									<div class="pagination">
										<div class="pageCount">
											<p>Page per row</p>
											<select id="pagenation_drop">
												
											</select>
										</div>
										<div class="paginationCount">
											<ul>
												<li id="first_row">First</li>
												<li id="prev_page"><i class="uil uil-angle-left-b"></i></li>
												<div id="page_num" style="display:flex">
												
												</div>
												<li id="nxt_page"><i class="uil uil-angle-right-b"></i></li>
												<li id="last_row">Last</li>
											</ul>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- consultingWindow close -->

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
<script src="js/bills.js?v=<?php echo $version_variable;?>"> </script>
<script>
	
	//sckelly
	$(window).load(function() {
		 $('.sckelly').css({
			display: 'none',
		 });
	});
	
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

  </script> 
</body>
</html>
<?php
}else{
header("Location:../login.php");
}	
?>