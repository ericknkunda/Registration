<?php
include_once 'header.php';
include 'db_connection.php';
include_once 'UserController.php';


// Insert a student
// die("reached the script");
var_dump($_SERVER['REQUEST_URI']);

$url ='/Registration/';

$explode =explode('?', $_SERVER['REQUEST_URI']);
$headers =getallheaders();

$myKey =array();
if(count($explode)>1){
    $myKey =$explode[1];
}
// print_r($explode);
// print_r($exploded);
// echo $myKey;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === $url.'insert-user') {
        
    // redirect to controller 
    $userController =new UserController();
    $userController->insertAUser();    
    
}

// Select a specific student. use  var_dump($_SERVER['REQUEST_URI']);
if(!empty($headers['x-api-key']) && $headers['requestkey']==="one"){

     if( $headers['x-api-key'] ==="one"){

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/Registration\/select-user\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
            //  print_r(getallheaders());
            
            // echo "Header ".$headers['x-api-key'];
            $studentId = $matches[1];
            
            $userController =new UserController();
            $userController->getAUser($studentId); 
        }else{
            http_response_code(404);
        }
     }
     else{

        header('http/1.0 403');
        echo json_encode(['403'=>'Forbidden']);            
        exit;
     }

}//else{

//     header('http/1.0 403');
//     echo json_encode(['403'=>'Forbidden']);            
//     exit;
// }

if(!empty($myKey) && $headers['requestkey']==="all"){
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === $url.'select-all-users?'.$myKey) {
        
            $userController =new UserController();
            $userController->getAllUsers(); 
        
    }
}else{
    header('http/1.0 401');
    echo json_encode(['401'=>'Unauthorized request. An api key is required']); 
    exit;
}

// delete a specific student. use  var_dump($_SERVER['REQUEST_URI']);
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/Registration\/delete-user\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    
    $studentId = $matches[1];
    
    $userController =new UserController();
    $userController->deleteAUser($studentId);   

    exit;
}

       
