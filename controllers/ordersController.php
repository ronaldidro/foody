<?php

  class OrdersController extends Controller {

    function __construct() {
      error_log('OrderController::construct -> Inicio de Order');
      parent::__construct();
    }

    function render() {
      error_log('OrderController::render -> Carga el index de Order');

      $this->view->render('orders');
    }

    function createOrder(){
      if($this->existPost(['orderCode', 'orderDate', 'orderCustomer', 'orderTable', 'orderDetail', 'orderTotal'])) {

        $code = $this->getPost('orderCode');
        $date = date_format(date_create($this->getPost('orderDate')), 'Y-m-d');;
        $customer = $this->getPost('orderCustomer');
        $table = $this->getPost('orderTable');
        $detail = $this->getPost('orderDetail');
        $total = $this->getPost('orderTotal');

        error_log('OrdersController::createOrder -> code: ' . $code . ', date: ' . $date . ', customer: ' . $customer . ', table: ' . $table . ', detail: ' . $detail . ', total: ' . $total);

        if($date == '' || empty($date)) {
          error_log('OrdersController::createOrder -> Descripcion vacía');

          $response = array (
            'errorFlag' => true,
            'message' => $this->getErrorMessage(ErrorMessages::ERROR_ORDER_EMPTY)
          );
        } else {

          $orderModel = new OrdersModel();
          $orderModel->setCode($code);
          $orderModel->setDate($date);
          $orderModel->setCustomer($customer);
          $orderModel->setTableNumber($table);
          $orderModel->setOrderDetail($detail);
          $orderModel->setTotal($total);

          if(!$orderModel->existsTableOrder()){
            $result = $orderModel->createOrder();
        
            if($result){
              error_log('OrdersController::createOrder -> success');

              $response = array (
                'errorFlag' => false,
                'message' => $this->getSuccessMessage(SuccessMessages::SUCCESS_ORDER_CREATE)
              );
            } else {
              error_log('OrdersController::createOrder -> error');

              $response = array (
                'errorFlag' => true,
                'message' => $this->getErrorMessage(ErrorMessages::ERROR_ORDER_CREATE)
              );
            }
          } else {
            error_log('OrdersController::createOrder -> existe orden');

            $response = array (
              'errorFlag' => true,
              'message' => $this->getErrorMessage(ErrorMessages::ERROR_ORDER_EXISTS)
            );
          }
        }
      } else {
        error_log('OrdersController::createOrder -> No hay POST');

        $response = array (
          'errorFlag' => true,
          'message' => $this->getErrorMessage(ErrorMessages::ERROR_ORDER_CREATE)
        );
      }

      die(json_encode($response));
    }

    function getOrders(){
      $ordersArray = array();
      $orders = $this->model->getAllOrders();

      error_log('OrdersController::getOrders -> ordenes cargadas: ' . count($orders));

      foreach ($orders as $order) {
        $auxArray = array();

        array_push($auxArray, $order->getCode());
        array_push($auxArray, $order->getDate());
        array_push($auxArray, $order->getCustomer());
        array_push($auxArray, $order->getTableNumber());

        $stateClass = ($order->getState() == 0) ? 'bg-gradient-warning' : 'bg-gradient-success';

        $btnState = '<button class="btn '.$stateClass.'" id="btnState" orderState='.$order->getState().' orderId='.$order->getId().'>'.$order->getStateDescription().'</button>';

        array_push($auxArray, $btnState);

        $viewOption = '<button class="dropdown-item" id="btnViewOrder" orderId='.$order->getId().'><i class="far fa-eye"></i> Ver Detalle</button>';
        $deleteOption = '<button class="dropdown-item" id="btnDeleteOrder" orderId='.$order->getId().'><i class="far fa-trash-alt"></i> Eliminar</button>';

        $buttons = '
          <div class="btn-group">
            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">Opciones </button>
            <div class="dropdown-menu" role="menu">'
              . $viewOption
              . $deleteOption .
            '</div>
          </div>
        ';

        array_push($auxArray, $buttons);

        $ordersArray['data'][] = $auxArray;
      }

      if(count($orders) == 0) $ordersArray['data'] = [];

      $jsonOrders = json_encode($ordersArray);
      die($jsonOrders);
    }

    function getOrder(){
      if($this->existPost(['orderId'])) {

        $id = $this->getPost('orderId');

        error_log('OrdersController::getOrder -> orderId: ' . $id);

        $order = $this->model->getOrder($id);

        die(json_encode($order));

      } else {
        error_log('OrdersController::getOrder -> No hay POST');
      }
    }

    function deleteOrder(){
      if($this->existPost(['orderId'])) {

        $id = $this->getPost('orderId');

        error_log('OrdersController::deleteOrder -> orderId: ' . $id);

        $result = $this->model->deleteOrder($id);

        if($result){
          error_log('OrdersController::deleteOrder -> success');

          $response = array (
            'errorFlag' => false,
            'message' => $this->getSuccessMessage(SuccessMessages::SUCCESS_ORDER_DELETE)
          );
        } else {
          error_log('OrdersController::deleteOrder -> error');

          $response = array (
            'errorFlag' => true,
            'message' => $this->getErrorMessage(ErrorMessages::ERROR_ORDER_DELETE)
          );
        }

      } else {
        error_log('OrdersController::deleteOrder -> No hay POST');

        $response = array (
          'errorFlag' => true,
          'message' => $this->getErrorMessage(ErrorMessages::ERROR_ORDER_DELETE)
        );
      }
      
      die(json_encode($response));
    }

    function getOrderCode(){
      die(json_encode($this->model->getOrderCode()));
    }

    function updateState(){
      if($this->existPost(['orderId', 'orderState'])) {
        $id = $this->getPost('orderId');
        $state = $this->getPost('orderState');

        error_log('OrdersController::updateState -> id: ' . $id . ', state: ' . $state);

        $orderModel = new OrdersModel();
        $orderModel->setId($id);
        $orderModel->setState($state);

        $result = $orderModel->updateState();

        if($result){
          error_log('OrdersController::updateState -> success');

          $response = array (
            'errorFlag' => false,
            'message' => $this->getSuccessMessage(SuccessMessages::SUCCESS_ORDER_UPDATE)
          );
        } else {
          error_log('OrdersController::updateState -> error');

          $response = array (
            'errorFlag' => true,
            'message' => $this->getErrorMessage(ErrorMessages::ERROR_ORDER_UPDATE)
          );
        }
      }
      die(json_encode($response));
    }
  }