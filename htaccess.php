<?php
$path = PATH.'.htaccess';
$extentions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp', 'svg', 'heif', 'heic', 'ico', 'raw', 'dng', 'jfif', 'apng'];

$sites = ['khanamir.me'];

$new = "RewriteEngine on\n";
$new .= "\n### Redirect image requests to php file ###";
$new .= "\n";

foreach($extentions as $ext) {
    $new .= "RewriteRule ^(.+)\.$ext$ index.php [L]\n";
    $new .= "RewriteRule ^(.+)\.".strtoupper($ext)."$ index.php [L]\n";
}

/*
$new .= "\n### Allowed only whitelisted domains ###";
$new .= "\n";
$new .= "order allow,deny\n";
$new .= "# deny from all\n";
$new .= "allow from 127.0.0.1\n";
foreach($sites as $allowed) {
    $ip = getAddresses_www($allowed);
    if(!empty($ip[0])) {
        $new .= "allow from $ip[0]\n";
    }
}
*/

if(!file_exists($path)) {
    $file = fopen($path, 'w');
    fclose($file);
}

$file = fopen($path, "r+");

$old = '';
while(! feof($file)) {
    $line = fgets($file);
    $old .= $line;
}

if($old!=$new) {
    fclose($file);
    $file = fopen($path, "w+");
    fwrite($file, $new);
    // echo "\nUpdated";
} else {
    // echo "\nNot Updated";
}

fclose($file);
