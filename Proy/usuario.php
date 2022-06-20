<?php

require_once("model/conectar.php");

try {
    $db = model\Conectar::dbConnect();
    $sql="Delete from usuario where codigo=".$_GET["usu"].";";
    if($stmt=$db->query($sql)==1){
        header("Location:profile.php");
    }
    else{
        header("Location:profile.php");
    }
} catch (PDOException $e) {
    echo '<p>No conectado !!</p>';
    echo $e->getMessage();
    exit;
}

