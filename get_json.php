<?php

// http://localhost/tasktracker/webservice/get_json.php?res={"ProfileEditId":"917","ContactsEmail":[{"Email":"email@yahoo.com","ContactId":"9992347930"}],"ContactsPhone":[{"CountryId":"+1","Type":"2","Phone":"345345"}],"ProfileId":"290","LastName":"demo","GroupId":"1212","Title":"tasktracker","City":"Rajkot","TemplateId":"1212","State":"Gujarat","AuthCode":"9bcc6f63-2050-4c5b-ba44-b8103fbc377a","Address":"address","FirstName":"demo","ContactId":"","Zip":"23","Company":"tv"}

// http://www.criticalpath.pro/TaskTracker/webservice/get_json.php?res={"ProfileEditId":"917","ContactsEmail":[{"Email":"email@yahoo.com","ContactId":"9992347930"}],"ContactsPhone":[{"CountryId":"+1","Type":"2","Phone":"345345"}],"ProfileId":"290","LastName":"demo","GroupId":"1212","Title":"tasktracker","City":"Rajkot","TemplateId":"1212","State":"Gujarat","AuthCode":"9bcc6f63-2050-4c5b-ba44-b8103fbc377a","Address":"address","FirstName":"demo","ContactId":"","Zip":"23","Company":"tv"}




// print_r($_REQUEST);
$res = $_REQUEST['res'];

$arr = json_decode($res, true);

// print_r($arr['ProfileEditId']);
print_r($arr);
echo json_encode($res);

?>