<?php

namespace App\Core;

use PDO;

/**
 * Model base para conexão com o banco de dados
 */
class Model
{

    /**
     * retorna a instancia do banco de dados
     *
     * @var object
     */
    private static object $instance;

    public static function getConn(): object
    {
        if (!isset(self::$instance)) :
            self::$instance = new PDO('mysql:host=localhost;dbname=teste;charset=utf8', 'root', '');
        endif;

        return self::$instance;
    }
}
