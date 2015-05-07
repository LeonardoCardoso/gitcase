<?php
/**
 * Created by PhpStorm.
 * User: leocardz
 * Date: 06/05/15
 * Time: 23:09
 */

$file = $_POST["file"];

list($type, $data) = explode(';', $file);
list(, $data) = explode(',', $data);
$data = base64_decode($data);

$name = uniqid(time());
$file = 'images/' . $name . '.png';
$success = file_put_contents($file, $data);
chmod($file, 0777);

echo json_encode(array("name" => $name));