<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$f = new NumberFormatter("en_US", NumberFormatter::SPELLOUT);
$customer_id = $_POST['customer_id'];
$amount_in_words='';
$x = 0;
$customer = $obj1->selectData("id,invoice_no,customer_name,staff_id,phone,created_date,total_price,total_discount,total_amonut","tbl_customer","where status!=0 and id=$customer_id");
// echo $customer; exit();
if(mysqli_num_rows($customer)>0){
    while($customer_row = mysqli_fetch_array($customer)){
        $response_arr[$x]['id'] = $customer_row['id'];
        $response_arr[$x]['customer_name'] = $customer_row['customer_name'];
        $response_arr[$x]['phone'] = $customer_row['phone'];
        $response_arr[$x]['date'] = $customer_row['created_date'];
        $response_arr[$x]['invoice_no'] = $customer_row['invoice_no'];
        $response_arr[$x]['total_discount'] = $customer_row['total_discount'];
        $response_arr[$x]['total_amount'] = $customer_row['total_amonut'];
		
		$total_amnt_to_pay= $customer_row['total_amonut'];
		$amount_in_words = $f->format($total_amnt_to_pay);
		 $response_arr[$x]['amount_words'] =$amount_in_words;
        $id = $customer_row['id'];
        $fetch_data = $obj1->selectData("id,customer_id,category_name,product_name,price,no_quantity,gross,total_price,discount,disc,tax_in_per,tax_data","tbl_productdetails","where customer_id=$id");
        if(mysqli_num_rows($fetch_data)>0){
            while($fetch_data_row = mysqli_fetch_array($fetch_data)){

                $response_arr[$x]['net_total'] =$fetch_data_row['total_price']; 
                $response_arr[$x]['discount'] =$fetch_data_row['discount']; 
                $response_arr[$x]['price'] =$fetch_data_row['price']; 
                $response_arr[$x]['gross'] =$fetch_data_row['gross']; 
			    $response_arr[$x]['disc'] =$fetch_data_row['disc']; 
                $response_arr[$x]['product_name'] =$fetch_data_row['product_name']; 
                $response_arr[$x]['quantity'] =$fetch_data_row['no_quantity']; 
                $response_arr[$x]['category_name'] =$fetch_data_row['category_name'];
            	$response_arr[$x]['tax_in_per'] =$fetch_data_row['tax_in_per'];
				$response_arr[$x]['tax_data'] =$fetch_data_row['tax_data'];
				
                $x++;
                
            }
        }
       else{
        $response_arr[$x]['disc'] ='0';
     }
    }
}

echo json_encode($response_arr);
?>
