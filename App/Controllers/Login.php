<?php

use App\Core\Controller;
use App\Models\Auth;

class Login extends Controller
{
    /** Recebe os dados do formulário @var array */
    private array $dataForm;
    /** Registros @var array */
    public array $data;

    public function index()
    {
        $this->loadView("Login/index");
    }

    public function validar()
    {
        if (isset($_POST['loginButton'])) {
            $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            unset($this->dataForm['loginButton']);

            $loginUser = new Auth();
            if ($loginUser->login($this->dataForm)) {
                header('Location: /users/index');
            } else {
                header('Location: /');
            }
        }
    }

    public function logout()
    {
        session_destroy();
        $_SESSION['msg'] = "<p><span style='color: #008000'>Deslogado com sucesso!</span><p>";
        header('Location: /');
    }

    static function checkLogin()
    {
        if (!isset($_SESSION['logado'])) {
            header('Location: /');
        }
    }
}
