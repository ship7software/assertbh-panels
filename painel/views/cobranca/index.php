<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
$idunidade = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$modulo = 'cobranca';
$title = 'Cobrança';
if ($delete):
    require('_app/Models/AdminCobranca.class.php');
    $delUser = new AdminCobranca();
    $delUser->ExeDelete($delete);
    DSErro($delUser->getError()[0], $delUser->getError()[1]);
endif;

$condominio = new AdminCobranca();
$proprietario = new AdminCobranca();
$banco = new AdminCobranca();

$readUnidade = new Read;
$readUnidade->ExeRead("unidades", "WHERE id = :user", "user={$idunidade}");
$readUnidade->getResult();

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
if ($checkCreate):
    DSErro("A ".$title." foi cadastrado com sucesso no sistema!", DS_ACCEPT);
endif;
$userLogin = $_SESSION['userloginPainel'];
?>

<section class="content-header">
    <h1>
        <?= $title; ?>s
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a><li class="active"><?= $title; ?></li></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de <?= $title; ?>s</h3>
            <div class="box-tools pull-right">
                <a href="painel.php?exe=<?= $modulo; ?>/create&id=<?= $idunidade; ?>" title="Cadastrar Nova <?= $title; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar <?= $title; ?></a>
                <a href="painel.php?exe=unidades/indexcond&id=<?=$readUnidade->getResult()[0]['id_condominio']?>" title="Retornar para Unidades" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Unidades</a>
            </div>
            <h4>Condomínio: <?= $condominio->getCondominio($readUnidade->getResult()[0]['id_condominio']); ?> - Unidade: Bloco: <?= $readUnidade->getResult()[0]['bloco']; ?> -
                Unidade: <?= $readUnidade->getResult()[0]['apto_sala']; ?> - Proprietário: <?= $proprietario->getProprietario($readUnidade->getResult()[0]['id_proprietario']); ?></h4>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover responsive nowrap" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Ref.</th>
                        <th>Data Lançamento</th>
                        <th>Data Vencimento</th>
                        <th>Valor</th>
                        <th>Valor Atualizado</th>
                        <th>Data Pagamento</th>
                        <th>Valor Pago</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $read = new Read;
                    $read->ExeRead($modulo, "WHERE id_unidade = {$idunidade} AND baixa = 0 ORDER BY data ");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            $link = '#';
                            if ($userLogin['email'] == 'admin@assertbh.com.br'):
                                $link = 'painel.php?exe='.$modulo.'/update&id1='.$id;
                            endif;
                            ?>
                            <tr>
                                <td><a href="<?= $link; ?>"><?= $mes_ref ?></td>
                                <td><a href="<?= $link; ?>"><?= date('d/m/Y', strtotime($data)); ?></td>
                                <td><a href="<?= $link; ?>"><?= date('d/m/Y', strtotime($vencimento)); ?></td>
                                <td><a href="<?= $link; ?>"><?= 'R$ '. number_format($valorOriginal, 2, ',', '.') ?></td>
                                <td><a href="<?= $link; ?>"><?= 'R$ '. number_format($valorTotal, 2, ',', '.') ?></td>
                                <td><a href="<?= $link; ?>"><?= (!empty($pagamento))?date('d/m/Y', strtotime($pagamento)): ''; ?></td>
                                <td><a href="<?= $link; ?>"><?= $valor_pago ?></td>
                                <td>
                                    <a class="btn btn-xs btn-success" href="http://assertbh-com-br.umbler.net/gerar/boleto/<?= $id; ?>" title="Visualizar Boleto" target="_blank"><i class="glyphicon glyphicon-file" ></i> Boleto</a>
                                    <a class="btn btn-xs btn-primary" href="<?= $link; ?>" title="Editar"><i class="glyphicon glyphicon-edit" ></i></a>
                                    <a id="delete_boletos" class="btn btn-xs btn-danger" data-id="<?= $id; ?>" data-idunidade="<?= $idunidade; ?>" data-tabela="<?= $modulo; ?>" data-pasta="<?= $modulo; ?>"  title="Deletar"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    else:
                        DSErro("Desculpe, ainda não existem ".$title."s cadastrados!", DS_INFOR);
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
