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

	$resObj1 = $controller->listTasksGivenByME($assign_id);

		foreach($resObj1 as $key =>$res){


			///---///
			// echo $res->assign_id,$res->responsible_id;
			// exit;

			$resObj2 = $controller->listTasksGivenByMEtoUser($res->assign_id,$res->responsible_id);
			// print_r($resObj2);
			// $resultArray[] = $resObj2;

			$count_multi = sizeof($resObj2);

			// exit;
			if(!empty($resObj2) && $count_multi>1 ){ //multiple
			
				$reminder_task_m = 0;
				$due_task_m = 0;
					
				foreach($resObj2 as $key2 =>$res2){
					
					$today = time();
					
					$rem_date1=strtotime($res2->rem_date1);
					$due_date=strtotime($res2->due_date); //1422918000

					if($rem_date1 < $today && $due_date > $today){
						$reminder_task_m++;
						$res2->is_reminded="1"; //keep this 
					}else{
						$res2->is_reminded="0"; //keep this 
					}

					if($due_date < $today ){
						$due_task_m++;
						$res2->is_due="1"; //keep this 
					}else{
						$res2->is_due="0"; //keep this 
					}

				}
				/*
				$resultArray[] =('responsible_name: '.$res->responsible_name .
								',total_task: '.$count_multi .
								',reminder_task: '.$reminder_task .
								',due_task: '.$due_task
				);*/
				
				$resultArray[] =($res->responsible_name .
								','.$count_multi .
								','.$reminder_task .
								','.$due_task
				);

				$resultArray[] = $resObj2;


			}else{ //Single Entry
				
				
				$reminder_task = 0;
				$due_task = 0;
				$res->is_due="0";
				$res->is_reminded="0";
				
				$today = time();
				
				$rem_date1=strtotime($res->rem_date1);
				$due_date=strtotime($res->due_date); //1422918000

				if($rem_date1 < $today && $due_date > $today){
					$res->is_reminded="1";
					$reminder_task++;
				}
				
				if($due_date < $today ){
					$res->is_due="1";
					$due_task++;
				}
				/*
				$resultArray[] =('responsible_name: '.$res->responsible_name .
								',total_task: '.$count_multi .
								',reminder_task: '.$reminder_task .
								',due_task: '.$due_task
				);*/
				
				$resultArray[] =($res->responsible_name .
								','.$count_multi .
								','.$reminder_task .
								','.$due_task
				);

				// print_r($res);exit;// 
				// $res->is_due="no";
				$resultArray[][] = $res;

			}

		}

	// $obj_merged = (object) array_merge((array) $resObj2, (array) $resultArray);
	$obj_merged = $resultArray;


	if(!empty($obj_merged)){
		$arr_result = array(RESULT => SUCCESS,
							MESSAGE => "List of Tasks given by me..!",
							DATA => $obj_merged);
	}else{
		$arr_result = array(RESULT => FAILED,
							MESSAGE => "No Tasks Found..!",
							DATA => "");
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