<?php
namespace App\Controllers;

use App\Models\BotupdateModel;

class Bot extends BaseController
{
    protected $token = "1223733794:AAGoZW11nxyWj_jAa5q2PpSo9WRBmMZrD3s";
    protected $base_url = "https://api.telegram.org/bot<token>/";
    
    public function __construct() {
        $this->base_url = str_replace("<token>", $this->token, $this->base_url);
    }
    
    public function getUpdates(){
        $client = \Config\Services::curlrequest();
        
        $botupdate = new BotupdateModel();
        
        $ultimo = $botupdate->ultimo_id();
        
        // file_get_contents puede hacer solicitudes HTTP pero 1.0
        //$respuesta = file_get_contents($this->base_url."getUpdates?offset=".$ultimo["update_id"]);
        
        $http_respuesta = $client->request("get", $this->base_url."getUpdates?offset=".($ultimo["update_id"]+1));
        $respuesta = $http_respuesta->getBody();
                
        $resp = json_decode($respuesta, true);
        
        if (empty($resp["ok"])) return;
        
        
        
        foreach($resp["result"] as $update){
            if (empty($update["message"]["text"])) 
                continue;
            
            $params = [
                "chat_id" => $update["message"]["from"]["id"],
                "text" => "al revez: ".strrev($update["message"]["text"])
            ];
            
            // chat_id=<contenido>&text=<contenido>
            $client->setHeader("Content-Type", "application/json")
                   ->setBody(json_encode($params))
                   ->post($this->base_url."sendMessage");
            //$enviados[] = file_get_contents($this->base_url."sendMessage?". http_build_query($params));
            
            $this->saveUpdate($botupdate, $update);
            sleep(1);
        }
    }
    
    public function hook(){
        $botupdate = new BotupdateModel();
        
        $input = file_get_contents("php://input");
        
        $update = json_decode($input, true);
        
        $this->saveUpdate($botupdate, $update);
        
        if (empty($update["message"]["text"])) return;
        
        $client = \Config\Services::curlrequest();
        
        $params = [
            "chat_id" => $update["message"]["from"]["id"],
            "text" => "al revez al instante: ".strrev($update["message"]["text"])
        ];
            
        // chat_id=<contenido>&text=<contenido>
        $client->setHeader("Content-Type", "application/json")
               ->setBody(json_encode($params))
               ->post($this->base_url."sendMessage");
    }
    
    protected function saveUpdate($botupdate, $update){
        try{
                $botupdate->insert([
                    "update_id" => $update["update_id"],
                    "content" => json_encode($update)
                ]);
            } catch(\Exception $e){}
    }
}