<?php
include 'modelo/clases_sistema/Autoloader.php';
new Autoloader("modelo/");

$s = new Session();
if($s->isOpen()){
    
	$menu = new Menu();
	$menu->getMenu($s->getIdSesion());
	$vista = file_get_contents("vista/MenuPrincipal.html");
	$vista = str_replace("@scriptMenus", $menu->getMenus(), $vista);
	$vista = str_replace("@scriptControladores", $menu->getScripts(), $vista);
    $vista = str_replace("@script", $menu->getRutas(), $vista);
    
	
}else{

	$menu = new Menu();
	$menu->getMenuLogin();
	$vista = file_get_contents("vista/Login.html");	
	$vista = str_replace("@script", $menu->getScripts(), $vista);
	
}

echo $vista;