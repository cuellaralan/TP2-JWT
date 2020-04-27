<?php

class usuario
{
    public $email;
    public $clave;
    public $nombre;
    public $apellido;
    public $telefono;
    public $tipo;

    public function __construct($mail,$pass, $name, $apell, $phone, $tipe)
    {
        $this->email = $mail;
        $this->clave = $pass;
        $this->nombre = $name;
        $this->apellido = $apell;
        $this->telefono = $phone;
        $this->tipo = $tipe;
    }

    public function guardarUsuario($archivo)
    {
        // echo "estoy en usuario";

        funciones::Guardar($this,$archivo,'a+');
    }

    public static function verificarLogin($archivo,$email,$pass)
    {
        // echo "estoy en usuario";
        $retorno = false;
        $usuarios = funciones::Listar($archivo);
        foreach ($usuarios as $key => $value) {
            // var_dump($value); echo "$key";
            if($value->email == $email && $value->clave== $pass)
            {
                $retorno = $value;
                break;
            }
            
        }
        return $retorno;
    }

    public static function verificarUser($archivo,$name,$lastname)
    {
        // echo "estoy en usuario";
        $retorno = false;
        $usuarios = funciones::Listar($archivo);
        foreach ($usuarios as $key => $value) {
            // var_dump($value); echo "$key";
            if($value->nombre == $name && $value->apellido== $lastname)
            {
                $retorno = $value;
                break;
            }
            
        }
        return $retorno;
    }
    

}

?>