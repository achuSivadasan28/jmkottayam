<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
require_once '../../../_class_common/query_common.php';
$obj_common = new query_common();
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
$url_val = $_POST['id'];
$branch_id = "";
//echo $branch;exit();
$check_appointment_data = $obj->selectData("id,real_branch_id,branch_id","tbl_appointment","where id =$url_val");
//echo $check_appointment_data;exit();
if(mysqli_num_rows($check_appointment_data)>0){
	$check_appointment_data_row = mysqli_fetch_array($check_appointment_data);
	$branch_id = $check_appointment_data_row['branch_id'];
	if($check_appointment_data_row['real_branch_id'] == $check_appointment_data_row['branch_id']){
		$select_lab_category = $obj->selectData(" distinct tbl_labcategory.category_name,tbl_labcategory.id","tbl_labcategory inner join  tbl_lab on tbl_labcategory.id = tbl_lab.category_id "," where tbl_labcategory.status !=0");
if(mysqli_num_rows($select_lab_category)>0){
	$x = 0;
	while($select_lab_category_row = mysqli_fetch_assoc($select_lab_category)){
		
		$response_arr[$x]['category_name'] = $select_lab_category_row['category_name'];
        $category_id = $select_lab_category_row['id'];
		
		$select_lab_tests = $obj->selectData("id,test_name,mrp","tbl_lab","where category_id = $category_id and status != 0 and category_status = 1");
	   if(mysqli_num_rows($select_lab_tests)>0){
			$y = 0;
			while($select_lab_tests_rows = mysqli_fetch_assoc($select_lab_tests)){
				$response_arr[$x]['category'][$y]['test'] = $select_lab_tests_rows['test_name'];
				$response_arr[$x]['category'][$y]['test_id'] = $select_lab_tests_rows['id'];
				$response_arr[$x]['category'][$y]['check_status'] = 0;
				$check_status = 0;
				
				$check_data = $obj->selectData("test_id","tbl_add_lab_data","where appointment_id=$url_val and status!=0");
				if(mysqli_num_rows($check_data)>0){
					while($check_data_row = mysqli_fetch_array($check_data)){
						if($check_data_row['test_id'] == $select_lab_tests_rows['id']){
							$response_arr[$x]['category'][$y]['check_status'] = 1;
						}
					}
				}
				$y++;
				
			}
		}
	$select_lab_subcat = $obj->selectData("sub_categoryname, id","tbl_lab_subcategory","where status != 0 and category_id = $category_id");
	if(mysqli_num_rows($select_lab_subcat)>0){
			$z = 0;
		    
			while($select_lab_subcat_rows = mysqli_fetch_assoc($select_lab_subcat)){
				
				$response_arr[$x]['subcategory'][$z]['subcategory_name'] = $select_lab_subcat_rows['sub_categoryname'];
				$sub_category_id =  $select_lab_subcat_rows['id'];
				
                 $select_lab_subtests = $obj->selectData("id,test_name,mrp","tbl_lab","where subcategory_id = $sub_category_id and status != 0 and category_status = 2");
					if(mysqli_num_rows($select_lab_subtests)>0){
			          $i = 0;
			          while($select_lab_tests_rows = mysqli_fetch_assoc($select_lab_subtests)){
							$response_arr[$x]['subcategory'][$z]['subcategorytest'][$i]['test'] = $select_lab_tests_rows['test_name'];
							$id = $response_arr[$x]['subcategory'][$z]['subcategorytest'][$i]['test_id'] = $select_lab_tests_rows['id'];
						    $response_arr[$x]['subcategory'][$z]['subcategorytest'][$i]['check_status'] = 0;
							$check_data = $obj->selectData("test_id","tbl_add_lab_data","where appointment_id=$url_val and status!=0");
							if(mysqli_num_rows($check_data)>0){
								while($check_data_row = mysqli_fetch_array($check_data)){
									if($check_data_row['test_id'] == $id){
										$response_arr[$x]['subcategory'][$z]['subcategorytest'][$i]['check_status'] = 1;
									}
								}
							}
							$i++;
				
						}

		    	 }
				
				
				
				$z++;
		    	}
	       }
		$x++;
	  }
		
	}
	}else{
		$branch = $branch_id;
		require_once '../../../_class_branch/query_branch.php';
		$obj_branch = new query_branch();
		$select_appointment = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id = $url_val");
		$select_appointment_id = mysqli_fetch_assoc($select_appointment);
		$id = $select_appointment_id['id'];
		$select_lab_category = $obj_branch->selectData(" distinct tbl_labcategory.category_name,tbl_labcategory.id","tbl_labcategory inner join  tbl_lab on tbl_labcategory.id = tbl_lab.category_id "," where tbl_labcategory.status !=0");
		//print_r($obj_branch);exit();
if(mysqli_num_rows($select_lab_category)>0){
	$x = 0;
	while($select_lab_category_row = mysqli_fetch_assoc($select_lab_category)){
		
		$response_arr[$x]['category_name'] = $select_lab_category_row['category_name'];
        $category_id = $select_lab_category_row['id'];
		
		$select_lab_tests = $obj_branch->selectData("id,test_name,mrp","tbl_lab","where category_id = $category_id and status != 0 and category_status = 1");
	   if(mysqli_num_rows($select_lab_tests)>0){
			$y = 0;
			while($select_lab_tests_rows = mysqli_fetch_assoc($select_lab_tests)){
				$response_arr[$x]['category'][$y]['test'] = $select_lab_tests_rows['test_name'];
				$response_arr[$x]['category'][$y]['test_id'] = $select_lab_tests_rows['id'];
				$response_arr[$x]['category'][$y]['check_status'] = 0;
				$check_status = 0;
				
				$check_data = $obj_branch->selectData("test_id","tbl_add_lab_data","where appointment_id=$id and status!=0");
				if(mysqli_num_rows($check_data)>0){
					while($check_data_row = mysqli_fetch_array($check_data)){
						if($check_data_row['test_id'] == $select_lab_tests_rows['id']){
							$response_arr[$x]['category'][$y]['check_status'] = 1;
						}
					}
				}
				$y++;
				
			}
		}
	$select_lab_subcat = $obj_branch->selectData("sub_categoryname, id","tbl_lab_subcategory","where status != 0 and category_id = $category_id");
	if(mysqli_num_rows($select_lab_subcat)>0){
			$z = 0;
		    
			while($select_lab_subcat_rows = mysqli_fetch_assoc($select_lab_subcat)){
				
				$response_arr[$x]['subcategory'][$z]['subcategory_name'] = $select_lab_subcat_rows['sub_categoryname'];
				$sub_category_id =  $select_lab_subcat_rows['id'];
				
                 $select_lab_subtests = $obj_branch->selectData("id,test_name,mrp","tbl_lab","where subcategory_id = $sub_category_id and status != 0 and category_status = 2");
					if(mysqli_num_rows($select_lab_subtests)>0){
			          $i = 0;
			          while($select_lab_tests_rows = mysqli_fetch_assoc($select_lab_subtests)){
							$response_arr[$x]['subcategory'][$z]['subcategorytest'][$i]['test'] = $select_lab_tests_rows['test_name'];
							$id = $response_arr[$x]['subcategory'][$z]['subcategorytest'][$i]['test_id'] = $select_lab_tests_rows['id'];
						    $response_arr[$x]['subcategory'][$z]['subcategorytest'][$i]['check_status'] = 0;
							$check_data = $obj->selectData("test_id","tbl_add_lab_data","where appointment_id=$id and status!=0");
							if(mysqli_num_rows($check_data)>0){
								while($check_data_row = mysqli_fetch_array($check_data)){
									if($check_data_row['test_id'] == $id){
										$response_arr[$x]['subcategory'][$z]['subcategorytest'][$i]['check_status'] = 1;
									}
								}
							}
							$i++;
				
						}

		    	 }
				
				
				
				$z++;
		    	}
	       }
		$x++;
	  }
		
	}
		

		
	
	
	
	}
}


echo json_encode($response_arr);
?>