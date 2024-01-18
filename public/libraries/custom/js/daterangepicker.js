$(function() {

    $('.datepick').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        //minYear: 1901,
        //maxYear: parseInt(moment().format('YYYY'),10)

        locale: {
        format: "DD-MM-YYYY",
        cancelLabel: 'Limpiar',
        applyLabel: "Aplicar",
        daysOfWeek: [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sá"
        ],
        monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        },
    });

    $('.datepick').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });

    $('.datepick').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });


    $('.daterange').daterangepicker({
        ranges: {
        'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'Año Pasado': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        },
  
        autoUpdateInput: false,
        alwaysShowCalendars: true,
        linkedCalendars: false,
        showDropdowns: false,
  
        locale: {
        format: "DD-MM-YYYY",
        separator: " a ",
        cancelLabel: 'Limpiar',
        applyLabel: "Aplicar",
        linkedCalendars: false,
        daysOfWeek: [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sá"
        ],
        monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        },
      });
  
      $('.daterange').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('DD-MM-YYYY') + ' a ' + picker.endDate.format('DD-MM-YYYY'));
      });
  
      $('.daterange').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
      });
    
});