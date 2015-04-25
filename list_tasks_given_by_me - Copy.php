<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getTaskController();
$data="";

$taskObj = new Task;
$taskObj->processRequest();
// print_r($taskObj);
// die();
$assign_id= $taskObj->assign_id;

if(isset($assign_id) && $assign_id !=""){
	
	$resObj = $controller->listTasksGivenByME($assign_id);

	if(!empty($resObj)){
		$arr_result = array(RESULT => SUCCESS,
							MESSAGE => "List of all User's Given Tasks!",
							DATA => $resObj);
	}else{
		$arr_result = array(RESULT => FAILED,
							MESSAGE => "No Tasks Found..!",
							DATA => $resObj);
	}
	
	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;

}else{

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}


?>