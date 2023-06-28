<?php
include_once 'header.php';
include 'db_connection.php';
include_once 'UserController.php';


// Insert a student
// die("reached the script");
// var_dump($_SERVER['REQUEST_URI']);

$url ='/Registration/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === $url.'insert-user') {
        
    // redirect to controller 
    $userController =new UserController();
    $userController->insertAUser();    
    
}

// Select a specific student. use  var_dump($_SERVER['REQUEST_URI']);
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/Registration\/select-user\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    
    $studentId = $matches[1];
    
    $userController =new UserController();
    $userController->getAUser($studentId);   

    exit;
}


// Select all students
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === $url.'select-all-users') {
    
    $userController =new UserController();
    $userController->getAllUsers();    
    
}

// delete a specific student. use  var_dump($_SERVER['REQUEST_URI']);
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/Registration\/delete-user\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    
    $studentId = $matches[1];
    
    $userController =new UserController();
    $userController->deleteAUser($studentId);   

    exit;
}

       
