    
app.controller('consultaUsuarioController', function($scope, $q, servicioAjax, $timeout  ,servicioUsuario, i18nService, uiGridConstants, fecha){
    
    $('[data-toggle="tooltip"]').tooltip();
    loading(false);
    $scope.clientes = [];
    $scope.inicial = true;
    $scope.bloquearBusqueda = false;
    i18nService.setCurrentLang('es');
        
    $scope.paginationOptions = {
        estadoCliente:"1",
        pageNumber: 1,
        pageSize: 20,
        sort: {
            columna: "",
            orden: ""
        },
        filtros: []
    };

    $scope.$watch('cliente.alta', function(newVal, oldVal){
        if( newVal && $scope.opcion.idOpcion == 2 ){
            fechaArray = newVal.split("-");
            if( fechaArray.length == 3  ){
                nuevaFecha = new Date(Date.UTC( fechaArray[2] , Number(fechaArray[1]-1), fechaArray[0] , 0, 0, 0));
                nuevaFecha.setDate(  nuevaFecha.getDate() + 48 );
                $scope.cliente.diasTranscurridos =  fecha.fechaconformato(nuevaFecha, 2);
            }else{
                $scope.cliente.diasTranscurridos = "";
            }
        }
    }, true);


    inicializarConfigOpcion = function(){
        $scope.opcion = {
            idOpcion:0,
            titulo:"",
            textoBoton:"",
            textoCerrar:"",
            mostrarBotonAceptar:false,
            funcion:function(){},
        }
    }

    $scope.$watch('paginationOptions.estadoCliente', function(newVal, oldVal){
        if( newVal && !$scope.inicial ){
            $scope.bloquearBusqueda = true;
            $scope.getDatos( $scope.paginationOptions.pageSize , $scope.paginationOptions.pageNumber, $scope.paginationOptions.sort );
        }
    }, true);

    var statusTemplate = `
    <button type="button" class="btn btn-secondary dropdown-toggle py-0  px-2 text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-cog"></i>
    </button>
    <div class="dropdown-menu px-2 mx-2" style="min-width:8rem" >
        <a class="dropdown-item px-0 mx-0" ng-click="grid.appScope.verDetalles(row.entity)">Ver detalles</a>
        <a class="dropdown-item px-0 mx-0" ng-click="grid.appScope.editarCliente(row.entity)">Editar</a>
    </div>`;

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
            { field: 'numeroCliente', name: 'Número cliente'  },
            { field: 'nombre', name:'Nombre' },
            { field: 'apellido', name:'Apellido'},
            { field: 'nss', name :'NSS' },
            { field: 'curp', name: 'Curp' },
            { field: 'afore', name :'Afore'},
            { field: 'asesor', name: 'Asesor'},
            { field: 'alta', name: "Alta" , maxWidth: 80 },
            { field: 'diasTranscurridos', name: "47 días", maxWidth: 80  },
            { field: "opciones", name:"Acciones", maxWidth: 60, enableRowHeaderSelection: false, cellClass: 'text-center', enableFiltering: false, enableSorting:false,cellTemplate: statusTemplate  }
        ],
        onRegisterApi: function (gridApi) {
            $scope.gridApi = gridApi;
            // ordenamiento
            $scope.gridApi.core.on.sortChanged($scope, function(grid, sortColumns) {
                console.log("ordenamiento")
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
                console.log("filtros")
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
                console.log("paginacion")
                $scope.paginationOptions.pageNumber = newPage;
                $scope.paginationOptions.pageSize = pageSize;
                
                if( $scope.bloquearBusqueda ){
                    return;
                }
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
        if( !$scope.paginationOptions.estadoCliente ){
            mostrarMensajeModal("Datos incompletos", "Por favor selecciona el estado de cliente a filtrar");
            return;
        }

        var params = {
            controlador: "Cliente",
            metodo: "getClientes",
            numRegistros: numRegistros,
            pagina: pagina,
            orden: orden,
            filtros: filtros ? filtros: [],
            busqueda: $scope.seHizoBusqueda ? $scope.documentosBusqueda : [],
            estadoCliente: $scope.paginationOptions.estadoCliente
        }

        loading(true, "Cargando información...");
        $q.all([servicioAjax.llamadaAjax(params,function( respuesta ){
            $scope.gridOptions.data = respuesta.registros;
            $scope.gridOptions.totalItems = respuesta.totalRegistros;
        }, function(){})]).then(function(respuesta){
            loading(false,"");
            $scope.inicial = false;
            $scope.bloquearBusqueda = true;
        });
    }

    $scope.getDatos( $scope.paginationOptions.pageSize , $scope.paginationOptions.pageNumber, $scope.paginationOptions.sort );

    $scope.verDetalles = function( cliente ){
        $scope.cliente = angular.copy(cliente);
        inicializarConfigOpcion()
        $scope.opcion.idOpcion = 1;
        $scope.opcion.titulo = "Detalles del cliente";
        $scope.opcion.textoCerrar  = "Aceptar";
        setTimeout(()=>{
            $("#modalAccion").modal("show");
        });
    }

    $scope.copiarInfo = function(){
        var texto = $scope.cliente.afore + " - " + $scope.cliente.asesor + "\r\n";
        texto += $scope.cliente.numeroCliente + " - " + $scope.cliente.nombre + ", " + $scope.cliente.nss + ", ";
        texto += $scope.cliente.curp + ", SC:" + $scope.cliente.sc + ", SD:" + $scope.cliente.sd + ", FB:" + $scope.cliente.fb + ", ";
        texto += "ALTA DE UN DIA CON SBC:" + $scope.cliente.sbc;

        var miModal = document.getElementById("modalAccion");
        var miInput = document.createElement('textarea');
        miInput.innerHTML = texto;
        miModal.appendChild(miInput);
        miInput.select();
        document.execCommand('copy');
        miModal.removeChild(miInput);
    }
   
    $scope.editarCliente = function( cliente ){
        $scope.cliente = angular.copy(cliente);
        $scope.cliente.oficina = $scope.cliente.oficina.descripcion;
        $scope.cliente.nss = Number($scope.cliente.nss);
        $scope.cliente.sc = Number($scope.cliente.sc);
        $scope.cliente.sd = Number($scope.cliente.sd);
        $scope.cliente.fb = fecha.formatoPicker($scope.cliente.fb);
        $scope.cliente.alta = $scope.cliente.alta == "0000-00-00" ? "":fecha.formatoPicker($scope.cliente.alta);
        $scope.cliente.diasTranscurridos = $scope.cliente.diasTranscurridos == "0000-00-00" ? "":fecha.formatoPicker($scope.cliente.diasTranscurridos);
        
        inicializarConfigOpcion();
        $scope.opcion.idOpcion = 2;
        $scope.opcion.titulo = "Editar cliente";
        $scope.opcion.textoCerrar = "Cancelar";
        $scope.opcion.textoBoton  = "Guardar";
        $scope.opcion.mostrarBotonAceptar = true;
        $scope.opcion.funcion = actualizarCliente;
        setTimeout(()=>{
            $("#modalAccion").modal("show");
        });
    }

    var validarCliente = function(){
        if( !$scope.cliente.numeroCliente ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el número de cliente por favor");
            return false;
        }else if( !$scope.cliente.nombre ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el nombre del cliente por favor");
            return false;
        }else if( !$scope.cliente.apellido ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el apellido del cliente por favor");
            return false;
        }else if( !$scope.cliente.nss ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el NSS del cliente por favor");
            return false;
        }else if( !$scope.cliente.curp ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el curp del cliente por favor");
            return false;
        }else if( !$scope.cliente.afore ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el afore del cliente por favor");
            return false;
        }else if( !$scope.cliente.sc ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el SC de cliente por favor");
            return false;
        }else if( Number($scope.cliente.sd) == NaN || Number( $scope.cliente.sd) <0 ){
            mostrarMensajeModal("Datos incompletos", "Ingrese las semanas descontadas de cliente por favor");
            return false;
        }else if( !$scope.cliente.fb ){
            mostrarMensajeModal("Datos incompletos", "Ingrese la fecha de baja de cliente por favor");
            return false;
        }else if( !$scope.cliente.sbc ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el salario base cotizado por favor");
            return false;
        }else if( !$scope.cliente.comentarios ){
            mostrarMensajeModal("Datos incompletos", "Ingrese comentario por favor");
            return false;
        }

        if(  $scope.cliente.alta ){
            fechaArray = $scope.cliente.alta.split("-");
            if( fechaArray.length != 3 ){
                $scope.cliente.alta = "";
            }
        }

        return true;
    }

    var actualizarCliente = function(){
        if( !validarCliente() ){
            return false;
        }

        var clienteSend   = angular.copy( $scope.cliente );
        console.log( clienteSend  )
        clienteSend.fb    = fecha.formatoSQL(clienteSend.fb);
        clienteSend.alta  = clienteSend.alta ? fecha.formatoSQL(clienteSend.alta):"";
        clienteSend.diasTranscurridos  = clienteSend.diasTranscurridos ? fecha.formatoSQL(clienteSend.diasTranscurridos):"";
        
        loading(true,"Creando cliente...");
		var params = {
			controlador : "Cliente",
			metodo : "actualizarCliente",
			cliente : clienteSend
        };

        $("#modalAccion").modal("hide");
        $q.all([servicioAjax.llamadaAjax(params, function( respuesta ){
            loading(false);
            mostrarMensajeModal("Operación exitosa", respuesta.mensaje );
            $scope.cliente = {};
            $scope.cliente.oficina = $scope.usuario.oficina.descripcion;
            $scope.getDatos( $scope.paginationOptions.pageSize , $scope.paginationOptions.pageNumber, $scope.paginationOptions.sort );
		}, function(){})]).then(function(respuestas){
			loading(false, "");
		});
    }

});
