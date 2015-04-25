<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getTaskController();
$data="";

$taskObj = new Task;
$taskObj->processRequest();
// print_r($taskObj);
// die();
$responsible_id= $taskObj->responsible_id;

if(isset($responsible_id) && $responsible_id !=""){

	$resObj1 = $controller->listTasksAssignToMeWatch($responsible_id);
	// print_r($resObj1);exit;
	$resultArray="";
	$count_multi = sizeof($resObj1);
	// $resultArray[]=$resObj1;
		foreach($resObj1 as $key =>$res){
	
				$reminder_task = 0;
				$due_task = 0;
				$res->is_due="0";
				$res->is_reminded="0";
				$res->is_passed_all_reminded="0";
				
				$today = time();
				
				$rem_date1=($res->rem_date1!='0000-00-00 00:00:00') ? strtotime($res->rem_date1) : "";
			 	$rem_date2=($res->rem_date2!='0000-00-00 00:00:00') ? strtotime($res->rem_date2) : "";
			 	$rem_date3=($res->rem_date3!='0000-00-00 00:00:00') ? strtotime($res->rem_date3) : "";
			 	$rem_date4=($res->rem_date4!='0000-00-00 00:00:00') ? strtotime($res->rem_date4) : "";
				
			 	$due_date=($res->due_date!='0000-00-00 00:00:00') ? strtotime($res->due_date) : "";
			 	$assign_date=($res->assign_date!='0000-00-00 00:00:00') ? strtotime($res->assign_date) : "";
				
				if($rem_date1 < $today && $due_date > $today  && ($res->is_complete == 0)){
					$res->is_reminded="1";
					$reminder_task++;
				}
				
				if(($rem_date1 < $today && $rem_date2 < $today && $rem_date3 < $today && $rem_date4 < $today ) && $due_date > $today && ($res->is_complete == 0)){
					$res->is_passed_all_reminded="1"; //keep this 
				}
				
				if($due_date < $today && ($res->is_complete == 0)) {
					$res->is_due="1";
					$due_task++;
				}
				
				//=if date is passed than blank=//
				// echo "ABCDJROSJDFGZ";
				if($rem_date1 < $today ){
				 	$res->rem_date1="";
				}
				if($rem_date2 < $today ){
					$res->rem_date2="";
				}
				if($rem_date3 < $today ){
					$res->rem_date3="";
				}
				if($rem_date4 < $today ){
					$res->rem_date4="";
				}
				//=if date is passed than blank=//
				
				/*
				$resultArray[] =('assigner_name: '.$res->assigner_name .
								',total_task: '.$count_multi .
								',reminder_task: '.$reminder_task .
								',due_task: '.$due_task
				);*/
				
				$resultArray[] =($res->title .
								','.$count_multi .
								','.$reminder_task .
								','.$due_task
				);

				// print_r($res);exit;// 
				// $res->is_due="no";

				$res->rem_date1 = ($rem_date1!="") ? date('Y-m-d H:i:s D' ,$rem_date1) : "";
				$res->rem_date2 = ($rem_date2!="") ? date('Y-m-d H:i:s D' ,$rem_date2) : "";
				$res->rem_date3 = ($rem_date3!="") ? date('Y-m-d H:i:s D' ,$rem_date3) : "";
				$res->rem_date4 = ($rem_date4!="") ? date('Y-m-d H:i:s D' ,$rem_date4) : "";
				
				$res->due_date = ($due_date!="") ? date('Y-m-d H:i:s D' ,$due_date) : "";
				$res->assign_date = ($assign_date!="") ? date('Y-m-d H:i:s D' ,$assign_date) : "";
				
				$resultArray[][] = $res;

			//}

		}

	$obj_merged = $resultArray;


	if(!empty($obj_merged)){
		$arr_result = array(RESULT => SUCCESS,
							MESSAGE => "List of Tasks assign to me..!",
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