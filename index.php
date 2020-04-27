<?php

require_once __DIR__ .'./vendor/autoload.php';
use \Firebase\JWT\JWT;
// require './clases/paises.php';
require_once './clases/funciones.php';
require_once './clases/usuarios.php';

$metodo = $_SERVER["REQUEST_METHOD"];
$path = $_SERVER['PATH_INFO'];

$key = "example_key";
// $payload = array(
//     "iss" => "http://example.org",
//     "aud" => "http://example.com",
//     "iat" => 1356999524,
//     "nbf" => 1357000000
// );

if($metodo == 'GET')
{
    if(empty($_GET))
    {
        // echo("consulta vacia realizada");
        echo "estoy en GET"  ;
        echo(json_encode(paises::mostrar()));
    }
    else
    {
        // var_dump($_GET);
        switch($path)
        {
            case '/detalle':
                // echo "estoy en SIGNIN <br>";
                $archivo = './files/usuarios.txt';
                if(!empty($_GET))
                {
                    // echo "POST con datos <br>";
                    if(isset($_GET['token']))
                    {
                        // echo "datos OK <br>";
                        $token = $_GET['token'];
                        $decoded = JWT::decode($token, $key, array('HS256'));
                        // print_r($decoded);
                        $respuesta = usuario::verificarUser($archivo, $decoded->name,$decoded->apellido);
                        if($respuesta === false)
                        {
                            echo "error ,los datos no coinciden con un usuario registrado";
                        }
                        else 
                        {
                            echo"Usuario: <br>";
                            print_r(json_encode($respuesta));
                            // echo "usuario no registrado";
                        }
                    }
                    else
                    {
                        echo "Token no informado";
                    }
                }
                else
                {
                    echo "Error - Datos vacíos para realizar INSERT/UPDATE";
                }
            break;
            case '/lista':
                // echo "estoy en SIGNIN <br>";
                $archivo = './files/usuarios.txt';
                if(!empty($_GET))
                {
                    // echo "POST con datos <br>";
                    if(isset($_GET['token']))
                    {
                        // echo "datos OK <br>";
                        $token = $_GET['token'];
                        $decoded = JWT::decode($token, $key, array('HS256'));
                        // print_r($decoded);
                        $respuesta = usuario::verificarUser($archivo, $decoded->name,$decoded->apellido);
                        if($respuesta === false)
                        {
                            echo "error ,los datos no coinciden con un usuario registrado";
                        }
                        else 
                        {
                            $tipuser = $respuesta->tipo;
                            if($tipuser == "admin")
                            {
                                $usuarios = funciones::Listar($archivo);
                                foreach ($usuarios as $key => $value) {
                                    echo json_encode($value);
                                }
                            }
                            else
                            {
                                echo"Usuario: <br>";
                                print_r(json_encode($respuesta));
                                // echo "usuario no registrado";
                            }
                        }
                    }
                    else
                    {
                        echo "Token no informado";
                    }
                }
                else
                {
                    echo "Error - Datos vacíos para realizar INSERT/UPDATE";
                }
            break;
        }        
    }
}
else
{
    if($metodo == 'POST')
    {
        // echo "estoy en POST <br>"; //var_dump($_POST);
        // var_dump($_POST);
        switch($path)
        {
            case '/signin':
                // echo "estoy en SIGNIN <br>";
                $archivo = './files/usuarios.txt';
                if(!empty($_POST))
                {
                    // echo "POST con datos <br>";
                    if(isset($_POST['email'])&&isset($_POST['clave'])&&isset($_POST['nombre'])&&isset($_POST['apellido'])&&isset($_POST['telefono']) &&isset($_POST['tipo']))
                    {
                        // echo "datos OK <br>";
                        $nombre = $_POST['nombre'];
                        $apellido = $_POST['apellido'];
                        $email = $_POST['email'];
                        $pass = $_POST['clave'];
                        $telefono = $_POST['telefono'];
                        $tipo = $_POST['tipo'];
                        // echo "usuario: $nombre apellido: $apellido , email: $email";
                        $user = new usuario($email, $pass, $nombre, $apellido, $telefono, $tipo);
                        // echo "USER: <br>";
                        // var_dump($user);
                        // echo "<br>";
                        $respuesta = $user->guardarUsuario($archivo);
                        echo "$respuesta";
                        if($respuesta === false)
                        {
                            echo "error al guardar: $respuesta";
                        }
                        else 
                        {
                            echo "usuario registrado";
                        }
                    }
                }
                else
                {
                    echo "Error - Datos vacíos para realizar INSERT/UPDATE";
                }
            break;
            case '/login':
                // echo "estoy en SIGNIN <br>";
                $archivo = './files/usuarios.txt';
                if(!empty($_POST))
                {
                    // echo "POST con datos <br>";
                    if(isset($_POST['email'])&&isset($_POST['clave']))
                    {
                        // echo "datos OK <br>";
                        $email = $_POST['email'];
                        $pass = $_POST['clave'];
                        // echo "usuario: $nombre apellido: $apellido , email: $email";
                        // echo "USER: <br>";
                        // var_dump($user);
                        // echo "<br>";
                        $respuesta = usuario::verificarLogin($archivo,$email,$pass);
                        // echo "$respuesta";
                        if($respuesta === false)
                        {
                            echo "Datos erroneos, verifique.";
                        }
                        else 
                        {
                            $payload = array(
                                "iss" => "http://example.org",
                                "aud" => "http://example.com",
                                "iat" => 1356999524,
                                "nbf" => 1357000000,
                                "name" => $respuesta->nombre,
                                "apellido" => $respuesta->apellido
                            );
                            $jwt = JWT::encode($payload, $key);
                            echo "el token es: <br> $jwt";
                        }
                    }
                }
                else
                {
                    echo "Error - Datos vacíos para realizar INSERT/UPDATE";
                }
            break;

        }
    }
    else
    {
        echo("Error 405 , method not valid");
    }
}


?>

