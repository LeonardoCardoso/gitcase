<?php
/**
 * Created by PhpStorm.
 * User: leocardz
 * Date: 05/05/15
 * Time: 14:20
 */

include("../statics/urls.php");
include("../statics/cookies.php");

setcookie($access_token, NULL, -1, "/");
header("Location: http://gitcase.leocardz.com");