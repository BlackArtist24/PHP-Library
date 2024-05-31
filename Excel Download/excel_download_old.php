<?php
  include('olivrweb/includes/config.php'); 
  error_reporting(0);
  $date= date('Y_m_d_H_i_s');
header('Content-Type: application/csv');
$link = 'https://theroundrectangle.com/olivr_events/VivoMagicMirror/olivrweb/user/';
header('Content-Disposition: attachment; filename="UsersDetails"'.$date.'".csv"');
$qry=mysqli_query($mysqli_user,"SELECT `id` , `name` , `code` , `mobile` , `scene` , `email` , `video` , `insert_time` from `user` ");
// print_r(mysqli_fetch_assoc($qry));
// die;

$data="Id".","."Name".","."Code".","."Mobile".","."Scene".","."Email".","."Video".","."Insert Time".","."\n";
while($row = mysqli_fetch_array($qry)) {
    // $row[3] = preg_replace('/\r|\n/','', $row[3]);
    // date('Y-m-d H:i:s', strtotime($row[4]. ' + 5 hours'));
    // $row[4] =  'https://theroundrectangle.com/olivr_events/Intel/olivrweb/user/'.$row[4];
    // $row[5] =  'https://theroundrectangle.com/olivr_events/Intel/olivrweb/user/'.$row[5];
    // Date(strtotime($row[4]))
  $data .= $row[0].",".$row[1].",".$row[2].",".$row[3].",".$row[4].",".$row[5].",".$row[6].",".$row[7].","."\n";
}
echo $data;
 exit();
?>