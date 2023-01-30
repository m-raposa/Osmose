<?php

function homepage() {
    $pageTitle = 'Osmose - Simplifiez-vous la data produit';

    ob_start();
        require(__DIR__.'/../views/homepage.view.php');
    $pageContent = ob_get_clean();

    require_once(__DIR__.'/../views/template.view.php');
}
