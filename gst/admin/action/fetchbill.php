<?php
session_start();
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$f = new NumberFormatter("en_US", NumberFormatter::SPELLOUT);
$staff_id=$_SESSION['staffId']; 
$customer_id = $_POST['customer_id'];
$amount_in_words='';
$x = 0;
//$id=$_POST['id'];
$customer = $obj1->selectData("id,tax_invoice_year,tax_invoice,tax_compained_val,invoice_no,customer_name,staff_id,phone,created_date,total_price,total_discount,total_amonut,tax_apply,total_tax_amt,time","tbl_customer","where status!=0 and id=$customer_id  ORDER BY id DESC");
if(mysqli_num_rows($customer)>0){
    while($customer_row = mysqli_fetch_array($customer)){
        $response_arr[$x]['id'] = $customer_row['id'];
        $response_arr[$x]['customer_name'] = $customer_row['customer_name'];
        $response_arr[$x]['phone'] = $customer_row['phone'];
        $response_arr[$x]['date'] = $customer_row['created_date'].' '.$customer_row['time'];
        $response_arr[$x]['invoice_no'] = $customer_row['invoice_no'];
        $response_arr[$x]['total_discount'] = $customer_row['total_discount'];
        $response_arr[$x]['total_amount'] = $customer_row['total_amonut'];
		$response_arr[$x]['tax_invoice_year'] = $customer_row['tax_invoice_year'];
		$response_arr[$x]['tax_invoice'] = $customer_row['tax_invoice'];
		$response_arr[$x]['tax_compained_val'] = $customer_row['tax_compained_val'];
		$response_arr[$x]['tax_apply'] = $customer_row['tax_apply'];
		$response_arr[$x]['total_tax_amt'] = $customer_row['total_tax_amt'];
		
		$total_amnt_to_pay= $customer_row['total_amonut'];
		$amount_in_words = $f->format($total_amnt_to_pay);
		 $response_arr[$x]['amount_words'] =$amount_in_words;
        $id = $customer_row['id'];
		$y = 0;
		$total_price_1 = 0;
		$total_quantity = 0;
		$total_price_q = 0;
        $fetch_data = $obj1->selectData("id,customer_id,category_name,product_name,price,no_quantity,gross,total_price,discount,disc","tbl_productdetails","where customer_id=$id and status!=0");
        if(mysqli_num_rows($fetch_data)>0){
            while($fetch_data_row = mysqli_fetch_array($fetch_data)){
				$total_price_1 += $fetch_data_row['total_price'];
				$total_quantity += $fetch_data_row['no_quantity'];
				$total_price_q += $fetch_data_row['price'];
                $response_arr[$x]['product'][$y]['net_total'] =$fetch_data_row['total_price']; 
                $response_arr[$x]['product'][$y]['discount'] =$fetch_data_row['discount']; 
                $response_arr[$x]['product'][$y]['price'] =$fetch_data_row['price']; 
                $response_arr[$x]['product'][$y]['gross'] =$fetch_data_row['gross']; 
                $response_arr[$x]['product'][$y]['product_name'] =$fetch_data_row['product_name']; 
                $response_arr[$x]['product'][$y]['quantity'] =$fetch_data_row['no_quantity']; 
                $response_arr[$x]['product'][$y]['category_name'] =$fetch_data_row['category_name'];
				$response_arr[$x]['product'][$y]['disc'] =$fetch_data_row['disc'];
            
                $y++;
                
            }
        }
      	$response_arr[$x]['total_price_1'] = $total_price_1;
		$response_arr[$x]['total_quantity'] = $total_quantity;
		$response_arr[$x]['total_price_q'] = $total_price_q;
    }
}

echo json_encode($response_arr);
?>
