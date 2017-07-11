<section class="content-header">
    <h1>
        Dashboard
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a><li class="active">Dashboard</li></li>

    </ol>
</section>
<?php

$prop = new Read;
$prop->ExeRead('proprietarios','WHERE id = :condo',"condo={$_SESSION['userlogin']['id']}");

extract($prop->getResult());
foreach ($prop->getResult() as $user):
    extract($user);
    if ($alterar == 0):
        $texto = '<h3>Sr. Condômino,</h3>';
        $texto .= '<p>Para nos comunicarmos com maior eficiência e assim podermos fazer uma administração transparente e de qualidade, solicitamos, por gentileza, que preencha os dados em branco do seu cadastro e salve as informações.</p>';
        $texto .= '<p>A seguir, entre na opção “MINHAS PROPRIEDADES”, preencha os dados em branco e salve as informações.</p>';
        $texto .= '<p>Em caso de dúvidas, entre em contato com a administradora.</p>';
        $texto .= '<p>Atenciosamente, ASSERTBH Gestão de Condomínios”</p>';


        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal({  title: \'Informação\',
                    text: \''.$texto.'\',  
                       
                    html: true,
                    showCancelButton: false,   
                    closeOnConfirm: true,   
                    confirmButtonText: \'OK\', 
                    showLoaderOnConfirm: true, }, 
                    function(){   
                        setTimeout(function(){     
                            location = \'painel.php?exe=proprietarios/update&userid='.$id.'\';  
                        });
                        });';
        echo '}, 10);</script>';
    endif;
endforeach;
?>


<section class="content">
    <div class="row">

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        Cadastro
                    </h3>
                    <p>Dados Cadastrais</p>
                </div>
                <div class="icon">
                    <i class="fa fa-id-card"></i>
                </div>
                <a href="painel.php?exe=proprietarios/update&userid=<?=$id?>" class="small-box-footer">Dados Cadastrais <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <?php
        $condominio = new Read;
        $condominio->ExeRead('proprietarios','WHERE id = :condo','condo={$id}');

        extract($condominio->getResult());
        ?>
    </div>

    <div class="row">

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php
                        $condominio = new Read;
                        $condominio->FullRead('SELECT * FROM unidades WHERE id_proprietario = '.$id);
                        echo $condominio->getRowCount();
                        ?>
                    </h3>
                    <p>Minhas Propriedades</p>
                </div>
                <div class="icon">
                    <i class="fa fa-id-card"></i>
                </div>
                <a href="painel.php?exe=unidades/index&userid=<?=$id?>" class="small-box-footer">Acesso Propriedades <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</section>
