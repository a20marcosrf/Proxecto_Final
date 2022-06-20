<?php
session_start();
require_once("autoload.php");
use model\Producto_model;
// require_once("model/producto_model.php");

//Instanciamos clase Producto
$productos=new Producto_model();

//Metodos de la clase
$producto=$productos->get_producto();
$mostrar=$productos->mostrar();

$producto_ordenado=$productos->get_ordenado();
$mostrar_ordenado=$productos->mostrar_ordenado();

$producto_visitado=$productos->get_visitado();
$mostrar_visitado=$productos->mostrar_visitado();

require_once("view/html/shop_view.php");
