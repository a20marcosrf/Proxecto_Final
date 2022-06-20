<?php

namespace model;

class Ingrediente_model{
    private $db;

    private $producto_ingrediente;


    public function __construct()
    {
        require_once("conectar.php");
        $this->db = Conectar::dbConnect();
        $this->producto_ingrediente = array();
    }

    
    public function get_productoIngrediente()
    {
        $pdo = $this->db;
       
        $sql = "select producto,(select nombre from producto where codigo=producto_ingrediente.producto) as nombre_prod, ingrediente as num_ingrediente,
        (select nombre from ingrediente where codigo=producto_ingrediente.ingrediente) as ingrediente from producto_ingrediente where producto=:prod;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":prod", $_GET["producto"], \PDO::PARAM_STR);
        $stmt->execute();
        //$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        while ($filas = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->producto_ingrediente[] = $filas;
        }
        unset($pdo);
        unset($stmt);
        return $this->producto_ingrediente;
    }


    public function mostrar(){
        $res="";
        $i=1;
        echo $this->producto_ingrediente[0]["nombre_prod"] . "<br>";
        foreach ($this->producto_ingrediente as $prod) {
            $res.= "Ingrediente : <input type='text' name='prod".$i."' value='".$prod["ingrediente"]."'>"."<br>";
            $i++; 
        }
        return $res;
    }

    public function eliminar($producto){
        
        try{
            $pdo=$this->db;
            $pdo->beginTransaction();
            $sql="Delete from producto_ingrediente where producto = :prod;";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":prod",$producto,\PDO::PARAM_INT);

            if($res=$stmt->execute()==1){
                unset($sql);
                unset($stmt);
                $sql="Delete from producto where codigo = :prod;";
                $stmt=$pdo->prepare($sql);
                $stmt->bindParam(":prod",$producto,\PDO::PARAM_INT);

                if($res=$stmt->execute()==1){
                    $pdo->commit();
                    unset($stmt);
            }
            
        }
        }catch(\PDOException $e){
            $pdo->rollBack();
            echo $e->getMessage();

        }

            
    }
}