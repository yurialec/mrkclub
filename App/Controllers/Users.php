<?php

use App\Core\Controller;
use App\Models\Auth;
use App\Models\Users as ModelsUsers;

class Users extends Controller
{
    /** Recebe os dados do formulario @var array */
    private array $dataForm;
    /** id do usuario @var integer */
    private int $id;
    /** Registros @var array */
    public array $data;

    public function index()
    {
        if (!isset($_SESSION['logado'])) {
            header('Location: /');
        }

        $users = new ModelsUsers;
        $this->data['Users'] = $users->getAll();

        $totalUsers = new ModelsUsers;
        $this->data['total'] = $totalUsers->totalRecords();

        $this->loadView("Users/index", [$this->data['Users'], $this->data['total']]);
    }

    public function create()
    {
        if (!isset($_SESSION['logado'])) {
            header('Location: /');
        }

        if (isset($_POST['addUser'])) {
            $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($this->dataForm['nome'] == '') {
                header('Location: /users/create');
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher o nome</span><p>";
            }
            if ($this->dataForm['cpf'] == '') {
                header('Location: /users/create');
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher o cpf</span><p>";
            }
            if ($this->dataForm['email'] == '') {
                header('Location: /users/create');
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher o email</span><p>";
            }
            if ($this->dataForm['senha'] == '') {
                header('Location: /users/create');
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher a senha</span><p>";
            }
            if ($this->dataForm['status'] == '') {
                header('Location: /users/create');
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher o status</span><p>";
            }

            unset($this->dataForm['addUser']);

            $newUser = new ModelsUsers;
            $newUser->save($this->dataForm);

            $users = new ModelsUsers;
            $this->data['Users'] = $users->getAll();

            if ($newUser->getResult()) {
                $this->loadView("Users/index", $this->data['Users']);
            } else {
                $this->loadView("Users/index", $this->data['Users']);
            }
        } else {
            $this->loadView('Users/create');
        }
    }

    public function delete($id = '')
    {
        if (!isset($_SESSION['logado'])) {
            header('Location: /');
        }

        $this->id = $id;
        $deleteUser = new ModelsUsers;
        $deleteUser->delete($this->id);

        $users = new ModelsUsers;
        $this->data['Users'] = $users->getAll();

        if ($deleteUser->getResult()) {
            $this->loadView("Users/index", $this->data['Users']);
        } else {
            echo "Erro";
            die;
        }
    }

    public function update($id = '')
    {
        if (!isset($_SESSION['logado'])) {
            header('Location: /');
        }

        $this->id = (int) $id;
        $updateUser = new ModelsUsers;
        $this->data['user'] = $updateUser->getUserById($this->id);

        $users = new ModelsUsers;
        $this->data['Users'] = $users->getAll();

        $total = new ModelsUsers;
        $this->data['total'] = $total->totalRecords();

        if (isset($_POST['updateUser'])) {
            $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($this->dataForm['nome'] == '') {
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher o nome</span><p>";
                $this->loadView('Users/update', [$this->data['user'], $this->data['total']]);
            }
            if ($this->dataForm['cpf'] == '') {
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher o cpf</span><p>";
                $this->loadView('Users/update', [$this->data['user'], $this->data['total']]);
            }
            if ($this->dataForm['email'] == '') {
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher o email</span><p>";
                $this->loadView('Users/update', [$this->data['user'], $this->data['total']]);
            }
            if ($this->dataForm['senha'] == '') {
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher a senha</span><p>";
                $this->loadView('Users/update', [$this->data['user'], $this->data['total']]);
            }
            if ($this->dataForm['status'] == '') {
                $_SESSION['msg'] = "<p><span style='color: #f00'>Necessário preencher o status</span><p>";
                $this->loadView('Users/update', [$this->data['user'], $this->data['total']]);
            }

            unset($this->dataForm['editUser']);

            $updateUser = new ModelsUsers;
            $updateUser->update($this->dataForm);

            if ($updateUser->getResult()) {
                $this->loadView("Users/index", $this->data['Users']);
            } else {
                $this->loadView('Users/update', [$this->data['user'], $this->data['total']]);
            }
        }

        $this->loadView('Users/update', [$this->data['user'], $this->data['total']]);
    }
}
