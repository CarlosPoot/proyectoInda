
loading = function(toggle, texto){
	if(toggle == true){
		$("#textoLoading").text(texto);
		$("#contenedorVistas").hide();
		$("#loadingPrincipal").show();
	}else{
		$("#loadingPrincipal").hide();
		$("#contenedorVistas").show();
	}
};


mostrarMensajeModal = function(titulo, mensaje){
	mensaje = mensaje.replace(/(?:\r\n|\r|\n)/g, '<br />');
	$("#tituloMensajeModal").text(titulo);
	$("#bodyMensajeModal").html(mensaje);
	$("#mensajeModal").modal('show');	
};

