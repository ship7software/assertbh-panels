<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$idunidade = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modulo = 'cobranca';
$title = 'Cobrança';
if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);

    require('_app/Models/AdminCobranca.class.php');
    $cadastra = new AdminCobranca();
    $cadastra->ExeCreate($ClienteData);

    if ($cadastra->getResult()):
        header("Location: painel.php?exe={$modulo}/update&create=true&id={$cadastra->getResult()}");
    else:
        DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    endif;
endif;

$mes_ref = $ClienteData['mes_ref'];

if(!$mes_ref):
    switch (date("m")) {
        case "01":    $mes_ref = "Janeiro";     break;
        case "02":    $mes_ref = "Fevereiro";   break;
        case "03":    $mes_ref = "Março";       break;
        case "04":    $mes_ref = "Abril";       break;
        case "05":    $mes_ref = "Maio";        break;
        case "06":    $mes_ref = "Junho";       break;
        case "07":    $mes_ref = "Julho";       break;
        case "08":    $mes_ref = "Agosto";      break;
        case "09":    $mes_ref = "Setembro";    break;
        case "10":    $mes_ref = "Outubro";     break;
        case "11":    $mes_ref = "Novembro";    break;
        case "12":    $mes_ref = "Dezembro";    break; 
    }
endif;

$readUnidade = new Read;
$readUnidade->ExeRead("unidades", "WHERE id = :user", "user={$idunidade}");
$readUnidade->getResult();

$readCondominio = new Read;
$readCondominio->ExeRead("condominios", "WHERE id = :user", "user={$readUnidade->getResult()[0]['id_condominio']}");
$readCondominio->getResult();

$diaVencimento = $readCondominio->getResult()[0]['vencimento'];
if(!$diaVencimento):
    $diaVencimento = date("d");
endif;

$vencimentoDefault = date("Y")."-".date("m")."-".str_pad($diaVencimento, 2, "0", STR_PAD_LEFT);

$vencimento = new DateTime();
$condominio = new AdminCobranca();
$proprietario = new AdminCobranca();
$banco = new AdminCobranca();


?>

<section class="content-header">
    <h1>
        <?= $title; ?>s
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="painel.php?exe=<?= $modulo; ?>/index"><?= $title; ?></a></li>
        <li class="active">Cadastro</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de <?= $title; ?></h3>
            <h4>Condomínio: <?= $condominio->getCondominio($readUnidade->getResult()[0]['id_condominio']); ?> - Unidade: Bloco: <?= $readUnidade->getResult()[0]['bloco']; ?> -
                Apto/Sala: <?= $readUnidade->getResult()[0]['apto_sala']; ?> - Proprietário: <?= $proprietario->getProprietario($readUnidade->getResult()[0]['id_proprietario']); ?></h4>

        </div>
        <div class="box-body">
            <script>
                function atualizarDataVencimento() {
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

                    var mes = meses[$("#mes_ref").val()]

                    console.log({
                        mes, dia, concat: new Date().getFullYear() + mes + dia
                    });

                    var vencimento = moment(new Date().getFullYear() + mes + "01", "YYYYMMDD");
                    var now = moment();
                    var isPast = vencimento.isBefore(now.startOf('month'));
                    vencimento.add(dia, 'd').add(-1, 'd')
                    if (isPast) {
                        vencimento.add(1, 'y');
                    }

                    $("#vencimento").val(vencimento.format('YYYY-MM-DD'));
                }
            </script>
            <input type="hidden" id="vencimentoPadrao" value="<?= $readCondominio->getResult()[0]['vencimento'] ?>">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">
                <input type = "text" hidden name = "id_condominio" value="<?= $readUnidade->getResult()[0]['id_condominio']; ?>">
                <input type = "text" hidden name = "id_proprietario" value="<?= $readUnidade->getResult()[0]['id_proprietario']; ?>">
                <input type = "text" hidden name = "id_unidade" value="<?= $idunidade ?>">

                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Mês de Referência</label>
                        <select onchange="atualizarDataVencimento()" class="form-control" name="mes_ref" id="mes_ref" required>
                            <option disabled="disabled" <?php if (empty($mes_ref)) echo 'selected="selected"';?>>Selecione o Mês</option>
                            <option value="Janeiro" <?php if ($mes_ref == 'Janeiro') echo 'selected="selected"';?>>Janeiro</option>
                            <option value="Fevereiro" <?php if ($mes_ref == 'Fevereiro') echo 'selected="selected"';?>>Fevereiro</option>
                            <option value="Março" <?php if ($mes_ref == 'Março') echo 'selected="selected"';?>>Março</option>
                            <option value="Abril" <?php if ($mes_ref == 'Abril') echo 'selected="selected"';?>>Abril</option>
                            <option value="Maio" <?php if ($mes_ref == 'Maio') echo 'selected="selected"';?>>Maio</option>
                            <option value="Junho" <?php if ($mes_ref == 'Junho') echo 'selected="selected"';?>>Junho</option>
                            <option value="Julho" <?php if ($mes_ref == 'Julho') echo 'selected="selected"';?>>Julho</option>
                            <option value="Agosto" <?php if ($mes_ref == 'Agosto') echo 'selected="selected"';?>>Agosto</option>
                            <option value="Setembro" <?php if ($mes_ref == 'Setembro') echo 'selected="selected"';?>>Setembro</option>
                            <option value="Outubro" <?php if ($mes_ref == 'Outubro') echo 'selected="selected"';?>>Outubro</option>
                            <option value="Novembro" <?php if ($mes_ref == 'Novembro') echo 'selected="selected"';?>>Novembro</option>
                            <option value="Dezembro" <?php if ($mes_ref == 'Dezembro') echo 'selected="selected"';?>>Dezembro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Data de Lançamento:</label>
                        <input class="form-control"
                               type = "date"
                               name = "data"
                               value="<?= date("Y-m-d");?>"
                               title = "Informe a Data de Lançamento da <?= $title; ?>"
                               required
                               placeholder="Data de Lançamento da <?= $title; ?>" >
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Data de Vencimento:</label>
                        <input class="form-control"
                               type = "date"
                               name = "vencimento"
                               id="vencimento"
                               value="<?=$vencimentoDefault?>"
                               title = "Informe a Data de Vencimento da <?= $title; ?>"
                               required
                               placeholder="Data de Vencimento da <?= $title; ?>" >
                    </div>
                    <div class="col-md-3">
                        <label>Valor: R$</label>
                        <input class="form-control mask-money2"
                               type = "text"
                               name = "valor"
                               value="0,00"
                               title = "Informe o Valor da <?= $title; ?>"
                               required
                               placeholder="Valor da <?= $title; ?>" >
                    </div>
                    <input type = "number" hidden
                           name = "baixa"
                           value=0
                           required >
                </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Salvar" class="btn btn-primary" /></span>
                <a href="painel.php?exe=<?= $modulo; ?>/index&id=<?= $idunidade; ?>" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
