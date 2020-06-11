<?php

class cadena{
    public $datos = [];
    
    /**
     * 
     * @param int $num
     * @return \cadena
     */
    public function operacion1($num){
        $this->datos[] = $num;
        
        return $this;
    }
    
    /**
     * 
     * @param string $letra
     * @return \cadena
     */
    public function operacion2($letra){
        $this->datos[] = $letra;
        
        return $this;
    }
    
    /**
     * 
     * @param string $simbolo
     * @return cadena
     */
    public function operacion3($simbolo){
        $this->datos[] = $simbolo;
        
        return $this;
    }
    
    public function show(){
        echo '<pre>';
        print_r($this->datos);
        echo '</pre>';
        
        return $this;
    }
}


$obj = new cadena();

$obj->operacion1(13)
    ->operacion2("a")
    ->operacion3("+")
    ->show();