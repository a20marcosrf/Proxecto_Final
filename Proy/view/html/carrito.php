<?php
require_once("model/conectar.php");
session_start();

$productos = implode(",", array_keys($_SESSION["carrito"]));

function getProd($cod)
{
    $db = model\Conectar::dbConnect();
    $sql = "select codigo,nombre,precio from producto where codigo in (" . $cod . ")";
    $stmt = $db->query($sql);
    $filas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return $filas;
}


function mostrar($array)
{
    $msg = "<div class='container_carrito'>";
    $precio = 0;

    foreach ($array as $producto) {
        $msg .= "<div class='card'><input type'text' name='nombre' value='" . $producto["nombre"] . "    (ud. " . $producto["precio"] . "€)" . "' disabled>";
        $msg .= " Cantidad:<input type'text' name='nombre' value='" . $_SESSION["carrito"][$producto["codigo"]] . "' disabled>";
        $precio += ($producto["precio"] * $_SESSION["carrito"][$producto["codigo"]]);
        $msg .= "<a href='carrito.php?codElim=" . $producto["codigo"] . "'><button>Eliminar</button></a>";
        $msg .= "<a href='carrito.php?cod=" . $producto["codigo"] . "'><button>Añadir</button></a></div>";
    }
    $msg .= "</div><p>Precio total a pagar en el establecimiento: ";
    $msg .= $precio . "€</p>";
    return $msg;
}



function eliminar($prod)
{
    $_SESSION["carrito"][$prod]--;
    if ($_SESSION["carrito"][$prod] == 0) {
        unset($_SESSION["carrito"][$prod]);
    }
    header("Location:carrito.php");
}

function anhadir($prod)
{
    $_SESSION["carrito"][$prod]++;
    if ($_SESSION["carrito"][$prod] == 0) {
        unset($_SESSION["carrito"][$prod]);
    }
    header("Location:carrito.php");
}

function insertar($array)
{
    $res = array();
    $db = model\Conectar::dbConnect();
    $sql = "select codigo from usuario where correo = '" . $_SESSION["email"] . "';";
    $stmt = $db->query($sql);
    $res[] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $usu = $res[0][0]["codigo"];
    unset($stmt);
    unset($sql);

    //Introducimos los valores en la tabla 

    foreach ($array as $producto) {

        // if (isset($_POST["fechaReserva"])) {
        //     $fecha= $_POST["fechaReserva"];
        // } else {
        //     $fecha = date('Y/m/d H:i');
        // }

        $fecha = date('Y/m/d H:i');

        try {
            $db->beginTransaction();
            $sql = "INSERT INTO carrito (usuario, producto, cantidad, fecha, estado) VALUES (?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $parameters = array($usu, $producto["codigo"], $_SESSION["carrito"][$producto["codigo"]], $fecha, "pendiente");
            // $stmt->bindParam(1, $usu, \PDO::PARAM_INT);
            // $stmt->bindParam(2, $producto["codigo"], \PDO::PARAM_INT);
            // $stmt->bindParam(3, $_SESSION["carrito"][$producto["codigo"]], \PDO::PARAM_INT);
            // $stmt->bindParam(4, $fecha, \PDO::PARAM_STR);
            // $stmt->execute();
            $stmt->execute($parameters);
            $db->commit();
        } catch (\PDOException $exc) {
            $db->rollBack();
            echo $exc->getMessage();
        } finally {
            unset($sql);
            unset($stmt);
        }


        // if ($stmt->execute() == 1) {
        //     unset($sql);
        //     unset($stmt);
        // }
    }

    /**/

    // $_SESSION["carrito"] = [];
    // header("Location:carrito.php");
}

function confirmar_pedido()
{
    $res = array();
    $db = model\Conectar::dbConnect();
    $sql = "select codigo, (select correo from usuario where codigo=carrito.usuario) as usuario,producto,estado from carrito where estado='pendiente';";
    $stmt = $db->query($sql);
    while ($filas = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $res[] = $filas;
    }
    return $res;
}



function reservar($array)
{
    $res = array();
    $db = model\Conectar::dbConnect();
    $sql = "select codigo from usuario where correo = '" . $_SESSION["email"] . "';";
    $stmt = $db->query($sql);
    $res[] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $usu = $res[0][0]["codigo"];
    unset($stmt);
    unset($sql);

    $fecha = $_POST["fechaReserva"];
    $fecha2 = $_POST["fechaReserva2"];

    foreach ($array as $producto) {
        try {
            $db = model\Conectar::dbConnect();
            $db->beginTransaction();
            $sql = "INSERT INTO encargo (nombre_usuario, fecha, fecha2) VALUES (?,?,?)";
            $stmt = $db->prepare($sql);
            $parameters = array($usu, $fecha, $fecha2);
            $stmt->execute($parameters);
            $db->commit();
        } catch (\PDOException $exc) {
            $db->rollBack();
            echo $exc->getMessage();
        } finally {
            unset($sql);
            unset($stmt);
        }
    }
}

function insertar_encargo_pedido($array)
{
    $res = array();
    $db = model\Conectar::dbConnect();
    $sql = "select codigo from encargo where nombre_usuario = (select codigo from usuario where correo = '" . $_SESSION["email"] . "')";
    $stmt = $db->query($sql);
    $res[] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $encar = $res[0][0]["codigo"];
    unset($stmt);
    unset($sql);

    $precio = 1;

    foreach ($array as $producto) {
        try {
            $db = model\Conectar::dbConnect();
            $db->beginTransaction();
            $sql = "INSERT INTO producto_encargo (cod_producto, cod_pedido, precio) VALUES (?,?,?)";
            $stmt = $db->prepare($sql);
            $parameters = array($producto["codigo"], $encar, $precio);
            $stmt->execute($parameters);
            $db->commit();
        } catch (\PDOException $exc) {
            $db->rollBack();
            echo $exc->getMessage();
        } finally {
            unset($sql);
            unset($stmt);
        }
    }
}

function mostrar_reservas($email, $param1, $param2)
{
    $res = [];
    $db = model\Conectar::dbConnect();

    if ($_SESSION["rol"] == 0) {
        $sql = "SELECT * from encargo where fecha between '" . $param1 . "' and '" . $param2 . "'";
    } else {
        $sql = "SELECT * from encargo where usuario = (select codigo from usuario where correo = '" . $email . "') and fecha between '" . $param1 . "' and '" . $param2 . "'";
    }

    $stmt = $db->query($sql);

    while ($filas = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $res[] = $filas;
    }

    //echo var_dump($res);
    $salida = "<table><tr><th>Codigo DE ENCARGO</th><th>FECHA DE ENCARGO</th><tr>";

    foreach ($res as $encargo) {
        $salida .= "<tr>";
        $salida .= "<td>" . $encargo["codigo"] . "</td>";
        $salida .= "<td>" . $encargo["fecha"] . "</td>";
        $salida .= "</tr>";
    }

    $salida .= "</table>";
    return $salida;
}

function mostrar_todas_reservas($email)
{
    $res = [];
    $db = model\Conectar::dbConnect();
    if ($_SESSION["rol"] == 0) {
        $sql = "SELECT * from encargo";
    } else {
        $sql = "SELECT * from encargo where usuario = (select codigo from usuario where correo = '" . $email . "')";
    }

    $stmt = $db->query($sql);
    while ($filas = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $res[] = $filas;
    }
    //echo var_dump($res);
    $salida = "<table><tr><th>Codigo</th><th>Fecha Encargo</th><tr>";

    foreach ($res as $encargos) {
        $salida .= "<tr>";
        $salida .= "<td>" . $encargos["codigo"] . "</td>";
        $salida .= "<td>" . $encargos["fecha"] . "</td>";
        $salida .= "</tr>";
    }
    $salida .= "</table>";
    return $salida;
}

function mostrar_pendientes($array)
{
    $msg = "";
    $msg .= "<table><tr><th>Código</th><th>Usuario</th><th>Producto</th><th>Estado</th><th></th></tr>";

    foreach ($array as $reserva) {
        $msg .= "<tr><td>" . $reserva["codigo"] . "</td>";
        $msg .= "<td>" . $reserva["usuario"] . "</td>";
        $msg .= "<td>" . $reserva["producto"] . "</td>";
        $msg .= "<td>" . $reserva["estado"] . "</td>";
        $msg .= "<td><a href='carrito.php?producto=" . $reserva["codigo"] . "'>Confirmar</a></td></tr>";
    }

    $msg .= "</table>";
    return $msg;
}

function update_carrito($cod)
{
    $db = model\Conectar::dbConnect();
    $sql = "UPDATE `carrito` SET `estado`='confirmado' WHERE codigo = :cod";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":cod", $cod, \PDO::PARAM_INT);
    if ($stmt->execute() == 1) {
        header("Location:carrito.php");
    } else {
        header("Location:carrito.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Carrito</title>
</head>

<body>
    <h1>Carrito de la compra</h1>
    <?php
    if (empty($_SESSION["carrito"])) {
        echo "<h2>Tu carrito se encuentra vacío</h2>";
    }

    if (isset($_GET["codElim"])) {
        eliminar($_GET["codElim"]);
    }
    if (isset($_GET["cod"])) {
        anhadir($_GET["cod"]);
    }
    if (isset($_GET["producto"])) {
        update_carrito($_GET["producto"]);
    }
    if (!empty($_SESSION["carrito"])) {
        echo mostrar(getProd($productos));
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method='POST'>
        <input type="submit" id="enviar_pedido" value='Enviar Pedido' name='enviar_pedido'>
        <label for="fechaReserva">Fecha Reserva:</label><input type="date" id="fechaReserva" name="fechaReserva">
        <label for="fechaReserva2">Fecha limite reserva:</label><input type="date" id="fechaReserva2" name="fechaReserva2">
        <input type="submit" id="reservar" value='reservar' name='reservar'>
    </form>
    <div id="tabla_modificaciones">
        <h1>Historial de Encargos:</h1>
        <div id="tabla_modificaciones_inner">
            <p>Filtrado por fecha: </p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <div id="inputs">
                    <div>
                        <label for="">Fecha Inicio:</label><input type="date" name="fecha1">
                        <label for="">Fecha Final:</label><input type="date" name="fecha2">
                    </div>
                    <div>
                        <input type="submit" value="Filtrar" name="filtrar">
                        <input type="submit" value="Quitar filtros" name="desfiltrar">
                    </div>
                </div>
            </form>
        </div>
        <?php

        var_dump($_COOKIE["cookieCarrito"]);

        if (isset($_POST["enviar_pedido"]) && !empty($_SESSION["carrito"])) {
            //require_once("mail_compra.php");
            //unset($mail);
            //require_once("mail_productos.php");
            insertar(getProd($productos));
            var_dump(getProd($productos));
        }

        if (isset($_POST["reservar"]) && !empty($_SESSION["carrito"])) {
            insertar_encargo_pedido(getProd($productos));
            reservar(getProd($productos));
        }

        if (!isset($_POST["filtrar"])) {
            $res = mostrar_todas_reservas($_SESSION["email"]);
            echo $res;
        } else {
            $res2 = mostrar_reservas($_SESSION["email"], $_POST["fecha1"], $_POST["fecha2"]);
            echo $res2;
        }

        if ($_SESSION["email"] == "franza@gmail.com") {
            echo mostrar_pendientes(confirmar_pedido());
        }

        //reservar

        ?>
        <a href="index.php"><button class="enviar_pedido">Volver al inicio</button></a>
</body>

</html>