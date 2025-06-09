<?php

/* Created by Stealth Consulting */

class HubSpotFormPost {
  
  public $end_point = "https://api.hsforms.com/submissions/v3/integration/submit/";
  public $portal_id = false;
  public $form_guid = false;
  public $form_responses = false;
  public $page_name = false;
  public $page_path = false;

  public function __construct($request=false){
    if(!$request) return false;
    if(!isset($request["portal_id"])) return "Portal ID not set";
    if(!isset($request["form_guid"])) return "Form GUID not set";
    if(!isset($request["form_responses"])) return "Form responses are not set";

    $this->portal_id = $request["portal_id"];
    $this->form_guid = $request["form_guid"];
    $this->form_responses = $request["form_responses"];

    if(isset($request["end_point"])){
      $this->end_point = $request["end_point"];
    }
    if(isset($request["page_name"])){
      $this->page_name = $request["page_name"];
    }
    if(isset($request["page_path"])){
      $this->page_path = $request["page_path"];
    }

    return $this->post();
  }

  public function post(){

    $post_url = $this->end_point.$this->portal_id."/".$this->form_guid;

    $post_body = [
      "fields" => []
    ];    
    foreach ($this->form_responses as $key => $value) {
      $post_body["fields"][] = [
        "objectTypeId" => "0-1",
        "name" => $key,
        "value" => $value
      ];
    }

    $post_body["context"] = [
      "hutk" => $this->hutk(),
      "ipAddress" => $this->ip(),
      "pageName" => $this->page_name,
      "pageUri" => $this->page_path
    ];
  
    var_dump($post_body);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $post_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_body));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
  
    $output = curl_exec($ch);

    var_dump($output);
    
    curl_close($ch);
  
    return $output;
  }

  public function hutk(){
    foreach($_COOKIE as $name => $val){
	    if($name == "hubspotutk"){
	      return $val;
	    }
	  }
    return "";
  }

  public function ip(){
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }elseif(isset($_SERVER['REMOTE_ADDR'])){
      return $_SERVER['REMOTE_ADDR'];
    }

    return "";
  }

}

?>
