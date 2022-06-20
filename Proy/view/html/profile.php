<?php
session_start();

function dbConnect() {
    $servidor = "localhost";
    $base = "panaderia";
    $usuario = "root";
    $contrasenha = "";
    try {
        $db = new PDO('mysql:host=' . $servidor . ';dbname=' . $base, $usuario, $contrasenha);
    } catch (PDOException $e) {
        echo '<p>No conectado !!</p>';
        echo $e->getMessage();
        exit;
    }
    return $db;
}

//Funcion que hace UPDATE en la tabla usuarios
function modificar() {
    $pdo = dbConnect();
    $update = "UPDATE `usuario` SET `nombre`=:nombre,`correo`=:correo,`telefono`=:telefono,`direccion`=:direccion,`ficheros`=:ficheros WHERE `correo`='" . $_SESSION["email"] . "';";
    $stmt = $pdo->prepare($update);
    $stmt->bindValue(':nombre', $_POST['name'], PDO::PARAM_STR);
    $stmt->bindValue(':correo', $_POST['email'], PDO::PARAM_STR);
    $stmt->bindValue(':telefono', $_POST['tel'], PDO::PARAM_INT);
    $stmt->bindValue(':direccion', $_POST['direc'], PDO::PARAM_STR);
    $stmt->bindValue(':ficheros', "../../../usuarios/".$_POST['name']."/", PDO::PARAM_STR);
    $result = $stmt->execute();
    //echo var_dump($result);
    //echo $_SESSION["email"];
    if ($result == 1) {
        unset($stmt);
        unset($pdo);
        $_SESSION["email"]=$_POST["email"];
        header("Location:profile.php");
    } else {
        echo '<p>Se produjo un error en la actualización..</p>';
    }
}
//Modificamos la contraseña
function modificarPsw() {
    $pdo = dbConnect();
    $update = "UPDATE `usuario` SET `contraseña`=:psw WHERE `correo`='" . $_SESSION["email"] . "';";
    $stmt = $pdo->prepare($update);
    $stmt->bindValue(':psw',password_hash($_POST["psw2"],PASSWORD_DEFAULT), PDO::PARAM_STR);
    $result = $stmt->execute();
    if ($result == 1) {
        unset($stmt);
        unset($pdo);
        //header("Location:profile.php");
    } else {
        echo '<p>Se produjo un error en la actualización..</p>';
    }
}


//Comprobamos que $_POST["pwd"] sea igual a la que hay en la bbdd
function comprobarPsw($correo) {
    try {
        $pdo = dbConnect();
        $sql = 'select contraseña from usuario where correo=?;';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($correo));
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        if (empty($result)) {
            //echo 'El correo no existe';
            $res=true;
        } else {
            if (password_verify($_POST["psw"], $result[0]->contraseña)) {
                $res = false;
            } else {
                $res = true;
            }
        }

        unset($stmt);
        unset($pdo);
        return $res;
    } catch (PDOException $e) {
        print $e->getMessage();
    }
}


//Recibimos codigo pasando por parametro el correo
function getCod($correo) {
    try {
        $pdo = dbConnect();
        $sql = 'select codigo from usuario where correo=?;';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($correo));
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);


        unset($stmt);
        unset($pdo);
        
        echo var_dump($result[0]->codigo);
        return $result[0]->codigo;
    } catch (PDOException $e) {
        print $e->getMessage();
    }
}

//Insertamos el acceso en la tabla Logs
function insertMod() {
    try {
        $pdo = dbConnect();
        $sql = "INSERT INTO `mods`(`usuario`, `fecha`) VALUES (:usu,:fecha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":usu", getCod($_POST["email"]), PDO::PARAM_INT);
        $stmt->bindValue(":fecha", date('m/d/Y h:i:s a', time()), PDO::PARAM_STR);
        $result=$stmt->execute();
        //echo var_dump($result);
        unset($stmt);
        unset($pdo);
    } catch (PDOException $e) {
        print $e->getMessage();
    }
}

function subir_fichero($email){
    $dir_subida = "../../../usuarios/".$email."/";
    $fichero_subido = $dir_subida . basename($_FILES['fich']['name']);
    
    echo '<pre>';
    if (move_uploaded_file($_FILES['fich']['tmp_name'], $fichero_subido)) {
        echo "El fichero es válido y se subió con éxito.\n";
    } else {
        echo "¡Posible ataque de subida de ficheros!\n";
    }
}


try {
    $pdo = dbConnect();
    $sql = "select nombre,correo,telefono,direccion from usuario where correo='" . $_SESSION["email"] . "';";
    $stmt = $pdo->query($sql);
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    //echo var_dump($res);
    unset($pdo);
    unset($stmt);
    if (isset($_POST["modificar"]) && !comprobarPsw($_SESSION["email"])) {
        if(!empty($_POST["psw2"])){
            modificarPsw();
        }
        insertMod();
        modificar();
    }
    else{
        if(isset($_POST["modificar"])){
            echo '<script language="javascript">alert("Error en la modificación");</script>';
        }
    }
    if(isset($_POST["logout"])){
        session_unset();
        session_destroy();
        //header("Location:../../index.php");
    }
} catch (PDOException $e) {
    print $e->getMessage();
}


if (isset($_SESSION["email"])) {
    ?>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <link rel="stylesheet" href="../css/profile_register.css">
        </head>
        <body>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">
                <div class="container">
                    <h1>TU PERFIL</h1>
                    <p>MODIFICA LOS DATOS A TO GUSTO</p>
                    <hr>
                    <label for="name"><b>NOMBRE</b></label>
                    <input type="text" placeholder="Enter name" name="name" id="name" required value="<?php echo $res[0]->nombre; ?>">

                    <label for="email"><b>CORREO ELECTRÓNICO</b></label>
                    <input type="text" placeholder="Enter Email" name="email" id="email" required value="<?php echo $res[0]->correo; ?>">

                    <label for="psw"><b>CONTRASEÑA</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" id="psw" required value="<?php echo "*********" ?>">
                    
                    <label for="psw2"><b>NUEVA CONTRASEÑA</b></label>
                    <input type="password" placeholder="Enter Password" name="psw2" id="psw2">

                    <label for="tel"><b>TELÉFONO</b></label>
                    <input type="text" placeholder="Para contactarte en caso de necesidad" name="tel" id="tel" required value="<?php echo $res[0]->telefono; ?>">

                    <label for="dir"><b>DIRECCIÓN</b></label>
                    <input type="text" placeholder="¿A dónde enviamos el pedido?" name="direc" id="direc" required value="<?php echo $res[0]->direccion; ?>">

                    <label for="fich"><b>FICHEROS<input type="submit" name="enviar" value="Enviar"></b></label>
                    <input type="file" name="fich" id="fich">
                    

                    <button type="submit" name="modificar" class="registerbtn">MODIFICAR</button>
                    <button type="submit" name="logout" class="registerbtn">SAÍR</button>
                </div>
            </form>
            <?php
                if(isset($_POST["enviar"])){
                    subir_fichero($_SESSION["email"]);
                }
            ?>
        </body>
    </html>

    </body>
    </html>
    <?php
} else {
    echo "<h3>Ha ocurrido un problema</h3>";
}
?>