<?php

//Adding time to the database time ie to insert time //
  include('olivrweb/includes/config.php'); 
  error_reporting(0);
  $date= date('Y_m_d_H_i_s');
header('Content-Type: application/csv');
$link = 'https://theroundrectangle.com/olivr_events/VivoMagicMirror/olivrweb/user/';
header('Content-Disposition: attachment; filename="UsersDetails"'.$date.'".csv"');
$qry=mysqli_query($mysqli_user,"Select `id`, `name` , `gender`, `aiimage` , `insert_time` from `user` where `id` between '1' and  '179'");
// $qry = "Select * from user where  DATE(timestamp) > (now() - INTERVAL 6 day)";
// $qry=mysqli_query($mysqli_user,"SELECT * FROM user WHERE timestamp BETWEEN '2023-08-29' AND '2023-09-05 12:00'");
// $qry=mysqli_query($mysqli_user,"SELECT * FROM user where image like 'Mumbai%'");
// $qry=mysqli_query($mysqli_user,"Select * from user where  DATE(timestamp) > (now() - INTERVAL 8 day)");

// $qry=mysqli_query($mysqli_user,"SELECT * FROM user WHERE timestamp='2023-08-29'");
$data='';
while($row = mysqli_fetch_array($qry)) {
    // $row[3] = preg_replace('/\r|\n/','', $row[3]);
    // date('Y-m-d H:i:s', strtotime($row[4]. ' + 5 hours'));
    $row[3] =  'https://theroundrectangle.com/olivr_events/VivoMagicMirror/olivrweb/user/'.$row[3];
    $row[4] = date('Y-m-d H:i:s', strtotime($row[4]. ' + 5 hours 30 minutes'));
    // $x=strtotime($row[4]);
    // $row[3] = $link.$row[3];
    
    // Date(strtotime($row[4]))
  $data .= $row[0].",".$row[1].",".$row[2].",".$row[3].",".$row[4].","."\n";
}
echo $data;
 exit();
?>