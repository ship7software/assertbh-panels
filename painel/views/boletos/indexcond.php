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
                    <h3 class="box-title">Filtrar por Período: </h3>
                    <div class="box-tools pull-left">
                        <form action = "" method = "post" name = "filtroForm" enctype="multipart/form-data">
                            <div class="row form-inline">

                                    <label>Início:</label>
                                    <input class="form-control mask-date"
                                           type = "text"
                                           name = "data"
                                           value="<?= date("d/m/Y");?>"
                                           title = "Informe a Data de Início do Filtro ?>">

                                    <label>Fim:</label>
                                    <input class="form-control mask-date"
                                           type = "text"
                                           name = "data"
                                           value="<?= date("d/m/Y");?>"
                                           title = "Informe a Data de Início do Filtro ?>">
                                <span class="icon-input-btn"><span class="fa fa-filter"></span><input type="submit" name="SendFilterForm" value="Filtrar" class="btn btn-primary" /></span>
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
                        <th>Pagamento</th>
                        <th>Valor Pago</th>
                        <th>Remessa</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    $read = new Read;
                    $read->ExeRead($modulo, "WHERE id_condominio = {$idcond}");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= date('d/m/Y', strtotime($data)); ?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= $Proprietario->getProprietario($id_proprietario)?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= $Condominio->getCondominio($id_condominio)?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= $Unidade->getUnidade($id_unidade)?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= date('d/m/Y', strtotime($vencimento)); ?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= $valor ?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= (!empty($pagamento))?date('d/m/Y', strtotime($pagamento)): ''; ?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= $valor_pago ?></td>
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
