<?php

namespace model;

class Producto_model
{

    private $db;
    private $producto;
    private $producto_ordenado;
    private $producto_visitado;

    public function __construct()
    {
        require_once("conectar.php");
        $this->db = Conectar::dbConnect();
        $this->producto = array();
        $this->producto_ordenado = array();
        $this->producto_visitado = array();
    }

    //Obtenemos los productos de la base de datos
    public function get_producto()
    {

        $numRegistros = 6; //Registros por página
        $pagina = 1; //por defecto a pagina será la primera
        //primero obtenemos el parámetro que nos dice en qué página estamos
        if (array_key_exists('pag', $_GET)) {
            $pagina = $_GET['pag'];
        }

        $pdo = $this->db;
        $stmt = $pdo->query("select * from producto");
        $totalRegistros = $stmt->rowCount();
        $totalPaginas = ceil($totalRegistros / $numRegistros);

        $sql = "select codigo,nombre,grupo,cantidad,precio,url,descripcion from producto";
        // Obtenemos el segmento paginado que corresponde a esta página
        $sql .= " LIMIT " . (($pagina - 1) * $numRegistros) . ", $numRegistros ";
        $stmt = $pdo->query($sql);


        $filas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($filas as $fila) {
            $this->producto[] = $fila;
        }
        unset($pdo);
        unset($stmt);
        return $this->producto;
    }

    //Mostramos los productos por pantalla
    public function mostrar()
    {

        $producto = "";
        foreach ($this->producto as $prod) {
            $producto .= "<div class='card'>
            <img src='" . $prod["url"] . "' style='width:100%'>
            <h1>" . $prod["nombre"] . "</h1>
            <p class='price'>" . $prod["precio"] . " €</p>
            <p>" . $prod["descripcion"] . "</p>";
            $producto .= "<form action='";
            $producto .= htmlspecialchars($_SERVER["PHP_SELF"]);
            $producto .= "' method='POST'>";
            if (isset($_SESSION["email"])) {
                $producto .= "<p><button><a href='ingrediente.php?producto=" . $prod["codigo"] . "'>Ver Ingredientes</a></button></p><p><button type='submit' name='comprar'>Al carrito</button></p>
                <input name = 'cod' type='hidden' value = '" . $prod["codigo"] . "'></form></div>";
            } else {
                $producto .= "<p><button disabled><a>Ver Ingredientes</a></button></p><p><button type='submit' disabled>Al carrito</button></p></form></div>";
            }
        }
        return $producto;
    }

    //Obtenemos los productos ordenados segun los inputs del formulario
    public function get_ordenado()
    {
        try {
            $pdo = $this->db;
            $sql = "select codigo,nombre,grupo,cantidad,precio,url,descripcion from producto ";

            $sql .= "where grupo like :grupo ";
            $grupo = isset($_POST['ordenar']) ? ($_POST['ordenar'] . "%") : "%";

            $ord = isset($_POST["ord"]) ? $_POST["ord"] : "asc";
            if (isset($_POST["ordenar2"])) {
                $sql .= "order by " . $_POST["ordenar2"] . " " . $ord . ";";
            } else {
                $sql .= "order by codigo;";
            }
            //echo var_dump($sql)."<br>";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":grupo", $grupo, \PDO::PARAM_STR);
            $stmt->execute();


            while ($filas = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $this->producto_ordenado[] = $filas;
            }
            unset($pdo);
            unset($stmt);
            return $this->producto_ordenado;
        } catch (\PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    //Mostramos los productos ordenados
    public function mostrar_ordenado()
    {

        $producto = "";
        foreach ($this->producto_ordenado as $prod) {
            $producto .= "<div class='card'>
            <img src='" . $prod["url"] . "' style='width:100%'>
            <h1>" . $prod["nombre"] . "</h1>
            <p class='price'>" . $prod["precio"] . " €</p>
            <p>" . $prod["descripcion"] . "</p>";
            $producto .= "<form action='";
            $producto .= "../Proy/model/anadir_carrito.php";
            $producto .= "' method='POST'>";
            if (isset($_SESSION["email"])) {
                $producto .= "<p><button><a href='ingrediente.php?producto=" . $prod["codigo"] . "'>Ver Ingredientes</a></button></p><p></button></p><p><button type='submit' name='comprar'>Al carrito</button></p>
                <input name = 'cod' type='hidden' value = '" . $prod["codigo"] . "'></form></div>";
            } else {
                $producto .= "<p><button disabled><a>Ver Ingredientes</a></button></p><p><button type='submit' disabled>Al carrito</button></p></form></div>";
            }
        }

        return $producto;
    }

    public function anadir_carrito($cod)
    {
        setcookie("cookieCarrito", $_SESSION['carrito'][$cod], time() + (86400 * 30), "/");
        if (isset($_SESSION['carrito'][$cod])) {
            $_SESSION['carrito'][$cod] += 1;
        } else {
            $_SESSION['carrito'][$cod] = 1;
        }
    }

    // public function get_visitado($cod)
    // {
    //     $pdo = $this->db;
    //     $sql = "select codigo,nombre,precio,url,descripcion from producto where codigo = :prod";
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->bindValue(":prod", $_GET["producto"], \PDO::PARAM_STR);
    //     $stmt->execute();
    //     $filas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    //     foreach ($filas as $fila) {
    //         $this->producto_visitado[] = $fila;
    //     }
    //     unset($pdo);
    //     unset($stmt);
    //     return $this->producto_visitado;
    // }

    function get_visitado()
    {

        foreach ($_COOKIE["ingredienteVisto"] as $producto) {
            $pdo = $this->db;
            $sql = "select codigo,nombre,precio,url,descripcion from producto where codigo = :prod";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":prod", $producto, \PDO::PARAM_STR);
            $stmt->execute();
            $filas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($filas as $fila) {
                $this->producto_visitado[] = $fila;
            }
        }
        unset($pdo);
        unset($stmt);
        return $this->producto_visitado;
    }

    public function mostrar_visitado()
    {

        $producto = "";
        foreach ($this->producto_visitado as $prod) {
            $producto .= "<div class='card'>
            <img src='" . $prod["url"] . "' style='width:100%'>
            <h1>" . $prod["nombre"] . "</h1>
            <p class='price'>" . $prod["precio"] . " €</p>
            <p>" . $prod["descripcion"] . "</p>";
            $producto .= "<form action='";
            $producto .= htmlspecialchars($_SERVER["PHP_SELF"]);
            $producto .= "' method='POST'>";
            if (isset($_SESSION["email"])) {
                $producto .= "<p><button><a href='ingrediente.php?producto=" . $prod["codigo"] . "'>Ver Ingredientes</a></button></p><p><button type='submit' name='comprar'>Al carrito</button></p>
                <input name = 'cod' type='hidden' value = '" . $prod["codigo"] . "'></form></div>";
            } else {
                $producto .= "<p><button disabled><a>Ver Ingredientes</a></button></p><p><button type='submit' disabled>Al carrito</button></p></form></div>";
            }
        }
        return $producto;
    }
}
