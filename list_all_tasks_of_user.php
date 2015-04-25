<?php

include_once '../blu/ControllerFactory.php';
$controller = ControllerFactory::getInstance()->getTaskController();
$data="";

// $taskObj = new Task;
// $taskObj->processRequest();
// print_r($taskObj);
// die();
$assign_id= isset($_REQUEST['user_id'])? $_REQUEST['user_id']:"";

if(isset($assign_id) && $assign_id !=""){

	$resObj1 = $controller->listTasksGivenByME($assign_id);
	// print_r($resObj1);exit;
		$resultArray="";

		foreach($resObj1 as $key =>$res){

			///---///
			// echo $res->assign_id,$res->responsible_id;
			// exit;

			$resObj2 = $controller->listTasksGivenByMEtoUser($assign_id,$res->responsible_id);
			// print_r($resObj2);exit;
			// $resultArray[] = $resObj2;

			$count_multi = sizeof($resObj2);

			// exit;
			if(!empty($resObj2) && $count_multi>1 ){ //multiple
			
				$reminder_task_m = 0;
				$due_task_m = 0;
					
				foreach($resObj2 as $key2 =>$res2){
					// echo "assigner-".$res2->assign_id;
					// echo "<br/>responsible-".$res2->responsible_id;
					//// if($res2->assign_id!=$res2->responsible_id){
					// echo " match"; exit;
					$today = time();

					$rem_date1=($res2->rem_date1!='0000-00-00 00:00:00') ? strtotime($res2->rem_date1) : "";
					$rem_date2=($res2->rem_date2!='0000-00-00 00:00:00') ? strtotime($res2->rem_date2) : "";
					$rem_date3=($res2->rem_date3!='0000-00-00 00:00:00') ? strtotime($res2->rem_date3) : "";
					$rem_date4=($res2->rem_date4!='0000-00-00 00:00:00') ? strtotime($res2->rem_date4) : "";
					
					$due_date=($res2->due_date!='0000-00-00 00:00:00') ? strtotime($res2->due_date) : "";
					$assign_date=($res2->assign_date!='0000-00-00 00:00:00') ? strtotime($res2->assign_date) : "";
					
					if($due_date < $today){
						$due_task_m++;
						$res2->is_due="1"; //keep this 
					}else{
						$res2->is_due="0"; //keep this 
					}
					
					// if(($res2->is_complete == 0) && (
					if($res2->is_due=="1"){
						$reminder_task_m++;
						$res2->is_reminded="1";
					}elseif( 
					($rem_date1!="" && $rem_date1 < $today) ||
					($rem_date2!="" && $rem_date2 < $today) ||
					($rem_date3!="" && $rem_date3 < $today) ||
					($rem_date4!="" && $rem_date4 < $today)
					// ) && $due_date!="" && $due_date > $today ){
					){
						$reminder_task_m++;
						$res2->is_reminded="1"; //keep this 
					}else{
						$res2->is_reminded="0"; //keep this 
					}
					
					/* old code
					// if(($rem_date1 < $today && $rem_date2 < $today && $rem_date3 < $today && $rem_date4 < $today ) && $due_date > $today && ($res2->is_complete == 0)){
						
					if(//($res2->is_due == "0") &&($res2->is_complete == 0) && 
						($rem_date1 < $today) &&
						($rem_date2 < $today) &&
						($rem_date3 < $today) &&
						($rem_date4 < $today) ){
						
						$res2->is_passed_all_reminded="1"; //keep this 
					}else{
						$res2->is_passed_all_reminded="0"; //keep this 
					}*/
					if($res2->is_due=="1"){
						$res2->is_passed_all_reminded="1";
					}elseif($rem_date1 =="" && $rem_date2 =="" && $rem_date3 =="" && $rem_date4 =="" ){
						$res2->is_passed_all_reminded="0"; //keep this 
					}elseif(
						($rem_date1 !="" && $rem_date1 > $today) ||
						($rem_date2 !="" && $rem_date2 > $today) ||
						($rem_date3 !="" && $rem_date3 > $today) ||
						($rem_date4 !="" && $rem_date4 > $today) 
					){
						$res2->is_passed_all_reminded="0"; //keep this 
					}else{
						$res2->is_passed_all_reminded="1"; //keep this 
					}
					
					$res2->rem_date1 = ($rem_date1!="") ? date('Y-m-d H:i:s D' ,$rem_date1) : "";
					$res2->rem_date2 = ($rem_date2!="") ? date('Y-m-d H:i:s D' ,$rem_date2) : "";
					$res2->rem_date3 = ($rem_date3!="") ? date('Y-m-d H:i:s D' ,$rem_date3) : "";
					$res2->rem_date4 = ($rem_date4!="") ? date('Y-m-d H:i:s D' ,$rem_date4) : "";
					
					$res2->due_date = ($due_date!="") ? date('Y-m-d H:i:s D' ,$due_date) : "";
					$res2->assign_date = ($assign_date!="") ? date('Y-m-d H:i:s D' ,$assign_date) : "";
					$res2->contact = isset($res2->contact) ? $res2->contact : "";

					// print_r($res2);exit;
					// //}
				}
				/*
				$resultArray[] =('responsible_name: '.$res->responsible_name .
								',total_task: '.$count_multi .
								',reminder_task: '.$reminder_task_m .
								',due_task: '.$due_task_m
				);*/
				
				$resultArray[] =($res->responsible_name .
								' (responsible),'.$count_multi .
								','.$reminder_task_m .
								','.$due_task_m
								);

				$resultArray[] = $resObj2;
				

			}else{ //Single Entry
			//// }elseif($res->assign_id != $res->responsible_id){ //Single Entry //responsible /assigned by
				
				
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

				if($due_date < $today) {
					$res->is_due="1";
					$due_task++;
				}else{
					$res->is_due="0";
				}
				
				// if(($res->is_complete == 0) && $rem_date1!="" && $rem_date1 < $today && $due_date!="" && $due_date > $today ){
				// if(($res->is_complete == 0) && (
				if($res->is_due=="1"){
					$reminder_task++;
					$res->is_reminded="1";
				}elseif(
					($rem_date1!="" && $rem_date1 < $today) ||
					($rem_date2!="" && $rem_date2 < $today) ||
					($rem_date3!="" && $rem_date3 < $today) ||
					($rem_date4!="" && $rem_date4 < $today)
				// ) && $due_date!="" && $due_date > $today ){ //due date consider for rem date
				){
					$reminder_task++;
					$res->is_reminded="1";
				}else{
					$res->is_reminded="0";
				}

				// if(($rem_date1 < $today && $rem_date2 < $today && $rem_date3 < $today && $rem_date4 < $today ) && $due_date > $today && ($res->is_complete == 0)){
					// $res->is_passed_all_reminded="1"; //keep this
				// }
				
				/* old code
				if(//($res->is_due == "0") && ($res->is_complete == 0) && 
					($rem_date1 < $today) &&
					($rem_date2 < $today) &&
					($rem_date3 < $today) &&
					($rem_date4 < $today) ){
					
					$res->is_passed_all_reminded="1"; //keep this 
				}else{
					$res->is_passed_all_reminded="0"; //keep this 
				} */
				
				if($res->is_due=="1"){
					$res->is_passed_all_reminded="1";
				}elseif($rem_date1 =="" && $rem_date2 =="" && $rem_date3 =="" && $rem_date4 =="" ){
					$res->is_passed_all_reminded="0"; //keep this 
				}elseif(
					($rem_date1 !="" && $rem_date1 > $today) ||
					($rem_date2 !="" && $rem_date2 > $today) ||
					($rem_date3 !="" && $rem_date3 > $today) ||
					($rem_date4 !="" && $rem_date4 > $today) 
				){
					$res->is_passed_all_reminded="0"; //keep this 
				}else{
					$res->is_passed_all_reminded="1"; //keep this 
				}
				
				/*
				$resultArray[] =('responsible_name: '.$res->responsible_name .
								',total_task: '.$count_multi .
								',reminder_task: '.$reminder_task .
								',due_task: '.$due_task
				);*/
				
				$resultArray[] =($res->responsible_name .
								' (responsible),'.$count_multi .
								','.$reminder_task .
								','.$due_task
				);
// echo "/";
// echo  time();
// echo "/";
// echo strtotime('0000-00-00 00:00:00');
				// print_r($res);exit;// 
				// $res->is_due="no";
				
				$res->rem_date1 = ($rem_date1!="") ? date('Y-m-d H:i:s D' ,$rem_date1) : "";
				$res->rem_date2 = ($rem_date2!="") ? date('Y-m-d H:i:s D' ,$rem_date2) : "";
				$res->rem_date3 = ($rem_date3!="") ? date('Y-m-d H:i:s D' ,$rem_date3) : "";
				$res->rem_date4 = ($rem_date4!="") ? date('Y-m-d H:i:s D' ,$rem_date4) : "";
				
				$res->due_date = ($due_date!="") ? date('Y-m-d H:i:s D' ,$due_date) : "";
				$res->assign_date = ($assign_date!="") ? date('Y-m-d H:i:s D' ,$assign_date) : "";
				$res->contact = isset($res->contact) ? $res->contact : "";

				$resultArray[][] = $res;

			}

		}

	// $obj_merged = (object) array_merge((array) $resObj2, (array) $resultArray);
	// print_r($resultArray);exit;
//////////////////////////////////////////1-first phase//////////////////////////////////////////////	
$responsible_id= isset($_REQUEST['user_id'])? $_REQUEST['user_id']:"";

if(isset($responsible_id) && $responsible_id !=""){

	$resObj1 = $controller->listTasksAssignToMe($responsible_id);
	// print_r($resObj1);exit;
	$resultArray2="";//must be define
	
	if(!empty($resObj1)){

		foreach($resObj1 as $key =>$res){
			///---///
			// echo $res->assign_id,$res->responsible_id;
			// exit;
			if($res->assign_id != $res->responsible_id){
				$resObj2 = $controller->listTasksAssignToMeByUser($res->responsible_id,$res->assign_id);
				// print_r($resObj2);

				$count_multi = sizeof($resObj2);

				// exit;
				if(!empty($resObj2) && $count_multi>1 ){ //multiple

					$reminder_task_m = 0;
					$due_task_m = 0;
						
					foreach($resObj2 as $key2 =>$res2){
						// echo "assigner-".$res2->assign_id;
						// echo "<br/>responsible-".$res2->responsible_id;
						////if($res2->assign_id != $res2->responsible_id){
						$today = time();
						
						$rem_date1=($res2->rem_date1!='0000-00-00 00:00:00') ? strtotime($res2->rem_date1) : "";
						$rem_date2=($res2->rem_date2!='0000-00-00 00:00:00') ? strtotime($res2->rem_date2) : "";
						$rem_date3=($res2->rem_date3!='0000-00-00 00:00:00') ? strtotime($res2->rem_date3) : "";
						$rem_date4=($res2->rem_date4!='0000-00-00 00:00:00') ? strtotime($res2->rem_date4) : "";
						
						$due_date=($res2->due_date!='0000-00-00 00:00:00') ? strtotime($res2->due_date) : "";
						$assign_date=($res2->assign_date!='0000-00-00 00:00:00') ? strtotime($res2->assign_date) : "";

						if($due_date < $today ){
							$due_task_m++;
							$res2->is_due="1"; //keep this 
						}else{
							$res2->is_due="0"; //keep this 
						}
						
						// if(($res2->is_complete == 0) && (
						if($res2->is_due=="1"){
							$reminder_task_m++;
							$res2->is_reminded="1";
						}elseif(
							($rem_date1!="" && $rem_date1 < $today) ||
							($rem_date2!="" && $rem_date2 < $today) ||
							($rem_date3!="" && $rem_date3 < $today) ||
							($rem_date4!="" && $rem_date4 < $today)
						// ) && $due_date!="" && $due_date > $today ){
						){
							$reminder_task_m++;
							$res2->is_reminded="1"; //keep this 
						}else{
							$res2->is_reminded="0"; //keep this 
						}
						
						/* old code
						// if(($rem_date1 < $today && $rem_date2 < $today && $rem_date3 < $today && $rem_date4 < $today ) && $due_date > $today && ($res2->is_complete == 0)){
							
						if(//($res2->is_due == "0") &&($res2->is_complete == 0) && 
							($rem_date1 < $today) &&
							($rem_date2 < $today) &&
							($rem_date3 < $today) &&
							($rem_date4 < $today) ){
							
							$res2->is_passed_all_reminded="1"; //keep this 
						}else{
							$res2->is_passed_all_reminded="0"; //keep this 
						}*/
						if($res2->is_due=="1"){
							$res2->is_passed_all_reminded="1";
						}elseif($rem_date1 =="" && $rem_date2 =="" && $rem_date3 =="" && $rem_date4 =="" ){
							$res2->is_passed_all_reminded="0"; //keep this 
						}elseif(
							($rem_date1 !="" && $rem_date1 > $today) ||
							($rem_date2 !="" && $rem_date2 > $today) ||
							($rem_date3 !="" && $rem_date3 > $today) ||
							($rem_date4 !="" && $rem_date4 > $today) 
						){
							$res2->is_passed_all_reminded="0"; //keep this 
						}else{
							$res2->is_passed_all_reminded="1"; //keep this 
						}
						
						$res2->rem_date1 = ($rem_date1!="") ? date('Y-m-d H:i:s D' ,$rem_date1) : "";
						$res2->rem_date2 = ($rem_date2!="") ? date('Y-m-d H:i:s D' ,$rem_date2) : "";
						$res2->rem_date3 = ($rem_date3!="") ? date('Y-m-d H:i:s D' ,$rem_date3) : "";
						$res2->rem_date4 = ($rem_date4!="") ? date('Y-m-d H:i:s D' ,$rem_date4) : "";
						
						$res2->due_date = ($due_date!="") ? date('Y-m-d H:i:s D' ,$due_date) : "";
						$res2->assign_date = ($assign_date!="") ? date('Y-m-d H:i:s D' ,$assign_date) : "";
						// print_r($res2);exit;
						
						////}
					}
					/*
					$resultArray2[] =('assigner_name: '.$res->assigner_name .
									',total_task: '.$count_multi .
									',reminder_task: '.$reminder_task .
									',due_task: '.$due_task
					);*/
					
					$resultArray2[] =($res->assigner_name .
									' (assigner),'.$count_multi .
									','.$reminder_task_m .
									','.$due_task_m
					);
					

					$resultArray2[] = $resObj2;//something different ,it can access from foreach loop


				}else{ //Single Entry //responsible /assigned by
				////}elseif($res->assign_id != $res->responsible_id){ //Single Entry //responsible /assigned by
					
					
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
					
					if($due_date < $today ) {
						$res->is_due="1";
						$due_task++;
					}else{
						$res->is_due="0";
					}
					
					// if(($res->is_complete == 0) && $rem_date1!="" && $rem_date1 < $today && $due_date!="" && $due_date > $today ){
					// if(($res->is_complete == 0) && (
					if($res->is_due=="1"){
						$reminder_task++;
						$res->is_reminded="1";
					}elseif(
						($rem_date1!="" && $rem_date1 < $today) ||
						($rem_date2!="" && $rem_date2 < $today) ||
						($rem_date3!="" && $rem_date3 < $today) ||
						($rem_date4!="" && $rem_date4 < $today)
					// ) && $due_date!="" && $due_date > $today ){ //due date consider for rem date
					){
						$reminder_task++;
						$res->is_reminded="1";
					}else{
						$res->is_reminded="0";
					}

					
					// if(($rem_date1 < $today && $rem_date2 < $today && $rem_date3 < $today && $rem_date4 < $today ) && $due_date > $today && ($res->is_complete == 0)){
						// $res->is_passed_all_reminded="1"; //keep this
					// }
					
					/* old code
					if(//($res->is_due == "0") && ($res->is_complete == 0) && 
						($rem_date1 < $today) &&
						($rem_date2 < $today) &&
						($rem_date3 < $today) &&
						($rem_date4 < $today) ){
						
						$res->is_passed_all_reminded="1"; //keep this 
					}else{
						$res->is_passed_all_reminded="0"; //keep this 
					} */
					
					if($res->is_due=="1"){
						$res->is_passed_all_reminded="1";
					}elseif($rem_date1 =="" && $rem_date2 =="" && $rem_date3 =="" && $rem_date4 =="" ){
						$res->is_passed_all_reminded="0"; //keep this 
					}elseif(
						($rem_date1 !="" && $rem_date1 > $today) ||
						($rem_date2 !="" && $rem_date2 > $today) ||
						($rem_date3 !="" && $rem_date3 > $today) ||
						($rem_date4 !="" && $rem_date4 > $today) 
					){
						$res->is_passed_all_reminded="0"; //keep this 
					}else{
						$res->is_passed_all_reminded="1"; //keep this 
					}

					/*
					$resultArray2[] =('assigner_name: '.$res->assigner_name .
									',total_task: '.$count_multi .
									',reminder_task: '.$reminder_task .
									',due_task: '.$due_task
					);*/
					
					$resultArray2[] =($res->assigner_name .
									' (assigner),'.$count_multi .
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
					// $res->assign_date  = ($assign_date!="") ? date('d-m-Y h:i A D' ,strtotime($res->assign_date)) : "";
					// 12-15-2015 2:20 PM Tue
					$resultArray2[][] = $res;

				}
			}
		}
	}
}
	
	// $resultArray2="";
	// $obj_merged =  array_merge((array) $resultArray, (array) $resultArray3);
	
	if(!empty($resultArray) && $resultArray !="" && !empty($resultArray2) && $resultArray2 !="" ){
		$obj_merged =  array_merge((array) $resultArray, (array) $resultArray2);
	}elseif(!empty($resultArray) && $resultArray !=""){
		$obj_merged =  $resultArray;
	}elseif(!empty($resultArray2) && $resultArray2 !=""){
		$obj_merged =  $resultArray2;
	}else{
		$obj_merged="";
	}

	// $obj_merged= array_unique($obj_merged);

	if(!empty($obj_merged) && $obj_merged !=array("","")){
		$arr_result = array(RESULT => SUCCESS,
							MESSAGE => "List all Tasks of user..!",
							DATA => $obj_merged);
	}else{
		$arr_result = array(RESULT => FAILED,
							MESSAGE => "No Tasks Found..!",
							DATA => "");
	}
	
	$json = json_encode($arr_result);
	echo  preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $json); // remove null values
	// echo   preg_replace("/null/", '""', $json);
	exit;

}else{

	$arr_result = array(RESULT => FAILED,
						MESSAGE => "Please provide the data.",
						DATA => "");

	echo json_encode($arr_result);
    exit;

}


?>