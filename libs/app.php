<?php

  require_once 'controllers/errorController.php';

  class App {

    function __construct()
    {
      if (isset($_GET["page"])) {
        
        $url = $_GET['page'];
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        $controllerName = $url[0] . 'Controller';
        $controllerRoot = 'controllers/' . $controllerName . '.php';

        if(file_exists($controllerRoot)) {
          
          require_once $controllerRoot;
          $controller = new $controllerName;
          $controller->loadModel($url[0]);
  
          if(isset($url[1])) {
  
            if(method_exists($controller, $url[1])) {
              
              $controller->{$url[1]}();

            } else {

              $controller = new ErrorController();
              $controller->render();

            }
          } else {

            $controller->render();

          }
        } else {

          $controller = new ErrorController();
          $controller->render();

        }
      } else {
        
        require_once 'controllers/ordersController.php';

        $controller = new OrdersController();
        $controller->loadModel('orders');
        $controller->render();        
      }
    }
  }