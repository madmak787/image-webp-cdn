<?php
require 'functions.php';
require 'htaccess.php';

if(isset($_FILES['file']) && $_FILES['file']['error']==0) {
    $imagePath = $_FILES['file']['tmp_name'];
    $outputDir = './uploads';
    $webpPath = convertToWebP($imagePath, $outputDir);

    echo $webpPath;
} else {
    $filename = str_replace('php','webp',$_SERVER['SCRIPT_FILENAME']);
    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $file = str_replace(URL, '', $actual_link);

    $image_info = getimagesize($file);

    //Set the content-type header as appropriate
    header('Content-Type: ' . $image_info['mime']);
    //Set the content-length header
    header('Content-Length: ' . filesize($file));
    //Write the image bytes to the client
    readfile($file);
    exit;
}
