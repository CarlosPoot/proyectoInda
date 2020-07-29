
app.controller('menuPrincipalController', function($scope, $q, $timeout, servicioAjax, servicioRutas, servicioUsuario){
    
    loading(true, "Cargando...");
	$scope.usuario = {};
	$scope.menus = menu;
	
	var isRequested = false;
	var stop;
	var timeout = 0;
	
	$scope.actualizarSesion = function(){
		if(isRequested == false){
			if(angular.isDefined(stop)){
				$timeout.cancel(stop);
				stop = undefined;
			}
			$timeout(function(){
				$q.all([servicioUsuario.validarSesion()])
					.then(function(respuesta){
						stop = $timeout(function(){
								$q.all([servicioUsuario.validarSesion()])
									.then(function(respuesta){
										
									});
						}, timeout);
						isRequested = false;
				});
			},60000);
			isRequested = true;
		}
	}
	
	$q.all([servicioUsuario.validarSesion()]).then(function(respuesta){
        $scope.usuario = respuesta[0].usuario;
        timeout = respuesta[0].timeout * 1000 + 20000;
        loading(false);
	});
    
    //cerrar sesión
	$scope.cerrarSesion = function(){
		var params = {
			controlador : "Login",
			metodo : "cerrarSesion"
		};
		
		loading(true, "Cerrando sesión...");
		servicioAjax.request(params).then(function(response){
				servicioRutas.irHome();
		}).catch(function(){
				
		});
	};
	
	hasTouch = 'ontouchstart' in window;
	if(hasTouch){
		$(document.body).bind('touchstart',$scope.actualizarSesion);
	}else{
		$(document.body).bind('mousemove',$scope.actualizarSesion);
	}
	
});
