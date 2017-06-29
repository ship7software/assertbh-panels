<?php
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$idcond = filter_input(INPUT_GET, 'idcond', FILTER_VALIDATE_INT);
$nomeCondominio = filter_input(INPUT_GET, 'nomeCondominio');
$arquivo = filter_input(INPUT_GET, 'arquivo');
$modulo = 'boletos';
$title = 'Remessa';

require('_app/Models/AdminCobranca.class.php');

$Proprietario = new AdminCobranca();
$Condominio = new AdminCobranca();
$Unidade = new AdminCobranca();
$banco = new AdminCobranca();
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
            <h3 class="box-title">Boletos da <?= $title; ?> <?= $arquivo; ?> - Condomínio: <?= $nomeCondominio; ?></h3>

            <div class="box-tools pull-right">
                <a href="painel.php?exe=remessa/indexcond&nomeCondominio=<?= $nomeCondominio; ?>&id=<?= $idcond; ?>" title="Retornar para Remessas" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Remessas</a>
            </div>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover" id="cobrancastable">
                    <thead>
                    <tr>
                        <th>Lançamento</th>
                        <th>Proprietário</th>
                        <th>Condomínio</th>
                        <th>Unidade</th>
                        <th>Vencimento Original</th>
                        <th>Vencimento Boleto</th>
                        <th>Valor</th>
                        <th>Juros</th>
                        <th>Multa</th>
                        <th>Pagamento</th>
                        <th>Valor Pago</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    $read = new Read;
                    $read->ExeRead($modulo, "WHERE id_remessa = {$id}");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($data)); ?></td>
                                <td><?= $Proprietario->getProprietario($id_proprietario)?></td>
                                <td><?= $Condominio->getCondominio($id_condominio)?></td>
                                <td><?= $Unidade->getUnidade($id_unidade)?></td>
                                <td><?= date('d/m/Y', strtotime($vencimento)); ?></td>
                                <td><?= date('d/m/Y', strtotime($vencimentoBoleto)); ?></td>
                                <td><?= $valor ?></td>
                                <td><?= $juros ?></td>
                                <td><?= $multa ?></td>
                                <td><?= (!empty($pagamento))?date('d/m/Y', strtotime($pagamento)): ''; ?></td>
                                <td><?= $valor_pago ?></td>
                            </tr>

                            <?php
                        endforeach;

                    else:
                        DSErro("Desculpe, ainda não existem ".$title."s cadastradas!", DS_INFOR);
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
