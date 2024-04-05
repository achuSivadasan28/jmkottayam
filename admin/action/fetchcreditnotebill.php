
<?php
session_start();
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$f = new NumberFormatter("en_US", NumberFormatter::SPELLOUT);
//$staff_id=$_SESSION['staffId']; 
$id = $_POST['tbl_id'];
$amount_in_words='';
$x = 0;


$customer = $obj1->selectData("id,invoice_id,invoice_number,credit_note_invoice_number,addedDate,addedTime","tbl_credit_note","where id=$id  ORDER BY id DESC");
if(mysqli_num_rows($customer)>0){
    while($customer_row = mysqli_fetch_array($customer)){
        $response_arr[$x]['id'] = $customer_row['id'];
        $response_arr[$x]['invoice_id'] = $customer_row['invoice_id'];
        $response_arr[$x]['invoice_number'] = $customer_row['invoice_number'];
        $response_arr[$x]['date'] = $customer_row['addedDate'].' '.$customer_row['addedTime'];
        $response_arr[$x]['credit_note_invoice_number'] = $customer_row['credit_note_invoice_number'];
        
		$y = 0;
		$total_price_1 = 0;
		
        $fetch_data = $obj1->selectData("id,tbl_credit_note_id,product_name,amount_paid,product_price,returned_qty,returned_amount","tbl_credit_note_products","where tbl_credit_note_id=$id and status!=0");
        if(mysqli_num_rows($fetch_data)>0){
            while($fetch_data_row = mysqli_fetch_array($fetch_data)){
				$total_price_1 += $fetch_data_row['returned_amount'];
				
				$response_arr[$x]['product'][$y]['tbl_credit_note_id'] =$fetch_data_row['tbl_credit_note_id'];
				$response_arr[$x]['product'][$y]['product_id'] =$fetch_data_row['product_id'];
				$response_arr[$x]['product'][$y]['product_name'] =$fetch_data_row['product_name'];
                $response_arr[$x]['product'][$y]['amount_paid'] =$fetch_data_row['amount_paid']; 
                $response_arr[$x]['product'][$y]['product_price'] =$fetch_data_row['product_price']; 
                $response_arr[$x]['product'][$y]['returned_qty'] =$fetch_data_row['returned_qty']; 
                $response_arr[$x]['product'][$y]['returned_amount'] =$fetch_data_row['returned_amount'];
				 $y++;
				
              
            }
        }
		
		$response_arr[$x]['total_price_1'] = $total_price_1;
    }
}

echo json_encode($response_arr);
?>
