<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if ($delete):
    require('_app/Models/AdminContatos.class.php');
    $delDados = new AdminContatos();
    $delDados->ExeDelete($delete);
    $delDados->geraJSON();
    DSErro($delDados->getError()[0], $delDados->getError()[1]);
endif;
?>
<section class="content-header">
    <h1>
        Contatos
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a><li class="active">Contatos</li></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de Contatos</h3>
            <div class="box-tools pull-right">
                <a href="painel.php?exe=contatos/create" title="Cadastrar Novo Contato" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar Contato</a>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover" id="contatostable">
                    <thead>
                    <tr>
                        <th>Departamento</th>
                        <th>Fornecedor</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $ReadDados = new Read;
                    $ReadDados->ExeRead("contatos", "ORDER BY departamento");
                    if ($ReadDados->getResult()):
                        foreach ($ReadDados->getResult() as $dados):
                            extract($dados);
                            ?>
                            <tr>
                                <td><a href="painel.php?exe=contatos/update&contatoid=<?= $id; ?>"><?= $departamento ?></td>
                                <td><a href="painel.php?exe=contatos/update&contatoid=<?= $id; ?>"><?= $nomefornecedor ?></td>
                                <td><a href="painel.php?exe=contatos/update&contatoid=<?= $id; ?>"><?= $email ?></td>
                                <td><a href="painel.php?exe=contatos/update&contatoid=<?= $id; ?>"><?= $telefone ?></td>
                                <td><a href="painel.php?exe=contatos/update&contatoid=<?= $id; ?>"><?= $celular ?></td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="painel.php?exe=contatos/update&contatoid=<?= $id; ?>" title="Editar"><i class="glyphicon glyphicon-edit" ></i></a>
                                    <a id="delete_btn" class="btn btn-xs btn-danger" data-id="<?= $id; ?>" data-tabela="contatos" data-pasta="contatos"  title="Deletar"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>

                            <?php
                        endforeach;

                    else:
                        DSErro("Desculpe, ainda não existem Contatos cadastrados!", DS_INFOR);
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
