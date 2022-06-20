<?php
    require_once("autoload.php");
    session_start();
    
    use model\Ingrediente_model;
    // require_once("model/ingrediente_model.php");
    
    //Instanciamos clase Ingredientes
    $ingredientes= new Ingrediente_model;


    //Metodos de la clase
    $producto_ingredientes=$ingredientes->get_productoIngrediente();
    
    require_once("view/html/ingrediente_view.php");

?>