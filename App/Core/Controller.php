<?php

namespace App\Core;

/**
 * Undocumented class
 */
class Controller
{
    public function loadModel($modelName)
    {
        require_once '../App/Models/' . $modelName . '.php';
        return new $modelName;
    }

    public function loadView($viewName, $data = [])
    {
        require_once '../App/Views/Template.php';
    }
}
