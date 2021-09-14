<?php
  error_reporting(E_ALL);
  ini_set('ignore_repeated_errors', TRUE);
  ini_set('display_errors', FALSE);
  ini_set('log_errors', TRUE);
  ini_set('error_log', 'C:/xampp/htdocs/footy/public/log/footy-error.log');

  require_once 'core/config.php';
  require_once 'classes/error.php';
  require_once 'classes/success.php';
  require_once 'libs/database.php';
  require_once 'libs/model.php';
  require_once 'libs/view.php';
  require_once 'libs/controller.php';
  require_once 'libs/app.php';

  $app = new App();