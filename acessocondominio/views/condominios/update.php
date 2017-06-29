<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$userId = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
$modulo = 'condominios';
$title = 'Condomínio';

if ($ClienteData && $ClienteData['SendPostForm']):
    $ClienteData['imagem'] = ( $_FILES['imagem']['tmp_name'] ? $_FILES['imagem'] : 'null' );
    $ClienteData['juros_naoaplicar'] = (isset($ClienteData['juros_naoaplicar']) ? true : null);
    $ClienteData['multa_naoaplicar'] = (isset($ClienteData['multa_naoaplicar']) ? true : null);

    unset($ClienteData['SendPostForm']);

    require('_app/Models/AdminCondominio.class.php');
    $cadastra = new AdminCondominio();
    $cadastra->ExeUpdate($userId, $ClienteData);
    DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-arrow-left';
    $imagem = $cadastra->getImagem($userId);
else:
    $ReadUser = new Read;
    $ReadUser->ExeRead($modulo, "WHERE id = :userid", "userid={$userId}");
    if ($ReadUser->getResult()):
        $ClienteData = $ReadUser->getResult()[0];
        unset($ClienteData['senha']);
        $imagem = $ClienteData['imagem'];
    endif;
    $botaoCR = 'Cancelar';
    $botaoClass = 'fa fa-ban';
endif;

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
if ($checkCreate && empty($cadastra)):
    DSErro("O ".$title." foi cadastrado com sucesso no sistema!", DS_ACCEPT);
    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-ban';
endif;
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
        </div>
        <div class="box-body">
            <script>
                var especiesTitulo = {};
                <?php
                $especies = new Read;
                $especies->ExeRead('especies_titulo', "ORDER BY codigo_banco, descricao");
                $codigoBancoAtual = null;
                if ($especies->getResult()):
                    foreach ($especies->getResult() as $dados):
                        extract($dados);
                        if(!$codigoBancoAtual || $codigoBancoAtual !== $codigo_banco):
                            $codigoBancoAtual = $codigo_banco;
                        ?>
                            especiesTitulo['<?=$codigo_banco?>'] = [];
                        <?php
                        endif;
                            ?>
                                especiesTitulo['<?=$codigo_banco?>'].push({ id: '<?=$id?>', descricao: '<?=$descricao?>' });          
                            <?php
                    endforeach;
                endif;
                ?>

                function atualizarComboEspecies() {
                    var codigoBanco = $("#codigo_banco").val();
                    var htmlOptions = '<option disabled="disabled" selected="selected"> Selecione a Espécie</option>';

                    console.log(codigoBanco);

                    if(especiesTitulo[codigoBanco] && especiesTitulo[codigoBanco].length > 0) {
                        for (var index = 0; index < especiesTitulo[codigoBanco].length; index++) {
                            var especie = especiesTitulo[codigoBanco][index];
                            htmlOptions += ('<option value="' + especie.id + '">' + especie.descricao + '</option>');   
                        }
                    }

                    $("#especie_titulo").html(htmlOptions);
                }
            </script>
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">

                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class="active"><a href="#imovel" data-toggle="tab">Dados do Condomínio</a></li>
                    <li><a href="#corpodiretivo" data-toggle="tab">Corpo Diretivo</a></li>
                    <li><a href="#financeiro" data-toggle="tab">Financeiro</a></li>
                    <li><a href="#contabil" data-toggle="tab">Contábil</a></li>
                    <li><a href="#banco" data-toggle="tab">Banco</a></li>
                    <li><a href="#obs" data-toggle="tab">Observações</a></li>
                </ul>

                <div id="my-tab-content" class="tab-content">

                    <div class="tab-pane active" id="imovel" style="margin-top: 20px;">

                        <div class="row form-group">
                            <div class="col-md-2">
                                <a href="#" class="thumbnail" onclick="document.getElementById('upload').click(); return false"><?= Check::Image('../uploads/'.$modulo.'/'. $imagem); ?></a>
                            </div>
                            <div class="col-md-3">
                                <label>Selecione Nova Imagem</label>
                                <input class="form-control"
                                       id="upload"
                                       type = "file"
                                       name = "imagem" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Nome</label>
                                <input class="form-control"
                                       type = "text"
                                       value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>"
                                       title = "Informe o Nome do <?= $title; ?>"
                                       required
                                       placeholder="Nome do <?= $title; ?>" disabled="disabled">
                            </div>
                            <input type = "text" hidden="hidden"
                                   name = "nome"
                                   value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>">
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5">
                                <label>E-mail</label>
                                <input class="form-control"
                                       type = "text"
                                       value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>"
                                       title = "Informe o E-mail do <?= $title; ?>"
                                       required
                                       placeholder="E-mail do <?= $title; ?>" disabled="disabled">
                            </div>
                            <input type = "text" hidden="hidden"
                                   name = "email"
                                   value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>">
                        </div>
                        <div class="row form-group">
                            <div class="col-md-5">
                                <label>CNPJ</label>
                                <input class="form-control mask-cpfCnpj"
                                       type = "text"
                                       name = "cnpj"
                                       value="<?php if (!empty($ClienteData['cnpj'])) echo $ClienteData['cnpj']; ?>"
                                       title = "Informe o CNPJ do <?= $title; ?>"
                                       placeholder="CNPJ do <?= $title; ?>" disabled="disabled">

                                <input type = "text" hidden="hidden"
                                       name = "cnpj"
                                       value="<?php if (!empty($ClienteData['cnpj'])) echo $ClienteData['cnpj']; ?>">
                            </div>
                            <div class="col-md-3">
                                <label>Número de Unidades</label>
                                <input class="form-control"
                                       type = "number"
                                       name = "numero_unidades"
                                       value="<?php if (!empty($ClienteData['numero_unidades'])) echo $ClienteData['numero_unidades']; ?>"
                                       title = "Informe o Número de Unidades do <?= $title; ?>"
                                       placeholder="Número de Unidades do <?= $title; ?>" disabled="disabled">
                                <input type = "text" hidden="hidden"
                                       name = "numero_unidades"
                                       value="<?php if (!empty($ClienteData['numero_unidades'])) echo $ClienteData['numero_unidades']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5">
                                <label>Telefone</label>
                                <input class="form-control mask-phone9"
                                       type = "text"
                                       name = "telefone"
                                       value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>"
                                       title = "Informe o Telefone do <?= $title; ?>"
                                       placeholder="Telefone do <?= $title; ?>" >
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Endereço</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "endereco"
                                       value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>"
                                       title = "Informe o Endereço do <?= $title; ?>"
                                       placeholder="Endereço do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-2">
                                <label>Número</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "numero"
                                       value="<?php if (!empty($ClienteData['numero'])) echo $ClienteData['numero']; ?>"
                                       title = "Informe o Número do Endereço do <?= $title; ?>"
                                       placeholder="Número" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Complemento</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "complemento"
                                       value="<?php if (!empty($ClienteData['complemento'])) echo $ClienteData['complemento']; ?>"
                                       title = "Informe o Complemento do <?= $title; ?>"
                                       placeholder="Complemento do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Bairro</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "bairro"
                                       value="<?php if (!empty($ClienteData['bairro'])) echo $ClienteData['bairro']; ?>"
                                       title = "Informe o Bairro do <?= $title; ?>"
                                       placeholder="Bairro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-4">
                                <label>Cidade</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "cidade"
                                       value="<?php if (!empty($ClienteData['cidade'])) echo $ClienteData['cidade']; ?>"
                                       title = "Informe a Cidade do <?= $title; ?>"
                                       placeholder="Cidade do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Estado</label>
                                <select class="form-control" name="estado" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    <option disabled="disabled" <?php if (empty($ClienteData['estado'])) echo 'selected="selected"';?>>Selecione o Estado</option>
                                    <option value="Acre" <?php if ($ClienteData['estado'] == 'Acre') echo 'selected="selected"';?>>Acre</option>
                                    <option value="Alagoas" <?php if ($ClienteData['estado'] == 'Alagoas') echo 'selected="selected"';?>>Alagoas</option>
                                    <option value="Amapá" <?php if ($ClienteData['estado'] == 'Amapá') echo 'selected="selected"';?>>Amapá</option>
                                    <option value="Amazonas" <?php if ($ClienteData['estado'] == 'Amazonas') echo 'selected="selected"';?>>Amazonas</option>
                                    <option value="Bahia" <?php if ($ClienteData['estado'] == 'Bahia') echo 'selected="selected"';?>>Bahia</option>
                                    <option value="Ceará" <?php if ($ClienteData['estado'] == 'Ceará') echo 'selected="selected"';?>>Ceará</option>
                                    <option value="Distrito Federal" <?php if ($ClienteData['estado'] == 'Distrito Federal') echo 'selected="selected"';?>>Distrito Federal</option>
                                    <option value="Espírito Santo" <?php if ($ClienteData['estado'] == 'Espírito Santo') echo 'selected="selected"';?>>Espírito Santo</option>
                                    <option value="Goiás" <?php if ($ClienteData['estado'] == 'Goiás') echo 'selected="selected"';?>>Goiás</option>
                                    <option value="Maranhão" <?php if ($ClienteData['estado'] == 'Maranhão') echo 'selected="selected"';?>>Maranhão</option>
                                    <option value="Mato Grosso" <?php if ($ClienteData['estado'] == 'Mato Grosso') echo 'selected="selected"';?>>Mato Grosso</option>
                                    <option value="Mato Grosso do Sul" <?php if ($ClienteData['estado'] == 'Mato Grosso do Sul') echo 'selected="selected"';?>>Mato Grosso do Sul</option>
                                    <option value="Minas Gerais" <?php if ($ClienteData['estado'] == 'Minas Gerais') echo 'selected="selected"';?>>Minas Gerais</option>
                                    <option value="Pará" <?php if ($ClienteData['estado'] == 'Pará') echo 'selected="selected"';?>>Pará</option>
                                    <option value="Paraíba" <?php if ($ClienteData['estado'] == 'Paraíba') echo 'selected="selected"';?>>Paraíba</option>
                                    <option value="Paraná" <?php if ($ClienteData['estado'] == 'Paraná') echo 'selected="selected"';?>>Paraná</option>
                                    <option value="Pernambuco" <?php if ($ClienteData['estado'] == 'Pernambuco') echo 'selected="selected"';?>>Pernambuco</option>
                                    <option value="Piauí" <?php if ($ClienteData['estado'] == 'Piauí') echo 'selected="selected"';?>>Piauí</option>
                                    <option value="Rio de Janeiro" <?php if ($ClienteData['estado'] == 'Rio de Janeiro') echo 'selected="selected"';?>>Rio de Janeiro</option>
                                    <option value="Rio Grande do Norte" <?php if ($ClienteData['estado'] == 'Rio Grande do Norte') echo 'selected="selected"';?>>Rio Grande do Norte</option>
                                    <option value="Rio Grande do Sul" <?php if ($ClienteData['estado'] == 'Rio Grande do Sul') echo 'selected="selected"';?>>Rio Grande do Sul</option>
                                    <option value="Rondônia" <?php if ($ClienteData['estado'] == 'Rondônia') echo 'selected="selected"';?>>Rondônia</option>
                                    <option value="Roraima" <?php if ($ClienteData['estado'] == 'Roraima') echo 'selected="selected"';?>>Roraima</option>
                                    <option value="São Paulo" <?php if ($ClienteData['estado'] == 'São Paulo') echo 'selected="selected"';?>>São Paulo</option>
                                    <option value="Sergipe" <?php if ($ClienteData['estado'] == 'Sergipe') echo 'selected="selected"';?>>Sergipe</option>
                                    <option value="Tocantins" <?php if ($ClienteData['estado'] == 'Tocantins') echo 'selected="selected"';?>>Tocantins</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>CEP</label>
                                <input class="form-control cep"
                                       type = "text"
                                       name = "cep"
                                       value="<?php if (!empty($ClienteData['cep'])) echo $ClienteData['cep']; ?>"
                                       title = "Informe o CEP do <?= $title; ?>"
                                       placeholder="CEP do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="corpodiretivo" style="margin-top: 20px;">

                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Nome do Síndico </label>
                                <input class="form-control"
                                       type = "text"
                                       name = "nome_sindico"
                                       value="<?php if (!empty($ClienteData['nome_sindico'])) echo $ClienteData['nome_sindico']; ?>"
                                       title = "Informe o Nome do Síndico do <?= $title; ?>"
                                       placeholder="Nome do Síndico do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Telefone do Síndico</label>
                                <input class="form-control mask-phone9"
                                       type = "tel"
                                       name = "telefone_sindico"
                                       value="<?php if (!empty($ClienteData['telefone_sindico'])) echo $ClienteData['telefone_sindico']; ?>"
                                       title = "Informe o Telefone do Síndico do <?= $title; ?>"
                                       placeholder="Telefone do Síndico do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-4">
                                <label>Unidade do Síndico</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "unidade_sindico"
                                       value="<?php if (!empty($ClienteData['unidade_sindico'])) echo $ClienteData['unidade_sindico']; ?>"
                                       title = "Informe a Unidade do Síndico do <?= $title; ?>"
                                       placeholder="Unidade do Síndico do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Nome do Subsíndico </label>
                                <input class="form-control"
                                       type = "text"
                                       name = "nome_subsindico"
                                       value="<?php if (!empty($ClienteData['nome_subsindico'])) echo $ClienteData['nome_subsindico']; ?>"
                                       title = "Informe o Nome do Subsíndico do <?= $title; ?>"
                                       placeholder="Nome do Subsíndico do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Telefone do Subsíndico</label>
                                <input class="form-control mask-phone9"
                                       type = "tel"
                                       name = "telefone_subsindico"
                                       value="<?php if (!empty($ClienteData['telefone_subsindico'])) echo $ClienteData['telefone_subsindico']; ?>"
                                       title = "Informe o Telefone do Subsíndico do <?= $title; ?>"
                                       placeholder="Telefone do Subsíndico do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-4">
                                <label>Unidade do Subsíndico</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "unidade_subsindico"
                                       value="<?php if (!empty($ClienteData['unidade_subsindico'])) echo $ClienteData['unidade_subsindico']; ?>"
                                       title = "Informe a Unidade do Subsíndico do <?= $title; ?>"
                                       placeholder="Unidade do Subsíndico do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>

                        <hr>
                        <h3>Conselho Consultivo</h3>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Nome do Conselheiro 1</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "conselho1"
                                       value="<?php if (!empty($ClienteData['conselho1'])) echo $ClienteData['conselho1']; ?>"
                                       title = "Informe o Nome Conselheiro do <?= $title; ?>"
                                       placeholder="Nome do Conselheiro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Telefone do Conselheiro 1</label>
                                <input class="form-control mask-phone9"
                                       type = "tel"
                                       name = "telefone_conselho1"
                                       value="<?php if (!empty($ClienteData['telefone_conselho1'])) echo $ClienteData['telefone_conselho1']; ?>"
                                       title = "Informe o Telefone do Conselheiro do <?= $title; ?>"
                                       placeholder="Telefone do Conselheiro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-4">
                                <label>Unidade do Conselheiro 1</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "unidade_conselho1"
                                       value="<?php if (!empty($ClienteData['unidade_conselho1'])) echo $ClienteData['unidade_conselho1']; ?>"
                                       title = "Informe a Unidade do Conselheiro do <?= $title; ?>"
                                       placeholder="Unidade do Conselheiro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Nome do Conselheiro 2</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "conselho2"
                                       value="<?php if (!empty($ClienteData['conselho2'])) echo $ClienteData['conselho2']; ?>"
                                       title = "Informe o Nome Conselheiro do <?= $title; ?>"
                                       placeholder="Nome do Conselheiro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Telefone do Conselheiro 2</label>
                                <input class="form-control mask-phone9"
                                       type = "tel"
                                       name = "telefone_conselho2"
                                       value="<?php if (!empty($ClienteData['telefone_conselho2'])) echo $ClienteData['telefone_conselho2']; ?>"
                                       title = "Informe o Telefone do Conselheiro do <?= $title; ?>"
                                       placeholder="Telefone do Conselheiro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-4">
                                <label>Unidade do Conselheiro 2</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "unidade_conselho2"
                                       value="<?php if (!empty($ClienteData['unidade_conselho2'])) echo $ClienteData['unidade_conselho2']; ?>"
                                       title = "Informe a Unidade do Conselheiro do <?= $title; ?>"
                                       placeholder="Unidade do Conselheiro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Nome do Conselheiro 3</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "conselho3"
                                       value="<?php if (!empty($ClienteData['conselho3'])) echo $ClienteData['conselho3']; ?>"
                                       title = "Informe o Nome Conselheiro do <?= $title; ?>"
                                       placeholder="Nome do Conselheiro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Telefone do Conselheiro 3</label>
                                <input class="form-control mask-phone9"
                                       type = "tel"
                                       name = "telefone_conselho3"
                                       value="<?php if (!empty($ClienteData['telefone_conselho3'])) echo $ClienteData['telefone_conselho3']; ?>"
                                       title = "Informe o Telefone do Conselheiro do <?= $title; ?>"
                                       placeholder="Telefone do Conselheiro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-4">
                                <label>Unidade do Conselheiro 3</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "unidade_conselho3"
                                       value="<?php if (!empty($ClienteData['unidade_conselho3'])) echo $ClienteData['unidade_conselho3']; ?>"
                                       title = "Informe a Unidade do Conselheiro do <?= $title; ?>"
                                       placeholder="Unidade do Conselheiro do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="financeiro" style="margin-top: 20px;">
                        <h3>Forma de Rateio Atual de Despesas:</h3>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <h4>Divisão por:</h4>
                                <label class="radio-inline"><input type="radio" name="rateio_divisao" value="1" <?=($ClienteData['rateio_divisao'] == 1 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Despesas Previstas</label>
                                <label class="radio-inline"><input type="radio" name="rateio_divisao" value="2" <?=($ClienteData['rateio_divisao'] == 2 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Despesas Efetivas</label>

                                <h4>Despesas Ordinárias:</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="radio-inline"><input type="radio" name="despesas_ordinarias" value="1" <?=($ClienteData['despesas_ordinarias'] == 1 ? 'checked="checked"' : '')?>
                                                <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Igualitário</label>
                                        <label class="radio-inline"><input type="radio" name="despesas_ordinarias" value="2" <?=($ClienteData['despesas_ordinarias'] == 2 ? 'checked="checked"' : '')?>
                                                <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Fração Ideal</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <label class="radio-inline"><input type="radio" name="despesas_ordinarias" value="3" <?=($ClienteData['despesas_ordinarias'] == 3 ? 'checked="checked"' : '')?>
                                                <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Outro</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control"
                                               type = "text"
                                               name = "despesas_ord_outros"
                                               value="<?php if (!empty($ClienteData['despesas_ord_outros'])) echo $ClienteData['despesas_ord_outros']; ?>"
                                               title = "Despesas Ordinárias Outro"
                                               placeholder="Despesas Ordinárias Outro" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>
                                </div>
                                <h4>Despesas Extraordinárias:</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="radio-inline"><input type="radio" name="despesas_extraordinarias" value="1" <?=($ClienteData['despesas_extraordinarias'] == 1 ? 'checked="checked"' : '')?>
                                                <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Igualitário</label>
                                        <label class="radio-inline"><input type="radio" name="despesas_extraordinarias" value="2" <?=($ClienteData['despesas_extraordinarias'] == 2 ? 'checked="checked"' : '')?>
                                                <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Fração Ideal</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <label class="radio-inline"><input type="radio" name="despesas_extraordinarias" value="3" <?=($ClienteData['despesas_extraordinarias'] == 3 ? 'checked="checked"' : '')?>
                                                <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Outro</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control"
                                               type = "text"
                                               name = "despesas_extra_outros"
                                               value="<?php if (!empty($ClienteData['despesas_extra_outros'])) echo $ClienteData['despesas_extra_outros']; ?>"
                                               title = "Despesas Extraordinárias Outro"
                                               placeholder="Despesas Extraordinárias Outro" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h3>Em caso de Inadimplência:</h3>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <h4>Multas e Juros:</h4>
                                <div class="row form-inline">
                                    <div class="col-md-4">
                                        <label>Aplicar Multa de:</label>
                                        <input class="form-control mask-money"
                                               type = "text"
                                               name = "multa"
                                               value="<?php if (!empty($ClienteData['multa'])) echo $ClienteData['multa']; else echo '0'?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>> %
                                    </div>
                                    <div class="col-md-3">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name = "multa_naoaplicar" value="on" <?= ($ClienteData['multa_naoaplicar'])? "checked='checked'" : null ?><?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>> Não Aplicar</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-inline">
                                    <div class="col-md-8">
                                        <label>Aplicar Juros Moratórios de:</label>
                                        <input class="form-control mask-money"
                                               type = "text"
                                               name = "juros"
                                               value="<?php if (!empty($ClienteData['juros'])) echo $ClienteData['juros']; else echo '0'?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>> % a.m. Pro rata die
                                        <div class="checkbox" style="margin-left: 10px">
                                            <label><input type="checkbox" name = "juros_naoaplicar" value="on" <?= ($ClienteData['juros_naoaplicar'])? "checked='checked'" : null ?><?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>> Não Aplicar</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <h4>Cartas de Cobrança: </h4>
                                <div class="col-md-10">
                                    <label>Enviar e-mails de cobrança para:</label>
                                    <label class="radio-inline"><input type="radio" name="cobranca" value="1" <?=($ClienteData['cobranca'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Proprietário</label>
                                    <label class="radio-inline"><input type="radio" name="cobranca" value="2" <?=($ClienteData['cobranca'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Inquilino</label>
                                    <label class="radio-inline"><input type="radio" name="cobranca" value="3" <?=($ClienteData['cobranca'] == 3 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Ambos</label>
                                </div>
                                <div class="col-md-10">
                                    <label>Se ambos, direcionado ao: </label>
                                    <label class="radio-inline"><input type="radio" name="ambos" value="1" <?=($ClienteData['ambos'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Proprietário</label>
                                    <label class="radio-inline"><input type="radio" name="ambos" value="2" <?=($ClienteData['ambos'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Inquilino</label>
                                    <label class="radio-inline"><input type="radio" name="ambos" value="3" <?=($ClienteData['ambos'] == 3 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não Aplicável</label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h4>Fundos do Condomínio: </h4>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Nome do Fundo</label>
                                        <input class="form-control"
                                               type = "text"
                                               name = "fundo1"
                                               value="<?php if (!empty($ClienteData['fundo1'])) echo $ClienteData['fundo1']; ?>"
                                               title = "Informe o Nome do Fundo"
                                               placeholder="Nome do Fundo" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Valor Médio de Contribuição por Condômino</label>
                                        <div class="form-inline">
                                            <input class="form-control mask-money"
                                                   type = "text"
                                                   name = "taxa_fundo1"
                                                   value="<?php if (!empty($ClienteData['taxa_fundo1'])) echo $ClienteData['taxa_fundo1']; else echo '0' ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                            <label class="radio-inline"><input type="radio" name="tipofundo1" value="1" <?=($ClienteData['tipofundo1'] == 1 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Valor Fixo em R$(reais)</label>
                                            <label class="radio-inline"><input type="radio" name="tipofundo1" value="2" <?=($ClienteData['tipofundo1'] == 2 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>% da Taxa de Condomínio</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Nome do Fundo</label>
                                        <input class="form-control"
                                               type = "text"
                                               name = "fundo2"
                                               value="<?php if (!empty($ClienteData['fundo2'])) echo $ClienteData['fundo2']; ?>"
                                               title = "Informe o Nome do Fundo"
                                               placeholder="Nome do Fundo" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Valor Médio de Contribuição por Condômino</label>
                                        <div class="form-inline">
                                            <input class="form-control mask-money"
                                                   type = "text"
                                                   name = "taxa_fundo2"
                                                   value="<?php if (!empty($ClienteData['taxa_fundo2'])) echo $ClienteData['taxa_fundo2']; else echo '0'?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                            <label class="radio-inline"><input type="radio" name="tipofundo2" value="1" <?=($ClienteData['tipofundo2'] == 1 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Valor Fixo em R$(reais)</label>
                                            <label class="radio-inline"><input type="radio" name="tipofundo2" value="2" <?=($ClienteData['tipofundo2'] == 2 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>% da Taxa de Condomínio</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Nome do Fundo</label>
                                        <input class="form-control"
                                               type = "text"
                                               name = "fundo3"
                                               value="<?php if (!empty($ClienteData['fundo3'])) echo $ClienteData['fundo3']; ?>"
                                               title = "Informe o Nome do Fundo"
                                               placeholder="Nome do Fundo" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Valor Médio de Contribuição por Condômino</label>
                                        <div class="form-inline">
                                            <input class="form-control mask-money"
                                                   type = "text"
                                                   name = "taxa_fundo3"
                                                   value="<?php if (!empty($ClienteData['taxa_fundo3'])) echo $ClienteData['taxa_fundo3']; else echo '0'?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                            <label class="radio-inline"><input type="radio" name="tipofundo3" value="1" <?=($ClienteData['tipofundo3'] == 1 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Valor Fixo em R$(reais)</label>
                                            <label class="radio-inline"><input type="radio" name="tipofundo3" value="2" <?=($ClienteData['tipofundo3'] == 2 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>% da Taxa de Condomínio</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Nome do Fundo</label>
                                        <input class="form-control"
                                               type = "text"
                                               name = "fundo4"
                                               value="<?php if (!empty($ClienteData['fundo4'])) echo $ClienteData['fundo4']; ?>"
                                               title = "Informe o Nome do Fundo"
                                               placeholder="Nome do Fundo" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Valor Médio de Contribuição por Condômino</label>
                                        <div class="form-inline">
                                            <input class="form-control mask-money"
                                                   type = "text"
                                                   name = "taxa_fundo4"
                                                   value="<?php if (!empty($ClienteData['taxa_fundo4'])) echo $ClienteData['taxa_fundo4']; else echo '0'?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                            <label class="radio-inline"><input type="radio" name="tipofundo4" value="1" <?=($ClienteData['tipofundo4'] == 1 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Valor Fixo em R$(reais)</label>
                                            <label class="radio-inline"><input type="radio" name="tipofundo4" value="2" <?=($ClienteData['tipofundo4'] == 2 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>% da Taxa de Condomínio</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Nome do Fundo</label>
                                        <input class="form-control"
                                               type = "text"
                                               name = "fundo5"
                                               value="<?php if (!empty($ClienteData['fundo5'])) echo $ClienteData['fundo5']; ?>"
                                               title = "Informe o Nome do Fundo"
                                               placeholder="Nome do Fundo" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Valor Médio de Contribuição por Condômino</label>
                                        <div class="form-inline">
                                            <input class="form-control mask-money"
                                                   type = "text"
                                                   name = "taxa_fundo5"
                                                   value="<?php if (!empty($ClienteData['taxa_fundo5'])) echo $ClienteData['taxa_fundo5']; else echo '0'?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                            <label class="radio-inline"><input type="radio" name="tipofundo5" value="1" <?=($ClienteData['tipofundo5'] == 1 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Valor Fixo em R$(reais)</label>
                                            <label class="radio-inline"><input type="radio" name="tipofundo5" value="2" <?=($ClienteData['tipofundo5'] == 2 ? 'checked="checked"' : '')?>
                                                    <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>% da Taxa de Condomínio</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="contabil" style="margin-top: 20px;">
                        <h3>Dados Contábeis:</h3>
                        <h4>Síndico: </h4>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>Recebe Remuneração ?:</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_remuneracao" value="1" <?=($ClienteData['sindico_remuneracao'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_remuneracao" value="2" <?=($ClienteData['sindico_remuneracao'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">R$</span>
                                        <input class="form-control mask-money"
                                               type = "text"
                                               name = "sindico_remu_valor"
                                               value="<?php if (!empty($ClienteData['sindico_remu_valor'])) echo $ClienteData['sindico_remu_valor']; else echo '0'?>"
                                               title = "Valor da Remuneração"
                                               placeholder="Valor da Remuneração" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Recebe Desconto no Condomínio ?:</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_desconto" value="1" <?=($ClienteData['sindico_desconto'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_desconto" value="2" <?=($ClienteData['sindico_desconto'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input class="form-control mask-money"
                                               type = "text"
                                               name = "sindico_desc_valor"
                                               value="<?php if (!empty($ClienteData['sindico_desc_valor'])) echo $ClienteData['sindico_desc_valor']; else echo '0'?>"
                                               title = "Valor do Desconto"
                                               placeholder="Valor do Desconto" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-7">
                                    <label>Desconto em Despesas ?:</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_desc_despesas" value="1" <?=($ClienteData['sindico_desc_despesas'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Ordinárias</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_desc_despesas" value="2" <?=($ClienteData['sindico_desc_despesas'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Extraordinárias</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_desc_despesas" value="3" <?=($ClienteData['sindico_desc_despesas'] == 3 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Ambos</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <label class="radio-inline"><input type="radio" name="sindico_desc_despesas" value="4" <?=($ClienteData['sindico_desc_despesas'] == 4 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não Aplicável</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control"
                                           type = "text"
                                           name = "sindico_desc_desp_outro"
                                           value="<?php if (!empty($ClienteData['sindico_desc_desp_outro'])) echo $ClienteData['sindico_desc_desp_outro']; ?>"
                                           title = "Outro Desconto"
                                           placeholder="Outro Desconto" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <label>Deve ser recolhido Contribuição Patronal (20% do valor do desconto) ?:</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_patronal" value="1" <?=($ClienteData['sindico_patronal'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_patronal" value="2" <?=($ClienteData['sindico_patronal'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <label>Deve ser recolhido INSS (11% do valor do desconto) ?:</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_inss" value="1" <?=($ClienteData['sindico_inss'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_inss" value="2" <?=($ClienteData['sindico_inss'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <label>Se SIM:</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_inss_paga" value="1" <?=($ClienteData['sindico_inss_paga'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Pago pelo Condomínio</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_inss_paga" value="2" <?=($ClienteData['sindico_inss_paga'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Pago pelo Síndico</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_inss_paga" value="3" <?=($ClienteData['sindico_inss_paga'] == 3 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não Aplicável</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Síndico recebe algum outro benefício ?:</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_beneficio" value="1" <?=($ClienteData['sindico_beneficio'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="sindico_beneficio" value="2" <?=($ClienteData['sindico_beneficio'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control"
                                           type = "text"
                                           name = "sindico_bene_nome"
                                           value="<?php if (!empty($ClienteData['sindico_bene_nome'])) echo $ClienteData['sindico_bene_nome']; ?>"
                                           title = "Qual benefício ?"
                                           placeholder="Qual benefício ?" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>Subsíndico: </h4>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>Recebe Remuneração ?:</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_remuneracao" value="1" <?=($ClienteData['subsindico_remuneracao'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_remuneracao" value="2" <?=($ClienteData['subsindico_remuneracao'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">R$</span>
                                        <input class="form-control mask-money"
                                               type = "text"
                                               name = "subsindico_remu_valor"
                                               value="<?php if (!empty($ClienteData['subsindico_remu_valor'])) echo $ClienteData['subsindico_remu_valor']; else echo '0'?>"
                                               title = "Valor da Remuneração"
                                               placeholder="Valor da Remuneração" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Recebe Desconto no Condomínio ?:</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_desconto" value="1" <?=($ClienteData['subsindico_desconto'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_desconto" value="2" <?=($ClienteData['subsindico_desconto'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input class="form-control mask-money"
                                               type = "text"
                                               name = "subsindico_desc_valor"
                                               value="<?php if (!empty($ClienteData['subsindico_desc_valor'])) echo $ClienteData['subsindico_desc_valor'];  else echo '0'?>"
                                               title = "Valor do Desconto"
                                               placeholder="Valor do Desconto" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label>Desconto em Despesas ?:</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_desc_despesas" value="1" <?=($ClienteData['subsindico_desc_despesas'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Ordinárias</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_desc_despesas" value="2" <?=($ClienteData['subsindico_desc_despesas'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Extraordinárias</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_desc_despesas" value="3" <?=($ClienteData['subsindico_desc_despesas'] == 3 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Ambos</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <label class="radio-inline"><input type="radio" name="subsindico_desc_despesas" value="4" <?=($ClienteData['subsindico_desc_despesas'] == 4 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não Aplicável</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control"
                                           type = "text"
                                           name = "subsindico_desc_desp_outro"
                                           value="<?php if (!empty($ClienteData['subsindico_desc_desp_outro'])) echo $ClienteData['subsindico_desc_desp_outro']; ?>"
                                           title = "Outro Desconto"
                                           placeholder="Outro Desconto" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <label>Deve ser recolhido Contribuição Patronal (20% do valor do desconto) ?:</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_patronal" value="1" <?=($ClienteData['subsindico_patronal'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_patronal" value="2" <?=($ClienteData['subsindico_patronal'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <label>Deve ser recolhido INSS (11% do valor do desconto) ?:</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_inss" value="1" <?=($ClienteData['subsindico_inss'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_inss" value="2" <?=($ClienteData['subsindico_inss'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <label>Se SIM:</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_inss_paga" value="1" <?=($ClienteData['subsindico_inss_paga'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Pago pelo Condomínio</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_inss_paga" value="2" <?=($ClienteData['subsindico_inss_paga'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Pago pelo Síndico</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_inss_paga" value="3" <?=($ClienteData['subsindico_inss_paga'] == 3 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não Aplicável</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Síndico recebe algum outro benefício ?:</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_beneficio" value="1" <?=($ClienteData['subsindico_beneficio'] == 1 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                    <label class="radio-inline"><input type="radio" name="subsindico_beneficio" value="2" <?=($ClienteData['subsindico_beneficio'] == 2 ? 'checked="checked"' : '')?>
                                            <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control"
                                           type = "text"
                                           name = "subsindico_bene_nome"
                                           value="<?php if (!empty($ClienteData['subsindico_bene_nome'])) echo $ClienteData['subsindico_bene_nome']; ?>"
                                           title = "Qual benefício ?"
                                           placeholder="Qual benefício ?" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h3>Informações à Receita Federal:</h3>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>Quando houver alteração do Síndico, deve ser alterado o nome junto ao CNPJ/RECEITA FEDERAL ?:</label>
                                <label class="radio-inline"><input type="radio" name="sindico_receita_federal" value="1" <?=($ClienteData['sindico_receita_federal'] == 1 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                <label class="radio-inline"><input type="radio" name="sindico_receita_federal" value="2" <?=($ClienteData['sindico_receita_federal'] == 2 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                            </div>
                        </div>
                        <hr>
                        <h3>Declarações ao governo a serem entregues pela administração:</h3>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>DIRF - Declaração de Imposto de Renda Retido na Fonte (Somente se houver Imposto de Renda Retido na Fonte):</label>
                                <label class="radio-inline"><input type="radio" name="dirf" value="1" <?=($ClienteData['dirf'] == 1 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                <label class="radio-inline"><input type="radio" name="dirf" value="2" <?=($ClienteData['dirf'] == 2 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                            </div>
                            <div class="col-md-12">
                                <label>DES - Declaração Eletrônica de Serviços (Se tiver tomado serviço com Nota Fiscal):</label>
                                <label class="radio-inline"><input type="radio" name="des" value="1" <?=($ClienteData['des'] == 1 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                <label class="radio-inline"><input type="radio" name="des" value="2" <?=($ClienteData['des'] == 2 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                            </div>
                            <div class="col-md-12">
                                <label>RAIS - Relação Anual de Informação Social (Informações dos Funcionários):</label>
                                <label class="radio-inline"><input type="radio" name="rais" value="1" <?=($ClienteData['rais'] == 1 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                <label class="radio-inline"><input type="radio" name="rais" value="2" <?=($ClienteData['rais'] == 2 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                            </div>
                            <div class="col-md-12">
                                <label>CAGED - Cadastro Geral de Empregados e Desempregados (Somente se houver funcionários próprios do condomínio):</label>
                                <label class="radio-inline"><input type="radio" name="caged" value="1" <?=($ClienteData['caged'] == 1 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                <label class="radio-inline"><input type="radio" name="caged" value="2" <?=($ClienteData['caged'] == 2 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                            </div>
                        </div>
                        <hr>
                        <h3>Contratações de Serviços de Autônomo:</h3>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>RECOLHER ISS (% DO VALOR DO SERVIÇO CONFORME CADASTRO DO AUTÔNOMO NA PREFEITURA):</label>
                                <label class="radio-inline"><input type="radio" name="iss_recolher" value="1" <?=($ClienteData['iss_recolher'] == 1 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                <label class="radio-inline"><input type="radio" name="iss_recolher" value="2" <?=($ClienteData['iss_recolher'] == 2 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                <label class="radio-inline"><input type="radio" name="iss_recolher" value="3" <?=($ClienteData['iss_recolher'] == 3 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Solicitar definição do Síndico</label>
                            </div>
                            <div class="col-md-12">
                                <label>Recolher INSS (11% do valor do Serviço):</label>
                                <label class="radio-inline"><input type="radio" name="inss_recolher" value="1" <?=($ClienteData['inss_recolher'] == 1 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                <label class="radio-inline"><input type="radio" name="inss_recolher" value="2" <?=($ClienteData['inss_recolher'] == 2 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                <label class="radio-inline"><input type="radio" name="inss_recolher" value="3" <?=($ClienteData['inss_recolher'] == 3 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Solicitar definição do Síndico</label>
                            </div>
                            <div class="col-md-12">
                                <label>Recolher Contribuição Patronal pelo Condomínio (20% do valor do serviço):</label>
                                <label class="radio-inline"><input type="radio" name="patronal_recolher" value="1" <?=($ClienteData['patronal_recolher'] == 1 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Sim</label>
                                <label class="radio-inline"><input type="radio" name="patronal_recolher" value="2" <?=($ClienteData['patronal_recolher'] == 2 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Não</label>
                                <label class="radio-inline"><input type="radio" name="patronal_recolher" value="3" <?=($ClienteData['patronal_recolher'] == 3 ? 'checked="checked"' : '')?>
                                        <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>Solicitar definição do Síndico</label>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="banco" style="margin-top: 20px;">
                        <h3>Dados da Conta Bancária</h3>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Banco</label>
                                <select onchange="atualizarComboEspecies()" class="form-control" name="banco" id="codigo_banco" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    <option disabled="disabled" selected="selected"> Selecione o Banco</option>
                                    <?php
                                    $bancos = new Read;
                                    $bancos->ExeRead('especies_titulo', 'GROUP BY codigo_banco ORDER BY max(banco)');
                                    if ($bancos->getResult()):
                                        foreach ($bancos->getResult() as $dados):
                                            extract($dados);
                                                ?>
                                                <option value="<?=$codigo_banco ?>" <?=($ClienteData['banco'] == $codigo_banco ? 'selected="selected"' : '')?>>
                                                    <?= $banco ?></option>
                                                <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Espécie de Título</label>
                                <select class="form-control" name="id_especie_titulo" id="especie_titulo" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                                    <option disabled="disabled" selected="selected"> Selecione a Espécie de Título</option>
                                    <?php
                                    $bancos = new Read;
                                    $bancos->ExeRead('especies_titulo', "WHERE codigo_banco = :user ORDER BY descricao", "user={$ClienteData['banco']}");
                                    if ($bancos->getResult()):
                                        foreach ($bancos->getResult() as $dados):
                                            extract($dados);
                                                ?>
                                                <option value="<?=$id ?>" <?=($ClienteData['id_especie_titulo'] == $id ? 'selected="selected"' : '')?>>
                                                    <?= $descricao ?></option>
                                                <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>Agência</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "agencia"
                                       value="<?php if (!empty($ClienteData['agencia'])) echo $ClienteData['agencia']; ?>"
                                       title = "Informe a Agência do <?= $title; ?>"
                                       placeholder="Agência do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-1">
                                <label>DV</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "agencia_dv"
                                       value="<?php echo $ClienteData['agencia_dv']; ?>"
                                       title = "Informe a Agência DV do <?= $title; ?>"
                                       placeholder="DV" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-3">
                                <label>Conta</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "conta"
                                       value="<?php if (!empty($ClienteData['conta'])) echo $ClienteData['conta']; ?>"
                                       title = "Informe a Conta do <?= $title; ?>"
                                       placeholder="Conta do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-1">
                                <label>DV</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "conta_dv"
                                       value="<?php echo $ClienteData['conta_dv']; ?>"
                                       title = "Informe a Conta DV do <?= $title; ?>"
                                       placeholder="DV" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>DV - Agência e Conta</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "dv_agencia_conta"
                                       value="<?php echo $ClienteData['dv_agencia_conta']; ?>"
                                       title = "Informe o DV da Agência e Conta <?= $title; ?>"
                                       placeholder="DV" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Convênio</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "convenio"
                                       value="<?php if (!empty($ClienteData['convenio'])) echo $ClienteData['convenio']; ?>"
                                       title = "Informe o Convênio do <?= $title; ?>"
                                       placeholder="Convênio do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                            <div class="col-md-4">
                                <label>Carteira</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "carteira"
                                       value="<?php if (!empty($ClienteData['carteira'])) echo $ClienteData['carteira']; ?>"
                                       title = "Informe a Carteira do <?= $title; ?>"
                                       placeholder="Carteira do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>

                        <h4>Vencimento:</h4>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Dia de Vencimento do Boleto</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "vencimento"
                                       value="<?php if (!empty($ClienteData['vencimento'])) echo $ClienteData['vencimento']; ?>"
                                       title = "Informe o Dia de Vencimento do Boleto do <?= $title; ?>"
                                       placeholder="Dia de Vencimento do Boleto do <?= $title; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>

                        <hr>
                        <h3>Configuração do Boleto</h3>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>Taxa do Boleto</label>
                                <input class="form-control"
                                       type = "text"
                                       name = "taxa"
                                       value="<?php if (!empty($ClienteData['taxa'])) echo $ClienteData['taxa']; else echo '0' ?>"
                                       title = "Taxa do Boleto"
                                       placeholder="Taxa do Boleto" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>

                        <h3>Demonstrativo</h3>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <input class="form-control"
                                       type = "text"
                                       name = "demonstrativo1"
                                       value="<?php if (!empty($ClienteData['demonstrativo1'])) echo $ClienteData['demonstrativo1']; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <input class="form-control"
                                       type = "text"
                                       name = "demonstrativo2"
                                       value="<?php if (!empty($ClienteData['demonstrativo2'])) echo $ClienteData['demonstrativo2']; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <input class="form-control"
                                       type = "text"
                                       name = "demonstrativo3"
                                       value="<?php if (!empty($ClienteData['demonstrativo3'])) echo $ClienteData['demonstrativo3']; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <h3>Instruções</h3>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <input class="form-control"
                                       type = "text"
                                       name = "instrucoes1"
                                       value="<?php if (!empty($ClienteData['instrucoes1'])) echo $ClienteData['instrucoes1']; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <input class="form-control"
                                       type = "text"
                                       name = "instrucoes2"
                                       value="<?php if (!empty($ClienteData['instrucoes2'])) echo $ClienteData['instrucoes2']; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <input class="form-control"
                                       type = "text"
                                       name = "instrucoes3"
                                       value="<?php if (!empty($ClienteData['instrucoes3'])) echo $ClienteData['instrucoes3']; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8">
                                <input class="form-control"
                                       type = "text"
                                       name = "instrucoes4"
                                       value="<?php if (!empty($ClienteData['instrucoes4'])) echo $ClienteData['instrucoes4']; ?>" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="obs" style="margin-top: 20px;">
                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Observações</label>
                                <textarea class="form-control" <?php if ($ClienteData['alterar']) echo 'disabled="disabled"'; ?>
                                          name = "observacoes"
                                          rows="15"
                                          title = "Informe as Observações do <?= $title; ?>"
                                          placeholder="Observações do <?= $title; ?>"><?php if (!empty($ClienteData['observacoes'])) echo htmlspecialchars($ClienteData['observacoes']); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <input type = "text" hidden
                           name = "alterar"
                           value="1">
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php if (!$ClienteData['alterar']):?>
                        <div class="row form-group col-lg-12">
                            <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Atualizar" class="btn btn-primary" /></span>
                        </div>
                    <?php endif;?>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->