<!DOCTYPE html>
<html>
  <head>
    <title>csog</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link href="<?php echo WS_URL; ?>css/formalize.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo WS_URL; ?>css/main.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo WS_URL; ?>css/lightbox.css" rel="stylesheet" type="text/css"/>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo WS_URL; ?>js/jquery.json-2.4.min.js"></script>
    <script src="<?php echo WS_URL; ?>js/main.js?rnd=1"></script> 
    <script src="<?php echo WS_URL; ?>js/jquery.formalize.min.js"></script> 
    <script src="<?php echo WS_URL; ?>js/lightbox-2.6.min.js"></script> 

    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>

  </head>
  <body>
    <div id="header_wrapper">
      <div id="header_inner">
          <div class="headerLogo"><span id="header_title"><a href="<?php if($_SESSION['USER']['LoggedIn'] == true) { ?>/projects"><?php } else { ?>/"><?php } ?>Community Septic System Owner's Guide Tool</a></span></div>
        <ul id="header_nav">
            <?php if(@$_SESSION['USER']['LoggedIn'] == true) { ?>
            <li <?php if( strstr($_SERVER['REQUEST_URI'], 'account') ) { echo "class=active"; } ?>><a href="<?php echo WS_URL; ?>account/edit">Your Account</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
          <li <?php if( strstr($_SERVER['REQUEST_URI'], 'projects') ) { echo "class=active"; } ?>><a href="<?php echo WS_URL; ?>projects/">Projects</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
          <li <?php if( strstr($_SERVER['REQUEST_URI'], 'help') ) { echo "class=active"; } ?>><a href="<?php echo WS_URL; ?>help/">Help</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
          <li>

              <a href="<?php echo WS_URL . "logout/"; ?>">Log Out</a> 
            <?php } else { ?>
              <a href="<?php echo WS_URL . "login/"; ?>">Click here to Log In or Register</a>
            <?php  } ?>
          </li>
        </ul>
        <div id="headerLinks">
            <!--
          <div id="disclaimerLink">
            <?php
              $projectOk = "";
            ?>
            <?php
            if($path[1] == "projects" && @$path[2] == "view")
            {
              $sql = "SELECT name FROM projects WHERE id = ".$path[3]." AND users_id = ".$_SESSION['USER']['ID'];
              $result = sqlsrv_query($database,$sql);
              if(@sqlsrv_has_rows($result))
              {
                $name = sqlsrv_fetch_array($result);
                $projectOk = $name['name'];
              }
            }
            /*
            if($path[1] == "register" || $path[1] == "projects" || $path[1] == "account" )
            { 
                // echo "<p style='position:relative; right:100px; top:20px;'>* Asterisks indicate required fields.</p>";
            }
*/
            ?><br />
          </div>-->
          <div id="headerInfo">
            <?php
              if(@$_SESSION['USER']['Name'] != "")
              {
                echo $_SESSION['USER']['Name']." - ".$_SESSION['USER']['CompanyName']."<br>";
              }
              if($projectOk != "")
              {
                echo "Project: $projectOk";
              }
            ?>
          </div>
        </div>
        <?php
            if(($path[1] == "register" && @$_REQUEST['registersubmit'] != 1) || ($path[1] == "projects" && @$path[2] == "view") || $path[1] == "account" )
            { 
                echo '<div id="asterisk">Entries marked * are required fields.</div>';
            }
              
            ?>
      </div>
    </div>
