
app.controller('altaUsuarioController', function($scope, $q, $timeout, servicioAjax, servicioRutas, servicioUsuario){
    

    $scope.cliente = {};
    $('[data-toggle="tooltip"]').tooltip();

    
    var validarCliente = function(){
        if( !$scope.cliente.numeroCliente ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el número de cliente por favor");
            return false;
        }else if( !$scope.cliente.oficina ){
            mostrarMensajeModal("Datos incompletos", "Ingrese el número de cliente por favor");
            return false;
        }
        
    }
   
      



});
