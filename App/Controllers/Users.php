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
            $this->dataForm['newUser'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            unset($this->dataForm['newUser']['addUser']);

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
            $this->dataForm['updateUser'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            unset($this->dataForm['editUser']);

            $updateUser = new ModelsUsers;
            $updateUser->update($this->dataForm);

            if ($updateUser->getResult()) {
                $this->loadView("Users/index", [$this->data['Users'], $this->data['total']]);
            } else {
                $this->loadView("Users/index", [$this->data['Users'], $this->data['total']]);
            }
        }

        $this->loadView('Users/update', [$this->data['user'], $this->data['total']]);
    }
}
