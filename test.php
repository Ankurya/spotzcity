<?php
error_reporting(E_ALL & ~E_NOTICE);

$zip = new ZipArchive; 
 die('here'); 
// Zip File Name 
if ($zip->open('vendor.zip') === TRUE) { 
  
    // Unzip Path 
   // $zip->extractTo('/var/www/html'); 
   // $zip->close(); 
    echo 'Unzipped Process Successful!'; 
} else { 
    echo 'Unzipped Process failed'; 
} 

?>