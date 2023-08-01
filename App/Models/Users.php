<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

/**
 * Model usuarios
 */
class Users extends Model
{
    /** Recebe os dados do banco de dados @var array */
    private array $resultBd;

    /** Parametor do metodo save variable @var array */
    private array $data;

    //Dados do formulario
    private string $nome;
    private int $cpf;
    private string $email;
    private string $senha;
    private string $status;
    private string $permissao;

    /** Total de registros @var integer*/
    private array $numTotal;

    /** id do usuario @var integer */
    private int $id;

    private bool $result;

    public function getResult()
    {
        return $this->result;
    }

    public function getAll()
    {
        $query = "SELECT * FROM usuario";
        $stmt = Model::getConn()->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $this->resultBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->resultBd;
        } else {
            return [];
        }
    }

    public function save(array $data)
    {
        //Recebe os valores da controller
        $this->data = $data;

        // Os atrubutos da classe recebem os valores
        $this->nome = $this->data['newUser']['nome'];
        $uuid = uniqid();
        $data_criacao = date('Y-m-d H:i:s');
        $this->cpf = (int) str_replace("-", "", (str_replace(".", "", $this->data['newUser']['cpf'])));
        $this->email = filter_var($this->data['newUser']['email'], FILTER_VALIDATE_EMAIL);
        $this->senha = password_hash($this->data['newUser']['senha'], PASSWORD_DEFAULT);
        $this->status = (int) $this->data['newUser']['status'];
        $this->permissao = serialize($this->data['newUser']['permissao']);

        $query = "INSERT INTO usuario (uuid, nome, cpf, email, senha, permissao, data_criacao, status, data_atualizacao)
        VALUES (:uuid, :nome, :cpf, :email, :senha, :permissao, :data_criacao, :status, :data_atualizacao)";

        $stmt = Model::getConn()->prepare($query);
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':permissao', $this->permissao);
        $stmt->bindParam(':data_criacao', $data_criacao);
        $stmt->bindParam(':data_atualizacao', $data_criacao);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "<p><span style='color: #008000'>Cadastrado com sucesso!</span><p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p><span style='color: #f00'>Erro ao cadastrar!</span><p>";
            $this->result = false;
        }
    }

    public function delete(int $id)
    {
        $this->id = $id;
        $query = "DELETE FROM usuario WHERE id = :id";
        $stmt = Model::getConn()->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "<p><span style='color: #008000'>Excluído com sucesso!</span><p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p><span style='color: #f00'>Erro ao excluir!</span><p>";
            $this->result = false;
        }
    }

    public function totalRecords()
    {
        $query = "SELECT COUNT(id) AS num_total FROM usuario";
        $stmt = Model::getConn()->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $this->numTotal = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->numTotal;
        } else {
            return [];
        }
    }

    public function update(array $data)
    {
        //Recebe os valores da controller
        $this->data = $data;

        // Os atrubutos da classe recebem os valores
        $this->id = (int) $this->data['updateUser']['id'];
        $this->nome = $this->data['updateUser']['nome'];
        $this->cpf = (int) str_replace("-", "", (str_replace(".", "", $this->data['updateUser']['cpf'])));
        $this->email = filter_var($this->data['updateUser']['email'], FILTER_VALIDATE_EMAIL);
        $this->senha = password_hash($this->data['updateUser']['senha'], PASSWORD_DEFAULT);
        $this->status = (int) $this->data['updateUser']['status'];
        $this->permissao = serialize($this->data['updateUser']['permissao']);
        $data_atualizacao = date('Y-m-d H:i:s');


        $query = "UPDATE usuario
                    SET nome =:nome, cpf =:cpf, email =:email, senha =:senha,
                        permissao =:permissao, data_atualizacao =:data_atualizacao,
                        data_criacao =:data_criacao, status =:status
                    WHERE id =:id";

        $stmt = Model::getConn()->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':permissao', $this->permissao);
        $stmt->bindParam(':data_atualizacao', $data_atualizacao);
        $stmt->bindParam(':data_criacao', $data_atualizacao);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "<p><span style='color: #008000'>Atualizado com sucesso!</span><p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p><span style='color: #f00'>Erro ao atualizar!</span><p>";
            $this->result = false;
        }
    }

    public function getUserById($id)
    {
        $this->id = $id;

        $query = "SELECT * FROM usuario WHERE id =:id";
        $stmt = Model::getConn()->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $this->resultBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->resultBd;
        } else {
            return [];
        }
    }
}
