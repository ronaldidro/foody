<?php

  class View {

    function __construct(){
    }

    function render($name, $data = []) {
      $this->d = $data;
      require 'views/' . $name  . '.php';
    }
  }