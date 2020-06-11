<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    
    protected $page_size = 10;
    
    public function __construct(\CodeIgniter\Database\ConnectionInterface &$db = null, \CodeIgniter\Validation\ValidationInterface $validation = null) {
        parent::__construct($db, $validation);
        
        $this->validationRules = [
            // "id" => "", // Se genera internamente
            "nombre" => "required|max_length[255]", //"nombre" => "required|max_length[255]|multiples_palabras",
            "apellido" => "required|max_length[255]",
            "sexo" => "in_list[hombre,mujer]",
            "telefono" => "decimal|max_length[50]",
            "direccion" => "required|max_length[255]",
            // "extranjero" => "",
            // "becado" => "",
            "carrera" => "required|max_length[50]",
            "foto" => "max_length[255]",
            "titulo" => "max_length[255]",
            // "fecha_registro" => "" // se genera internamente
        ];
        
        $this->validationMessages = [
            "sexo" => [
                "in_list" => "Solo se permite el valor hombre o mujer"
            ],
            "foto" => [
                "required" => "La foto es requerida"
            ],
            "titulo" => [
                "required" => "El titulo es requerido"
            ]
        ];
        
        $this->allowedFields = [
            "nombre", 
            "apellido", 
            "sexo", 
            "telefono", 
            "direccion", 
            "carrera",
            "foto",
            "titulo",
            "fecha_registro"
        ];
    }
    
    public function listar($page = 1) {
        $offset = ($page - 1) * $this->page_size;
        return $this->findAll($this->page_size, $offset);
    }
    
    public function ver($id){
        return $this->asArray()
                ->where(["id"=>$id])
                ->first();
    }
    
    public function consulta(){
        /* @var $query \CodeIgniter\Database\MySQLi\Result */
        $query = $this->db->query("SELECT (:num1: + :num2:) as resultado", ["num1" => 12, "num2" => 23]);
        return $query->getRowArray();
    }
    
    public function borrar($id){
        /* @var $query \CodeIgniter\Database\MySQLi\Result */
        $query = $this->db->query('DELETE FROM `usuario` WHERE `id`=:id:', ["id" => $id]);
        $affected_rows = $this->db->affectedRows();
        return ($affected_rows > 0);
    }
    
    public function images_dir(){
        return WRITEPATH.'uploads';
    }
    
    public function get_thumbnail($file,int $width, int $height){
        // usuario_id.extension
        // usuario_id_width_height.extension
        $destination_dir = FCPATH."/img/usuario";
        
        if (!is_dir($destination_dir)) {
            mkdir($destination_dir, 0755, true);
        }
        
        $destination_file = $destination_dir."/".
                            pathinfo($file, PATHINFO_FILENAME).
                            "_".intval($width).
                            "_".intval($height).".".
                            pathinfo($file, PATHINFO_EXTENSION);
        
        
        if (!is_file($destination_file)) {
            $image = \Config\Services::image();
            $image->withFile($this->images_dir()."/".$file)
                  ->fit($width, $height, "center")
                  ->save($destination_file);
        }
        
        return base_url("img/usuario/".basename($destination_file));
    }
    
    public function procesar_fotos(&$usuario, $fotos){
        $campos = ["foto", "titulo"];
        foreach($campos as $field){
            if (!isset($fotos[$field])) continue;
            
            /* @var $foto \CodeIgniter\HTTP\Files\UploadedFile */
            $img = $fotos[$field];
            
            if (!empty($img) 
                && $img->getError()==0
                && $img->getSize()>0) {

                // $newName = $img->getRandomName();
                $newName = "usuario_".$usuario["id"].".".$img->getExtension();
                
                $img->move($this->images_dir(), $newName);

                if (!empty($usuario[$field])) {
                    $old_filepath = $this->images_dir().'/'.$usuario[$field];
                    if (is_file($old_filepath)) {
                        unlink($old_filepath);
                    }
                }
                $usuario[$field] = $newName;
            }
        }
    }
}