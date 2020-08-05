
app.controller('consultaUsuarioController', function($scope, $q, servicioAjax, servicioUsuario, i18nService, uiGridConstants){
    
    loading(false);
    $scope.clientes = [];

    i18nService.setCurrentLang('es');
    $scope.paginationOptions = {
        pageNumber: 1,
        pageSize: 20,
        sort: {
            columna: "",
            orden: ""
        },
        filtros: []
    };

    $scope.gridOptions = {
        paginationPageSizes: [10,15, 20, 30, 50],
        paginationPageSize: $scope.paginationOptions.pageSize ,
        useExternalPagination: true,
        enableSorting: true,
        enableFiltering: false,
        filterOptions: $scope.filterOptions,
        multiSelect: false,
        expandableRowHeight: 150,
        showExpandAllButton: false,
        enableGridMenu: true,
        enableRowSelection: true,
        enableRowHeaderSelection: false,
        enableColumnMenus: false,
        columnDefs: [
            { field: 'numeroCliente', name: 'Número cliente', maxWidth: 135  },
            { field: 'nombre', name:'Nombre', maxWidth: 50 },
            { field: 'apellido', name:'Apellido', maxWidth: 50 },
            { field: 'nss', name :'NSS', maxWidth: 100 },
            { field: 'curp', name: 'Curp', maxWidth: 90 },
            { field: 'afore', name :'Afore', maxWidth: 140 },
            { field: 'asesor', name: 'Asesor', maxWidth: 240 },
            { field: 'alta', name: "Alta" },
            { field: 'diasTranscurridos', name: "47 días" }
        ],
        onRegisterApi: function (gridApi) {
            $scope.gridApi = gridApi;
            // ordenamiento
            $scope.gridApi.core.on.sortChanged($scope, function(grid, sortColumns) {
                if (sortColumns.length == 0) {
                  $scope.paginationOptions.sort.orden = "";
                  $scope.paginationOptions.sort.columna = "";
                } else {
                  $scope.paginationOptions.sort.orden = sortColumns[0].sort.direction;
                  $scope.paginationOptions.sort.columna = sortColumns[0].field;
                }
                $scope.getDatos( $scope.paginationOptions.pageSize , $scope.paginationOptions.pageNumber , $scope.paginationOptions.sort, $scope.paginationOptions.filtros );
            });

            // Filtros
            $scope.gridApi.core.on.filterChanged( $scope, function() {
                var grid = this.grid;
                $scope.paginationOptions.filtros = [];
                for ( x in  grid.columns ) {
                    if( grid.columns[x].filters[0].term ){
                        var filtro = {
                            campo:  grid.columns[x].field,
                            termino: grid.columns[x].filters[0].term
                        }

                        $scope.paginationOptions.filtros.push( filtro );
                    }
                }
                
                // se retrasa la busqueda medio segundo
                $timeout.cancel( $scope.busquedaInfo );
                $scope.busquedaInfo = $timeout( function(){
                    $scope.paginationOptions.pageNumber = 1;
                    $scope.gridApi.pagination.seek( $scope.paginationOptions.pageNumber );
                    $scope.getDatos( $scope.paginationOptions.pageSize, $scope.paginationOptions.pageNumber, $scope.paginationOptions.sort, $scope.paginationOptions.filtros );
                },700);
                
            });

            // Paginación
            $scope.gridApi.pagination.on.paginationChanged($scope, function (newPage, pageSize) {
                $scope.paginationOptions.pageNumber = newPage;
                $scope.paginationOptions.pageSize = pageSize;
                $scope.getDatos( pageSize, newPage, $scope.paginationOptions.sort, $scope.paginationOptions.filtros );
                $scope.gridApi.core.scrollTo( 
                    $scope.gridOptions.data[0],
                    $scope.gridOptions.columnDefs[0]
                )
            });

            // Ocultat mostrar filtros
            $scope.gridOptions.gridMenuCustomItems =  [
                {
                    title: 'Ocultar Filtros',
                    icon: 'fas fa-filter ocultarFiltro',
                    leaveOpen: true,
                    order: 0,
                    action: function ($event) {
                        $scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
                        $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
                    },
                    shown: function () {
                        return $scope.gridOptions.enableFiltering;
                    }
                },
                {
                    title: 'Mostrar Filtros',
                    icon: 'fas fa-filter mostrarFiltro',
                    leaveOpen: true,
                    order: 0,
                    action: function ($event) {
                        $scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
                        $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
                    },
                    shown: function () {
                        return !$scope.gridOptions.enableFiltering;
                    }
                }
            ]
        }
    };


    $scope.getDatos = function( numRegistros, pagina, orden , filtros ){
        var params = {
            controlador: "Cliente",
            metodo: "getClientes",
            numRegistros: numRegistros,
            pagina: pagina,
            orden: orden,
            filtros: filtros ? filtros: [],
            busqueda: $scope.seHizoBusqueda ? $scope.documentosBusqueda : []
        }

        loading(true, "Cargando información...");
        $q.all([servicioAjax.llamadaAjax(params,function( respuesta ){
            $scope.gridOptions.data = respuesta.registros;
            $scope.gridOptions.totalItems = respuesta.totalRegistros;
        }, function(){})]).then(function(respuesta){
            loading(false,"");
        });
    }

});
