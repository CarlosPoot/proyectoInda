
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

// calendario
app.directive('datepicker', function() {
    return {
        restrict: 'A',
        require : 'ngModel',
        link : function (scope, element, attrs, ngModelCtrl){
            $(function(){
                $(element).datepicker({
                    dateFormat:'dd-mm-yy',
                    showOn: "button",
    	    		buttonImage: "libs/jquery-ui/images/arrow-down.png",
    	    		buttonImageOnly: false,
    	    		buttonText: "Seleccionar fecha",
    	    		changeMonth: attrs.changeMonth === 'true' ? true : false,
    	    	    changeYear: attrs.changeYear === 'true' ? true : false,
                    onSelect:function(date){
                        scope.$apply(function(){
                            ngModelCtrl.$setViewValue(date);
                        });
                    }
                });
            });
        }
    }
});