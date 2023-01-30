<?php

global $url;
$action = $url->getAction();

switch ($action) {
    case 'productDescription':
        require ('controllers/productDescription.controller.php');
        productDescription();
    break;
    
    default:
        require ('controllers/homepage.controller.php');
        homepage();
}

// require_once ('views/template.view.php');