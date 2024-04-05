<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$search_val = $_GET['search_val'];
$limit = $_GET['limit'];
$search_where = "";
if($search_val != ''){
	$search_where = " and (category_name like '%$search_val%')";
}
$fetch_data = $obj1->selectData("id,category_name","tbl_category","where status!=0 $search_where ORDER BY id DESC limit $limit");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){
    $response_arr[$x]['id'] = $fetch_data_row['id'] ;
    $response_arr[$x]['category'] = $fetch_data_row['category_name'] ;
    
    $id=$fetch_data_row['id'];
     $count = $obj1->selectData("id,COUNT(category_id) AS post","tbl_product","where status!=0 and category_id=$id GROUP BY category_id");
  
    if(mysqli_num_rows( $count)>0){
      while($count_data_row = mysqli_fetch_array($count)){
         $response_arr[$x]['post'] = $count_data_row['post'] ;
      }  
    }
    else{
      $response_arr[$x]['post'] = '0';
    }
    $x++;
 }
}else{
    
}
echo json_encode($response_arr);
?>
