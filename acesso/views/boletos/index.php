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
                <a href="painel.php?exe=unidades/index&userid=<?=$readUnidade->getResult()[0]['id_proprietario']?>" title="Retornar para Propriedades" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Propriedades</a>
            </div>
            <h4>Condomínio: <?= $condominio->getCondominio($readUnidade->getResult()[0]['id_condominio']); ?> - Unidade: Bloco: <?= $readUnidade->getResult()[0]['bloco']; ?> -
                Apto/Sala: <?= $readUnidade->getResult()[0]['apto_sala']; ?></h4>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover responsive nowrap" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Ref.</th>
                        <th>Data Lançamento</th>
                        <th>Data Vencimento Original</th>
                        <th>Data Vencimento Boleto</th>
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
                    $read->ExeRead($modulo, "WHERE id_unidade = {$idunidade} ORDER BY data ");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><a href="#"><?= $mes_ref ?></td>
                                <td><a href="#"><?= date('d/m/Y', strtotime($data)); ?></td>
                                <td><a href="#"><?= date('d/m/Y', strtotime($vencimento)); ?></td>
                                <td><a href="#"><?= (!empty($vencimentoBoleto))?date('d/m/Y', strtotime($vencimentoBoleto)): date('d/m/Y', strtotime($vencimento)); ?></td>
                                <td><a href="#"><?= $valorOriginal ?></td>
                                <td><a href="#"><?= $valorAtualizado ?></td>
                                <td><a href="#"><?= (!empty($pagamento))?date('d/m/Y', strtotime($pagamento)): ''; ?></td>
                                <td><a href="#"><?= $valor_pago ?></td>
                                <td>
                                    <a class="btn btn-xs btn-success" href="https://boleto-assertbh.mybluemix.net/gerar/boleto/<?= $id; ?>" title="Visualizar Boleto" target="_blank"><i class="glyphicon glyphicon-file" ></i>2&ordf; Via Boleto</a>
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
