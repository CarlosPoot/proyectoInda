servicioUsuario = function(servicioAjax, servicioRutas){
	
	this.validarSesion = function(){
		var params = {
			controlador : "Login",
			metodo : "getUsuarioLogueado"
		};
		
		return servicioAjax.request(params)
			.then(function(response){
				if(response.success == false){
					servicioRutas.irHome();
				}else{
					return response;
				}
			})
			.catch(function(){
				loading(false, "");
				mostrarError(true);
				return false;
			});
	};
	
};
