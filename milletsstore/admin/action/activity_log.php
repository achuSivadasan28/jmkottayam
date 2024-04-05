


<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$x = 0;
$limit_range = $_GET['limit_range'];
$customer = $obj1->selectData("id,product_id,product_activity,performed_by,performed_date,performed_time,remark","tbl_stock_activity","where status!=0 ORDER BY id DESC limit $limit_range");

if(mysqli_num_rows($customer)>0){
    while($customer_row = mysqli_fetch_array($customer)){
        $response_arr[$x]['id'] = $customer_row['id'];
        $response_arr[$x]['product_id'] = $customer_row['product_id'];
        $response_arr[$x]['product_activity'] = $customer_row['product_activity'];
        $response_arr[$x]['performed_by'] = $customer_row['performed_by'];
        $response_arr[$x]['performed_date'] = $customer_row['performed_date'];
        $response_arr[$x]['performed_time'] = $customer_row['performed_time'];
        $response_arr[$x]['remark'] = $customer_row['remark'];
        $x++;
    }
}

echo json_encode($response_arr);
?>
