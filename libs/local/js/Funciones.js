
loading = function(toggle, texto){
	if(toggle == true){
		$("#textoLoading").text(texto);
		$("#loadingPrincipal").show();
	}else{
		$("#loadingPrincipal").hide();
	}
};


mostrarMensajeModal = function(titulo, mensaje){
	mensaje = mensaje.replace(/(?:\r\n|\r|\n)/g, '<br/>');
	$("#tituloModalMensaje").text(titulo);
	$("#bodyModalMensaje").html(mensaje);
    // $("#modalMensaje").modal('show');	
    window.$('#modalMensaje').modal();
};

