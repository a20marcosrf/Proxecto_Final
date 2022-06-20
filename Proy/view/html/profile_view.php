<?php

try {

    if (isset($_POST["modificar"]) && !$usuario->comprobarPsw()) {
        if (!empty($_POST["psw2"])) {
            $usuario->modificarPsw();
        }
        $usuario->insertMod();
        $usuario->modificar();
    } else {
        if (isset($_POST["modificar"])) {
            echo '<script language="javascript">alert("Error en la modificación");</script>';
        }
    }
    if (isset($_POST["logout"])) {
        session_unset();
        session_destroy();
        header("Location:index.php");
    }
} catch (\PDOException $e) {
    print $e->getMessage();
}


if (isset($_SESSION["email"])) {
?>

    <!-- <label for="fich"><b>FICHEROS</b></label>
                    <input type="file" name="fich" id="fich">
                    <input type="submit" name="enviar" value="Enviar"> -->

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">
        <div class="container">
            <h1>TU PERFIL</h1>
            <img src="<?php echo ".." . DIRECTORY_SEPARATOR . "usuarios" . DIRECTORY_SEPARATOR . $_SESSION["email"] . DIRECTORY_SEPARATOR . "img_perfil" . DIRECTORY_SEPARATOR . "profile_pic.jpg"; ?>" alt="Imagen Perfil" width="50px" height="50px">
            <p id="sesion">Bienvenido:</p>

            <label for="name"><b>NOMBRE</b></label>
            <input type="text" placeholder="Enter name" name="name" id="name" required value="<?php echo $atrib_usuario["nombre"]; ?>">

            <label for="email"><b>CORREO ELECTRÓNICO</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required value="<?php echo $atrib_usuario["correo"]; ?>">

            <label for="psw"><b>CONTRASEÑA</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required value="<?php echo "*********" ?>">

            <label for="psw2"><b>NUEVA CONTRASEÑA</b></label>
            <input type="password" placeholder="Enter Password" name="psw2" id="psw2">

            <label for="tel"><b>TELÉFONO</b></label>
            <input type="text" placeholder="Para contactarte en caso de necesidad" name="tel" id="tel" required value="<?php echo $atrib_usuario["telefono"]; ?>">

            <label for="dir"><b>DIRECCIÓN</b></label>
            <input type="text" placeholder="¿A dónde enviamos el pedido?" name="direc" id="direc" required value="<?php echo $atrib_usuario["direccion"]; ?>">

            <label for="imag"><b>IMAGEN DE PERFIL</b></label>
            <input type="file" name="imag" id="imag">
            <input type="submit" name="enviar2" value="Subir Imagen">

            <button type="submit" name="modificar" class="registerbtn">MODIFICAR</button>
            <button type="submit" name="logout" class="registerbtn">SAÍR</button>

        </div>

        <div id="formulario">
            <h3>Formulario para solicitar empleo</h3>
            <form action="">
                <label>Nombre</label>
                <div class="input">
                    <input type="text" name="nombre" placeholder="Nombre:" /><br />
                </div>

                

                <label>Apellido</label>
                <div class="input">
                    <input type="text" name="apellido" placeholder="Apellido:" /><br />
                </div>

                <label>Email de contacto</label>
                <div class="input">
                    <input type="text" name="email" placeholder="Email:" />
                </div>

                <label for="imag"><b>SUBIR CURRICULUM</b></label>
                <input type="file" name="curriculum" id="curriculum">
                <input type="submit" name="enviar_curriculum" value="Subir Curriculum">
                
                <div class="input">
                    <input type="button" name="form" id="form" value="Contactar" />
                </div>
            </form>
        </div>

        <div id="tabla_modificaciones">
            <h1>Historial de logeos:</h1>
            <div id="tabla_modificaciones_inner">
                <p>Filtrado por fecha: </p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                    <div id="inputs">
                        <div>
                            <label for="">Fecha Inicio:</label><input type="date" name="fecha1Logs">
                            <label for="">Fecha Final:</label><input type="date" name="fecha2Logs">
                        </div>
                        <div>
                            <input type="submit" value="Filtrar" name="filtrarLogs">
                            <input type="submit" value="Quitar filtros" name="desfiltrarLogs">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="pages">
            <?php
            if (!isset($_POST["filtrar"])) {
                for ($i = 0; $i < 3; $i++) {
                    echo '<li><a class="page_link" href="profile.php?pag=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                }
            }
            ?>
        </div>
        <?php
        if (!isset($_POST["filtrarLogs"])) {
            $res = $usuario->obtener_logs($_SESSION["email"]);
            echo $res;
        } else {
            $res2 = $usuario->obtener_logs_param($_SESSION["email"], $_POST["fecha1Logs"], $_POST["fecha2Logs"]);
            echo $res2;
            echo $_POST["fecha1Logs"];
        }
        ?>

    </form>
    <div id="tabla_modificaciones">
        <h1>Historial de Modificaciones:</h1>
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

        <div id="pages">
            <?php
            if (!isset($_POST["filtrar"])) {
                for ($i = 0; $i < 3; $i++) {
                    echo '<li><a class="page_link" href="profile.php?pag=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                }
            }
            ?>
        </div>

        <?php
        //Controlador para filtrar


        if (!isset($_POST["filtrar"])) {
            $res = $usuario->obtener_mods($_SESSION["email"]);
            echo $res;
        } else {
            $res2 = $usuario->obtener_mods_param($_SESSION["email"], $_POST["fecha1"], $_POST["fecha2"]);
            echo $res2;
        }
        //Controlador para desfiltrar
        if (isset($_POST["desfiltrar"])) {
            unset($_POST["fecha1"]);
            unset($_POST["fecha2"]);
        }


        ?>
    </div>
    <h2>CONTROL DE USUARIOS</h2>
    <div id="usuarios_eliminar">
        <?php

        if (isset($_POST["enviar"]) && !empty($_FILES)) {
            echo $usuario->subir_fichero($_SESSION["email"]);
        }
        if (isset($_POST["enviar2"]) && !empty($_FILES)) {
            echo $usuario->subir_imagen($_SESSION["email"]);
        }

        if (isset($_POST["enviar_curriculum"]) && !empty($_FILES)) {
            echo $usuario->subir_curriculum($_SESSION["email"]);
        }

        if ($_SESSION["rol"] == 0) {
            echo $usuario->mostrar();
        }
        ?>
    </div>
<?php
} else {
    echo "<h3>Ha ocurrido un problema</h3>";
}
?>