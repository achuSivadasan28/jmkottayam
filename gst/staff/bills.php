<?php
session_start();
if(isset($_SESSION['staff'])){
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
					<p>31/410A, NELSON MANDELA ROAD, KOONAMTHAI, EDAPPALLY ERNAKULAM Pin 682024</p>
                    <p>Ph : 8086250300 | E-mail : johnmarians@gmail.com | Web : johnmarians.com</p>
                    <p><b>GST Number : 32BUYPR6807F1Z4</b></p>
					<h2>Bill of Supply</h2>
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
                            <th>QTY</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Value of supply</th>
                        </tr>
                    </thead>
                    <tbody>
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
                    <tfoot>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="3" class="tax_val_dis"><b>Total</b></td>
                            <td colspan="1"><b id="quantity_class"></b></td>
                            <td colspan="1"><b id="total_amt_3"></b></td>
                            <td colspan="1"><b id="total_amt_1"></b></td>
                            <td colspan="1"><b id="g_total_amt"></b></td>
                        </tr>
                        <!--<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="7" style="border: none; text-align: right; padding: 0px 10px; 0px 0px;"><b>Total Disc</b></td>
                            <td colspan="1" style="border: none; padding:0;"><b id="total_disc_val">₹ 40</b></td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="7" style="border: none; text-align: right; padding-right: 10px;"><b>Total Amount</b></td>
                            <td colspan="1" style="border: none;"><b id="g_total_amt">₹ 380</b></td>
                        </tr>-->
                        <tr style="page-break-inside: avoid; page-break-after: auto; border-top: 1px solid black;">
                            <td colspan="7"><b id="amt_in_words"></b> - Inc. of all taxes</td>
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
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Invoice No">
                                                        <p>12345</p>
                                                    </td>
                                                    <td data-label="Customer Name">
                                                        <p>Afsal KT</p>
                                                    </td>
                                                    <td data-label="Products Name">
                                                        <p>Paracetamol</p>
                                                    </td>
                                                    <td data-label="Category">
                                                        <p>Medicin Category</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Price">
                                                        <p>₹ 100</p>
                                                    </td>
                                                    <td data-label="Quantity">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Discount">
                                                        <p>₹ 20</p>
                                                    </td>
                                                    <td data-label="Total Amount">
                                                        <p>₹ 180</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" onclick="print()" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Invoice No">
                                                        <p>12345</p>
                                                    </td>
                                                    <td data-label="Customer Name">
                                                        <p>Afsal KT</p>
                                                    </td>
                                                    <td data-label="Products Name">
                                                        <p>Paracetamol</p>
                                                    </td>
                                                    <td data-label="Category">
                                                        <p>Medicin Category</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Price">
                                                        <p>₹ 100</p>
                                                    </td>
                                                    <td data-label="Quantity">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Discount">
                                                        <p>₹ 20</p>
                                                    </td>
                                                    <td data-label="Total Amount">
                                                        <p>₹ 180</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" onclick="print()" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Invoice No">
                                                        <p>12345</p>
                                                    </td>
                                                    <td data-label="Customer Name">
                                                        <p>Afsal KT</p>
                                                    </td>
                                                    <td data-label="Products Name">
                                                        <p>Paracetamol</p>
                                                    </td>
                                                    <td data-label="Category">
                                                        <p>Medicin Category</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Price">
                                                        <p>₹ 100</p>
                                                    </td>
                                                    <td data-label="Quantity">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Discount">
                                                        <p>₹ 20</p>
                                                    </td>
                                                    <td data-label="Total Amount">
                                                        <p>₹ 180</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" onclick="print()" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>4</p>
                                                    </td>
                                                    <td data-label="Invoice No">
                                                        <p>12345</p>
                                                    </td>
                                                    <td data-label="Customer Name">
                                                        <p>Afsal KT</p>
                                                    </td>
                                                    <td data-label="Products Name">
                                                        <p>Paracetamol</p>
                                                    </td>
                                                    <td data-label="Category">
                                                        <p>Medicin Category</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Price">
                                                        <p>₹ 100</p>
                                                    </td>
                                                    <td data-label="Quantity">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Discount">
                                                        <p>₹ 20</p>
                                                    </td>
                                                    <td data-label="Total Amount">
                                                        <p>₹ 180</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" onclick="print()" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr> -->
                                            </tbody>
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
<script src="js/bills.js"> </script>
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