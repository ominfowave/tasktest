<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getTaskController();
$data="";

// $taskObj = new Task;
// $taskObj->processRequest();
// print_r($taskObj);
// die();

	$resObj = $controller->listAllTasks();
	// $resObj['count'] = $controller->count();

	$arr_result = array(RESULT => SUCCESS,
	    				MESSAGE => "List of all Tasks!",
	    				DATA => $resObj);

	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;


?>