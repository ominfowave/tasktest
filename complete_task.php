<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getTaskController();
$data="";

$taskObj = new Task;
$taskObj->processRequest();
// print_r($taskObj);
// die();

if(FALSE == $taskObj->validateCompleteTask()){

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}else{

	$TASK_ID = $controller->completeTask($taskObj);

	$resObj = $controller->getTask($TASK_ID);

	$arr_result = array(RESULT => SUCCESS,
	    				MESSAGE => "Task completed..!",
	    				DATA => $resObj);

	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;
}


?>