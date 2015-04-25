<?php
///Now this service is combine with edit_task.php 
include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getTaskController();
$data="";

$taskObj = new Task;
$taskObj->processRequest();
// print_r($taskObj);
// die();

if($taskObj->task_id ==""){

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}else{

	$resObj = $controller->send_rem_email($taskObj);
	// exit;
	if($resObj == 1){
		$arr_result = array(RESULT => SUCCESS,
							MESSAGE => "Reminder mail sent successfully..!",
							DATA => TRUE);
	}else{
		$arr_result = array(RESULT => FAILED,
							MESSAGE => $resObj,
							DATA => FALSE);
	}
	
	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;
}


?>