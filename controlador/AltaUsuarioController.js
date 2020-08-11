
app.controller('altaUsuarioController', function($scope, $q, $timeout, servicioAjax, fecha , servicioUsuario){
    
    $scope.cliente = {};
    $('[data-toggle="tooltip"]').tooltip();

    $scope.guardarCliente = function(){
        if( !validarCliente() ){
            return false;
        }

        var clienteSend   = angular.copy( $scope.cliente );
        clienteSend.fb    = fecha.formatoSQL(clienteSend.fb);
        // clienteSend.alta  = fecha.formatoSQL(clienteSend.alta);
        // clienteSend.diasTranscurridos  = fecha.formatoSQL(clienteSend.diasTranscurridos);
        
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
            $scope.cliente.oficina = $scope.usuario.oficina.descripcion;
		}, function(){})]).then(function(respuestas){
			loading(false, "");
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

        return true;
    }
   

    $q.all([servicioUsuario.validarSesion()]).then(function(respuesta){
        $scope.usuario = respuesta[0].usuario;
        $scope.cliente.oficina = $scope.usuario.oficina.descripcion;
        timeout = respuesta[0].timeout * 1000 + 20000;
        loading(false);
	});

});
