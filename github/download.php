<?php
/**
 * Created by PhpStorm.
 * User: leocardz
 * Date: 06/05/15
 * Time: 23:17
 */

ignore_user_abort(true);

$file = $_GET["file"];
$file = 'images/' . $file . '.png';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
//    unlink($file);
}