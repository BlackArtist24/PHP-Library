<?php
include "../includes/config.php";
include "../includes/functions.php";

$response = array();
$current_time = date("Y-m-d H:i:s");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username     =  mysqli_real_escape_string($mysqli_user,trim(isset($_POST['username']))) ? mysqli_real_escape_string($mysqli_user,trim($_POST['username'])) :'';
	$password     =  mysqli_real_escape_string($mysqli_user,trim(isset($_POST['password']))) ? mysqli_real_escape_string($mysqli_user,trim($_POST['password'])) :'';
	$type     =  mysqli_real_escape_string($mysqli_user,trim(isset($_POST['type']))) ? mysqli_real_escape_string($mysqli_user,trim($_POST['type'])) :'';
	
	if($username == '' || $username == null)
    {
        $response['status']=false;
        $response['message']="Please enter your username.";
        $response['admindata'] = array();
    }
	else if($password == '' || $password == null)
    {
        $response['status']=false;
        $response['message']="Please enter your password.";
        $response['admindata'] = array();
    }
    else
    {
        //Email Check
		$exhibitor = mysqli_query($mysqli_user, "SELECT * from admin where username = '$username' and password = '$password'");
		if(mysqli_num_rows($exhibitor)>0){
			$row=mysqli_fetch_assoc($exhibitor);
			$response['status']=true;
			$response['message']="";
			$response['admindata']=$row;
		}else{
			$response['status']=false;
			$response['message']="Login failed";
			$response['admindata'] = array();
		}
    }
}
else
{
	header("HTTP/1.0 404 Not Found");
	die;
}

echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);



?>


