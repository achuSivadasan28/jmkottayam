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
<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->

<body>
	<style>
		.pagination ul{
  width: 100%;
  display: flex;
  align-items : center;
  flex-wrap: wrap;
  background: #fff;
  padding: 8px;
  border-radius: 10px;
  box-shadow: 0px 10px 15px rgba(0,0,0,0.1);
}
.pagination ul li{
  color: black;
  list-style: none;
  line-height: 25px;
  text-align: center;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  user-select: none;
  transition: all 0.3s ease;
}
.pagination ul li.numb{
  list-style: none;
  height: 35px;
  width: 35px;
  margin: 0 3px;
  line-height: 45px;
  border-radius: 10px;
}
.pagination ul li.numb.first{
  margin: 0px 3px 0 -5px;
}
.pagination ul li.numb.last{
  margin: 0px -5px 0 3px;
}
.pagination ul li.dots{
  font-size: 18px;
  cursor: default;
}
.pagination ul li.btn{
  padding: 0 20px;
  border-radius: 40px;
}
.pagination li.active,
.pagination ul li.numb:hover,
.pagination ul li:first-child:hover,
.pagination ul li:last-child:hover{
  color: #fff;
  background: #68bb56;
}
	</style>
    
    <main>

        <!-- shimmer -->
        <div class="shimmer"></div>
        <!-- shimmer close -->
		
		<!--cancelledAlertBox -->
		<div class="cancelledAlertBox">
			<div class="cancelledAlertBoxClose"><i class="uil uil-multiply"></i></div>
			<h2>Name</h2>
			<p>Nandhana Betty</p>
			<h2>Invoice No</h2>
			<p>E-0000356</p>
			<h2>Reason</h2>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
		</div>
		<!--cancelledAlertBox close -->
		
		<!--cancel recipt popup -->
		<div class="cancelReciptPopup">
			<form>
				<h1>Cancel Receipt</h1>
				<div class="formGroup">
					<label>Customer Name</label>
					<input type="text" value="Nandhana Betty">
				</div>
				<div class="formGroup">
					<label>Invoice No</label>
					<input type="text" value="E-0000277">
				</div>
				<div class="formGroup">
					<label>Reason</label>
					<textarea></textarea>
				</div>
				<div class="formBtn">
					<div class="cancelReciptBtn">Cancel</div>
					<button class="submitReciptBtn">Submit</button>
				</div>
			</form>
		</div>
		<!--cancel recipt popup close -->

        <!-- delete alert  -->
        <div class="deleteAlert">
            <div class="deleteAlertMian">
                <div class="deleteAlertThumbnail">
                    <img src="assets/images/icon/delete-alert.gif" alt="">
                </div>
                <div class="deleteAlertContent">
                    <p>Do you want to delete ?</p>
                    <div class="deleteAlertBtnArea">
                        <div class="closedeleteAlert">No</div>
                        <div class="confirmdeleteAlert">Delete</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- delete alert close -->

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
                            <th>Discount</th>
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
                            <td colspan="1"><b id="total_disc_val"></b></td>
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
                            <td colspan="8"><b id="amt_in_words"></b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="printDesignTC" style="page-break-inside: avoid; page-break-after: auto;">
				<h2>Bank Details</h2>
				<p>Account Name : JOHNMARIAN WELLNESS CLINIC</p>
				<p>Account Number : 306530123456789</p>
				<p>Branch: KALAMASSERY</p>
				<p>Account Type : Current Account</p>
				<p>IFSC Code : TMBL0000306</p>
				<p>MICR Code : 682060003</p>
                <h2>Terms & Conditions</h2>
                <p>You should not make any change in your current medications or health regimen before consulting a registered medical practitioner</p>
            </div>
        </div>
        <!-- print design close -->

        <!-- filter section  -->
        <div class="filterSection">
            <div class="filterSectionHead">
                <h1><i class="uil uil-filter"></i> Filter</h1>
            </div>
            <div class="filterSectionBody">
                <div class="filterSectionBodyBox">
                    <h2>Staff</h2>
                    <div class="filterSectionBodyCheckbox staff">
                        <!-- <div class="formGroup">
                            <input type="checkbox" id="staff1">
                            <label for="staff1">Afsal KT</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="staff2">
                            <label for="staff2">Abhijith</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="staff3">
                            <label for="staff3">Albin</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="staff4">
                            <label for="staff4">Josmey</label>
                        </div> -->
                    </div>
                </div>
                <!--<div class="filterSectionBodyBox">
                    <h2>Branch</h2>
                    <div class="filterSectionBodyCheckbox">
                        <div class="formGroup">
                            <input type="checkbox" id="branch1">
                            <label for="branch1">Palakkad</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="branch2">
                            <label for="branch2">Ernakulam</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="branch3">
                            <label for="branch3">Kottayam</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="branch4">
                            <label for="branch4">Idukki</label>
                        </div>
                    </div>
                </div>-->
                <div class="filterSectionBodyBox">
                    <h2>Status</h2>
                    <div class="filterSectionBodyCheckbox">
                        <div class="formGroup">
                            <input type="checkbox" id="Cancelled">
                            <label for="Cancelled">Cancelled</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filterSectionFooter">
                <div class="closeFilter">Close</div>
                <div class="applyFilter">Apply</div>
            </div>
        </div>
        <!-- filter section close -->
        
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
                        <h1>Invoice Reports</h1>
                        <div class="breadCrumbs">
                            <a href="reports.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="reports.php">Reports</a>
                        </div>
                    </div>
                    <!--<div class="canvasHeadBox2">
                        <a href="action/invoice_export.php" class="addBtn">Export Exel</a>
                    </div>-->
                </div>
                <!-- canvas head close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
                    <div class="consultAppointmentList">
                        <div class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                               <!-- <div class="consultAppointmentListTableHead">
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
                                    <div class="filterTable">
                                        <div class="filterTableBtn">
                                            <i class="uil uil-filter"></i>
                                        </div>
                                    </div>
                                </div>-->
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
                                        <table id="tbl_details_activity">
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Action Type</th>
                                                    <th>Remark</th>
                                                    <th>Action Date</th>
													<th>Action Time</th>
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
                                                    <td data-label="Staff Name">
                                                        <p>Abjith</p>
                                                    </td>
                                                    <td data-label="Branch">
                                                        <p>Palakkadu</p>
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
                                                    <td data-label="Staff Name">
                                                        <p>Abjith</p>
                                                    </td>
                                                    <td data-label="Branch">
                                                        <p>Palakkadu</p>
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
                                                    <td data-label="Staff Name">
                                                        <p>Abjith</p>
                                                    </td>
                                                    <td data-label="Branch">
                                                        <p>Palakkadu</p>
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
                                                    <td data-label="Staff Name">
                                                        <p>Abjith</p>
                                                    </td>
                                                    <td data-label="Branch">
                                                        <p>Palakkadu</p>
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
										<ul> </ul>
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

    <script>

		
		//pagination
		
		

        // filter popup 
        $('.filterTableBtn').click(function(){
            $('.filterSection').addClass('filterSectionActive');
            $('.shimmer').fadeIn();
        });
        $('.closeFilter').click(function(){
            $('.filterSection').removeClass('filterSectionActive');
            $('.shimmer').fadeOut();
        });
        $('.applyFilter').click(function(){
            $('.filterSection').removeClass('filterSectionActive');
            $('.shimmer').fadeOut();
        });
    </script>
<script src="js/stock-log.js?v=<?php echo $version_variable;?>"> </script>

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
        $('.navProfileName p').append(`${data[0]['user']}`)
        $('.navProfileName span').append(`${data[0]['srole']}`)
    })
	
	//cancel Receipt
	$('body').delegate('.cancelReceipt','click', function(e){
		$('.cancelReciptPopup').fadeIn();
		$('.shimmer').fadeIn();
	});
	$('.cancelReciptBtn').click(function(e){
		$('.cancelReciptPopup').fadeOut();
		$('.shimmer').fadeOut();
	});
	$('.submitReciptBtn').click(function(e){
		$('.cancelReciptPopup').fadeOut();
		$('.shimmer').fadeOut();
	});
	
	
	$('body').delegate('.cancelledAlert','click', function(e){
		$('.cancelledAlertBox').fadeIn();
		$('.shimmer').fadeIn();
	});
	$('body').delegate('.cancelledAlertBoxClose','click', function(e){
		$('.cancelledAlertBox').fadeOut();
		$('.shimmer').fadeOut();
	});
	
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