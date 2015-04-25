<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getTaskController();
$data="";

$taskObj = new Task;
$taskObj->processRequest();
// print_r($taskObj);
// print_r($_REQUEST);
// die();

if(FALSE == $taskObj->validateDeleteTask()){

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}else{

	$resObj = $controller->getTask($taskObj->task_id,$taskObj->current_datetime);
	
	if($resObj!=0){
		$arr_result = array(RESULT => SUCCESS,
							MESSAGE => "Task detail fetched Successfully..!",
							DATA => $resObj);
	}else{
		$arr_result = array(RESULT => FAILED,
							MESSAGE => "No Task Found..!",
							DATA => "");
	}
	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;
}

?>