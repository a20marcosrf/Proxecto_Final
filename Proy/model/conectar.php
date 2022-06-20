<?php

//Clase para conectarse a la base de datos
namespace model;

class Conectar
{

    public static function dbConnect()
    {
        try {
            $res = self::leer_config("../Proy/config/configuracion.xml", "../Proy/config/configuracion.xsd");
            $db = new \PDO($res[0], $res[1], $res[2]);
        } catch (\PDOException $e) {
            echo '<p>No conectado !!</p>';
            echo $e->getMessage();
            exit;
        }
        return $db;
    }

    public static function getRol()
    {
        if (isset($_SESSION["email"])) {
            $servidor = "127.0.0.1";
            $base = "a16panaderia";
            $usuario = "user";
            $contraseña = "";
            try {
                $db = new \PDO('mysql:host=' . $servidor . ';dbname=' . $base, $usuario, $contraseña);
                $sql = "select rol from usuario where correo = :correo";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":correo", $_SESSION["email"], \PDO::PARAM_STR);
                $stmt->execute();
                $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
                $_SESSION["rol"]=$res[0]->rol;
                return $res[0]->rol;
            } catch (\PDOException $e) {
                echo '<p>No conectado !!</p>';
                echo $e->getMessage();
                exit;
            }
        }else{
            return 2;
        }

    }

    public static function leer_config($fichero_config_BBDD, $esquema)
    {
        $config = new \DOMDocument();
        $config->load($fichero_config_BBDD);
        $res = $config->schemaValidate($esquema);
        if ($res === FALSE) {
            throw new \InvalidArgumentException("Revise el fichero de configuración");
        }
        $datos = simplexml_load_file($fichero_config_BBDD);
        $ip = $datos->xpath("//ip");
        $nombre = $datos->xpath("//nombre");
        $usu = $datos->xpath("//usuario");
        $clave = $datos->xpath("//clave");
        $cad = sprintf("mysql:dbname=%s;host=%s", $nombre[0], $ip[0]);
        //$_SESSION["a"] = var_dump($usu[self::getRol()]);
        //$_SESSION["b"] = var_dump($clave[self::getRol()]);
        $resul = [];
        $resul[] = $cad;
        $resul[] = $usu[self::getRol()];
        $resul[] = $clave[self::getRol()];
        return $resul;
    }
}
