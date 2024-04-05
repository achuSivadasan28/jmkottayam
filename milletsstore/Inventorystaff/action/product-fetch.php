<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$search_val = $_GET['search'];
$limit = $_GET['limit'];
$search_where = "";
if($search_val != ''){
	$search_where = " and (product_name like '%$search_val%')";
}
$fetch_data = $obj1->selectData("tbl_product.id as id,tbl_product.product_name,tbl_medicine_details.id as med_id,tbl_product.category_id,tbl_product.price,tbl_product.discount,tbl_product.quantity","tbl_product inner join  tbl_medicine_details on tbl_product.id = tbl_medicine_details.product_id inner join tbl_category on tbl_category.id = tbl_product.category_id","where tbl_product.status!=0  and tbl_medicine_details.status != 0 and tbl_category.status != 0 $search_where ORDER BY product_name ASC limit $limit");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
	//print_r($fetch_data);exit();
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){

    $id=$fetch_data_row['category_id'];
	$product_id = $fetch_data_row['med_id'];
	$select_product_details = $obj1->selectData("id,no_of_pills,price,discount,quantity","tbl_medicine_details","where id=$product_id and status!=0 ");                                                                                                                                   //print_r($obj1);exit();                                                     
	 if(mysqli_num_rows($select_product_details)){
	 	while($select_product_details_row = mysqli_fetch_array($select_product_details)){
			    $category = $obj1->selectData("id,category_name","tbl_category","where status!=0 and id=$id ORDER BY id DESC ");
    			if(mysqli_num_rows($category)>0){
        		while($category_row = mysqli_fetch_array($category)){
    				$response_arr[$x]['category'] = $category_row['category_name'] ;        
    				$response_arr[$x]['id'] = $fetch_data_row['id'] ;
    				$response_arr[$x]['product_name'] = $fetch_data_row['product_name'];
    				$response_arr[$x]['price'] = $select_product_details_row['price'] ;
    				$response_arr[$x]['discount'] = $select_product_details_row['discount'];
    				$response_arr[$x]['quantity'] = $select_product_details_row['quantity'];
					$response_arr[$x]['no_of_pills'] = $select_product_details_row['no_of_pills'];
        		}
			
    	} 
			$x++;
		}
	 }

 }
}
echo json_encode($response_arr);
?>
