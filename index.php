<?php
session_start();

spl_autoload_register(function ($className){
    $className = str_replace('\\', '/', $className);
    require_once($className.'.class.php');
});

use \Lib\Url;

try {
    $url = new Url;
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

    $module = $url->getModule();

    switch ($module) {
        case 'frontend':
            require('frontend/index.php');
        break;

        case 'backend':
            require ('backend/index.php');
        break;

        default:
            throw new Exception('Le module demandé n\'existe pas.');
    }
} catch (Exception $e) {
    $errorMessage = '<div class="alert alert-warning" role="alert">';
        $errorMessage .= '<p><strong>'.$e->getMessage().'</strong></p>';
        $errorMessage .= '<p>File path:<br><em>'.__FILE__.'</em> on <strong>line '.__LINE__.'</strong>.</p>';
    $errorMessage .= '</div>';

    die($errorMessage);
}