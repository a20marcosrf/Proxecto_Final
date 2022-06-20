<?php

session_start();
$email = isset($_POST["email"])  ? $_POST["email"] : "";

function dbConnect() {
    $servidor = "127.0.0.1";
    $base = "a16panaderia";
    $usuario = "anon";
    $contraseña = "";
    try {
        $db = new \PDO('mysql:host=' . $servidor . ';dbname=' . $base, $usuario, $contraseña);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
        echo '<p>No conectado !!</p>';
        echo $e->getMessage();
        exit;
    }
    return $db;
}

function comprobarLogin($correo) {
    try {
        $pdo = dbConnect();
        $sql = 'select contrasena from usuario where correo=?;';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($correo));
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
        
        if (empty($result)) {
            //echo 'El correo no existe';
            $res=true;
        } else {
            if (password_verify($_POST["psw"], $result[0]->contrasena)) {
                $res = false;
            } else {
                $res = true;
            }
        }

        unset($stmt);
        unset($pdo);
        return $res;
    } catch (\PDOException $e) {
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
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);


        unset($stmt);
        unset($pdo);
        
        echo var_dump($result[0]->codigo);
        return $result[0]->codigo;
    } catch (\PDOException $e) {
        print $e->getMessage();
    }
}

//Insertamos el acceso en la tabla Logs
function insertLog() {
    try {
        $pdo = dbConnect();
        $sql = "INSERT INTO `logs`(`usuario`, `fecha`) VALUES (:usu,:fecha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":usu", getCod($_POST["email"]), \PDO::PARAM_INT);
        $stmt->bindValue(":fecha", date('Y/m/d'), \PDO::PARAM_STR);
        $result=$stmt->execute();
        //echo var_dump($result);
        unset($stmt);
        unset($pdo);
        $_SESSION["carrito"]=[];
    } catch (\PDOException $e) {
        print $e->getMessage();
    }
}

if (!isset($_POST["login"]) || isset($_POST["login"]) && comprobarLogin($_POST["email"])) {
    ?>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        </head>
        <body style="background-image:url('../media/monograma2.jpg'); width:80%; margin:auto; margin-top:20px ">
                            <div class="card" style="border-radius: 1rem; margin: top 30px; background-color:rgb(81, 23, 35); color:white">
                                <div class="row g-0">
                                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                                        <img
                                            src="../media/login_persoa.avif"
                                            alt="login form"
                                            style="width:100%; height:80%; margin:20px; border-radius: 10px;"
                                            class="img-fluid" 
                                            />
                                    </div>
                                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                        <div class="card-body p-4 p-lg-5 text-black">

                                            <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>' method="POST">

                                                <div class="d-flex align-items-center mb-3 pb-1">
                                                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                                    <span class="h1 fw-bold mb-0"><b>BIENVENIDO A TU PANADERÍA</b></span>
                                                </div>

                                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">¿Qué necesitas?</h5>

                                                <div class="form-outline mb-4">
                                                    <input type="email" id="email" name="email" class="form-control form-control-lg" value="<?php echo htmlspecialchars($email) ?>" required/>
                                                    <label class="form-label" for="email">Correo Electrónico</label>
                                                </div>

                                                <div class="form-outline mb-4">
                                                    <input type="password" id="psw" name="psw" class="form-control form-control-lg" />
                                                    <label class="form-label" for="psw">Constraseña</label>
                                                </div>

                                                <?php

                                                if (isset($_POST["login"])) {
                                                    if (comprobarLogin($_POST["email"])) {
                                                        echo "<h3 style='color:red'>Contraseña o correo incorrectos</h3>";                                                 }                                                       
                                                }
                                                ?>

                                                <div class="pt-1 mb-4">
                                                    <button class="btn btn-warning btn-lg btn-block" type="submit" name="login"><b>ENTRA EN TU PANADERÍA</b></button>
                                                </div>

                                                <p class="mb-5 pb-lg-2" style="color: white;">No tienes cuenta? <a href="../../register.php" style="color: white;"><b>Registrate aqui!</b></a></p>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </body>
    </html>
    <?php
} else {
    $_SESSION["email"]=$_POST["email"];
    insertLog();
    header("Location:../../index.php");
}
