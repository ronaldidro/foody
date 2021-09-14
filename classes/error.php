<?php

  class ErrorMessages {
    
    const ERROR_ORDER_CREATE = "5lf04ae8963b16403f45d8eod851f789";
    const ERROR_ORDER_UPDATE = "5254fdskfsmfmmsdf4545fjsdf8344g9";
    const ERROR_ORDER_EXISTS = "6lf04ae8963b164k3485d8eolgfdik54";
    const ERROR_ORDER_DELETE = "8f48a0845b4f8704cb7e8b00d4981233";
    const ERROR_ORDER_EMPTY  = "6h7f0ae8963b75g403f3ec9edee1f789";

    private $errorsList = [];

    public function __construct() {
       $this->errorsList = [
        ErrorMessages::ERROR_ORDER_CREATE => 'Hubo un problema al crear la orden, inténtalo de nuevo',
        ErrorMessages::ERROR_ORDER_UPDATE => 'Hubo un problema al cambiar el estado, inténtalo de nuevo',
        ErrorMessages::ERROR_ORDER_EXISTS => 'La mesa ya tiene una orden registrada',
        ErrorMessages::ERROR_ORDER_DELETE => 'Hubo un problema al eliminar la orden, inténtalo de nuevo',
        ErrorMessages::ERROR_ORDER_EMPTY  => 'Los campos no pueden estar vacíos'        
      ];
    }

    public function get($hash) {
      return $this->errorsList[$hash];
    }

    public function existsKey($key) {
      if(array_key_exists($key, $this->errorsList)) {
        return true;
      } else {
        return false;
      }
    }
  }