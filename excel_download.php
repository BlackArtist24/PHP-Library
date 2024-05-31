<?php
  include('config.php'); 
  error_reporting(0);
  $date= date('Y_m_d_H_i_s');
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="UsersDetails"'.$date.'".csv"');
$qry=mysqli_query($mysqli_user,"Select * from user where  DATE(timestamp) > (now() - INTERVAL 6 day)");
// $qry = "Select * from user where  DATE(timestamp) > (now() - INTERVAL 6 day)";
// $qry=mysqli_query($mysqli_user,"SELECT * FROM user WHERE timestamp BETWEEN '2023-08-29' AND '2023-09-05 12:00'");
// $qry=mysqli_query($mysqli_user,"SELECT * FROM user where image like 'Mumbai%'");
// $qry=mysqli_query($mysqli_user,"Select * from user where  DATE(timestamp) > (now() - INTERVAL 8 day)");

// $qry=mysqli_query($mysqli_user,"SELECT * FROM user WHERE timestamp='2023-08-29'");
$data='';
while($row = mysqli_fetch_array($qry)) {
    $row[3] = preg_replace('/\r|\n/','', $row[3]);
  $data .= $row[0].",".$row[1].",".$row[2].",".$row[3].",".$row[4].","."\n";
}
echo $data;
 exit();
?>