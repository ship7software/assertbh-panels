<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$idunidade = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modulo = 'cobranca';
$title = 'Cobrança';
if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);
    $ClienteData['data'] = date('Y-m-d', strtotime(str_replace('/', '-', $ClienteData['data'])));
    $ClienteData['vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $ClienteData['vencimento'])));

    require('_app/Models/AdminCobranca.class.php');
    $cadastra = new AdminCobranca();
    $cadastra->ExeCreate($ClienteData);

    if ($cadastra->getResult()):
        $curl = curl_init('http://assertbh-com-br.umbler.net/atualizarDataVencimento');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        header("Location: painel.php?exe={$modulo}/index&create=true&id={$idunidade}");
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

    $mes_ref = $mes_ref."/".date("Y");
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

$vencimentoDefault = str_pad($diaVencimento, 2, "0", STR_PAD_LEFT)."/".date("m")."/".date("Y");

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
                <input type = "text" hidden name = "id_condominio" value="<?= $readUnidade->getResult()[0]['id_condominio']; ?>">
                <input type = "text" hidden name = "id_proprietario" value="<?= $readUnidade->getResult()[0]['id_proprietario']; ?>">
                <input type = "text" hidden name = "id_unidade" value="<?= $idunidade ?>">

                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Mês de Referência</label>
                        <input class="form-control mask-monthdate"
                               type = "text"
                               oninput="atualizarDataVencimento"
                               name="mes_ref" id="mes_ref" required 
                               value="<?php if (!empty($mes_ref)) echo $mes_ref; ?>"
                               title = "Informe o Mês de Referência"
                               placeholder="Mês de Referência">
                    </div>
                    <div class="col-md-3">
                        <label>Data de Lançamento:</label>
                        <input class="form-control mask-date"
                               type = "text"
                               name = "data"
                               value="<?= date("d/m/Y");?>"
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
