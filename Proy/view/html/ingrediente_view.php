<?php

if (isset($_POST["volver"])) {
    header("Location:shop.php");
} else {
    setcookie("ingredienteVisto[".$_GET["producto"]."]", $_GET["producto"],time()+3600,'/');
    ?>
    <!DOCTYPE html>
    <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>

        <body>
            <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]) ?>" method="POST">
                <?php
                echo $ingredientes->mostrar();
                if (isset($_SESSION["email"])) {
                    if ($_SESSION["rol"] == 0) {
                        echo "<button type='submit' name='eliminar'>Eliminar</button>";
                    }
                }
                ?>
                <button type="submit" name="volver">Volver</button>
            </form>
            <?php
            if (isset($_POST["eliminar"])) {
                $ingredientes->eliminar($_GET["producto"]);
                header("Location:shop.php");
            }
            ?>
        </body>

    </html>
    <?php
}
?>