<?php
namespace App\Controllers;

use App\Models\UsuarioModel;

class Usuario extends BaseController {
    public function index($pagina=1){
        // $this->load->model("usuario");
        
        $usuario = new UsuarioModel();
        $usuarios = $usuario->listar($pagina);
        
        $data = [
            "titulo" => "Lista de usuarios",
            "subtitulo" => "",
            "usuarios" => $usuarios
        ];
        
        echo view("usuario/index", $data);
    }
    
    public function lista(){
        $usuario = new UsuarioModel();
        $lista = $usuario->listar();
        
        echo view("usuario/lista", ["lista" => $lista, "usuario_model"=>$usuario]);
        // echo view("common/adminlte/main", ["lista" => $lista, "usuario_model"=>$usuario]);
    }
    
    public function listaJson(){
        $usuario = new UsuarioModel();
        $lista = $usuario->listar();
        
        // header("Content-type: text/plain");
        echo view("usuario/lista_json", ["lista" => $lista]);
    }
    
    public function nuevo(){
        $usuario_model = new UsuarioModel();
        $usuario = [
            "nombre" => "",
            "apellido" => "",
            "sexo" => "hombre",
            "telefono" => "",
            "direccion" => "",
            "extranjero" => 0,
            "becado" => 0,
            "carrera" => "",
            "foto" => "",
            "titulo" => "",
        ];
        
        $errores = [];
        $success = NULL;
        
        // $this->request->getMethod(); // $_SERVER["REQUEST_METHOD"]
        if ($this->request->getMethod()=="post") {
            // Procesar el formulario
            $usuario = $_POST["u"];
            $usuario["fecha_registro"] = date("Y-m-d H:i:s");
            
            $insertado = $usuario_model->insert($usuario);
            $usuario["id"] = $usuario_model->getInsertID();
            $usuario_model->procesar_fotos($usuario, $this->request->getFiles());
            
            if (!$insertado) {
                $errores = $usuario_model->errors();
            } else {
                $success = "Usuario registrado";
            }
        }
        
        helper("form");
        
        echo view("usuario/nuevo", [
            "usuario"=>$usuario, 
            "errores"=>$errores,
            "success"=>$success
        ]);
    }
    
    public function editar(){
        $usuario_model = new UsuarioModel();
        
        $usuario = $usuario_model->ver($_GET["id"]);
        $errores = [];
        $success = [];
        
        if (empty($usuario)) {
            return redirect()->to(site_url("usuario/lista"));
        }
        
        if ($this->request->getMethod()=="post") {
            // Procesar el formulario
            $datos = $_POST["u"];
            $datos["id"] = $usuario["id"];
            $datos["foto"] = $usuario["foto"];
            $datos["titulo"] = $usuario["titulo"];
            $usuario_model->procesar_fotos($datos, $this->request->getFiles());
            $usuario = $datos;
            
            $modificado = $usuario_model->update($_GET["id"], $usuario);
            if (!$modificado) {
                $errores = $usuario_model->errors();
            } else {
                $success = "Usuario modificado";
            }
        }
        
        helper("form");
        echo view("usuario/editar", [
            "usuario"=>$usuario, 
            "errores"=>$errores,
            "success"=>$success
        ]);
    }
    
    public function borrar($id){
        $usuario_model = new UsuarioModel();
        if ($usuario_model->borrar($id)) {
            return redirect()->to(site_url("usuario/lista?deleted=1"));
        } else {
            
            return redirect()->to(site_url("usuario/lista?deleted=0"));
        }
    }
    
    public function test(){
        $arr = get_defined_constants();
        print_r($arr);
        /* @var $image \CodeIgniter\Images\Handlers\GDHandler */
        /*$image = \Config\Services::image();
        $image->fit($width, $height, $position);
        var_dump($image);*/
    }
    
    public function notify(){
        helper("form");
        
        $message = [
            "subject" => "",
            "message" => ""
        ];
        $success = NULL;
        
        if ($this->request->getMethod()=="post") {
            // Enviar el correo
            $message = $_POST["m"];
            /* @var $email \CodeIgniter\Email\Email */
            $email = \Config\Services::email();
            
            $destinatarios = "cyrus.rar@gmail.com,jabalcazar-es@udabol.edu.bo,mborora-es@udabol.edu.bo,kcarrillo1-es@udabol.edu.bo,ldclaure-es@udabol.edu.bo,mcolumba-es@udabol.edu.bo,leescalera-es@udabol.edu.bo,jdfernandez2-es@udabol.edu.bo,ahfernandez-es@udabol.edu.bo,dngonzales-es@udabol.edu.bo,jrgonzales-es@udabol.edu.bo,lguevara2-es@udabol.edu.bo,bagutierrez-es@udabol.edu.bo,mheredia10-es@udabol.edu.bo,vlopez7-es@udabol.edu.bo,imachaca-es@udabol.edu.bo,ejmagne-es@udabol.edu.bo,glmartinez-es@udabol.edu.bo,mmendez5-es@udabol.edu.bo,yemiranda-es@udabol.edu.bo,ymolina3-es@udabol.edu.bo,gmoron2-es@udabol.edu.bo,ceolmos-es@udabol.edu.bo,jpasabare-es1@udabol.edu.bo,jepedriel-es@udabol.edu.bo,jpillco1-es@udabol.edu.bo,equispe27-es@udabol.edu.bo,jdrojas-es@udabol.edu.bo,ssanchez9-es@udabol.edu.bo,jmvivanco-es@udabol.edu.bo";
            
            $email->setFrom('admin@codigote.com', 'Admin');
            $email->setTo($destinatarios);

            $email->setSubject($message["subject"]);
            $email->setMessage($message["message"]);

            if ($email->send()) {
                $success = true;
            }
        }
        
        $data = [
            "message" => $message,
            "success" => $success,
            "descripcion" => "Envia correo en texto plano"
        ];
        
        echo view("usuario/notify", $data);
    }
    
    public function notifyHtml(){
        helper("form");
        
        $message = [
            "subject" => "",
            "message" => ""
        ];
        $success = NULL;
        
        if ($this->request->getMethod()=="post") {
            // Enviar el correo
            $message = $_POST["m"];
            /* @var $email \CodeIgniter\Email\Email */
            $email = \Config\Services::email();
            
            $destinatarios = "cyrus.rar@gmail.com,jabalcazar-es@udabol.edu.bo,mborora-es@udabol.edu.bo,kcarrillo1-es@udabol.edu.bo,ldclaure-es@udabol.edu.bo,mcolumba-es@udabol.edu.bo,leescalera-es@udabol.edu.bo,jdfernandez2-es@udabol.edu.bo,ahfernandez-es@udabol.edu.bo,dngonzales-es@udabol.edu.bo,jrgonzales-es@udabol.edu.bo,lguevara2-es@udabol.edu.bo,bagutierrez-es@udabol.edu.bo,mheredia10-es@udabol.edu.bo,vlopez7-es@udabol.edu.bo,imachaca-es@udabol.edu.bo,ejmagne-es@udabol.edu.bo,glmartinez-es@udabol.edu.bo,mmendez5-es@udabol.edu.bo,yemiranda-es@udabol.edu.bo,ymolina3-es@udabol.edu.bo,gmoron2-es@udabol.edu.bo,ceolmos-es@udabol.edu.bo,jpasabare-es1@udabol.edu.bo,jepedriel-es@udabol.edu.bo,jpillco1-es@udabol.edu.bo,equispe27-es@udabol.edu.bo,jdrojas-es@udabol.edu.bo,ssanchez9-es@udabol.edu.bo,jmvivanco-es@udabol.edu.bo";
            // $destinatarios = "cyrus.rar@gmail.com";

            $email->setFrom('admin@codigote.com', 'Natural Food');
            $email->setTo($destinatarios);
            $email->setMailType("html");

            $email->setSubject("Contacto form message - ".$message["subject"]);
            
            $logo = APPPATH."/../email-templates/11a/images/person_2.png";
            $email->attach($logo, "inline");
            
            $body_message = view("mail_template", [
                "message" => $message,
                "logo_cid" => $email->setAttachmentCID($logo) // obtiene el content id de la imagen del logo
            ]);
            
            $email->setMessage($body_message);

            if ($email->send()) {
                $success = true;
            }
        }
        
        $data = [
            "message" => $message,
            "success" => $success,
            "descripcion" => "Envia correo en formato HTML"
        ];
        
        echo view("usuario/notify", $data);
    }
    
    public function http(){
        echo "GET";
        print_r($_GET);
        echo "POST";
        print_r($_POST);
        echo "FILES";
        print_r($_FILES);
        echo "SERVER";
        print_r($_SERVER);
        
        $contenido_crudo = file_get_contents("php://input");
        echo "CONTENIDO CRUDO:\n";
        echo $contenido_crudo;
    }
}
