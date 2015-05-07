<?php
/**
 * Created by PhpStorm.
 * User: leocardz
 * Date: 04/05/15
 * Time: 15:36
 */

include("../statics/urls.php");
include("../statics/cookies.php");

if ($_GET["type"] === "authorize") {
    echo json_encode(array("url" => $authorize_url));
} else if ($_GET["type"] === "issues") {
    echo json_encode(array("url" => $issues));
} else if ($_GET["type"] === "user") {
    echo json_encode(array("url" => $user, "repos_url" => $repos));
}