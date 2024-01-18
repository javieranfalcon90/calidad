
    function createDatatable(route, columns, sortcolumns) {

        var dataTable = $('#datatable').DataTable({
            responsive: true,
            columns: columns,
            searchDelay: 2000,
            autoWidth: false,
            order: [[0, "DESC"]], // Define el orden por defecto y la columna a ordenar
            columnDefs: [
                { responsivePriority: 1, targets: -1 },
                { searchable: false, targets: sortcolumns }, //Define las columnas que  no van a ser filtrables
                { orderable: false, targets: sortcolumns }, //Define las columnas que  no van a ser ordenables
            ],
            deferRender: true, //Opcion que permite una mayor velocidad de inicializacion(disponible desde la version 1.10)
            language: {
                paginate: {
                    first: "<<",
                    previous: "<",
                    next: ">",
                    last: ">>"
                },
                sLengthMenu: "Mostrar _MENU_ registros",
                sInfo: "Mostrando _START_ al _END_ de _TOTAL_ elementos",
                sInfoEmpty: "No hay datos para mostrar",
                sEmptyTable: "No hay datos para mostrar",
                sInfoFiltered: "(filtrado de _MAX_ elementos en total)",
                //sLoadingRecords: "Cargando...",
                //sProcessing: "Procesando...",
                sSearch: "Buscar:",
                sZeroRecords: "No se encontraron resultados"
            },
            processing: true,
            serverSide: true,
            ajax: route
        });

        return dataTable;

    }