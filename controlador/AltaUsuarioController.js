
app.controller('altaUsuarioController', function($scope, $q, $timeout, servicioAjax, fecha , servicioUsuario){
    

    $scope.cliente = {};
    $('[data-toggle="tooltip"]').tooltip();

    $scope.$watch('cliente.alta', function(newVal, oldVal){
        if( newVal ){

            fechaArray = newVal.split("-");
            nuevaFecha = new Date(Date.UTC( fechaArray[2] , Number(fechaArray[1]-1), fechaArray[0] , 0, 0, 0));
            nuevaFecha.setDate(  nuevaFecha.getDate() + 48 );
            $scope.cliente.diasTranscurridos =  fecha.fechaconformato(nuevaFecha, 2);
            
        }

    }, true);

    $scope.guardarCliente = function(){
        if( !validarCliente() ){
            return false;
        }

        var clienteSend   = angular.copy( $scope.cliente );
        clienteSend.fb    = fecha.formatoSQL(clienteSend.fb);
        clienteSend.alta  = fecha.formatoSQL(clienteSend.alta);
        clienteSend.diasTranscurridos  = fecha.formatoSQL(clienteSend.diasTranscurridos);
        
        loading(true,"Creando cliente...");
		var params = {
			controlador : "Cliente",
			metodo : "crearCliente",
			cliente : clienteSend
        };
        
        $q.all([servicioAjax.llamadaAjax(params, function( respuesta ){
            loading(false);
            mostrarMensajeModal("Operación exitosa", respuesta.mensaje );
            $scope.cliente = {};
		}, function(){})]).then(function(respuestas){
			loading(false, "");
		});
    }


    var validarCliente = function(){
        console.log( $scope.cliente.numeroCliente )
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
        }else if( !$scope.cliente.alta ){
            mostrarMensajeModal("Datos incompletos", "Ingrese la fecha del alta por favor");
            return false;
        }else if( !$scope.cliente.comentarios ){
            mostrarMensajeModal("Datos incompletos", "Ingrese comentario por favor");
            return false;
        }

        return true;
    }
   
      



});
