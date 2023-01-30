<?php

global $url;
$action = $url->getAction();

switch ($action) {
    case 'login':
        require ('controllers/login.controller.php');
        login();
    break;
    
    default:
        throw new Exception('Cette fonction du backend n\'est pas définie.');
}

// require_once ('views/template.view.php');