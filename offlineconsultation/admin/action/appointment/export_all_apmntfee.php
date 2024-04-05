<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
require_once '../../../_class_branch/query_branch.php';
$response_arr = array();
$obj = new query();
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$time = date('h:i:s A');

if (isset($_SESSION['admin_login_id'])) {
    $login_id = $_SESSION['admin_login_id'];
    $admin_role = $_SESSION['admin_role'];
    $admin_unique_code = $_SESSION['admin_unique_code'];
    if ($admin_role == 'admin') {
        $api_key_value = $_SESSION['api_key_value'];
        $admin_unique_code = $_SESSION['admin_unique_code'];
        $Api_key = fetch_Api_Key($obj);
        $admin_live_unique_code = fetch_unique_code($obj, $login_id);
        $check_security = check_security_details($Api_key, $admin_live_unique_code, $api_key_value, $admin_unique_code);

        if ($check_security == 1) {
            // Initialize response array
            $response_arr = array();

            // Filter the excel data 
            function filterData(&$str)
            {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }

            // Excel file name for download 
            $fileName = "AppoinmentFee_Reports" . date('d-m-Y') . ".xls";

            // Define fields for excel
            $fields = array('No', 'Invoice number', 'Name', 'Date', 'AppoinmentFee', 'payment mode', 'Type');
            $excelData = implode("\t", array_values($fields)) . "\n";

            // Handle search filter
            $search_val = isset($_GET['search']) ? $_GET['search'] : '';
            $where_name_filter = ($search_val != '') ? " AND tbl_appointment_modeinvoice.invoice_campain LIKE '%$search_val%'" : '';

            // Handle date filter
            $startDate_url = isset($_GET['startdate']) ? $_GET['startdate'] : 0;
            $EndDate_url = isset($_GET['enddate']) ? $_GET['enddate'] : 0;
            $date_where_clause = '';

            // Date filter
            if ($startDate_url != 0) {
                if ($EndDate_url != 0) {
                    $startDate_new_format = date("d-m-Y", strtotime($startDate_url));
                    $EndDate_new_format = date("d-m-Y", strtotime($EndDate_url));
                    if ($startDate_url == $EndDate_url) {
                        $date_where_clause = " AND tbl_appointment_modeinvoice.addedDate='$startDate_new_format'";
                    } else {
                        $date_diff = (strtotime($EndDate_new_format) - strtotime($startDate_new_format)) / 60 / 60 / 24;
                        if ($date_diff != 0) {
                            $date_where_clause = " AND (";
                            for ($x1 = 0; $x1 <= $date_diff; $x1++) {
                                $new_date = date('d-m-Y', strtotime($startDate_new_format . ' +' . $x1 . ' day'));
                                if ($x1 == $date_diff) {
                                    $date_where_clause .= "tbl_appointment_modeinvoice.addedDate='$new_date')";
                                } else {
                                    $date_where_clause .= "tbl_appointment_modeinvoice.addedDate='$new_date' OR ";
                                }
                            }
                        } else {
                            $date_where_clause = " AND tbl_appointment_modeinvoice.addedDate =$startDate_new_format";
                        }
                    }
                } else {
                    $startDate_new_format = date("d-m-Y", strtotime($startDate_url));
                    $date_where_clause = " AND tbl_appointment_modeinvoice.addedDate='$startDate_new_format'";
                }
            } else {
                $startDate_current = date("d-m-Y", strtotime($date));
                $date_where_clause = " AND tbl_appointment_modeinvoice.addedDate='$startDate_current'";
            }

            // Fetch data from the database
            $select_all_appoinmentfeereports = $obj->selectData("tbl_appointment_modeinvoice.id,tbl_appointment_modeinvoice.appointment_id,tbl_appointment_modeinvoice.patient_id,tbl_appointment_modeinvoice.invoice_campain,tbl_appointment_modeinvoice.addedDate,tbl_appoinment_payment.payment_id,tbl_appoinment_payment.payment_amnt,tbl_appointment.branch_id", "tbl_appointment_modeinvoice INNER JOIN tbl_appointment ON tbl_appointment_modeinvoice.appointment_id=tbl_appointment.id INNER JOIN tbl_appoinment_payment ON tbl_appointment_modeinvoice.id=tbl_appoinment_payment.tbl_apmnt_mode_payid", "WHERE tbl_appointment_modeinvoice.status!=0 AND tbl_appointment.status!=0 $date_where_clause $where_name_filter ORDER BY tbl_appointment_modeinvoice.id DESC");

            // Check if data exists
            if (mysqli_num_rows($select_all_appoinmentfeereports) > 0) {
                $x = 0;
                $response_arr[0]['status'] = 1;
                $response_arr[0]['data_exist'] = 1;

                // Fetch and process each row
                while ($select_all_appoinment_row = mysqli_fetch_array($select_all_appoinmentfeereports)) {
                    // Fetch additional data
                    $branch_id = $select_all_appoinment_row['branch_id'];
                    $patient_id = $select_all_appoinment_row['patient_id'];
                    $branch = $branch_id;
                    $obj_branch = new query_branch();
                    $selectData1 = $obj_branch->selectData("id,name", "tbl_patient", "WHERE id=$patient_id");

                    // Process patient data
                    if (mysqli_num_rows($selectData1) > 0) {
                        $temp_name = mysqli_fetch_assoc($selectData1);
                        // Process invoice data
                        if ($select_all_appoinment_row['payment_amnt'] == '500') {
                            if ($select_all_appoinment_row['payment_id'] != 0) {
                                $invoice_id = $select_all_appoinment_row['id'];
                                // Fetch appointment data
                                $appointment_id = $select_all_appoinment_row['appointment_id'];
                                $selectappointment = $obj->selectData("id,appointment_fee", "tbl_appointment", "WHERE id=$appointment_id");
                                $temperory_name = mysqli_fetch_assoc($selectappointment);
                                $appoinment_fee = $temperory_name['appointment_fee'];

                                // Process payment mode data
                                $payment_mode_data = '';
                                $patient_type = ($appoinment_fee == 500) ? 'New Patient' : (($appoinment_fee == 0) ? '' : 'Renewal');
                                $select_payment_mode = $obj->selectData("payment_id,payment_amnt", "tbl_appoinment_payment", "WHERE tbl_apmnt_mode_payid=$invoice_id AND status!=0");

                                if (mysqli_num_rows($select_payment_mode)) {
                                    while ($select_payment_mode_row = mysqli_fetch_array($select_payment_mode)) {
                                        $pay_mode = '';
                                        switch ($select_payment_mode_row['payment_id']) {
                                            case 1:
                                                $pay_mode = 'gpay';
                                                break;
                                            case 2:
                                                $pay_mode = 'cash';
                                                break;
                                            case 3:
                                                $pay_mode = 'card';
                                                break;
                                        }
                                        $payment_mode_data .= ($payment_mode_data != '') ? " ,$pay_mode(" . $select_payment_mode_row['payment_amnt'] . ")" : "$pay_mode (" . $select_payment_mode_row['payment_amnt'] . ")";
                                    }
                                }
                                // Prepare response array
                                $response_arr[$x]['payment_mode_data'] = $payment_mode_data;
                                $patient_name = $temp_name['name'];
                                $response_arr[$x]['id'] = $select_all_appoinment_row['id'];
                                $response_arr[$x]['appointment_id'] = $select_all_appoinment_row['appointment_id'];
                                $response_arr[$x]['patient_id'] = $select_all_appoinment_row['patient_id'];
                                $response_arr[$x]['patient_name'] = $patient_name;
                                $response_arr[$x]['invoice_campain'] = $select_all_appoinment_row['invoice_campain'];
                                $response_arr[$x]['addedDate'] = $select_all_appoinment_row['addedDate'];
                                $response_arr[$x]['appointment_fee'] = $appoinment_fee;
                                $response_arr[$x]['patient_type'] = $patient_type;
                                $x++;
                            }
                        } else {
                            $invoice_id = $select_all_appoinment_row['id'];
                            $patient_id = $select_all_appoinment_row['patient_id'];
                            $appointment_id = $select_all_appoinment_row['appointment_id'];
                            $selectappointment = $obj->selectData("id,appointment_fee", "tbl_appointment", "WHERE id=$appointment_id");
                            $temperory_name = mysqli_fetch_assoc($selectappointment);
                            $appoinment_fee = $temperory_name['appointment_fee'];
                            $payment_mode_data = '';
                            $patient_type = ($appoinment_fee == 500) ? 'New Patient' : (($appoinment_fee == 0) ? '' : 'Renewal');
                            $select_payment_mode = $obj->selectData("payment_id,payment_amnt", "tbl_appoinment_payment", "WHERE tbl_apmnt_mode_payid=$invoice_id AND status!=0");
                            if (mysqli_num_rows($select_payment_mode)) {
                                while ($select_payment_mode_row = mysqli_fetch_array($select_payment_mode)) {
                                    $pay_mode = '';
                                    switch ($select_payment_mode_row['payment_id']) {
                                        case 1:
                                            $pay_mode = 'gpay';
                                            break;
                                        case 2:
                                            $pay_mode = 'cash';
                                            break;
                                        case 3:
                                            $pay_mode = 'card';
                                            break;
                                    }
                                    $payment_mode_data .= ($payment_mode_data != '') ? " ,$pay_mode(" . $select_payment_mode_row['payment_amnt'] . ")" : "$pay_mode (" . $select_payment_mode_row['payment_amnt'] . ")";
                                }
                            }
                            $response_arr[$x]['payment_mode_data'] = $payment_mode_data;
                            $patient_name = $temp_name['name'];
                            $response_arr[$x]['id'] = $select_all_appoinment_row['id'];
                            $response_arr[$x]['appointment_id'] = $select_all_appoinment_row['appointment_id'];
                            $response_arr[$x]['patient_id'] = $select_all_appoinment_row['patient_id'];
                            $response_arr[$x]['patient_name'] = $patient_name;
                            $response_arr[$x]['invoice_campain'] = $select_all_appoinment_row['invoice_campain'];
                            $response_arr[$x]['addedDate'] = $select_all_appoinment_row['addedDate'];
                            $response_arr[$x]['appointment_fee'] = $appoinment_fee;
                            $response_arr[$x]['patient_type'] = $patient_type;
                            $x++;
                        }

                        $lineData = array($sino, $select_all_appoinment_row['invoice_campain'], $patient_name, $select_all_appoinment_row['addedDate'], $appoinment_fee, $payment_mode_data, $patient_type);
                        array_walk($lineData, 'filterData');
                        $excelData .= implode("\t", array_values($lineData)) . "\n";
                        $sino++;
                    }
                }
            } else {
                $excelData .= 'No records found...' . "\n";
            }

            // Headers for download 
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$fileName\"");

            // Render excel data 
            echo $excelData;
        }
    }
}
?>
