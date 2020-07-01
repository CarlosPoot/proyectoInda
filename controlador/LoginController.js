
var app = angular.module('login', ['ngRoute','ngAnimate']);
app.service('servicioRutas', servicioRutas);
app.service('servicioAjax', ['$http','$q','$location','servicioRutas', servicioAjax]);
app.controller('loginController', function($scope, $location, $timeout, $q, servicioAjax, servicioRutas){
    
   
    


	
});

	