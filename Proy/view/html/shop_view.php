<?php

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
    <nav>
        <h1>TU TIENDA ONLINE</h1>

        <div id="categorias-buscador-container">
            <p><a href="index.php">INICIO</a> ><a> TIENDA</a></p>
            <div id="categorie-list">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                    <h3 id="categorias">CATEGORIAS</h3>
                    <h3 id="order" class="order">ORDENAR POR</h3>
                    <select name="ordenar">
                        <option value="salado">SALADO</option>
                        <option value="dulce">DULCE</option>
                    </select>
                    <select name="ordenar2" class="order">
                        <option value="precio">PRECIO</option>
                        <option value="nombre">NOMBRE</option>
                        <option value="cantidad">CANTIDAD</option>
                    </select>
                    <div>
                        <input type="radio" name="ord" value="ASC">
                        <label class="order">ASCENDENTE</label>
                    </div>
                    <div>
                        <input type="radio" name="ord" value="DESC">
                        <label class="order">DESCENDENTE</label>
                    </div>
                    <button type="submit" id="quitar_filtro" name="desfiltrar">Quitar Filtros</button>
                    <button type="submit" id="filtrar" name="filtrar">Filtrar</button>
                </form>
            </div>
        </div>
    </nav>
    <main>
        <?php
        if (!empty($_SESSION["carrito"])) {
        ?>
            <h2 style="text-align: center; margin-bottom:10px"><a href="carrito.php">CARRITO</a></h2>
        <?php
        }

        ?>
        <h3>DESTACADOS PARA TI</h3>
        <div id="product_container" style="background-color: rgb(138, 44, 44); margin-bottom: 10px;">
            
            <?php
            echo $mostrar_visitado;
            ?>
        </div>
        <div id="pages">
            <?php
            if (!isset($_POST["filtrar"])) {
                for ($i = 0; $i < 3; $i++) {
                    echo '<li><a class="page_link" href="shop.php?pag=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                }
            }
            ?>
        </div>


        <div id="product_container">
            <?php

            if (isset($_POST["desfiltrar"])) {
                unset($_POST["filtrar"]);
            }
            if (!isset($_POST["filtrar"])) {
                echo $mostrar;
            } else {
                echo $mostrar_ordenado;
            }
            ?>
        </div>
    </main>
    <?php
    if (isset($_POST["comprar"])) {
        if (!empty($_POST["cod"])) {
            $productos->anadir_carrito($_POST["cod"]);
        }
    }
    ?>

    <script>

    </script>
</body>

</html>
<?php




?>