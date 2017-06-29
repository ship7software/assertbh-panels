<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
$userid = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
$modulo = 'unidades';
$title = 'Unidade';
if ($delete):
    require('_app/Models/AdminUnidade.class.php');
    $delUser = new AdminUnidade();
    $delUser->ExeDelete($delete);
    DSErro($delUser->getError()[0], $delUser->getError()[1]);
endif;

$prop = new Read;
$prop->ExeRead('proprietarios','WHERE id = :condo',"condo={$userid}");

if ($prop->getResult()[0]['alterar'] == 0):
    $texto = '<h3>Sr. Condômino,</h3>';
    $texto .= '<p>Para nos comunicarmos com maior eficiência e assim podermos fazer uma administração transparente e de qualidade, solicitamos, por gentileza, que preencha os dados em branco do seu cadastro e salve as informações.</p>';
    $texto .= '<p>A seguir, entre na opção “MINHAS PROPRIEDADES”, preencha os dados em branco e salve as informações.</p>';
    $texto .= '<p>Em caso de dúvidas, entre em contato com a administradora.</p>';
    $texto .= '<p>Atenciosamente, ASSERTBH Gestão de Condomínios”</p>';

    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal({  title: \'Informação\',
                text: \''.$texto.'\',  
                type: \'success\',
                    html: true,
                showCancelButton: false,   
                closeOnConfirm: true,   
                confirmButtonText: \'OK\', 
                showLoaderOnConfirm: true, }, 
                function(){   
                    setTimeout(function(){     
                        location = \'painel.php?exe=proprietarios/update&userid='.$userid.'\';  
                    });
                     });';
    echo '}, 10);</script>';
    return 0;
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
            </div>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover display responsive nowrap" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Condomínio</th>
                        <th>Unidade</th>
                        <th>Emergencia</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $Proprietario = new AdminUnidade();
                    $Condominio = new AdminUnidade();
                    $read = new Read;
                    $read->ExeRead($modulo, "WHERE id_proprietario = {$userid} ORDER BY id_proprietario ASC");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            if ($alterar == 0):
                                echo '<script type="text/javascript">';
                                echo 'setTimeout(function () { swal({  title: \'Informação\',
                                    text: \'Você precisa preencher todo o cadastro da propriedade: Condominio:'.$Condominio->getCondominio($id_condominio).' Bloco:'.$bloco.' Apto/Sala:'.$apto_sala.'\',  
                                    type: \'success\',    
                                    showCancelButton: false,   
                                    closeOnConfirm: true,   
                                    confirmButtonText: \'OK\', 
                                    showLoaderOnConfirm: true, }, 
                                    function(){   
                                        setTimeout(function(){     
                                            location = \'painel.php?exe=unidades/update&userid='.$id.'&idprop='.$userid.'&idcond='.$id_condominio.'\';  
                                        });
                                         });';
                                echo '}, 10);</script>';
                            endif;
                            ?>
                            <tr>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>&idprop=<?= $userid; ?>&idcond="<?= $id_condominio; ?>><?= $Condominio->getCondominio($id_condominio)?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>&idprop=<?= $userid; ?>&idcond="<?= $id_condominio; ?>>Bloco:<?=$bloco?> - Apto/Sala:<?=$apto_sala?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>&idprop=<?= $userid; ?>&idcond="<?= $id_condominio; ?>><?= $contato_emergencia ?></td>
                                <td>
                                    <a class="btn btn-xs btn-success" href="painel.php?exe=documentos/index&unidadeid=<?= $id; ?>" title="Documentos"><i class="glyphicon glyphicon-file" ></i> Acesso Documentos</a>
                                    <a class="btn btn-xs btn-success" href="painel.php?exe=boletos/index&id=<?= $id; ?>" title="Boletos"><i class="glyphicon glyphicon-usd" ></i> Boletos</a>
                                    <a class="btn btn-xs btn-primary" href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>&idprop=<?= $userid; ?>&idcond="<?= $id_condominio; ?> title="Vizualizar"><i class="glyphicon glyphicon-edit" ></i></a>
                                </td>
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
