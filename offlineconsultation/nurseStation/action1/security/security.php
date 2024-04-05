<?php
function check_security_details($Api_key,$admin_live_unique_code,$session_api_key_value,$admin_unique_code){
	$security_update = 0;
	if($admin_live_unique_code != 'Error'){
	if($admin_live_unique_code == $admin_unique_code){
		if($Api_key != 'Error'){
			$api_key_value = $Api_key.''.$admin_live_unique_code;
			if($session_api_key_value == $api_key_value){
				$security_update = 1;
			}else{
				$security_update = 0;
			}
		}else{
			$security_update = 0;
		}
	}else{
		$security_update = 0;
	}
}else{
	$security_update = 0;
}
	return $security_update;
}
?>