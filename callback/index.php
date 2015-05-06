<?php
/**
 * Created by PhpStorm.
 * User: leocardz
 * Date: 05/05/15
 * Time: 01:49
 */

include("../statics/urls.php");
include("../statics/cookies.php");

$url = $token_url;
$data = array(
    'client_id' => $clientID,
    'client_secret' => $clientSecret,
    'code' => $_GET["code"],
    'redirect_uri' => $callbackURL
);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ),
);
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$split = explode("&", $result);

foreach ($split as $str) {
    if (strpos($str, "access_token=") !== false) {
        $cookie_value = str_replace("access_token=", "", $str);
        setcookie($access_token, $cookie_value, time() + (86400 * 30) * 365, "/");
    }
}

header("Location: http://gitcase.leocardz.com");