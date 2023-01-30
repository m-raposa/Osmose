<?php
namespace Lib;

class PageView {
    protected $viewVariables = ['pageTitle',
                                'pageContent',
                            ];

    public function renderView($calledModule, $calledView, $viewVariables = []) {
        if (empty($calledModule)) {
            throw new Exception('Aucune module appelé pour rendre la vue.');
            return;
        }

        if (empty($calledView)) {
            throw new Exception('Aucun template appelé pour rendre la vue.');
            return;
        }

        echo $calledModule.'<br>';
        echo $calledView.'<br>';

        // Verifier validité du module: existe-t-il 
        // Verifier validité de la vue: le fichier existe-t-il

        // Verifier que toutes les variables nécessaires sont transmises à la vue
        // inclure la vue et les variables.
    }

    public function issetModule($module) {

    }

    public function issetView($view) {

    }

    public function getViewVariables($view) {

    }
}