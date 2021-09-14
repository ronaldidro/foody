<?php

  class SuccessMessages {

    const SUCCESS_ORDER_CREATE = "f52228665c4f14c8695b194f670b0ef1";
    const SUCCESS_ORDER_UPDATE = "gt9r49ytfkgfdgi358543t5kgfg85395";
    const SUCCESS_ORDER_DELETE = "fcd919285d5759328b143801573ec47d";

    private $successList = [];
    
    public function __construct() {
      $this->successList = [
        SuccessMessages::SUCCESS_ORDER_CREATE => "Orden creada correctamente",
        SuccessMessages::SUCCESS_ORDER_UPDATE => "Estado actualizado correctamente",
        SuccessMessages::SUCCESS_ORDER_DELETE => "Orden eliminada correctamente"
      ];
    }

    public function get($hash) {
      return $this->successList[$hash];
    }

    public function existsKey($key) {
      if(array_key_exists($key, $this->successList)) {
        return true;
      } else {
        return false;
      }
    }
  }