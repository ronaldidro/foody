<?php

  class Controller {

    function __construct(){
      $this->view = new View();
    }

    function loadModel($model){
      $url = 'models/' . $model . 'Model.php';

      if(file_exists($url)){
        require_once $url;

        $modelName = $model.'Model';
        $this->model = new $modelName();
      }
    }

    function existPost($params){
      foreach ($params as $param) {
        if(!isset($_POST[$param])) {
          error_log('Cotroller::existPost -> No existe parametro' . $param);
          return false;
        }
      }
      return true;
    }

    function existGet($params){
      foreach ($params as $param) {
        if(!isset($_GET[$param])) {
          error_log('Cotroller::existGet -> No existe parametro' . $param);
          return false;
        }
        return true;
      }
    }

    function getGet($name) {
      return $_GET[$name];
    }

    function getPost($name) {
      return $_POST[$name];
    }

    function getErrorMessage($hash) {
      $error = new ErrorMessages();
      
      if($error->existsKey($hash)) {
        return $error->get($hash);
      }
    }

    function getSuccessMessage($hash) {
      $success = new SuccessMessages();
      
      if($success->existsKey($hash)) {
        return $success->get($hash);
      }
    }
  }