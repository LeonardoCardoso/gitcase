<?php
include("statics/cookies.php");
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/js.cookie.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
          rel="stylesheet" type="text/css">
    <link href="http://leocardz.com/util/assets/images/favicon.png" rel="shortcut icon"
          type="image/x-icon">
    <link href="http://leocardz.com/util/assets/images/favicon.png" rel="apple-touch-icon"
          type="image/x-icon">
    <link href="http://leocardz.com/util/assets/images/favicon.png" rel="shortcut icon"
          type="image/x-icon">
    <link rel="apple-touch-startup-image" href="http://leocardz.com/util/assets/images/leocardz.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#f5f5f5">
    <title>gitcase - leocardz.com</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/adapt.css">
    <script src="js/gitcase.js"></script>
    <script>
        $(document).ready(function () {
            $("#download").gitcase({action: "download"});
            $("#oauth").gitcase({action: "request"});
            $("#generate").gitcase({action: "generate"});
        });
    </script>
    <title></title>
</head>
<body>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="http://leocardz.com/" target="_blank">
                    <img src="http://leocardz.com/utils/assets/img/leocardz-small.png" class="center-block img-responsive">
                </a>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Share your complete GitHub contribution graph
                    <br>
                </h3>
            </div>
        </div>
    </div>
</div>

<?php
if (!isset($_COOKIE[$access_token])) {
    ?>

    <div class="section">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-lg btn-primary" id="oauth">allow gitcase&nbsp;<i
                            class="fa fa-github fa-fw"><br></i></a>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    ?>

    <div class="section">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-lg btn-primary" id="download">
                        download and share&nbsp;<i class="fa hub fa-fw fa-download"><br></i>
                    </a>

                    <a class="btn btn-lg btn-primary" id="generate">
                        generate&nbsp;<i class="fa hub fa-fw fa-bar-chart"><br></i>
                    </a>

                    <a class="btn btn-lg btn-primary" href="github/invalidate.php">
                        logout&nbsp;<i class="fa hub fa-fw fa-power-off"><br></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>

<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center" id="currentRepo">
                    <br>
                </h3>
            </div>
        </div>
    </div>
</div>

<img id="finalResult" class="center img-responsive">
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="images/octocat-spinner-smil.min.svg" id="octal" class="center-block img-responsive">
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <iframe
                    src="https://ghbtns.com/github-btn.html?user=leonardocardoso&amp;repo=gitcase&amp;type=star&amp;count=true&amp;size=large"
                    frameborder="0" scrolling="0" width="160px" height="30px"></iframe>
                <iframe
                    src="https://ghbtns.com/github-btn.html?user=leonardocardoso&amp;repo=gitcase&amp;type=fork&amp;count=true&amp;size=large"
                    frameborder="0" scrolling="0" width="160px" height="30px"></iframe>
            </div>
            <div class="col-md-12 text-center">
                <a href="https://twitter.com/theleocardz" class="twitter-follow-button" data-show-count="true"
                   data-size="large">Follow @theleocardz</a>
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://gitcase.leocardz.com/"
                   data-text="Share your complete GitHub contribution graph" data-via="theleocardz" data-size="large"
                   data-hashtags="gitcase,git,github">Tweet</a>
                <script>!function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = p + '://platform.twitter.com/widgets.js';
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }(document, 'script', 'twitter-wjs');</script>
            </div>
        </div>
    </div>
</div>
</body>
</html>