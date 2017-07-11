<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$userId = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
$id_cond = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modulo = 'proprietarios';
$title = 'Proprietário';
$returnPage = 'index';

if ($ClienteData && $ClienteData['SendPostForm']):
    $ClienteData['imagem'] = ( $_FILES['imagem']['tmp_name'] ? $_FILES['imagem'] : 'null' );
    unset($ClienteData['SendPostForm']);

    require('_app/Models/AdminProprietario.class.php');
    $cadastra = new AdminProprietario();
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
        $ClienteData['condominios'] = explode(",",$ClienteData['condominios']);
        $imagem = $ClienteData['imagem'];
    endif;
    $botaoCR = 'Cancelar';
    $botaoClass = 'fa fa-ban';
endif;

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
if ($checkCreate && empty($cadastra)):
    DSErro("O ".$title." foi cadastrado com sucesso no sistema!", DS_ACCEPT);
    $returnPage = 'indexcond';
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
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">

                <div class="row form-group">
                    <div class="col-md-2">
                        <a href="#" class="thumbnail" onclick="document.getElementById('upload').click(); return false"><?= Check::Image('../uploads/'.$modulo.'/'. $imagem); ?></a>
                    </div>
                    <div class="col-md-3">
                        <label>Selecione Nova Imagem</label>
                        <input class="form-control"
                               id="upload"
                               type = "file"
                               name = "imagem" />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Nome Completo</label>
                        <input class="form-control"
                               type = "text"
                               name = "nome"
                               value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>"
                               title = "Informe o Nome Completo do <?= $title; ?>"
                               required
                               placeholder="Nome Completo do <?= $title; ?>" >
                    </div>
                    <div class="col-md-2">
                        <label>Data de Nascimento</label>
                        <input class="form-control mask-date"
                               type = "text"
                               name = "data_nascimento"
                               value="<?php if (!empty($ClienteData['data_nascimento'])) echo $ClienteData['data_nascimento']; ?>"
                               title = "Informe a Data de Nascimento do <?= $title; ?>"
                               placeholder="Data de Nascimento do <?= $title; ?>" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label>CPF/CNPJ</label>
                        <input class="form-control mask-cpfCnpj"
                               type = "text"
                               name = "cpf_cnpj" maxlenght="18"
                               value="<?php if (!empty($ClienteData['cpf_cnpj'])) echo $ClienteData['cpf_cnpj']; ?>"
                               title = "Informe o CPF/CNPJ do <?= $title; ?>"
                               placeholder="CPF/CNPJ do <?= $title; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>RG</label>
                        <input class="form-control"
                               type = "text"
                               name = "rg"
                               value="<?php if (!empty($ClienteData['rg'])) echo $ClienteData['rg']; ?>"
                               title = "Informe o RG do Endereço do <?= $title; ?>"
                               placeholder="RG do <?= $title; ?>" >
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-5">
                        <label>E-mail</label>
                        <input class="form-control"
                               type = "text"
                               name = "email"
                               value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>"
                               title = "Informe o E-mail do <?= $title; ?>"
                               placeholder="E-mail do <?= $title; ?>" >
                    </div>
                    <div class="col-md-3">
                        <label>Senha</label>
                        <input class="form-control"
                               type = "password"
                               name = "senha"
                               value="<?php if (!empty($ClienteData['senha'])) echo $ClienteData['senha']; ?>"
                               title = "Informe a Senha do <?= $title; ?> [ de 6 a 12 caracteres! ]"
                               pattern = ".{6,12}"
                               placeholder="Senha do <?= $title; ?>" >
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-10">
                        <label>Condomínios Relacionados</label><br>
                        <select class="form-control" name="condominios[]" id="multiple-checkboxes" multiple="multiple" required="required">
                            <?php
                            $condominios = new Read;
                            $condominios->ExeRead('condominios', 'ORDER BY nome');
                            if ($condominios->getResult()):
                                foreach ($condominios->getResult() as $dados):
                                    extract($dados);
                                    ?>
                                    <option value="<?=$id ?>" <?php if (in_array($id, $ClienteData['condominios'])) echo 'selected="selected"';?>><?= $nome; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

                <h4>Permitir Alteração:</h4>
                <label class="radio-inline"><input type="radio" name="alterar" value="0" <?=($ClienteData['alterar'] == 0 ? 'checked="true"' : '')?>>Sim</label>
                <label class="radio-inline"><input type="radio" name="alterar" value="1" <?=($ClienteData['alterar'] == 1 ? 'checked="true"' : '')?>>Não</label>

                <hr>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Endereço</label>
                        <input class="form-control"
                               type = "text"
                               name = "endereco"
                               value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>"
                               title = "Informe o Endereço do <?= $title; ?>"
                               placeholder="Endereço do <?= $title; ?>" >
                    </div>
                    <div class="col-md-2">
                        <label>Número</label>
                        <input class="form-control"
                               type = "text"
                               name = "numero"
                               value="<?php if (!empty($ClienteData['numero'])) echo $ClienteData['numero']; ?>"
                               title = "Informe o Número do Endereço do <?= $title; ?>"
                               placeholder="Número" >
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
                               placeholder="Complemento do <?= $title; ?>" >
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
                               placeholder="Bairro do <?= $title; ?>" >
                    </div>
                    <div class="col-md-4">
                        <label>Cidade</label>
                        <input class="form-control"
                               type = "text"
                               name = "cidade"
                               value="<?php if (!empty($ClienteData['cidade'])) echo $ClienteData['cidade']; ?>"
                               title = "Informe o Cidade do <?= $title; ?>"
                               placeholder="Cidade do <?= $title; ?>" >
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Estado</label>
                        <select class="form-control" name="estado">
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
                        <input class="form-control mask-cep"
                               type = "text"
                               name = "cep"
                               value="<?php if (!empty($ClienteData['cep'])) echo $ClienteData['cep']; ?>"
                               title = "Informe o CEP do <?= $title; ?>"
                               placeholder="CEP do <?= $title; ?>" >
                    </div>

                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Telefone</label>
                        <input class="form-control mask-phone9"
                               type = "tel"
                               name = "telefone"
                               value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>"
                               title = "Informe o Telefone do <?= $title; ?>"
                               placeholder="Telefone do <?= $title; ?>" >
                    </div>
                    <div class="col-md-4">
                        <label>Celular</label>
                        <input class="form-control mask-phone9"
                               type = "tel"
                               name = "celular"
                               value="<?php if (!empty($ClienteData['celular'])) echo $ClienteData['celular']; ?>"
                               title = "Informe o Celular do <?= $title; ?>"
                               placeholder="Celular do <?= $title; ?>" >
                    </div>
                </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Atualizar" class="btn btn-primary" /></span>
                <a href="painel.php?exe=<?=$modulo?>/<?= $returnPage ?>&id=<?=$id_cond?>" class="btn btn-danger"><i class="<?=$botaoClass ?>"></i> <?=$botaoCR ?></a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->