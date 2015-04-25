<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getUserController();
$data="";

$userObj = new User;
$userObj->processRequest();
// print_r($userObj);
// die();
// validateDeleteUser can be use to check id is not null
if(FALSE == $userObj->validateDeleteUser()){
			
	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;
}

$userAuthObj = $controller->getUserAuthOnUpdate($userObj->username,$userObj->email,$userObj->contact,$userObj->id);

// print_r($userAuthObj);
// exit;
if(NULL != $userAuthObj){
	$data['id'] = $userAuthObj->id;
	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Username,Contact or Email is not available to update..!",
						DATA => $data);

	echo json_encode($arr_result);
    exit;

}else{

	$is_update = $controller->updateUser($userObj);
	
// print_r($is_update);exit;
// if(isset($is_update) && $is_update > 0){
	// $update_status = '1'; //updated with new data or same data updated so blank
// }
	$resObj = $controller->getUser($userObj->id);
	
//joiti vastu j apo like login...
// id,gcm_id,firstname,lastname,username,email,contact,password,status,created_date

	$result_array =array(
						"id"=>$resObj->id,
						"firstname"=>$resObj->firstname,
						"lastname"=>$resObj->lastname,
						"contact"=>$resObj->contact,
						"email"=>$resObj->email,
						"status"=>$resObj->status,
						);
					
	$arr_result = array(RESULT => SUCCESS,
	    				MESSAGE => "Profile updated Successfully..!",
	    				DATA => $result_array);

	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;
}



?>