<?php
namespace App\Models;

use CodeIgniter\Model;

class BotupdateModel extends Model
{
    protected $table = 'botupdate';
    
    protected $page_size = 10;
    
    public function __construct(\CodeIgniter\Database\ConnectionInterface &$db = null, \CodeIgniter\Validation\ValidationInterface $validation = null) {
        parent::__construct($db, $validation);
        
        $this->validationRules = [
        ];
        
        $this->validationMessages = [
        ];
        
        $this->allowedFields = [
            "update_id", 
            "content"
        ];
    }
    
    public function ultimo_id(){
        return $this->orderBy('update_id', 'DESC')->first();
    }
}