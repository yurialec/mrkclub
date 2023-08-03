<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/form.css">
</head>

<body>
    <div id="site">
        <header>
            <a class="voltar" href="/users/index"><img src="/images/voltar.svg"></a>
            <h1 class="total">Editar usuário</h1>
            <figure></figure>
            <a class="sair" href="/login/logout">sair</a>
        </header>
        <?php
        if (!empty($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        ?>
        <form action="" class="cadastro" method="POST">
            <input type="hidden" name="id" id="id" value="<?= $this->data['user'][0]['id'] ?>">
            <div class="input">
                <label for="input_nome">Nome:</label>
                <input type="text" id="input_nome" name="nome" value="<?= $this->data['user'][0]['nome'] ?>">
            </div>
            <div class="input">
                <label for="input_cpf">CPF:</label>
                <input type="text" id="input_cpf" name="cpf" value="<?= $this->data['user'][0]['cpf'] ?>" readonly>
            </div>
            <div class="input">
                <label for="input_email">E-mail:</label>
                <input type="text" id="input_email" name="email" value="<?= $this->data['user'][0]['email'] ?>" required>
            </div>
            <div class="input">
                <label for="input_senha">Senha:</label>
                <input type="password" id="input_senha" name="senha" placeholder="Digite a nova senha" required>
            </div>
            <div class="select">
                <label for="input_status">Status</label>
                <select name="status" id="input_status">
                    <option value="" selected><?php $this->data['user'][0]['status'] == 1 ? printf("Ativo") : printf("Inativo"); ?></option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
                <div class="seta"><img src="images/seta.svg" alt=""></div>
            </div>

            <?php $permissao = unserialize($this->data['user'][0]['permissao']); ?>

            <h2>Permissão</h2>
            <div class="permissao">
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_login" name="permissao[]" value="login" <?php isset($permissao[0]) ? printf("checked") : printf("") ?>>
                    <div class="check"><img src="/images/check.svg"></div>
                    <label for="input_permissao_login">Login</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_add" name="permissao[]" value="usuario_add" <?php isset($permissao[1]) ? printf("checked") : printf("") ?>>
                    <div class="check"><img src="/images/check.svg"></div>
                    <label for="input_permissao_usuario_add">Add usuário</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_editar" name="permissao[]" value="usuario_editar" <?php isset($permissao[2]) ? printf("checked") : printf("") ?>>
                    <div class="check"><img src="/images/check.svg"></div>
                    <label for="input_permissao_usuario_editar">Editar usuário</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_deletar" name="permissao[]" value="usuario_deletar" <?php isset($permissao[3]) ? printf("checked") : printf("") ?>>
                    <div class="check"><img src="/images/check.svg"></div>
                    <label for="input_permissao_usuario_deletar">Deletar usuário</label>
                </div>
            </div>

            <button name="updateUser" id="updateUser">SALVAR</button>
        </form>
    </div>
</body>

</html>