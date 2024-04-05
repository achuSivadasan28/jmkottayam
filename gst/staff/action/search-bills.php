
<?php
session_start();
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$staff_id=$_SESSION['staffId']; 
$search=$_GET['searchval'];
$search_where='';
if($search != ''){
	$search_where = " and (customer_name like '%$search%' OR invoice_no like '%$search%')";
}
$x = 0;
$customer = $obj1->selectData("id,invoice_no,customer_name,staff_id,phone,created_date,total_price,total_discount,total_amonut","tbl_customer","where status!=0 and staff_id=$staff_id $search_where  ORDER BY id DESC");
if(mysqli_num_rows($customer)>0){
    while($customer_row = mysqli_fetch_array($customer)){
        $response_arr[$x]['id'] = $customer_row['id'];
        $response_arr[$x]['invoice_no'] = $customer_row['invoice_no'];
        $response_arr[$x]['customer_name'] = $customer_row['customer_name'];
        $response_arr[$x]['phone'] = $customer_row['phone'];
        $response_arr[$x]['date'] = $customer_row['created_date'];
        $response_arr[$x]['price'] = $customer_row['total_price'];
        $response_arr[$x]['discount'] = $customer_row['total_discount'];
        $response_arr[$x]['total_price'] = $customer_row['total_amonut'];
        $id = $customer_row['id'];
        $product_name = '';
        $product_quantity = 0;
        $product_cat = '';
        $cat_arr = [];
        $fetch_data = $obj1->selectData("id,customer_id,category_name,product_name,no_quantity","tbl_productdetails","where customer_id=$id ORDER BY id DESC");
        if(mysqli_num_rows($fetch_data)>0){
            while($fetch_data_row = mysqli_fetch_array($fetch_data)){
                if($product_name == ''){
                    $product_name = $fetch_data_row['product_name'];
                }else{
                    $product_name .= ','.$fetch_data_row['product_name'];

                }
                $product_quantity += $fetch_data_row['no_quantity']; //$product_quantity = $product_quantity+$fetch_data_row['quantity']

                if($product_cat == ''){
                    $product_cat = $fetch_data_row['category_name'];
                }else{
                    if(!in_array($fetch_data_row['category_name'],$cat_arr)){
                    $product_cat .= ','.$fetch_data_row['category_name'];
                    array_push($cat_arr,$fetch_data_row['category_name']);
                    }

                }
            }
        }
        $response_arr[$x]['product_name'] = $product_name;
        $response_arr[$x]['quantity'] = $product_quantity;
        $response_arr[$x]['category_name'] = $product_cat;
        $x++;
    }
}

echo json_encode($response_arr);
?>
