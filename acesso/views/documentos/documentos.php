<?php
$tipodoc = filter_input(INPUT_GET, 'tipo');
$unidadeid = filter_input(INPUT_GET, 'unidadeid', FILTER_VALIDATE_INT);

$unidade = new Read;
$unidade->ExeRead('unidades','WHERE id = :unidade','unidade='.$unidadeid);

$modulo = 'documentos';
$title = 'Documento';

$Condominio = new AdminDocumento();
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
            <h3 class="box-title">Lista de <?= $title; ?>s do Condomínio <?=$Condominio->getCondominio($unidade->getResult()[0]['id_condominio'])?></h3>

            <h4>Unidade: Bloco: <?= $unidade->getResult()[0]['bloco']; ?> / Unidade: <?= $unidade->getResult()[0]['apto_sala']; ?></h4>
            <div class="box-tools pull-right">
                <a href="painel.php?exe=documentos/index&unidadeid=<?= $unidadeid; ?>" title="Retornar para Pastas" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Pastas</a>
             </div>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover display responsive nowrap" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Pasta Documentos</th>
                        <th>Arquivo</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $read = new Read;
                    $read->FullRead('SELECT * FROM documentos WHERE id_condominio = '.$unidade->getResult()[0]['id_condominio'].' AND tipo_doc = "'.$tipodoc.'" ORDER BY data DESC');
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><a href="#"><?= date('d/m/Y', strtotime($data)); ?></a></td>
                                <td><?= $descricao?></td>
                                <td><?php if ($tipo_doc == 'docgerais'): echo "Documentos Gerais";
                                    elseif ($tipo_doc == 'comuinfo'): echo "Comunicados e Informações";
                                    elseif ($tipo_doc == 'gestao'): echo "Gestão";
                                    elseif ($tipo_doc == 'contabil'): echo "Contabilidade";
                                    endif;
                                    ?></td>
                                <td><a href="../painel/download.php?file=<?= 'documentos/'.$tipo_doc.'/'.$unidade->getResult()[0]['id_condominio'].'/'.$arquivo ?>" target="_blank"><?= $arquivo ?></a></td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="../painel/download.php?file=<?= 'documentos/'.$tipo_doc.'/'.$unidade->getResult()[0]['id_condominio'].'/'.$arquivo ?>" target="_blank" title="Download"><i class="glyphicon glyphicon-download-alt" ></i></a>
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
