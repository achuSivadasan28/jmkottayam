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

//check all sum
$total_price_sum = 0;
$fetch_data_sum = $obj1->selectData("total_price","tbl_productdetails","where customer_id=$customer_id and status!=0");
        if(mysqli_num_rows($fetch_data_sum)>0){
			while($fetch_data_sum_row = mysqli_fetch_array($fetch_data_sum)){
				$total_price_sum += $fetch_data_sum_row['total_price'];
			}
}
$check_total_sum = $obj1->selectData("total_amonut","tbl_customer","where id=$customer_id");
if(mysqli_num_rows($check_total_sum)>0){
	$check_total_sum_row = mysqli_fetch_array($check_total_sum);
	if($total_price_sum == $check_total_sum_row){
	
	}else{
		$info_data = array(
			"total_price" => $total_price_sum,
			"total_amonut" => $total_price_sum,
		);
		$obj1->updateData("tbl_customer",$info_data,"where id=$customer_id");
}
}
$delivery_charge = 0;
$customer = $obj1->selectData("id,tax_invoice_year,tax_invoice,tax_compained_val,invoice_no,customer_name,staff_id,phone,created_date,total_price,total_discount,total_amonut,tax_apply,total_tax_amt,time,delivery_charge","tbl_customer","where id=$customer_id  ORDER BY id DESC");
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
		$response_arr[$x]['total_tax_amt'] = $customer_row['total_tax_amt'] ;
		$response_arr[$x]['delivery_charge'] = $customer_row['delivery_charge'];
		$delivery_charge = $customer_row['delivery_charge'];
		$total_amnt_to_pay= $customer_row['total_amonut'] +$customer_row['delivery_charge'];
		$amount_in_words = $f->format($total_amnt_to_pay);
		 $response_arr[$x]['amount_words'] =$amount_in_words;
        $id = $customer_row['id'];
		$y = 0;
		$total_price_1 = 0;
		$total_quantity = 0;
		$total_price_q = 0;
		$total_tax = 0;
		$total_cgst = 0;
		$total_sgst = 0;
        $fetch_data = $obj1->selectData("id,customer_id,category_name,product_name,price,no_quantity,gross,total_price,discount,disc,hsn_number,batch_name,expiry_date,tax_in_per,tax_data","tbl_productdetails","where customer_id=$id and status!=0");
        if(mysqli_num_rows($fetch_data)>0){
            while($fetch_data_row = mysqli_fetch_array($fetch_data)){
				$total_price_1 += $fetch_data_row['total_price'];
				$total_quantity += $fetch_data_row['no_quantity'];
				$total_price_q += $fetch_data_row['price'];
				$response_arr[$x]['product'][$y]['hsn_number'] =$fetch_data_row['hsn_number'];
				$response_arr[$x]['product'][$y]['batch_name'] =$fetch_data_row['batch_name'];
				$response_arr[$x]['product'][$y]['expiry_date'] =$fetch_data_row['expiry_date'];
                $response_arr[$x]['product'][$y]['net_total'] =$fetch_data_row['total_price']; 
                $response_arr[$x]['product'][$y]['discount'] =$fetch_data_row['discount']; 
                $response_arr[$x]['product'][$y]['price'] =$fetch_data_row['price']; 
                $response_arr[$x]['product'][$y]['gross'] =$fetch_data_row['gross']; 
                $response_arr[$x]['product'][$y]['product_name'] =$fetch_data_row['product_name']; 
                $response_arr[$x]['product'][$y]['quantity'] =$fetch_data_row['no_quantity']; 
                $response_arr[$x]['product'][$y]['category_name'] =$fetch_data_row['category_name'];
				$response_arr[$x]['product'][$y]['disc'] =$fetch_data_row['disc'];
				$response_arr[$x]['product'][$y]['tax_in_per'] =$fetch_data_row['tax_in_per'];
				$response_arr[$x]['product'][$y]['tax_data'] = $fetch_data_row['tax_data'];
				$response_arr[$x]['product'][$y]['cgst'] = $fetch_data_row['tax_data']/2;
				$response_arr[$x]['product'][$y]['sgst'] = $fetch_data_row['tax_data']/2;
				$total_tax += $fetch_data_row['tax_data'];
				$total_cgst += $fetch_data_row['tax_data']/2;
				$total_sgst += $fetch_data_row['tax_data']/2;
            $response_arr[$x]['product'][$y]['hsn'] = $hsn_num;
					$response_arr[$x]['product'][$y]['expiry'] =$exp;
                $y++;
                
            }
        }
		
		$fetch_data_tax_d = $obj1->selectData("DISTINCT tax_in_per","tbl_productdetails","where customer_id=$id and status!=0 ORDER BY id DESC");
		if(mysqli_num_rows($fetch_data_tax_d)>0){
			$z = 0;
			while($fetch_data_tax_d_row = mysqli_fetch_array($fetch_data_tax_d)){
				$response_arr[$x]['tax_in_per'][$z]['tax_per'] = $fetch_data_tax_d_row['tax_in_per'];
				$tax_in_per = $fetch_data_tax_d_row['tax_in_per'];
				$fetch_data_tax_data = $obj1->selectData("tax_data","tbl_productdetails","where customer_id=$id and status!=0 and tax_in_per=$tax_in_per ORDER BY id DESC");
				if(mysqli_num_rows($fetch_data_tax_data)>0){
					$total_cgst_in = 0;
					$total_sgst_in = 0;
					while($fetch_data_tax_data_row = mysqli_fetch_array($fetch_data_tax_data)){
						$total_split_tax = $fetch_data_tax_data_row['tax_data'];
						$cgst_in = $total_split_tax/2;
						$sgst_in = $total_split_tax/2;
						$total_cgst_in +=$cgst_in;
						$total_sgst_in +=$sgst_in;
					}
					
				}
				$response_arr[$x]['tax_in_per'][$z]['total_cgst_in'] = round($total_cgst_in,4);
				$response_arr[$x]['tax_in_per'][$z]['total_sgst_in'] = round($total_sgst_in,4);
				$z++;
			}
			
		}
      	$response_arr[$x]['total_price_1'] = $total_price_1 + $delivery_charge;
		$response_arr[$x]['total_quantity'] = $total_quantity;
		$response_arr[$x]['total_price_q'] = $total_price_q;
		$response_arr[$x]['total_tax'] = round($total_tax,2);
		$response_arr[$x]['total_cgst'] = round($total_cgst,4);
		$response_arr[$x]['total_sgst'] = round($total_sgst,4);
    }
}

echo json_encode($response_arr);
?>
