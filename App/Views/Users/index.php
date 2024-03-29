<?php

use App\Pagination;

if (!empty($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

//O terceiro parametro indica quantos registros devem ser carregados por pagina
$pagination = new Pagination($this->data['Users'], isset($_GET['page']) ? $_GET['page'] : 1, 10);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../public/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="site">
        <header>
            <h1>USUÁRIOS</h1>
            <form class="busca" action="/users/search" method="POST">
                <input type="text" name="pesquisa" placeholder="Nome do usuário">
                <button type="submit" name="searchBtn"><i style="margin-right: 15px;" class="fa-solid fa-magnifying-glass fa-xl"></i></button>
            </form>
            <figure></figure>
            <a class="sair" href="/login/logout">sair</a>
        </header>
        <ul class="main">
            <li class="titulo">
                <div class="texto nome">Nome</div>
                <div class="texto cpf">CPF</div>
                <div class="texto email">E-MAIL</div>
                <div class="texto data">DATA</div>
                <div class="texto status">STATUS</div>
                <div class="editar"></div>
                <div class="deletar"></div>
            </li>
            <?php foreach ($pagination->result() as $user) : ?>
                <?php extract($user) ?>
                <li class="dado">
                    <div class="texto nome"><?= $nome; ?></div>
                    <div class="texto cpf"><?= $cpf; ?></div>
                    <div class="texto email"><?= $email; ?></div>
                    <div class="texto data"><?= date("d/m/Y", strtotime($data_criacao)) ?></div>
                    <div class="texto status"><?php $status == 1 ? printf("Ativo") : printf("Inativo"); ?></div>

                    <?php foreach ($_SESSION['user_permissao'] as $key => $value) : ?>
                        <?php if ($value == 'usuario_editar') : ?>
                            <div class="editar">
                                <a href="/users/update/<?= $id ?>"><img src="/images/editar.svg"></a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php foreach ($_SESSION['user_permissao'] as $key => $value) : ?>
                        <?php if ($value == 'usuario_deletar') : ?>
                            <div class="deletar">
                                <!-- Usuário logado não pode se excluir -->
                                <?php if ($_SESSION['user_id'] !== $id) : ?>
                                    <a href="/users/delete/<?= $id ?>" onClick="return confirm('Tem Certeza que deseja excluir este registro?')"><i class="fa-solid fa-trash-can fa-lg"></i></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </li>
            <?php endforeach; ?>
        </ul>
        <div class="pagina">
            <p class="resultado"><?= ($this->data['total'][0]['num_total']); ?> resultado(s).</p>
            <p><?php $pagination->navigator(); ?></p>
            <!-- <a href="">Anterior</a>
            <a href="">Próxima</a> -->
        </div>

        <?php foreach ($_SESSION['user_permissao'] as $key => $value) : ?>
            <?php if ($value == 'usuario_add') : ?>
                <a href="/users/create" class="botao_add">Adicionar novo</a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</body>

</html>