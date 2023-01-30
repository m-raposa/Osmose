<?php

function login() {
    $pageTitle = 'Connexion';

    ob_start();
        require(__DIR__.'/../views/login.view.php');
    $pageContent = ob_get_clean();

    require_once(__DIR__.'/../views/template.view.php');
}
