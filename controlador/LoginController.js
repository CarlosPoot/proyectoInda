
var app = angular.module('login', ['ngRoute','ngAnimate']);
app.service('servicioRutas', servicioRutas);
app.service('servicioAjax', ['$http','$q','$location','servicioRutas', servicioAjax]);
app.controller('loginController', function($scope, $location, $timeout, $q, servicioAjax, servicioRutas){
    
    $scope.contrasena = "";
    $scope.usuario = "";
    loading( false );
    
    $scope.iniciarSesion = function(){
        if( validar() ){
            var params = {
				controlador : "Login",
				metodo : "iniciarSesion",
				usuario : $scope.usuario != undefined ? $scope.usuario : '',
				contrasena : $scope.contrasena != undefined ? $scope.contrasena : '' 
			};
            loading(true, "Iniciando sesión...");
            $q.all([servicioAjax.llamadaAjax(params, funcionSuccessLogin, function(){})]).then(function(respuestas){
				loading(false, "");
			});
        }
    }

    funcionSuccessLogin = function(){
        $timeout(
            window.location.reload(),
            1500
        );
    }

    validar = function(){
		if($scope.usuario == undefined || $scope.usuario == ""){
			mostrarMensajeModal("Datos incompletos", "Ingrese su usuario por favor");
			return false;
		}
		if($scope.contrasena == undefined || $scope.contrasena == ""){
			mostrarMensajeModal("Datos incompletos", "Ingrese su contraseña por favor");
			return false;
		}
		return true;
	};
});

	