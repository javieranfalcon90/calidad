function createDelete(form) {

  const myswal = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-danger',
      cancelButton: 'btn btn-secondary'
    },
    buttonsStyling: false
  })

  myswal.fire({
      title: "CONFIRMACIÓN",
      text:
        "Esta acción no se podrá deshacer. Seguro que desea eliminar este elemento?",
      type: "error",
      showCancelButton: true,
      focusConfirm: false,
      cancelButtonText: "No, cancelar!",
      confirmButtonText: "Si, eliminar!",
      showLoaderOnConfirm: true,
  
      preConfirm: function() {
        form.submit();
      }
    });
  
}

function createCerrar(form) {

  const myswal = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-secondary'
    },
    buttonsStyling: false
  })

  myswal.fire({
      title: "CONFIRMACIÓN",
      text:
        "Desea cerrar este elemento?",
      type: "success",
      showCancelButton: true,
      focusConfirm: false,
      cancelButtonText: "No, cancelar!",
      confirmButtonText: "Si, cerrar!",
      showLoaderOnConfirm: true,
  
      preConfirm: function() {
        form.submit();
      }
    });
  
}

function createReabrir(form) {

  const myswal = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-warning',
      cancelButton: 'btn btn-secondary'
    },
    buttonsStyling: false
  })

  myswal.fire({
      title: "CONFIRMACIÓN",
      text:
        "Desea re abrir este elemento?",
      type: "warning",
      showCancelButton: true,
      focusConfirm: false,
      cancelButtonText: "No, cancelar!",
      confirmButtonText: "Si, re abrir!",
      showLoaderOnConfirm: true,
  
      preConfirm: function() {
        form.submit();
      }
    });
  
}

function createCerrarParameter(form) {

  const myswal = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-secondary'
    },
    buttonsStyling: false
  })

  myswal.fire({
      title: "CONFIRMACIÓN",
      input: "select",
      inputOptions: {
        'Cumplido': 'Cumplido',
        'No Cumplido': 'No Cumplido'
      },
      text: "Desea cerrar este elemento? Debe especificar el cumplimiento.",
      type: "success",
      showCancelButton: true,
      focusConfirm: false,
      cancelButtonText: "No, cancelar!",
      confirmButtonText: "Si, cerrar!",
      showLoaderOnConfirm: true,
  
      preConfirm: function(value) {
        $(form).find('.cumplimiento').attr('value', value)
        form.submit();
      }
    });
  
}