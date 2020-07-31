
app.controller('altaUsuarioController', function($scope, $q, $timeout, servicioAjax, servicioRutas, servicioUsuario){
    

    $scope.cliente = {};
    $('[data-toggle="tooltip"]').tooltip();

    
    var validarCliente = function(){
        if( !$scope.cliente.numeroCliente ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el número de cliente por favor");
            return false;
        }else if( !$scope.cliente.oficina ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el número del cliente por favor");
            return false;
        }else if( !$scope.cliente.nombre ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el nombre del cliente por favor");
            return false;
        }else if( !$scope.cliente.apellido ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el apellido del cliente por favor");
            return false;
        }else if( !$scope.cliente.nss ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el nss del cliente por favor");
            return false;
        }else if( !$scope.cliente.curp ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el curp del cliente por favor");
            return false;
        }else if( !$scope.cliente.afore ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el afore del cliente por favor");
            return false;
        }else if( !$scope.cliente.sc ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el NSS de cliente por favor");
            return false;
        }else if( !$scope.cliente.sd ){
            mostrarMensajeModal("Datos incompletos", "Ingrese las semnas descontadas de cliente por favor");
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
        
    }
   
      



});
