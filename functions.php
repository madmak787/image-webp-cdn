<?php
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
const DIR = '/cdn/';

define( 'PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/') . DIR );
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]" . DIR;
define( 'URL', $actual_link );

function getAddresses($domain)
{
    $records = dns_get_record($domain);
    $res = array();
    foreach ($records as $r) {
        if ($r['host'] != $domain)
            continue; // glue entry
        if (!isset($r['type']))
            continue; // DNSSec

        if ($r['type'] == 'A')
            $res[] = $r['ip'];
        if ($r['type'] == 'AAAA')
            $res[] = $r['ipv6'];
    }
    return $res;
}

function getAddresses_www($domain)
{
    $res = getAddresses($domain);
    if (count($res) == 0) {
        $res = getAddresses('www.' . $domain);
    }
    return $res;
}

function customlog($message, $logFile = 'custom.log') {
    $timestamp = date('Y-m-d H:i:s');
    
    if (is_array($message)) {
        $message = json_encode($message, JSON_PRETTY_PRINT);
    } elseif (!is_string($message)) {
        $message = strval($message);
    }
    
    $logMessage = "$timestamp - $message\n";
    
    try {
        if (!file_exists($logFile)) {
            touch($logFile);
        }
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
    } catch (Exception $e) {
        error_log("Error logging to $logFile: " . $e->getMessage());
    }
}

// Example usage:
// customlog('This is a test log message');
// customlog(['key' => 'value', 'another_key' => 'another_value']);
// customlog(123); // Will be converted to string


function convertToWebP($imagePath, $outputDir)
{
    if($imagePath) {
        // Check if GD library is installed
        if (!extension_loaded('gd')) {
            customlog('GD library is not installed');
            throw new Exception('GD library is not installed');
        }

        // Get current timestamp
        $timestamp = time();

        // Extract year, month, and day from timestamp
        $year = date('Y', $timestamp);
        $month = date('m', $timestamp);
        $day = date('d', $timestamp);

        // Create full path for the day folder
        $dayFolder = $outputDir . '/' . $year . '/' . $month . '/' . $day;

        // Create day folder if it doesn't exist
        if (!is_dir($dayFolder)) {
            customlog($dayFolder);
            mkdir($dayFolder, 0755, true);
        }

        // Generate unique filename based on timestamp
        $randomName = substr(str_shuffle(str_repeat(date('YmdHis', $timestamp).'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(20 / 62))), 0, 20);
        $filename = $randomName . '.webp';

        // Full path for the WebP file
        $webpPath = $dayFolder . '/' . $filename;

        customlog($webpPath);

        // Convert image to WebP
        $quality = 90;
        $sourceImage = imagecreatefromstring(file_get_contents($imagePath));
        
        if ($sourceImage === false) {
            customlog('Failed to open source image');
            throw new Exception('Failed to open source image');
        }

        // Add resizing logic here
        list($width, $height) = getimagesize($imagePath);
        
        // Define maximum dimensions
        $maxWidth = 1920; // Adjust as needed
        $maxHeight = 1080; // Adjust as needed

        if ($width > $maxWidth || $height > $maxHeight) {
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = round($width * $ratio);
            $newHeight = round($height * $ratio);

            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            
            // Convert optimized image to WebP
            $webpImage = imagewebp($thumb, $webpPath, $quality);
        } else {
            // Convert original image to WebP
            $webpImage = imagewebp($sourceImage, $webpPath, $quality);
        }

        if ($webpImage === false) {
            customlog('Failed to create WebP image');
            throw new Exception('Failed to create WebP image');
        }

        imagedestroy($sourceImage);
        // imagedestroy($webpImage);

        return str_replace( '/./', '/', URL . $webpPath );
    } else {
        return false;
    }
}
