<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getUserController();

$userObj = new User;
$userObj->processRequest();
 // print_r($userObj);
 // die();
if(FALSE == $userObj->validateEmail()){
			
	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => null);

	echo json_encode($arr_result);
    exit;
	
}

$userAuthObj = $controller->selectUserEmailId($userObj->email);

// print_r($userAuthObj);
// exit;
if(NULL != $userAuthObj){
	
	$generatePwd = $controller->generateUserToken($userObj->email);

	$userObj = $controller->sendEmailForgetPassword($userObj->email);
			
	$arr_result = array(RESULT => SUCCESS,
	    				MESSAGE => "Email sent successfully... ",
	    				DATA => $userObj);

	echo json_encode($arr_result);
	exit;

}else{

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Email not found",
						DATA => "");
	
	echo json_encode($arr_result);
    exit;
	
}

?>