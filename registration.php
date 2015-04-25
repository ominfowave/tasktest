<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getUserController();
$data="";

$userObj = new User;
$userObj->processRequest();
// print_r($userObj);
// die();
if(FALSE == $userObj->validateAddUser()){

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => null);

	echo json_encode($arr_result);
    exit;
}

$userAuthObj = $controller->getUserAuth($userObj->username,$userObj->email,$userObj->contact);

// print_r($userAuthObj);
// exit;
if(NULL != $userAuthObj){
	$data['id'] = $userAuthObj->id;
	$arr_result = array(RESULT => FAILED,
						MESSAGE => "You have already registered with this Contact or Email ..!",
						DATA => $data);

	echo json_encode($arr_result);
    exit;

}else{

	$USER_ID = $controller->addUser($userObj);

	$resObj = $controller->getUser($USER_ID);
	
//joiti vastu j apo like login...
// id,gcm_id,firstname,lastname,username,email,contact,password,status,created_date

	$result_array =array(
						"id"=>$resObj->id,
						"firstname"=>$resObj->firstname,
						"lastname"=>$resObj->lastname,
						"username"=>$resObj->username,
						"email"=>$resObj->email,
						"contact"=>$resObj->contact,
						);

	$arr_result = array(RESULT => SUCCESS,
	    				MESSAGE => "Thank you for registering with us.",
	    				DATA => $result_array);

	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;
}



?>