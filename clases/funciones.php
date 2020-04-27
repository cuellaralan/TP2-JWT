<?php
//ar -> manejador
class Funciones
{
    public static function Listar($archivo)
    {
        $miarray = array(); 
        if(file_exists($archivo))
        {
            $ar = fopen($archivo,"r"); 
            while(!feof($ar) )
            {
                $linea = fgets($ar);
                if(!empty($linea)) 
                {
                    array_push($miarray,json_decode($linea)); 
                }
            }
            fclose($ar);            
        }
    return ($miarray);
    }

    public static function Guardar($objeto,$archivo,$modo)
    {
        // var_dump($objeto);
        $ar = fopen($archivo,$modo); 
        $codificado = json_encode($objeto);
        $retorno = fwrite($ar,$codificado.PHP_EOL);
        fclose($ar);
        return $retorno;
    }

    public static function ModificarxID($id,$objeto,$archivo)
    {   
        $array1 = funciones::Listar($archivo);
        //modificar posición de array segun ID
        //llamar a función guardar por C/id del aray retornado por listar
        

    }

    public static function GuardaTemp($origen,$destino,$nomarch)
    {
        setlocale(LC_TIME,"es_RA");
        $fecha = date("Y-m-d");
        $hora = date("H-i-s");
        $extension = funciones::obtengoExt($nomarch);
        $destino = $destino.'_'.$fecha.';'.$hora.$extension;
        move_uploaded_file($origen,$destino);
    }

    public static function obtengoExt($nomarch)
    {
        $cantidad = strlen($nomarch);
        $start = $cantidad - 4 ;
        $ext = substr($nomarch, $start, 4);
        
        return $ext;
    }

    public static function GuardaTemp2($archivo,$directorio,$idConcat)
    {       
        setlocale(LC_TIME,"es_RA");
        $fecha = date("Y-m-d");
        $hora = date("H-i-s");
        // $extension = funciones::obtengoExt($nomarch);
        $extension = pathinfo($archivo->getClientFilename(), PATHINFO_EXTENSION);
        // $path= $destino.$idConcat.$extension;
        $filename = $idConcat.'_'.$fecha.';'.$hora.'.'.$extension;
        $archivo->moveTo($directorio . DIRECTORY_SEPARATOR . $filename);
        // move_uploaded_file($origen,$path);
        return $filename;
    }
}