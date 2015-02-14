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
        <link rel='stylesheet' id='googafont-css'  href='http://fonts.googleapis.com/css?family=Marvel%7CRoboto%3A300%2C500%2C400italic&#038;ver=3.9.1' type='text/css' media='all' />
        <link rel="stylesheet" href="/css/third_party/jquery/1.10.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="/css/third_party/foundation/normalize.css">
        <link rel="stylesheet" href="/css/third_party/foundation/foundation.min.css">
        <link rel="stylesheet" type="text/css" media="all" href="/css/black_and_yellow.css" />
        <?php
        if (!empty($css)) {
            echo $css;
        }
        if (!empty($js)) {
            echo $js;
        }
        ?>
        <script src="/js/third_party/jquery.min-1.11.0.js"></script>
        <script src="/js/third_party/foundation/vendor/modernizr.js"></script>
        <script src="/js/third_party/foundation/foundation.min.js"></script>
    </head>
    <body>
        <div class="row full-width">
            <div class="large-12 columns">
                <div class="large-8 columns">
                    <div class="page-header"><a href="/" >Solgen Toolbox</a></div>
                </div>
                <div class="large-4 columns">
                    <?php if (!$this->session->userdata("loggedIn")) { ?>
                        <?php echo form_open('user/login') ?>
                        <input type="text" id="email" name="email" value="" placeholder="Email" autocomplete="on"/>&nbsp;&nbsp;&nbsp;
                        <input id="password" name="password" placeholder="Password"  type="password" value="" />&nbsp;&nbsp;&nbsp;
                        <input type="submit" name="submit" value="Login" class="button tiny" />
                        <br/>
        <!--                <input type="checkbox" id="rememberMe" name="rememberMe" />Remember Me&nbsp;&nbsp;&nbsp;-->
                        <?php
                        if (!empty($error_message)) {
                            echo "<span class='fail-text'>" . $error_message . "</span>";
                            echo '<span style="display:inline-block;width:45px;">&nbsp;</span>';
                        }
                        ?>
                        <a href="/user/forgotten-password">Forgotten Password</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                        <a href="/user/register">Register</a>
                        </form>
                    <?php } else { ?>
                        <a href="/user/settings" >My Settings</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/user/logout" >Logout</a> 
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row full-width">
            <div class="large-12 columns">
                <div class="top-nav">
                    <?php $this->load->view("nav") ?>
                </div>
            </div>
        </div>
        <div class="row full-width">
            <div class="large-12 columns">
                <div id="contentMain" class="contentMain">
                

