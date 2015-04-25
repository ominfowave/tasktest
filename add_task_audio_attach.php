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

	$TASK_ARRAY = $controller->addTaskAudio($taskObj);
	
	$TASK_ID=$TASK_ARRAY[0];
	$TOTAL_CNT=$TASK_ARRAY[1];
	$UPLOAD_CNT=$TASK_ARRAY[2];
	
	if(isset($UPLOAD_CNT) && $UPLOAD_CNT >0){
	
	$resObj = $controller->getTask($TASK_ID);

	$arr_result = array(RESULT => SUCCESS,
	    				MESSAGE => "$UPLOAD_CNT out of $TOTAL_CNT audio files are uploaded Successfully..!",
	    				DATA => $resObj);
	}else{
		$arr_result = array(RESULT => FAILED,
							MESSAGE => "No audio file uploaded...!",
							DATA => "");
	}
	
	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;
}

?>