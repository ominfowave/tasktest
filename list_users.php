<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getUserController();
$data="";
	
	$resObj = $controller->listAllUsers();

	$arr_result = array(RESULT => SUCCESS,
	    				MESSAGE => "List of all Users..!",
	    				DATA => $resObj);

	$json = json_encode($arr_result);
	// echo  preg_replace("/null/", '""', $json);
	echo  $json = preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $json); 
	exit;

?>