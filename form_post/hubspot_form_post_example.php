<?php

//Include HubSpotFormPost.php via autoload or...
require_once('HubSpotFormPost.php');

$portal_id = "00000000"; //Enter HubSpot Portal ID (Account Specific)
$form_guid = "00000000-0000-0000-0000-000000000000"; //Enter HubSpot Form GUID (Form Specific)
$page_name = "Testing Page"; //Name of the Page Converting on
$page_path = "https://www.stealthconsulting.com/testpage/"; //Full Path of the Page Converting on

$form_responses = [
  "email" => "email@email.com",
  "firstname" => "test",
  "lastname" => "person",
  //Enter additional contact properties here
];

$request = [
  "portal_id" => $portal_id,
  "form_guid" => $form_guid,
  "page_name" => $page_name,
  "page_path" => $page_path,
  "form_responses" => $form_responses
];

$response = new HubSpotFormPost($request);

var_dump($response);

?>