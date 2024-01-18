$(document).ready(function() {

  select2 = $(".select2").select2({
    language: "es",
    theme: "bootstrap-5",
    allowClear: true,
    placeholder: ""
  });

  multiple = $(".multiple2").select2({
    language: "es",
    theme: "bootstrap-5",
    allowClear: true,
    closeOnSelect: false,
    placeholder: ""
  });

    /*$(document).find('form').attr( "autocomplete", "off" ); 

    $('.datetimepicker').datetimepicker({
      format: 'DD-MM-YYYY',
      locale: 'es',
      maxDate: moment()
    });

    $('.datetimepickerMin').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: false,
        locale: 'es',
        maxDate: moment()
    });


    $('.datetimepickerMax').datetimepicker({
      format: 'DD-MM-YYYY',
      useCurrent: false,
      locale: 'es',
      minDate: moment()
    });

    $(".datetimepickerMin").on("dp.change", function (e) {
      $('.datetimepickerMax').data("DateTimePicker").minDate(e.date);
    });
    $(".datetimepickerMax").on("dp.change", function (e) {
      $('.datetimepickerMin').data("DateTimePicker").maxDate(e.date);
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
      showDropdowns: true,

      locale: {
      format: "DD-MM-YYYY",
      separator: " / ",
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
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' / ' + picker.endDate.format('DD-MM-YYYY'));
    });

    $('.daterange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });



*/

});



function select_menu(menu_id) {
  var element = "#" + menu_id;

  if ($(element).hasClass("collapsed")) {

    $(element).removeClass("collapsed");
    /*$(element).removeClass("expand");
    $(element).addClass("active expand");
    $(element).find('.collapse').addClass('show');*/

  }
}