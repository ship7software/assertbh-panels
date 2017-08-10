<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
$idcond = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modulo = 'cobranca';
$title = 'Cobrança';

require('_app/Models/AdminCobranca.class.php');

$Proprietario = new AdminCobranca();
$Condominio = new AdminCobranca();
$Unidade = new AdminCobranca();
$banco = new AdminCobranca();
$userLogin = $_SESSION['userloginPainel'];
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($ClienteData && $ClienteData['SendFilterForm']):
    unset($ClienteData['SendFilterForm']);
    $dataInicio = $ClienteData['dataInicio'];
    $dataInicio = date("Y-m-d", strtotime(str_replace('/', '-', $dataInicio)));
    $dataFim = $ClienteData['dataFim'];
    $dataFim = date("Y-m-d", strtotime(str_replace('/', '-', $dataFim)));

    echo "<script type='text/javascript'>
            window.open( '../report/reports/cobrancasPagamento.php?userid={$ClienteData['id_condominio']}&dataInicio={$dataInicio}&dataFim={$dataFim}' )
        </script>";
endif;

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
                <!--                <a href="painel.php?exe=<?/*= $modulo; */?>/create&id=<?/*= $idcond; */?>" title="Cadastrar Novo <?/*= $title; */?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar <?/*= $title; */?></a>
-->                <a href="https://boleto-assertbh.mybluemix.net/gerar/remessa/<?= $idcond; ?>" target="_blank" title="Gerar Arquivo de Envio <?= $title; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Gerar Arquivo de Envio</a>
                <a href="painel.php?exe=boletos/index" title="Retornar para Condomínios" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Condomínios</a>
            </div>
        </div>
        <div class="box-body">

            <div class="box box-info" style="margin-bottom: 30px;">
                <div class="box-header with-border">
                    <h3 class="box-title">Período: </h3>
                    <div class="box-tools pull-left">
                        <form action = "" method = "post" name = "filtroForm" enctype="multipart/form-data">
                            <input type="hidden" name="id_condominio" value="<?= $idcond ?>">
                            <div class="row form-inline">
                                    <? 
                                    $date30 = date("d/m/Y", strtotime(date('Y-m-d') . ' -30 days'));
                                    ?>

                                    <label>Início:</label>
                                    <input class="form-control mask-date"
                                           type = "text"
                                           name = "dataInicio"
                                           value="<?= $date30 ?>"
                                           title = "Informe a Data de Início do Filtro ?>">

                                    <label>Fim:</label>
                                    <input class="form-control mask-date"
                                           type = "text"
                                           name = "dataFim"
                                           value="<?= date("d/m/Y");?>"
                                           title = "Informe a Data de Início do Filtro ?>">
                                <span class="icon-input-btn"><span class="fa fa-print"></span><input type="submit" name="SendFilterForm" value="Gerar Relatório de Boletos Pagos" class="btn btn-primary" /></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="dataTable_wrapper" style="margin-top: 10px;">
                <table class="table table-striped table-hover" id="cobrancastable">
                    <thead>
                    <tr>
                        <th>Lançamento</th>
                        <th>Proprietário</th>
                        <th>Condomínio</th>
                        <th>Unidade</th>
                        <th>Vencimento</th>
                        <th>Valor</th>
                        <th>Valor Atualizado</th>
                        <th>Pagamento</th>
                        <th>Valor Pago</th>
                        <th>Remessa</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    $read = new Read;
                    $read->ExeRead($modulo, "WHERE id_condominio = {$idcond} AND baixa = 0");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            $link = '#';
                            if ($userLogin['email'] != 'admin@assertbh.com.br'):
                                $link = 'painel.php?exe='.$modulo.'/update&id1='.$id.'&id2='.$idcond;
                            endif;
                            ?>
                            <tr>
                                <td><a href="<?= $link; ?>"><?= date('d/m/Y', strtotime($data)); ?></td>
                                <td><a href="<?= $link; ?>"><?= $Proprietario->getProprietario($id_proprietario)?></td>
                                <td><a href="<?= $link; ?>"><?= $Condominio->getCondominio($id_condominio)?></td>
                                <td><a href="<?= $link; ?>"><?= $Unidade->getUnidade($id_unidade)?></td>
                                <td><a href="<?= $link; ?>"><?= date('d/m/Y', strtotime($vencimento)); ?></td>
                                <td><a href="<?= $link; ?>"><?= $valorOriginal ?></td>
                                <td><a href="<?= $link; ?>"><?= $valorTotal ?></td>
                                <td><a href="<?= $link; ?>"><?= (!empty($pagamento))?date('d/m/Y', strtotime($pagamento)): ''; ?></td>
                                <td><a href="<?= $link; ?>"><?= $valor_pago ?></td>
                                <td>
                                    <? if(!empty($id_remessa)) { ?>
                                        <a class="btn btn-xs btn-info" href="https://boleto-assertbh.mybluemix.net/remessa/<?= $id_remessa; ?>" title="Baixar Remessa" target="_blank"><i class="glyphicon glyphicon-floppy-save" ></i> Remessa</a>
                                        <? } ?>
                                    <? if(empty($id_remessa)) { ?>
                                       Não gerada
                                        <? } ?>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-success" href="https://boleto-assertbh.mybluemix.net/gerar/boleto/<?= $id; ?>" title="Visualizar Boleto" target="_blank"><i class="glyphicon glyphicon-file" ></i> Boleto</a>
                                    <!--                                    <a class="btn btn-xs btn-primary" href="painel.php?exe=<?/*= $modulo; */?>/update&id1=<?/*= $id; */?>&id2=<?/*= $idcond; */?>" title="Editar"><i class="glyphicon glyphicon-edit" ></i></a>
                                    <a id="delete_btn" class="btn btn-xs btn-danger" data-id="<?/*= $id; */?>" data-tabela="<?/*= $modulo; */?>" data-pasta="<?/*= $modulo; */?>"  title="Deletar"><i class="glyphicon glyphicon-trash"></i></a>
-->                                </td>
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
