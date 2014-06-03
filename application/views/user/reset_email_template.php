<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sandbox</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/favicon.ico">
    </head>
    <body>
        <div>
            <h3>Reset your password.</h3>
            <p>
                Please complete one of the following 2 steps.
            </p>
            <ol>
                <li>
                    Click the link below.<br/>
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/user/resetPassword/<?php echo $token; ?>" target="_blank" >Reset Password</a>
                </li>
                <li>
                    Copy the link and paste it into your browser.<br/>
                    http://<?php echo $_SERVER['HTTP_HOST']; ?>/user/resetPassword/<?php echo $token; ?>
                </li>
            </ol>
        </div>
    </body>
</html>