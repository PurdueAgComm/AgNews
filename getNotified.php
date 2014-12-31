<?php
session_start();
include_once("includes/publicHeader.php");

?>
    <style type="text/css">
      body {
        padding-top: 70px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        background-image: url('img/agbg.jpg');
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
        opacity: 0.9;
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

    <div class="container">
      
      <?php if($_GET["action"] == "unsub") { ?>
        <form class="form-signin" method="post" action="functions/doGetNotified.php?action=unsub">
      <?php } else { ?>
        <form class="form-signin" method="post" action="functions/doGetNotified.php">
      <?php } ?>


        <?php
          if($_SESSION["error"] != "") {
            echo "<div class='alert alert-error'>" . $_SESSION["error"] . "</div>";
            $_SESSION["error"] = "";
          }

          if($_SESSION["success"] != "") {
            echo "<div class='alert alert-success'>" . $_SESSION["success"] . "</div>";
            $_SESSION["success"] = "";
          }

        if($_GET["action"] == "unsub") {
          echo "<h2 class='form-signin-heading'>Unsubscribe!</h2>";
          echo "<p>We're sorry to see you go, but we understand. Simply type your e-mail address in the field below to unsubscribe.</p>";
        }
        else {
          echo "<h2 class='form-signin-heading'>Get Notified!</h2>";
          echo "<p>Enter your e-mail address below to receive email notifications of when an AgComm News story gets published.</p>";
        }
        ?>

      <input type="email" class="input-block-level" placeholder="Email address" name="email" required>

      <?php
       if($_GET["action"] == "unsub") {
          echo "<button class='btn btn-large btn-primary btn-block' type='submit' >Unsubscribe Me!</button>";
        }
        else {
          echo "<button class='btn btn-large btn-primary btn-block' type='submit' >Notify Me!</button>";
        }
        ?>
      <br />
      <p class="text-center">&copy; <?php echo date("Y"); ?> | <a href="?action=unsub">Unsubscribe</a> | <a href="http://www.twitter.com/purdueag">Twiiter</a> | <a href="http://www.facebook.com/purdueag">Facebook</a>
      </form>

    </div> <!-- /container -->


    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
 
    <script type="text/javascript">
    $(function () {
        $("[rel='tooltip']").tooltip();
    });
    </script>

  </body>
</html>
