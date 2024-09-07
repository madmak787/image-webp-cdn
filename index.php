<?php
require 'db.php';
require 'functions.php';
require 'htaccess.php';

// echo "<pre>".print_r($_SERVER,true)."</pre>"; exit;

if(isset($_FILES['file']) && $_FILES['file']['error']==0) {
    $imagePath = $_FILES['file']['tmp_name'];
    $outputDir = './uploads';
    $webpPath = convertToWebP($imagePath, $outputDir);

    $data = [
		'name'=>$_FILES['file']['name'],
		'url'=>$webpPath,
		'created_at'=>time(),
		'last_accessed'=>time(),
		'domain'=>$_SERVER['HTTP_HOST'],
	];
	insert('images',$data);

    echo $webpPath;
} else {
    $accessed = empty($_GET['access'])?true:false;
    $filename = str_replace('php','webp',$_SERVER['SCRIPT_FILENAME']);
    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_link = str_replace('?access=false', '', $actual_link);
    $file = str_replace(URL, '', $actual_link);
    if(!empty($file)) {
        if($accessed===true) {
            $db_image = fetchWhere('images', "`url`='$actual_link'");
            if(isset($db_image[0])) {
                $data = [
                    'last_accessed'=>time(),
                ];
                update('images', $data, $db_image[0]['id']);
            }
        }
        $image_info = getimagesize($file);
        //Set the content-type header as appropriate
        header('Content-Type: ' . $image_info['mime']);
        //Set the content-length header
        header('Content-Length: ' . filesize($file));
        //Write the image bytes to the client
        readfile($file);
    } else {
        header("HTTP/1.0 404 Not Found");
        include 'error.php';
    }
    exit;
}
