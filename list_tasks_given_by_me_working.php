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
	// $resObj =array();
	$resObj1 = $controller->listTasksGivenByME($assign_id);
	
	$cnt=1;
	// $resultArray[] = $resObj1;
	// $tt  =array("ed"=>"fvreg");
	// $obj_merged = (object) array_merge((array) $tt, (array) $resultArray);
	// $cntt=0;
		foreach($resObj1 as $key =>$res){
			
			$res_total = 0;
			$due_task = 0;
			$reminder_task = 0;

			///---///
			// echo $res->assign_id,$res->responsible_id;
			// exit;

			$resObj2 = $controller->listTasksGivenByMEtoUser($res->assign_id,$res->responsible_id);
			// print_r($resObj2);
			// $resultArray[] = $resObj2;
			
			$count_multi = sizeof($resObj2);
			// exit;
			if(!empty($resObj2) && $count_multi>1 ){
				/*
				$today = date("Y-m-d H:i:s");
				// print_r($resObj2[0]);exit;
				$rem_date1=$resObj2[0]->rem_date1;
				
				if(date($rem_date1) < date($today)){
					$reminder_task++;
				}
				
				$due_date=$resObj2[0]->due_date;
				if(date($due_date) < date($today)){
					$due_task++;
				}
				
				$resObj2[0]->res_total = $count_multi;
				$resObj2[0]->reminder_task = $reminder_task;
				$resObj2[0]->due_task = $due_task;
				*/
				$resObj2_array = $resObj2 ;
				// $resultArray[] = $resObj2;
				// $resultArray = (object) array_merge((array) $resObj2_array, (array) $resultArray);
				// $resultArray1[] = array("responsible_name:"=>$res->responsible_name);
				$resultArray[] =('responsible_name: '.$res->responsible_name);
				$resultArray[] = $resObj2_array;


			}else{
				// print_r($res);exit;
				// $resultArray2[] = array("responsible_name:"=>$res->responsible_name);
				$resultArray[] =  ('responsible_name: '.$res->responsible_name);
				$resultArray[][] = $res;
			}
				// $resultArray = (object) array_merge((array) $resultArray2, (array) $resultArray1);
				// $resultArray = array_merge($resultArray2,$resultArray1);
				/*
			elseif($count_multi==1){
				$today = date("Y-m-d H:i:s");
				// print_r($resObj2[0]);exit;
				$rem_date1=$resObj2[0]->rem_date1;
				
				if(date($rem_date1) < date($today)){
					$reminder_task++;
				}
				
				$due_date=$resObj2[0]->due_date;
				if(date($due_date) < date($today)){
					$due_task++;
				}
				
				$res->res_total = $count_multi;
				$res->reminder_task = $reminder_task;
				$res->due_task = $due_task;
				// print_r($res);exit;
				$resultArray[$cnt] = $res;
				$cnt++;
			}
				*/
	//
		}
	
	
	// $resObj  = array_unique($resObj);

	// $obj_merged = (object) array_merge((array) $resObj2, (array) $resultArray);
	$obj_merged = $resultArray;

	
	if(!empty($obj_merged)){
		$arr_result = array(RESULT => SUCCESS,
							MESSAGE => "List of Tasks given by me..!",
							DATA => $obj_merged);
	}else{
		$arr_result = array(RESULT => FAILED,
							MESSAGE => "No Tasks Found..!",
							DATA => $resObj);
	}
	
	$json = json_encode($arr_result);
	echo  preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $json); // remove null values
	exit;

}else{

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}


?>