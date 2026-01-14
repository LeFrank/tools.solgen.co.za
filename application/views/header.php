<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (!empty($globalTitle))? $globalTitle . " - " : "";?> Toolbox</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Francois Campbell">
        <link rel="shortcut icon" href="/images/favicon.ico" />
        <link rel='stylesheet' id='googafont-css'  href='https://fonts.googleapis.com/css?family=Marvel%7CRoboto%3A300%2C500%2C400italic&#038;ver=3.9.1' type='text/css' media='all' />
        <link rel="stylesheet" href="/css/third_party/jquery/1.10.4/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="/css/third_party/foundation/normalize.css" />
        <link rel="stylesheet" href="/css/third_party/foundation/6.3.0/foundation.min.css" />
        <link rel="stylesheet" type="text/css" media="all" href="/css/third_party/foundation/3.0.0/foundation-icons.css" />
        <!-- <link rel="stylesheet" type="text/css" media="all" href="/css/black_and_yellow.scss" /> -->
        <link rel="stylesheet" type="text/css" media="all" href="/css/black_and_yellow_dark.scss" />
        <link rel="stylesheet" href="/css/third_party/foundation/6.3.0/responsive-tables.css" />
        <link rel="stylesheet" href="/css/third_party/fontawesome/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" media="print" href="/css/print.css" />

        <?php
        if (!empty($css)) {
            echo $css;
        }
        if (!empty($js)) {
            echo $js;
        }
        ?>
        <script type="text/javascript" src="/js/third_party/jquery.min-1.11.0.js"></script>
        <script type="text/javascript" src="/js/third_party/foundation/vendor/modernizr.js"></script>
        <script type="text/javascript" src="/js/third_party/foundation/6.3.0/foundation.min.js"></script>
        <script type="text/javascript" src="/js/third_party/foundation/6.3.0/what-input.js"></script>
        <script type="text/javascript" src="/js/third_party/foundation/6.3.0/responsive-tables.js"></script>
        <script type="text/javascript" src="/js/third_party/moment/moment.min.js"></script>
        <script src="/js/default.js"></script>
    </head>
    <body>
        <div id="elder-container" class="row expanded">
            <div class="large-12 columns">
                <div class="large-8 columns">
                    <div class="page-header"><a href="/" >Solgen Toolbox <span class="beta">alpha</span></a></div>
                </div>
                <div class="large-4 columns text-right">
                    <?php if (!$this->session->userdata("loggedIn")) { ?>
                        <?php echo form_open('user/login') ?>
                        <input type="text" id="email" name="email" value="" placeholder="Email" autocomplete="on" autofocus />&nbsp;&nbsp;&nbsp;
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
                        <a href="/home/dashboard" ><img src="/images/third_party/icons/home.svg" class="nav-icon-long" alt="Home"> Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/user/settings" >My Settings</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/user/logout" >Logout</a> 
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row expanded" data-sticky-container>
            <div id="top-nav" class="large-12 columns sticky top-nav" data-sticky data-options="marginTop: 0">
               <?php $this->load->view("nav") ?>
            </div>
        </div>
        <div class="row expanded">
            <div class="large-12 columns">
                <div id="contentMain" class="contentMain">
                <?php 
                    // echo phpinfo();
                    // xdebug_info();
                ?>
                

