<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if ($delete):
    require('_app/Models/AdminRepresentante.class.php');
    $delUser = new AdminRepresentante;
    $delUser->ExeDelete($delete);
    DSErro($delUser->getError()[0], $delUser->getError()[1]);
endif;
?>

<section class="content-header">
    <h1>
        Usuários
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a><li class="active">Representantes</li></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de Representantes</h3>
            <div class="box-tools pull-right">
                <a href="painel.php?exe=representantes/create" title="Cadastrar Novo Representante" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar Representante</a>
            </div>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover" id="representantestable">
                    <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $read = new Read;
                    $read->ExeRead("representantes", "ORDER BY nome ASC");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><a href="painel.php?exe=representantes/update&userid=<?= $id; ?>" class="thumbnail"><?= Check::Image('../uploads/representantes/'.$imagem); ?></a></td>
                                <td><a href="painel.php?exe=representantes/update&userid=<?= $id; ?>"><?= $nome?></td>
                                <td><a href="painel.php?exe=representantes/update&userid=<?= $id; ?>"><?= $email ?></td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="painel.php?exe=representantes/update&userid=<?= $id; ?>" title="Editar"><i class="glyphicon glyphicon-edit" ></i></a>
                                    <a id="delete_btn" class="btn btn-xs btn-danger" data-id="<?= $id; ?>" data-tabela="usuarios" data-pasta="users"  title="Deletar"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>

                            <?php
                        endforeach;

                    else:
                        DSErro("Desculpe, ainda não existem Representantes cadastrados!", DS_INFOR);
                    endif;
                    ?>

                    </tbody>
                </table>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
