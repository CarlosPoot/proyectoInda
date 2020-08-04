
var app = angular.module('app', ['ngRoute', 'ngAnimate', 'ui.grid','ui.grid.pagination', 'ui.grid.moveColumns', 'ui.grid.selection']);
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

//servicio para fecha
app.factory('fecha', function() { //servicio para parsear fechas
    return {
        fechaconformato: function(fecha,formato) {
            mes = fecha.getMonth() + 1;
            dia = fecha.getDate();
            dia = (dia < 10) ? "0" + dia.toString() : dia.toString();
            mes = (mes < 10) ? "0" + mes.toString() : mes.toString();
            if( formato == 2 ){
                fechaString = dia + "-" + mes + "-" + fecha.getFullYear().toString();
            }else{
                fechaString = fecha.getFullYear().toString() + "-" + mes + "-" + dia;
            }
            return fechaString;
        },
        formatoSQL: function(fecha) {
            fechaArray = fecha.split("-");
            mes  = fechaArray[1];
            dia  = fechaArray[0];
            year = fechaArray[2];
            fechaString = year + "-" + mes + "-" + dia;
            return fechaString;
        }
    }
})