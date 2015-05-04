<?php
/**
 * Created by PhpStorm.
 * User: leocardz
 * Date: 04/05/15
 * Time: 15:36
 */

include("../statics/urls.php");

echo json_encode(array("url" => $authorize_url));