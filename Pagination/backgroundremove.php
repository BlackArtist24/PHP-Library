<?php
include "../includes/config.php";
include "../includes/functions.php";
require '/var/www/html/olivr_events/atthahwpp/guzzle/vendor/autoload.php';

$response = array();
$current_time = date("Y-m-d H:i:s");

if($_SERVER["REQUEST_METHOD"] == "POST")
{

	$image	=  mysqli_real_escape_string($mysqli_user,trim(isset($_POST['image']))) ? mysqli_real_escape_string($mysqli_user,trim($_POST['image'])) :'';
	
	if($image == '' || $image == null)
    {
        $response['status']=false;
        $response['message']="Image parameter missing.";
        $response['data'] = array();
    }
	else
	{
		$client = new GuzzleHttp\Client();
		$res = $client->post('https://api.remove.bg/v1.0/removebg', [
			'multipart' => [
				[
					'name'     => 'image_file_b64',
					'contents' => $image
				],
				[
					'name'     => 'size',
					'contents' => 'auto'
				]
			],
			'headers' => [
				'X-Api-Key' => 'f9YkbPzCiGbAahZ3turGfhCJ'
			]
		]);
		
		$path = "transparent";
		$filename = rand(1000,9999) . "_" . date("Ymd_His") . ".png";
		$filepath = $path . DIRECTORY_SEPARATOR . $filename;
			
		$fileURL = $filepath;
		
		$fp = fopen($filepath, "wb");
		fwrite($fp, $res->getBody());
		fclose($fp);
		
		// $photo_data = array('fileURL'=>$fileURL);
		
		$response['status']=true;
        $response['message']="Image parameter missing.";
        $response['url'] = $fileURL;
	}
}
else
{
	header("HTTP/1.0 404 Not Found");
	die;
}

echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>


