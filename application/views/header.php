<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Toolbox</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/images/favicon.ico" />
        <link rel="stylesheet" type="text/css" media="all" href="/css/black_and_yellow.css" />
        <link rel="stylesheet" href="/css/third_party/jquery/1.10.4/themes/smoothness/jquery-ui.css">
        <script src="/js/third_party/jquery.min-1.11.0.js"></script>
    </head>
    <body>
        <div class="login" id="login">
            <?php if (!$this->session->userdata("loggedIn")) { ?>
                
                <?php echo form_open('user/login') ?>
                <input type="text" id="email" name="email" value="" placeholder="Email" autocomplete="on"/>&nbsp;&nbsp;&nbsp;
                <input id="password" name="password" placeholder="Password"  type="password" value="" />&nbsp;&nbsp;&nbsp;
                <input type="submit" name="submit" value="Login" />
                <br/>
<!--                <input type="checkbox" id="rememberMe" name="rememberMe" />Remember Me&nbsp;&nbsp;&nbsp;-->
                <?php if(!empty($error_message)){
                    echo "<span class='fail-text'>".$error_message."</span>";
                    echo '<span style="display:inline-block;width:45px;">&nbsp;</span>';
                }?>
                <a href="/user/forgotten-password">Forgotten Password</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="/user/register">Register</a>
                
                <br/>
                
            </form>
        <?php } else { ?>
            <a href="/user/settings" >My Settings</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/user/logout" >Logout</a> 
        <?php } ?>
    </div>
    <div class="page-header"><a href="/" >Solgen Toolbox</a></div>
    <div class="clear-float" ></div>
    <div class="top-nav">
        <?php $this->load->view("nav") ?>
    </div>
    <div id="contentMain" class="contentMain">

