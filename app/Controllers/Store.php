<?php
namespace App\Controllers;

class Store extends BaseController{
    public function index(){
        $data = [
            "titulo" => "Tienda de usuarios",
            "subtitulo" => "La moda a tus pies"
        ];
        echo view("store/header", $data);
        echo view("store/index", $data);
        echo view("store/footer", $data);
    }
    
    // http://localhost:8080/io1/ci/usuarios_store/public/store/data/25
    public function data($size){
        $data = [
            "titulo" => "Tienda de usuarios",
            "subtitulo" => "La moda a tus pies",
            "size" => $size
        ];
        
        echo view("store/data", $data);
    }
}