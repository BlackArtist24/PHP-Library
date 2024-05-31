<?php

namespace ETLAB;

$obj = new Api();
$urlParams = explode('/', $_SERVER['REQUEST_URI']);
$functionName = end($urlParams);
if (method_exists($obj, $functionName)) {
    $obj->$functionName();
} else {
    echo json_encode(array('status' => false, 'message' => 'Invalid url.'));
}

class Api
{
    public $mysqli_user;
    public $current_time;
    public $current_time_underscore;
    public $url;
    public function __construct()
    {
        include('../includes/config.php');
        include('../includes/Cdn.php');
        include "../includes/functions.php";

        // $t = date('H');
        // echo $t;
        $this->mysqli_user = $mysqli_user;
        $this->current_time = date("Y-m-d H:i:s");
        // $this->current_time_underscore = date("Y_m_d_H_i_s");
        $this->url = $GLOBALS['AppConfig']['SecureURL'];
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("HTTP/1.0 404 Not Found");
            die;
        }
    }

    public function __destruct()
    {
        $this->mysqli_user->close();
    }


    public function setuser(){
        $name = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['name']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['name'])) : '';
        $mobile = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['mobile']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['mobile'])) : '';
        $email = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['email']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['email'])) : '';


        if($name == '' || $name == null){
            $response = array('status' => false, "message" => "Please enter your name");
        }elseif (!preg_match('/^[\p{L} ]+$/u', $name)){
            $response = array('status' => false, "message" => "Please enter valid name");
        }elseif ($mobile == '' || $mobile == null){
            $response = array('status' => false, "message" => "Please enter your mobile number");
        }elseif (strlen($mobile)!=10){
            $response = array('status' => false, "message" => "Please enter valid mobile number");
        }elseif ($email == '' || $email == null){
            $response = array('status' => false, "message" => "Please enter your email");
        }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $response = array('status' => false, "message" => "Please enter valid email");
        }else{
            $insertUser = mysqli_query($this->mysqli_user, "Insert into user(name,mobile,email,status,insert_time) values('$name','$mobile','$email','0','$this->current_time')");
            if($insertUser){
                $insertUserId= $this->mysqli_user->insert_id;
                $userData=DBS::ExecuteScalarRow('select * from user where id=?',[$insertUserId]);
                $response =array('status'=>true, "message" =>"User registered successfully.", 'user'=>$userData);
            }else{
                $response =array('status' => false, "message" => "Unable to add at this moment.");
            }
        }
        echo json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    
    public function getUser(){
        $getLatestuser = mysqli_query($this->mysqli_user, "SELECT * FROM user where status='0' order by id desc limit 1 ");
        if (mysqli_num_rows($getLatestuser) > 0) {
            $data = mysqli_fetch_assoc($getLatestuser);
            $response = array('status' => true, 'message' => "User Data Found", 'user' => $data);
        } else {
            $response = array('status' => false, 'message' => "No Data Found");
        }
        echo json_encode($response);
    }

    public function setVideo(){
        $uid = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['id']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['id'])) : '';
        $name = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['name']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['name'])) : '';
        $mobile = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['mobile']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['mobile'])) : '';
        $email = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['email']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['email'])) : '';
        $code = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['code']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['code'])) : '';
        $scene = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['scene']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['scene'])) : '';
        // $file = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['file']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['file'])) : '';
        
        if($uid == '' || $uid == null){
            $response = array('status' => false, "message" => "Please enter your user id");
        }elseif($code == '' || $code == null){
            $response = array('status' => false, "message" => "Please enter your code");
        }elseif($email == '' || $email == null){
            $response = array('status' => false, "message" => "Please enter your email");
        }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $response = array('status' => false, "message" => "Please enter your valid email id");
        }else{
            if(isset($_FILES["video"]["size"]) && $_FILES["video"]["size"]>0){
                if($GLOBALS['AppConfig']['IsCdn']){
                    $x=CdnUpload($_FILES, "video", $GLOBALS['AppConfig']['CdnUploadDir']."video/","video/");  //Cdn Includes Function
                    if($x){
                        // echo $GLOBALS['AppConfig']['CdnUploadURL'].$x['dbPath'];
                        // echo $file;
                        $subject ="The new Hyundai CRETA. Undisputed. Ultimate. | First ever 4D billboard experience";
                        $video = $GLOBALS['AppConfig']['CdnUploadURL'].$x['dbPath'];
                        $this->sendVideoOnMail($name,$email,$subject,$x['dbPath'],$code);
                        mysqli_query($this->mysqli_user,"Insert into user(uid,name,code,mobile,scene,email,video,insert_time) values('$uid','$name','$code','$mobile','$scene','$email','$video','$this->current_time')");
                        // $this->sendVideoOnMail($name,$email,"Thank You",$GLOBALS['AppConfig']['HomeURL'].'/olivrweb/user/'.$dbPath_Video,$code);
                        // 'qrurl'=>$GLOBALS['AppConfig']['HomeURL'].'/olivrweb/user/'."i.php?u=".$dbPath_Video
                        $response = array('status'=>true,'message'=>'Video Upload Success.','path'=>$GLOBALS['AppConfig']['CdnUploadURL'].$x['dbPath']);
                    }else{
                        $response=array('status'=>false,'message'=>'Some error occurred!.');
                    }
                }else{
                    $response=array('status'=>false,'message'=>'Unable to upload at cdn!.');
                }
            }else{
                $response=array('status'=>false,'message'=>'Video not found!.');
            }
        }
        echo json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function sendVideoOnMail($name,$email,$subject,$link,$code){
        if($name==""){
            $name="user";
        }
        
        

        // if($email=="raj@atthah.com"){
        //     $link = $GLOBALS['AppConfig']['HomeURL']."/download.html?v=". $GLOBALS['AppConfig']['CdnUploadURL'].$link;
        //     $body="<table cellpadding='0' cellspacing='0' width='100%'>
        //             <tr>
        //                 <td style='font-family: Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif; font-size: 14px; color:#000; line-height: 22px;'>
        //                 Dear ".$name.",<br><br>
        //                 Thank you for being part of the first ever 4D billboard experience featuring 'The new Hyundai CRETA'. Undisputed. Ultimate.<br><br>
        //                 We trust you had an exhilarating time. We've stitched your experience into a personalized reel as a souvenir from our end. We invite you to share this memorable moment on your social media handles using the hashtag #FansofHyundai #NewHyundaiCRETA while tagging the Hyundai India official page @hyundaiindia.<br><br>
        //                 Feel free to view and save the video snippet from the following link: [<a href=".$link." style='color:blue'><b>Click to download!</b></a>]<br><br>
        //                 Kindly extend your recommendation to family and friends, promising them an unmatched and unequivocally exceptional experience.<br><br>
        //                 To enjoy this unparalleled experience one more time, kindly note your registration ID ".$code.".<br><br>

        //                 Best Regards,<br>
        //                 Hyundai Motor India Ltd.
        //                 </td>
        //             </tr>
        //         </table>";
        // }else{
            $link = $GLOBALS['AppConfig']['CdnUploadURL'].$link;
            $body="<table cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td style='font-family: Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif; font-size: 14px; color:#000; line-height: 22px;'>
                            Dear ".$name.",<br><br>
                            Thank you for being part of the first ever 4D billboard experience featuring 'The new Hyundai CRETA'. Undisputed. Ultimate.<br><br>
                            We trust you had an exhilarating time. We've stitched your experience into a personalized reel as a souvenir from our end. We invite you to share this memorable moment on your social media handles using the hashtag #FansofHyundai #NewHyundaiCRETA while tagging the Hyundai India official page @hyundaiindia.<br><br>
                            Feel free to view and save the video snippet from the following link: [<a href=".$link." style='color:blue'><b>Click to download!</b></a>]<br><br>
                            Kindly extend your recommendation to family and friends, promising them an unmatched and unequivocally exceptional experience.<br><br>
                            To enjoy this unparalleled experience one more time, kindly note your registration ID ".$code.".<br><br>

                            Best Regards,<br>
                            Hyundai Motor India Ltd.
                            </td>
                        </tr>
                    </table>";
        // }
        
        Mails::DoEmail($name, $email ,$subject, $body);
        // Mails::DoEmail($name, $email ,$subject, $body, $link);
    }


    
}
