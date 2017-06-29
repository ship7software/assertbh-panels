<?php
$base = $_GET['file'];
$file = '/home/assertbh/public_html/uploads/'.$base;
$baseName = basename($base);
$type = pathinfo($file, PATHINFO_EXTENSION);

if(!file_exists($file)){ // file does not exist
    die('file not found');
} else {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$baseName");
    header("Content-Type: ".$type);
    header("Content-Transfer-Encoding: binary");

    // read the file from disk
    readfile($file);
}
?>