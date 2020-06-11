<?php

namespace App\Models;

class UsuarioRules {
    public function multiples_palabras(string $str, string &$error = null):bool{
        $arr = explode(" ", $str);
        
        if (count($arr)>1) {
            return true;
        }
        
        $error = "Debe estar compuesto por más de una palabra";
        return false;
    }
}
