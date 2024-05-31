<?php
namespace ETLAB;
$obj = new Api();
$urlParams = explode('/', $_SERVER['REQUEST_URI']);
$functionName = end($urlParams);
if(method_exists($obj, $functionName)){
    $obj->$functionName();
}else{
    echo json_encode(array('status'=>false,'message'=>'Invalid url.'));  
}
class Api {
    public $mysqli_user;
    public function __construct()
    {
        // error_reporting(0);
        include 'config.php'; 
        // include "../includes/functions.php";
        $this->mysqli_user=$conn;
        // $conn=$conn;
        // $this->current_time = date("Y-m-d H:i:s");
        // if($_SERVER["REQUEST_METHOD"] != "POST")
        {
            // header("HTTP/1.0 404 Not Found");
	        // die;
        }
    }

    public function __destruct() {
        $this->mysqli_user->close();
    }

    public function get_image_information(){
        $get_image = "SELECT phone_model as mobile,user_image,generated_image,ai_image from information ";
        $get_image_data = mysqli_query($this->mysqli_user,$get_image);
        if(mysqli_num_rows($get_image_data) > 0)
        {
            while($row  = mysqli_fetch_assoc($get_image_data)){
                $image_data[] = array('phone_model'=>$row['mobile'],'user_image'=>$row['user_image'],'generated_image'=>$row['generated_image'],'ai_image'=>$row['ai_image']);
            }
            $response=array('status'=>true,"message"=>"Success.","imagedata"=> $image_data);
        }
        else
        {
            $response=array('status'=>false,"message"=>"No data found.");
        }
    echo json_encode($response);
    }
}
?>