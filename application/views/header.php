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
        <link rel="stylesheet" type="text/css" media="all" href="/css/black_and_yellow.css" />
        <link href='http://fonts.googleapis.com/css?family=Sarina' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <script src="/js/third_party/jquery.min-1.11.0.js"></script>
    </head>
    <body>
        <div class="login" id="login">
            <?php if (!$this->session->userdata("loggedIn")) { ?>
                <?php echo form_open('user/login') ?>
                <label class="login-label">Email</label><input id="email" name="email" value="" />&nbsp;&nbsp;&nbsp;
                <label class="login-label">Password</label><input id="password" name="password" type="password" value="" />&nbsp;&nbsp;&nbsp;
                <a href="/user/forgotten-password">Forgotten Password</a>
                <input type="submit" name="submit" value="Login" />
                <a href="/user/register">Register</a>
            </form>
        <?php } else { ?>
            <a href="/user/settings" >My Settings</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/user/logout" >Logout</a> 
        <?php } ?>
    </div>
    <div class="header"><a href="/" >Solgen Sandbox</a></div>
    <div class="clear-float" ></div>
    <div class="top-nav">
        <?php $this->load->view("nav") ?>
    </div>
    <div id="contentMain" class="contentMain">

