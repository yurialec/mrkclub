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
</head>

<body>
    <div id="site">
        <header>
            <h1>USUÁRIOS</h1>
            <form class="busca" action="">
                <i><img src="images/lupa.svg"></i>
                <input type="text" name="pesquisa" placeholder="Pesquisar...">
            </form>
            <figure></figure>
            <a class="sair" href="/login/logout">sair</a>
        </header>
        <?php
        if (!empty($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <ul>
            <li class="titulo">
                <div class="texto nome">Nome</div>
                <div class="texto cpf">CPF</div>
                <div class="texto email">E-MAIL</div>
                <div class="texto data">DATA</div>
                <div class="texto status">STATUS</div>
                <div class="editar"></div>
                <div class="deletar"></div>
            </li>
            <?php foreach ($this->data['Users'] as $user) : ?>
                <?php extract($user) ?>
                <li class="dado">
                    <div class="texto nome"><?= $nome; ?></div>
                    <div class="texto cpf"><?= $cpf; ?></div>
                    <div class="texto email"><?= $email; ?></div>
                    <div class="texto data"><?= date("d/m/Y", strtotime($data_criacao)) ?></div>
                    <div class="texto status"><?php $status == 1 ? printf("Ativo") : printf("Inativo"); ?></div>
                    <div class="editar"><a href="/users/update/<?= $id ?>"><img src="images/editar.svg"></a></div>
                    <div class="deletar">
                        <a href="/users/delete/<?= $id ?>" onClick="return confirm('Tem Certeza que deseja excluir este registro?')"><i class="fa-solid fa-trash-can fa-lg"></i></a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="pagina">
            <p class="resultado"><?= isset($this->data['total'][0]['num_total']); ?> resultado(s).</p>
            <a href="">Anterior</a>
            <a href="">Próxima</a>
        </div>
        <a href="/users/create" class="botao_add">Adicionar novo</a>
    </div>
</body>

</html>