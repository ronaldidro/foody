<?php

  class ErrorController extends Controller {

    function __construct() {
      error_log('ErrorController::construct -> Inicio de Error');
      parent::__construct();
    }

    function render() {
      error_log('ErrorController::render -> Carga el index de Errores');
      $this->view->render('404');
    }
  }