
var app = angular.module('app', ['ngRoute', 'ngAnimate', 'ngTable']);
app.service('servicioRutas', servicioRutas);
app.service('servicioAjax', ['$http','$q','$location','servicioRutas', servicioAjax]);
app.service('servicioUsuario', ['servicioAjax', 'servicioRutas',servicioUsuario]);

app.config(function($routeProvider){
	for(var x in arrayRutas){
		$routeProvider.when(arrayRutas[x].url,{
			templateUrl : arrayRutas[x].template,
			controller : arrayRutas[x].controller
		});
	}
	
	$routeProvider.otherwise({
		redirectTo : '/'
    });
    
});