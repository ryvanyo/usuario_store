<?php namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Asociación de una solicitud con el controlador y sus metodos:
     * http://example.com/home/index/
     */
	public function index()
	{
        // CI 3: $this->load->view("welcome_message");
        
		return view('welcome_message');
	}
    
    // http://localhost:8080/io1/ci/usuarios_store/public/home/about/pepe/25
    public function about($name, $age=18){
        echo "Hola ".$name.", you are ".$age." years old, right?";
    }
	//--------------------------------------------------------------------
}
