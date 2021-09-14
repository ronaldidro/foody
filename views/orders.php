<?php
  include_once 'templates/header.php';
  include_once 'templates/top-bar.php';
  include_once 'templates/navigation.php';
  $code = $this->d['code'];
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">                
                <div class="row">
                  <div class="col-sm-6">
                    <h3>ÓRDENES</h3>
                  </div>
                  <div class="col-sm-6">
                    <button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#modalCreateOrder">
                      <i class="fa fa-plus"></i> Nueva
                    </button>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="ordersTable" class="table table-striped text-sm-center">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>N° Mesa</th>
                      <th>Estado</th>
                      <th></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="modalCreateOrder">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nueva Orden</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frmCreateOrder" method="pos">
          <div class="modal-body">
            <div class="form-group">
              <label for="orderCode">Número</label>
              <input type="number" class="form-control" id="orderCode" name="orderCode" readonly required>
            </div>
            <div class="form-group">
              <label for="orderDate">Fecha</label>
              <div class="input-group date" id="orderDate" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" name="orderDate" data-target="#orderDate"/>
                <div class="input-group-append" data-target="#orderDate" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div>
              <!-- <input type="text" class="form-control" id="orderDate" name="orderDate" placeholder="Fecha de Orden" required> -->
            </div>
            <div class="form-group">
              <label for="orderCustomer">Cliente</label>
              <input type="text" class="form-control" id="orderCustomer" name="orderCustomer" placeholder="Nombres y Apellidos" required>
            </div>
            <div class="form-group">
              <label for="orderTable">Mesa</label>
              <input type="number" class="form-control" id="orderTable" name="orderTable" placeholder="Número de mesa" required>
            </div>
            <div class="form-group">
              <label for="orderDetail">Detalle de Orden</label>              
              <textarea class="form-control" id="orderDetail" name="orderDetail" rows="6" placeholder="Descripción y precio de productos p.e. Gaseosa: 1.50" required></textarea>
            </div>
            <div class="form-group">
              <label for="orderTotal">Total</label>
              <input type="number" step="0.01" class="form-control" id="orderTotal" name="orderTotal" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Registrar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <div class="modal fade" id="modalViewOrder">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detalle de Orden</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frmCreateOrder" method="pos">
          <div class="modal-body">
            <div class="form-group">
              <label for="orderCodeView">Número</label>
              <input type="number" class="form-control" id="orderCodeView" readonly>
            </div>
            <div class="form-group">
              <label for="orderDateView">Fecha</label>
              <input type="text" class="form-control" id="orderDateView" readonly>
            </div>
            <div class="form-group">
              <label for="orderCustomerView">Cliente</label>
              <input type="text" class="form-control" id="orderCustomerView" readonly readonly>
            </div>
            <div class="form-group">
              <label for="orderTableView">Mesa</label>
              <input type="number" class="form-control" id="orderTableView" readonly>
            </div>
            <div class="form-group">
              <label for="orderDetailView">Detalle de Orden</label>              
              <textarea class="form-control" id="orderDetailView" rows="6" readonly></textarea>
            </div>
            <div class="form-group">
              <label for="orderTotalView">Total</label>
              <input type="number" class="form-control" id="orderTotalView" readonly>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
<?php 
  include_once 'templates/footer.php';
?>  