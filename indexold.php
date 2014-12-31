
<!DOCTYPE html>

<?php

    include_once('CAS.php');

    phpCAS::setDebug();
    phpCAS::client(CAS_VERSION_2_0, 'www.purdue.edu', 443, '/apps/account/cas');
    // phpCAS::client(CAS_VERSION_2_0, 'webservices-test.itns.purdue.edu', 443, '/apps/account/cas-server-uber-webapp-3.4.6');

    phpCAS::setNoCasServerValidation();

    phpCAS::forceAuthentication();

    if (isset($_REQUEST['logout']))
    {
        phpCAS::logout();
    }

// TODO

    /* get list of userAlias's and compare to returned Alias
        if alias is okay, continue onto ysite
        if alias is not okay, display message

    */


?>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>AgComm News Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  </head>

  <body>

    <div class="container">

      <div class="well">
            <h1>Authentication Succeeded</h1>
              <p>
                  Hello, <b><?php echo phpCAS::getAttribute('fullname'); ?></b>!
              </p>
              <p>
                  Your username is <b><?php echo phpCAS::getUser(); ?></b>. Your email address is <b><?php echo phpCAS::getAttribute('email'); ?></b>. Your PUID is <b><?php echo phpCAS::getAttribute('puid'); ?></b>. Your I2A2 characteristics are <b><?php echo phpCAS::getAttribute('i2a2characteristics'); ?></b>.
              </p>
              <p>
                  <a href="?logout=">Logout</a>
              </p>
      </div>

      <form class="form-signin">
        <h2 class="form-signin-heading" style="text-align:center;">AgNews Database</h2>
        <input type="text" class="input-block-level" placeholder="Username">
        <input type="password" class="input-block-level" placeholder="Password">
        <div class="alert alert-error"><i class="icon-remove-sign"></i> This login does not function.</div>
        <button class="btn btn-large btn-primary disabled" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
