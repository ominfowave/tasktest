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
						MESSAGE => "Please provide task id",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}else{
	
	$TASK_ID = $controller->updateTask($taskObj);

	$resObj = $controller->getTask($taskObj->task_id);

	$arr_result = array(RESULT => SUCCESS,
						MESSAGE => "Task updated successfully..!",
						DATA => $resObj);

	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;
}
?>