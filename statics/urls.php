<?php
/**
 * Created by PhpStorm.
 * User: leocardz
 * Date: 05/05/15
 * Time: 02:44
 */

include("credentials.php");

$base = "http://api.github.com";

$token_url = "https://github.com/login/oauth/access_token";

$authorize_url = "https://github.com/login/oauth/authorize";
$authorize_url .= "?client_id=".$clientID;
$authorize_url .= "&redirect_uri=".$callbackURL;
$authorize_url .= "&scope=user,public_repo,repo";

$repos = $base . "/user/repos";

$user = $base . "/user";

$issues = $base . "/user/issues";