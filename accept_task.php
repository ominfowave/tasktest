<?php
///Now this service is combine with edit_task.php 
include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getTaskController();
$data="";

$taskObj = new Task;
$taskObj->processRequest();
// print_r($taskObj);//0-default, 1- accept,2-reject
// die();

if(FALSE == $taskObj->validateAcceptTask()){

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}else{

	$TASK_ID = $controller->acceptTask($taskObj);

	$resObj = $controller->getTask($TASK_ID);

	$arr_result = array(RESULT => SUCCESS,
	    				MESSAGE => "Task status updated..!",
	    				DATA => $resObj);

	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;
}


?>