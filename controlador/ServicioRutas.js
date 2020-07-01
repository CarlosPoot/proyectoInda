
servicioRutas = function($location){	
	var home = "http://" + $location.host() + ":" + $location.port();
	home += window.location.pathname;
	
	this.irHome = function(){
		window.location.href = home;
	};
	
	this.getRutaServicioAjax = function(){
		return home + "modelo/Servicio.php";
    };
    
    // Metodos cliente
    this.getRutaServidor = function(){
		return home;
	};

};
