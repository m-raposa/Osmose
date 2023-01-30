<?php

function productDescription() {
    $pageTitle = 'Osmose - Description produit';

    ob_start();
        require(__DIR__.'/../views/productDescription.view.php');
    $pageContent = ob_get_clean();

    require_once(__DIR__.'/../views/template.view.php');
}
