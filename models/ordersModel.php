<?php

  class OrdersModel extends Model {

    private $id;
    private $code;
    private $date;
    private $customer;
    private $tableNumber;
    private $orderDetail;
    private $total;
    private $state;

    function __construct() {
      parent::__construct();

      $this->id = 0;
      $this->description = '';
      $this->products = 0;
      $this->date = '';
    }

    public function createOrder(){
      
      try {
        $query = $this->prepare('INSERT INTO orders (code, date, customer, table_number, order_detail, total) VALUES (:code, :date, :customer, :table_number, :order_detail, :total)');
        $query->execute([
          'code' => $this->code,
          'date' => $this->date,
          'customer' => $this->customer,
          'table_number' => $this->tableNumber,
          'order_detail' => $this->orderDetail,
          'total' => $this->total
        ]);

        if($query->rowCount()) return true;
        return false;

      } catch (PDOException $e) {
        error_log('OrdersModel::createOrder -> PDOException ' . $e);
        return false;
      }
    }

    public function getAllOrders(){
      $items = [];
      
      try {
        $query = $this->query('SELECT * FROM orders');

        while($p = $query->fetch(PDO::FETCH_ASSOC)){
          
          $item = new OrdersModel();
          $item->setId($p['id']);
          $item->setCode($p['code']);
          $item->setDate($p['date']);
          $item->setCustomer($p['customer']);
          $item->setTableNumber($p['table_number']);
          $item->setOrderDetail($p['order_detail']);
          $item->setTotal($p['total']);
          $item->setState($p['state']);

          array_push($items, $item);
        }
        return $items;

      } catch (PDOException $e) {
        error_log('OrdersModel::getAllOrders -> PDOException ' . $e);
      }
    }

    public function getOrder($id){
            
      try {
        $query = $this->prepare('SELECT * FROM orders WHERE id = :id');
        $query->execute([
          'id' => $id
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);

      } catch (PDOException $e) {
        error_log('OrdersModel::getOrder -> PDOException ' . $e);
      }
    }

    public function deleteOrder($id){
      
      try {
        $query = $this->prepare('DELETE FROM orders WHERE id = :id');
        $query->execute([
          'id' => $id
        ]);

        return true;
      } catch (PDOException $e) {
        error_log('OrdersModel::deleteOrder -> PDOException ' . $e);
        return false;
      }
    }
    
    public function getOrderCode(){
            
      try {
        $query = $this->query('SELECT COUNT(*)+1 AS code FROM orders');

        $code = $query->fetch(PDO::FETCH_ASSOC)['code'];
        return $code;

      } catch (PDOException $e) {
        error_log('OrdersModel::getOrderCode -> PDOException ' . $e);
      }
    }

    public function existsTableOrder(){
            
      try {
        $query = $this->prepare('SELECT COUNT(*) AS count FROM orders WHERE table_number = :table_number');
        $query->execute([
          'table_number' => $this->getTableNumber()
        ]);

        return $query->fetch(PDO::FETCH_ASSOC)['count'];

      } catch (PDOException $e) {
        error_log('OrdersModel::existsTableOrder -> PDOException ' . $e);
      }
    }

    public function updateState(){
      
      try {
        $query = $this->prepare('UPDATE orders SET state = :state WHERE id = :id');
        $query->execute([
          'state' => $this->state,
          'id' => $this->id
        ]);

        if($query->rowCount()) return true;
        return false;

      } catch (PDOException $e) {
        error_log('OrdersModel::updateState -> PDOException ' . $e);
        return false;
      }
    }

    public function setId($value) { $this->id = $value; }
    public function setCode($value) { $this->code = $value; }
    public function setDate($value) { $this->date = $value; }
    public function setCustomer($value) { $this->customer = $value; }
    public function setTableNumber($value) { $this->tableNumber = $value; }
    public function setOrderDetail($value) { $this->orderDetail = $value; }
    public function setTotal($value) { $this->total = $value; }
    public function setState($value) { $this->state = $value; }

    public function getId() { return $this->id; }
    public function getCode() { return $this->code; }
    public function getDate() { return date_format(date_create($this->date), 'd-m-Y'); }
    public function getCustomer() { return $this->customer; }
    public function getTableNumber() { return $this->tableNumber; }
    public function getOrderDetail() { return $this->orderDetail; }
    public function getTotal() { return $this->total; }
    public function getState() { return $this->state; }
    public function getStateDescription() {
      if ($this->state == '0') { $stateDescription = 'Pendiente'; } 
      else { $stateDescription = 'Entregada'; }
      return $stateDescription; 
    }
    
  }