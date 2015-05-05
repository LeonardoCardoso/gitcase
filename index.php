<?php
    include ("statics/cookies.php");
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/gitcase.js"></script>
    <script>
        $(document).ready(function () {
            $("#oauth").gitcase({action: "request"});
            $("#graph").gitcase({action: "generate"});
        });
    </script>
    <title></title>
</head>
<body>

<?php
    if (!isset($_COOKIE[$access_token])) {
?>

    <button id="oauth">Sign In</button>

<?php
    } else {
?>

    <button id="graph">Generate</button>

<?php
    }
?>

</body>
</html>