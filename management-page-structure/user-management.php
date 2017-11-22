<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hippo Supermarket</title>
    <?php include('../main-page-structure/links.php') ?>
</head>
<body>

<?php include('../management-page-structure/top-bar.php'); ?>

<div class="container" style="display: flex">
    <div class="row body-project--navbar">
        <div class="body-project--options">
            <span class="body-project--title">Gerenciamento</span>
            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Usuarios
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="category-user-management.php">Categorias</a>
                    <a class="dropdown-item" href="product-management.php">Produtos</a>
                </div>
            </div>
        </div>
        <div class="body-project--addbutton">
            <button class='btn btn-danger' type='submit' data-toggle="modal" data-target="#produtoModal">Adicionar Novo
                Produto
            </button>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">

        <?php
        session_start();
        include('../db/bancodedados.php');
        $msg = $_SESSION['msg'];
        $erro = $_SESSION['erro'];
        if(isset($msg)){
            echo "
                <div class='container' style='left:23%'>
                    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\" style='width: 72%'> $msg
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">&times;</span>
                        </button>
                    </div>
                </div>
            ";
        }
        if(isset($erro)) {
            echo "
                <div class='container' style='left:23%'>
                    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\" style='width: 72%'> $erro
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">&times;</span>
                        </button>
                    </div>
                </div>
            ";
        }
        try {
            $instrucaoSQL = "SELECT idUsuario,loginUsuario,senhaUsuario,nomeUsuario,tipoPerfil, usuarioAtivo FROM Usuario";
            $consulta = sqlsrv_query($conn, $instrucaoSQL);
            $numRegistros = sqlsrv_num_rows($consulta);
        } catch (Exception $e) {
            die($e);
        }
        while ($usuario = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_NUMERIC)) {
            $usuario[1] = utf8_encode((empty($usuario[1])) ? "Sem dados" : $usuario[1]);
            $usuario[2] = utf8_encode((empty($usuario[2])) ? "Sem dados" : $usuario[2]);
            $usuario[5] =($usuario[5] == 1) ? "Sim" : "Não";
            ?>
            <div class="col-sm-6 col-md-4">
                <div class="card  mb-3">
                    <div class="card-block">
                        <input class="card-title" name="nome" value="<?= $usuario[3] ?>" />
                        <strong>Id do Usuário : </strong><input class="card-text" name="id" value="<?=  $usuario[0]; ?>" />
                    </div>
                    <ul class="list-group list-group-flush">
                        <strong>Login  </strong><input class="list-group-item" name="login" value="<?= $usuario[1]; ?>" />
                        <strong>Senha  </strong><input class="list-group-item" name="senha" value="<?= $usuario[2]; ?>" />
                        <strong>Tipo  </strong><input class="list-group-item" name="perfil" value="<?= $usuario[2]; ?>" />
                        <strong>Ativo/Desativo  </strong><input class="list-group-item" name="ativo" value="<?= $usuario[5]; ?>" />
                        
                    </ul>
                    <div class="card-footer" style="display: flex; justify-content: space-between;">
                        <input class='body-project--formbutton' type='image' src='/svg/pencil.svg'   formaction='/code/user/user-update.php'/>
                        <input class='body-project--formbutton' type='image' src='/svg/garbage.svg'  formaction='/code/user/user-delete.php'>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

    </div>
    <div class="row">
        <div class='box-container-add'>
            <div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Novo Usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Login:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="loginUsuario">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="form-control-label">Senha:</label>
                                    <input type="password" class="form-control" id="recipient-name" name="senhaUsuario">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="form-control-label">Nome:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="nomeUsuario">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="form-control-label">Perfil:</label>
                                    <select name="perfilUsuario">
                                        <option value="">Escolha</option>
                                        <option value="A">Administrador</option>
                                        <option value="C">Colaborador</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="form-control-label">Ativo:</label>
                                    <input type="checkbox" name="usuarioAtivo">
                                </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-danger" value="Adicionar nova categoria"
                                   name="btnGravar" formaction='/code/user/user-add.php'></input>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('../main-page-structure/import-javascript.php') ?>
</body>
</html>