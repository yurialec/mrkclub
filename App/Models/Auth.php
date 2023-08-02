<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * Model usuarios
 */
class Auth extends Model
{
    /** Recebe os dados do banco de dados @var array */
    private $resultBd;

    /** Parametor do metodo save variable @var array */
    private array $data;

    //Dados do formulario
    private $cpf;
    private $senha;

    private bool $result;

    public function getResult()
    {
        $this->result;
    }

    public function login($data)
    {
        $this->data = $data;

        $this->cpf = $this->data['login'];
        $this->senha = $this->data['senha'];

        $query = "SELECT * FROM usuario WHERE cpf =:cpf LIMIT 1";
        $stmt = Model::getConn()->prepare($query);
        $stmt->bindParam(':cpf', $this->cpf);

        if ($stmt->execute()) {
            $this->resultBd = $stmt->fetch(PDO::FETCH_ASSOC);

            if ((password_verify($this->senha, $this->resultBd['senha'])) and ($this->resultBd['status'] == 1)) {

                $_SESSION['logado'] = true;
                $_SESSION['user_id'] = $this->resultBd['id'];
                $_SESSION['user_nome'] = $this->resultBd['nome'];
                $_SESSION['user_permissao'] = unserialize($this->resultBd['permissao']);
                $_SESSION['user_status'] = $this->resultBd['status'];

                $_SESSION['msg'] = "<p><span style='color: #008000'>Login realizado com sucesso!</span><p>";
                return true;
            } elseif ($this->resultBd['status'] == 0) {
                $_SESSION['msg'] = "<p><span style='color: #f00'>Status do usuário inativo!</span><p>";
                return false;
            } else {
            }
        }
    }
}
