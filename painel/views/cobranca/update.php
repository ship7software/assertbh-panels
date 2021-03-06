<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$idboleto = filter_input(INPUT_GET, 'id1', FILTER_VALIDATE_INT);
$modulo = 'cobranca';
$title = 'Cobrança';

if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);
    $ClienteData['data'] = date('Y-m-d', strtotime(str_replace('/', '-', $ClienteData['data'])));
    $ClienteData['vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $ClienteData['vencimento'])));
    require('_app/Models/AdminCobranca.class.php');
    $cadastra = new AdminCobranca();
    $cadastra->ExeUpdate($idboleto, $ClienteData);
    DSErro($cadastra->getError()[0], $cadastra->getError()[1]);

    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-arrow-left';
else:
    $ReadUser = new Read;
    $ReadUser->ExeRead($modulo, "WHERE id = :userid", "userid={$idboleto}");
    if ($ReadUser->getResult()):
        $ClienteData = $ReadUser->getResult()[0];
    endif;
    $botaoCR = 'Cancelar';
    $botaoClass = 'fa fa-ban';
endif;

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
if ($checkCreate && empty($cadastra)):
    DSErro("A ".$title." foi cadastrado com sucesso no sistema!", DS_ACCEPT);
    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-ban';
endif;

$readUnidade = new Read;
$readUnidade->ExeRead("unidades", "WHERE id = :user", "user={$ClienteData['id_unidade']}");
$readUnidade->getResult();

$readCondominio = new Read;
$readCondominio->ExeRead("condominios", "WHERE id = :user", "user={$readUnidade->getResult()[0]['id_condominio']}");
$readCondominio->getResult();

$condominio = new AdminCobranca();
$proprietario = new AdminCobranca();
$banco = new AdminCobranca();

?>

<section class="content-header">
    <h1>
        <?=$title?>s
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="painel.php?exe=<?=$modulo?>/index"><?=$title?></a></li>
        <li class="active">Atualização</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Atualização de <?=$title?></h3>
            <h4>Condomínio: <?= $condominio->getCondominio($readUnidade->getResult()[0]['id_condominio']); ?> - Unidade: Bloco: <?= $readUnidade->getResult()[0]['bloco']; ?> -
                Unidade: <?= $readUnidade->getResult()[0]['apto_sala']; ?> - Proprietário: <?= $proprietario->getProprietario($readUnidade->getResult()[0]['id_proprietario']); ?></h4>

        </div>
        <div class="box-body">
            <script>
                $(document).ready(function() {
                    $("#mes_ref").on('change', function(evt){
                        var parts = evt.target.value.split('/');
                        var mes = parts[0];
                        var ano = new Date().getFullYear().toString();
                        if (parts.length > 1) {
                            ano = parts[1];
                        }

                        atualizarDataVencimento(mes, ano);
                    });
                });
                function atualizarDataVencimento(pMes, pAno) {
                    var dia = $("#vencimentoPadrao").val();
                    var meses = {};
                    meses['Janeiro'] = '01';
                    meses['Fevereiro'] = '02';
                    meses['Março'] = '03';
                    meses['Abril'] = '04';
                    meses['Maio'] = '05';
                    meses['Junho'] = '06';
                    meses['Julho'] = '07';
                    meses['Agosto'] = '08';
                    meses['Setembro'] = '09';
                    meses['Outubro'] = '10';
                    meses['Novembro'] = '11';
                    meses['Dezembro'] = '12';

                    var mes = meses[pMes]

                    var vencimento = moment(pAno + mes + "01", "YYYYMMDD");
                    var now = moment();
                    var isPast = vencimento.isBefore(now.startOf('month'));
                    vencimento.add(dia, 'd').add(-1, 'd')

                    $("#vencimento").val(vencimento.format('DD/MM/YYYY'));
                }
            </script>
            <input type="hidden" id="vencimentoPadrao" value="<?= $readCondominio->getResult()[0]['vencimento'] ?>">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">

                <input type = "text" hidden name = "id_condominio" value="<?php if (!empty($ClienteData['id_condominio'])) echo $ClienteData['id_condominio']; ?>">
                <input type = "text" hidden name = "id_proprietario" value="<?php if (!empty($ClienteData['id_proprietario'])) echo $ClienteData['id_proprietario']; ?>">
                <input type = "text" hidden name = "id_unidade" value="<?php if (!empty($ClienteData['id_unidade'])) echo $ClienteData['id_unidade']; ?>">

                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Mês de Referência</label>
                        <input class="form-control mask-monthdate"
                               type = "text"
                               oninput="atualizarDataVencimento"
                               name="mes_ref" id="mes_ref" required 
                               value="<?php if (!empty($ClienteData['mes_ref'])) echo $ClienteData['mes_ref']; ?>"
                               title = "Informe o Mês de Referência"
                               placeholder="Mês de Referência">
                    </div>
                    <div class="col-md-3">
                        <label>Data de Lançamento:</label>
                        <input class="form-control mask-date"
                               type = "text"
                               name = "data"
                               value="<?php if (!empty($ClienteData['data'])) echo $ClienteData['data']; ?>"
                               title = "Informe a Data de Lançamento da <?= $title; ?>"
                               required
                               placeholder="Data de Lançamento da <?= $title; ?>" >
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Data de Vencimento:</label>
                        <input class="form-control mask-date"
                               type = "text"
                               name = "vencimento"
                               id = "vencimento"
                               value="<?php if (!empty($ClienteData['vencimento'])) echo $ClienteData['vencimento']; ?>"
                               title = "Informe a Data de Vencimento da <?= $title; ?>"
                               required
                               placeholder="Data de Vencimento da <?= $title; ?>" >
                    </div>
                    <div class="col-md-3">
                        <label>Valor: R$</label>
                        <input class="form-control mask-money2"
                               type = "text"
                               name = "valor"
                               value="<?php if (!empty($ClienteData['valor'])) echo number_format($ClienteData['valor'], 2, ',', ''); else echo '0,00'?>"
                               title = "Informe o Valor da <?= $title; ?>"
                               required
                               placeholder="Valor da <?= $title; ?>" >
                    </div>
                </div>

                <input type = "number" hidden
                       name = "baixa"
                       value=<?php if (!empty($ClienteData['baixa'])) echo $ClienteData['baixa']; else echo 0; ?>
                       required >

        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Atualizar" class="btn btn-primary" /></span>
                <a href="painel.php?exe=<?=$modulo?>/index&id=<?=$ClienteData['id_unidade']?>" class="btn btn-danger"><i class="<?=$botaoClass ?>"></i> <?=$botaoCR ?></a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->