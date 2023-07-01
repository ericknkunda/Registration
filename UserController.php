<?php
include_once 'db_connection.php';
$dbConnection  =$pdo;

class UserController{
    private $connection;
    public function __construct(){

        global $dbConnection;
        $this->connection =$dbConnection;

    }

    public function insertAUser(){
        $name = $_POST['user_name'];
        $email =$_POST['user_email'];
        $password = $_POST['password'];
        $password =md5($password);
        $priviledge = $_POST['priviledge'];

        $selectBefore ="SELECT * FROM table_web_users WHERE user_name = :user ";
        $selected =$this->connection->prepare($selectBefore);
        $selected->bindParam(':user', $name, PDO::PARAM_STR);
        $selected->execute();
    
        if($selected->rowCount() ==0){
            $insertQuery = "INSERT INTO table_web_users(user_name, user_email, user_password, user_priviledge) VALUES ('".$name."', '".$email."', '".$password."', '".$priviledge."')";
            $insert =$this->connection->prepare($insertQuery);
            $insert->execute();
        
            // Redirect to a success page or send a JSON response
            // Example:
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        }
        else{
            header('Content-Type: application/json');
            http_response_code(409);
            echo json_encode(['error'=>"Conflicting query/check if user does not exist"]);
            exit;
        }     
    }

    /**
     *
     * select a sinfle user
     */

    public function getAUser($userId){
        
        $selectQuery = "SELECT * FROM table_web_users WHERE user_id = :id";
        $result = $this->connection->prepare($selectQuery);

        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->execute();
    
        if ($result->rowCount() > 0) {
            
            $student = $result->fetchAll();
            

            // Return the student details as a response, either by rendering a template or sending a JSON response
            
            echo json_encode([$student],JSON_FORCE_OBJECT);
        } else {
            // Return a not found response
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['404'=>"Student with id $userId not found"]);
        }

    }

    /** 
     * 
     *  get all users
    */

    public function getAllUsers(){
        
        // Prepare and execute the select query
        
        // echo "Key ".$_REQUEST['requestkey'];
        $selectQuery = "SELECT * FROM table_web_users";
            $result = $this->connection->query($selectQuery);

            // Check if there are any students
            if ($result->rowCount() > 0) {
                
                $students = $result->fetchAll();            
                echo json_encode([$students], JSON_FORCE_OBJECT);
            }
            else{
                header('HTTp/1.0 404 Not found');
                echo json_encode(['404'=>'empty table']);
            }
    }

    /**
     * 
     * delete a specific user 
     */

    public function deleteAUser($userId){

        $deleteUser ="DELETE FROM table_web_users WHERE user_id = :id";
        $delete =$this->connection->prepare($deleteUser);

        $delete->bindParam(':id', $userId, PDO::PARAM_INT);
        $delete->execute();
        
        if($delete){
            header('HTTP/1.0 200 Deleted');
            echo json_encode(['200'=>"User $userId was deleted suceesfully"]);
        }else{
            header('HTTP/1.0 409 Cnflict');
            echo json_encode(['409'=>'User not deleted']);
        }
    }
}


?>