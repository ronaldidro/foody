$(document).ready(function() {

  const path = (function(){
    var localObj = window.location;
    var contextPath = localObj.pathname.split("/")[1];
    var basePath = localObj.protocol + "//" + localObj.host + "/"+ contextPath;
    return basePath ;
  })();

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  $('#orderDate').datetimepicker({
    format: 'DD-MM-YYYY'
  });

  var table = $("#ordersTable").DataTable({
    "ajax": "orders/getOrders",
    "paging": true,
    "deferRender": true,
    "processing": true,
    "info": true,
    "autoWidth": false,
    "ordering": false,
    "responsive": true,
    "language": {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }
  });

  $('#modalCreateOrder').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
    $(this).find('input, textarea').removeClass('is-invalid');
  });

  $('#modalCreateOrder').on('show.bs.modal', async function () {
    const result = await getOrderCode();
    $('#orderCode').val(result);
  });

  $('#frmCreateOrder').validate({
    rules: {
      orderDate: { required: true },
      orderCustomer: { required: true },
      orderDetail: { required: true },
      orderTable: { required: true, min: 1 },
      orderTotal: { required: true, min: 1 }
    },
    messages: {
      orderDate: { required: "Debe ingresar la fecha de la orden" },
      orderCustomer: { required: "Debe ingresar el cliente de la orden" },
      orderDetail: { required: "Debe ingresar el detalle de la orden" },
      orderTable: { 
        required: "Debe ingresar el número de la mesa",
        min: "Ingrese un número mayor a cero"
      },
      orderTotal: { 
        required: "Debe ingresar el total de la orden",
        min: "Ingrese un número mayor a cero"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },
    submitHandler: function(htmlForm) {
      var form = $(htmlForm);
      var data = form.serializeArray();
     
      $.ajax({
        url: path + '/orders/createOrder',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(data) {
          
          var icon = 'success';
          if(data.errorFlag) icon = 'error';
  
          Toast.fire({
            icon: icon,
            title: data.message
          })
  
          if(!data.errorFlag) {
            table.ajax.reload();
            $('#modalCreateOrder').modal('hide');
          }
        },
        error: function(xhr, ajaxOptions, thrownError){
          console.log(xhr.responseText);
          Toast.fire({
            icon: 'error',
            title: 'Ocurrió un error interno'
          })
        }
      });
    }
  });

  $(document).on('click', '#btnViewOrder', async function(){

    var orderId = $(this).attr('orderId');

    const result = await getOrder(orderId);

    if (result == 'error') {
      Toast.fire({
        icon: result,
        title: 'Ocurrió un error interno'
      });
      return;
    }
    
    $('#orderCodeView').val(result['code']);
    $('#orderDateView').val(result['date']);
    $('#orderCustomerView').val(result['customer']);
    $('#orderTableView').val(result['table_number']);
    $('#orderDetailView').val(result['order_detail']);
    $('#orderTotalView').val(result['total']);
    $('#modalViewOrder').modal('show');
  });

  $(document).on('click', '#btnDeleteOrder', function(){
    
    Swal.fire({
      title: '¿Está seguro?',
      text: 'Luego de eliminar no se podrá recuperar',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar'
    }).then(async (result) => {
      if (result.isConfirmed) {

        var orderId = $(this).attr('orderId');

        const result = await deleteOrder(orderId);

        if (result == 'error') {
          Toast.fire({
            icon: result,
            title: 'Ocurrió un error interno'
          });
          return;
        }

        var icon = 'success';
        if(result.errorFlag) icon = 'error';

        Toast.fire({
          icon: icon,
          title: result.message
        });

        if(!result.errorFlag) table.ajax.reload();
      }
    })
  });

  $(document).on('click', '#btnState', async function(){
    
    Swal.fire({
      title: '¿Está seguro?',
      text: 'El estado de la orden será cambiado',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, cambiar'
    }).then(async (result) => {
      if (result.isConfirmed) {

        var orderId = $(this).attr('orderId');
        var orderState = $(this).attr('orderState');
        var newState = (orderState == 0) ? 1 : 0;

        const result = await updateState(orderId, newState);

        if (result == 'error') {
          Toast.fire({
            icon: result,
            title: 'Ocurrió un error interno'
          });
          return;
        }

        var icon = 'success';
        if(result.errorFlag) icon = 'error';

        Toast.fire({
          icon: icon,
          title: result.message
        });

        if(!result.errorFlag) table.ajax.reload();
      }
    })
  });

  async function getOrderCode() {
    try {
      const url = path + '/orders/getOrderCode';

      return await fetch(url, {
        method: 'POST'
      })
      .then(res => res.json())

    } catch (e) {
      console.log(e);
      return 'error';
    }
  };
  
  async function getOrder(orderId) {
    try {
      const url = path + '/orders/getOrder';

      const data = new FormData();
      data.append('orderId', orderId);

      return await fetch(url, {
        method: 'POST',
        body: data
      })
      .then(res => res.json())

    } catch (e) {
      console.log(e);
      return 'error';
    }
  };

  async function updateState(orderId, orderState) {
    try {
      const url = path + '/orders/updateState';

      const data = new FormData();
      data.append('orderId', orderId);
      data.append('orderState', orderState);

      return await fetch(url, {
        method: 'POST',
        body: data
      })
      .then(res => res.json())

    } catch (e) {
      console.log(e);
      return 'error';
    }
  };

  async function deleteOrder(orderId) {
    try {
      const url = path + '/orders/deleteOrder';

      const data = new FormData();
      data.append('orderId', orderId);

      return await fetch(url, {
        method: 'POST',
        body: data
      })
      .then(res => res.json())

    } catch (e) {
      console.log(e);
      return 'error';
    }
  };

});