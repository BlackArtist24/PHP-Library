<?php


// $_FILES["client_file1"]["type"];
// $_POST['target_age'];
if(isset($_FILES["image"]["type"]) ){
    $curl = curl_init();
    $cfile=new CURLFile($_FILES["image"]["tmp_name"],$_FILES["image"]["type"],$_FILES["image"]["name"]);
    $postRequest=array(
        'image'=>$cfile,
        'f'

        
    );
    // $data = array("firstname"=>  $_submit['firstname'],"lastname"=>  $SUBMIT['lastname'],"myimage"=>$cfile);
    $url = "http://localhost/Begin/Image_Upload/submit.php";
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS,$postRequest);

    $response = curl_exec($curl);
   print_r($response);



    // curl_setopt_array($curl, [
    //     CURLOPT_URL => "https://age-progression.p.rapidapi.com/huoshan/facebody/allagegeneration",
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_ENCODING => "",
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 30,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => "POST",
    //     CURLOPT_POSTFIELDS => "-----011000010111000001101001\r
    // Content-Disposition: form-data; name=\"image\"\r
    // \r$cfile
    // \r
    // -----011000010111000001101001\r
    // Content-Disposition: form-data; name=\"target_age\"\r
    // \r
    // 70\r
    // -----011000010111000001101001--\r
    // \r
    // ",
    //     CURLOPT_HTTPHEADER => [
    //         "X-RapidAPI-Host: age-progression.p.rapidapi.com",
    //         "X-RapidAPI-Key: 9227ebefe3msh284dcf9f32334f1p1afb05jsndac4aaed8c2f",
    //         "content-type: multipart/form-data; boundary=---011000010111000001101001"
    //     ],
    // ]);
}
?>

  
