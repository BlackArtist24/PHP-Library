<?php
include '../includes/config.php';
$get_image = "SELECT `id`,`uid`,`name`,`user_image`,`qr_image`,`insert_time`,`update_time` from `user` order by `id` desc";
$get_image_data = mysqli_query($mysqli_user,$get_image);
if(mysqli_num_rows($get_image_data) > 0){
    while($row  = mysqli_fetch_assoc($get_image_data)){
        $image_data[] = array('S_No'=>$row['id'],'User_Id'=>$row['uid'],'Name'=>$row['name'],'User_Image'=>$GLOBALS['AppConfig']['HomeURL'].'olivrweb/user/'.$row['user_image'],'Qr_Image'=>$GLOBALS['AppConfig']['HomeURL'].'olivrweb/user/'.$row['qr_image'],'Insert_Time'=>$row['insert_time'],'Update_Time'=>$row['update_time']);
    }
    $response=array('status'=>true,"message"=>"Success.","imagedata"=> $image_data);
}
else{
    $response=array('status'=>false,"message"=>"No data found.");
}
echo json_encode($response);     


?>