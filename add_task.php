<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getTaskController();
$data="";

$taskObj = new Task;
$taskObj->processRequest();
// print_r($taskObj);
// print_r($_REQUEST);


// die();
// die();

/*
$dtz = new DateTimeZone('Asia/kolkata');
$time_in_asia = new DateTime('now', $dtz);
// echo $dtz->getOffset( $time_in_asia );

$offset = $dtz->getOffset( $time_in_asia ) / 3600;
echo "GMT" . ($offset < 0 ? $offset : "+".$offset);

exit;
*/

if(FALSE == $taskObj->validateAddTask()){

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}else{

	$TASK_ID = $controller->addTask($taskObj);

	$resObj = $controller->getTask($TASK_ID);

	$arr_result = array(RESULT => SUCCESS,
	    				MESSAGE => "Task added Successfully..!",
	    				DATA => $resObj);

	$json = json_encode($arr_result);
	echo  preg_replace("/null/", '""', $json);
	exit;
}


?>