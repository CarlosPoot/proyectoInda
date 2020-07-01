
servicioAjax = function($http, $q, $location, servicioRutas ){
    
    var rutaServidor = servicioRutas.getRutaServicioAjax();	
	this.request = function (parametros){
		var defered = $q.defer();
		var promise = defered.promise;
		
		param = JSON.stringify(parametros);
		$http({
			method:	'POST',
			url : rutaServidor,
			headers: { 'Content-Type': 'application/json; charset=UTF-8' },
			data:	param
		}).success(function(data){
			defered.resolve(data);
		}).error(function(err, status, headers, config){
            if(status == 403){
                servicioRutas.irHome();
            }
            defered.reject(err);
		});
		return promise;
	};
	
	this.request2 = function (parametros){
		var defered = $q.defer();
		var promise = defered.promise;
		
		$http({
			method:	'POST',
			url : rutaServidor,
			headers: {'Content-Type': undefined},
			data:	parametros
			})
			.success(function(data){
				defered.resolve(data);
			})
			.error(function(err, status, headers, config){
				if(status == 403){
					servicioRutas.irHome();
				}
				defered.reject(err);
			});
			
		return promise;
    };
    
    // Metodos cliente
    this.llamadaAjax = function( params, funcionSuccess , funcionError){
		var funcion = params instanceof FormData ? this.request2 : this.request;
		return funcion(params).then(function(respuesta){
			if(respuesta.success == true){
				funcionSuccess(respuesta);
				return true;
			}else{
				mostrarMensajeModal("Error", "" + respuesta.mensaje);
				return false;
			}
		}).catch(function(){
			funcionError();
			return false;
		});
	};
    //Fin metodo cliente

};