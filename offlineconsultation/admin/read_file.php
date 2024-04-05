<?php
$conn = mysqli_connect("localhost:3306", "pala_consulation", "20tY3@5oa", "db_pala_consulation");
require_once "Classes/PHPExcel.php";
//$path="uploads/Records.xlsx";
	$path="uploads/".$_FILES['file_upload']['name'];
	//$_FILES['file_upload']['name'][0]
//$path="uploads/".$file_name;
$k = 0;
$reader= PHPExcel_IOFactory::createReaderForFile($path);
$excel_Obj = $reader->load($path);
$worksheet=$excel_Obj->getSheet($k);
$total_row_sheet = $excel_Obj->setActiveSheetIndex($k)->getHighestRow();
$colomncount = $worksheet->getHighestDataColumn();
$rowcount = $worksheet->getHighestRow();
$colomncount_number=PHPExcel_Cell::columnIndexFromString($colomncount);
$sheetTitle = $worksheet->getTitle();
$subquery='';
	$per_cal_per = 0;
	for($row=6;$row<=$rowcount;$row++){
		$insertquery="INSERT INTO tbl_lab(`si_no`,`test_name`,`mrp`,`special_rate`,`added_date`,`added_time`) VALUES";
		$col_values = '';
		$subquery = '';
		$row1 = 1;
		$col_values ="(";
		for($col=0;$col<$colomncount_number;$col++){
			if(trim($worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col).$row)->getValue()) == ''){
				$data_status = 'No Data';
				$col_values.='\''.$data_status.'\',';
			}else{
				$subquery1=$worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col).$row1)->getValue();
				$col_values.='\''.str_replace("'","",$worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col).$row)->getValue()).'\',';
				
			}
			
			
		}
		if($col_values != ''){
		$subquery .= $col_values;
		$subquery = substr($subquery, 0, strlen($subquery) - 1);
		$subquery .= ",'$date','$time'";
		$subquery=$subquery.')';
		$insertquery .= $subquery;
		}
		//echo $insertquery;exit();
		//$per_cal_per = ($row/$total_row_sheet)*100;
		mysqli_query($conn,$insertquery);
		
	}
//mysqli_query($conn,$insertquery);
mysqli_close($conn);
