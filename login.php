<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getUserController();

$userObj = new User;
$userObj->processRequest();
// print_r($userObj);
// die();

if(FALSE == $userObj->validateUserLogin()){

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}

$username = $userObj->username;
$password = $userObj->password;

if(isset($username) && isset($password) && $username !="" && $password !="" ){
	$userObjVerified = $controller->getUserFromUsernamenPwd($username,$password);

 // print_r($userObjVerified);
 // exit;
}
 if(NULL == $userObjVerified){

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Login failed.",
						DATA => "");

}else{
	//update gcm here:
	$controller->updateGCMwithLogin($userObj->gcm_id,$userObjVerified->id);

	//id, firstname, lastname, username, email, device_id, gcm_id, status, created_date 
	$userObj_response = array(
								"id"=>$userObjVerified->id,
								"firstname"=>$userObjVerified->firstname,
								"lastname"=>$userObjVerified->lastname,
								"username"=>$userObjVerified->username,
								"contact"=>$userObjVerified->contact,
								"email"=>$userObjVerified->email,
								"password"=>$userObjVerified->password,
								"status"=>$userObjVerified->status,
								);


	$arr_result = array(RESULT => SUCCESS,
						MESSAGE => "User Login Successfully...",
						DATA => $userObj_response);
}

$json  = json_encode($arr_result);
echo preg_replace("/null/", '""', $json); // replace null to ""

?>