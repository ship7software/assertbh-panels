<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$userId = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
$modulo = 'unidades';
$title = 'Unidade';
require('_app/Models/AdminUnidade.class.php');

if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);
    $cadastra = new AdminUnidade();
    $cadastra->ExeUpdate($userId, $ClienteData);
    DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-arrow-left';
else:
    $ReadUser = new Read;
    $ReadUser->ExeRead($modulo, "WHERE id = :userid", "userid={$userId}");
    if ($ReadUser->getResult()):
        $ClienteData = $ReadUser->getResult()[0];
        $ClienteData['alterarInquilino'] = 1;
        unset($ClienteData['senha']);
        $cadastra = new AdminUnidade();
        $cadastra->ExeUpdate($userId, $ClienteData);
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
        <li class="active">Dados</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Dados de <?=$title?></h3>
        </div>
        <div class="box-body">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">

                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Condomínio</label>
                        <select class="form-control" name="id_condominio" disabled="disabled">
                            <option disabled="disabled" selected="selected"> Selecione o Condomínio</option>
                            <?php
                            $condominios = new Read;
                            $condominios->ExeRead('condominios', 'ORDER BY nome');
                            if ($condominios->getResult()):
                                foreach ($condominios->getResult() as $dados):
                                    extract($dados);
                                    ?>
                                    <option value="<?=$id ?>" <?=($ClienteData['id_condominio'] == $id ? 'selected="selected"' : '')?>><?= $nome; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Proprietário</label>
                        <select class="form-control" name="id_proprietario" disabled="disabled">
                            <option disabled="disabled" selected="selected"> Selecione o Proprietário</option>
                            <?php
                            $proprietarios = new Read;
                            $proprietarios->ExeRead('proprietarios', 'ORDER BY nome');
                            if ($proprietarios->getResult()):
                                foreach ($proprietarios->getResult() as $dados):
                                    extract($dados);
                                    ?>
                                    <option value="<?=$id ?>" <?=($ClienteData['id_proprietario'] == $id ? 'selected="selected"' : '')?>><?= $nome; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Bloco</label>
                        <input class="form-control"
                               type = "text"
                               name = "bloco"
                               value="<?php if (!empty($ClienteData['bloco'])) echo $ClienteData['bloco']; ?>"
                               title = "Informe o Bloco da <?= $title; ?>"
                               placeholder="Bloco do <?= $title; ?>"  disabled="disabled">
                    </div>
                    <div class="col-md-4">
                        <label>Unidade</label>
                        <input class="form-control"
                               type = "text"
                               name = "apto_sala"
                               value="<?php if (!empty($ClienteData['apto_sala'])) echo $ClienteData['apto_sala']; ?>"
                               title = "Informe o Unidade da <?= $title; ?>"
                               placeholder="Unidade do <?= $title; ?>"  disabled="disabled">
                    </div>
                </div>
                <hr>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Contato para Emergências</label>
                        <input class="form-control"
                               type = "text"
                               name = "contato_emergencia"
                               value="<?php if (!empty($ClienteData['contato_emergencia'])) echo $ClienteData['contato_emergencia']; ?>"
                               title = "Informe o Contato para Emergências do <?= $title; ?>"
                               placeholder="Contato para Emergências do <?= $title; ?>"  disabled="disabled">
                    </div>
                    <div class="col-md-4">
                        <label>Telefone para Emergências</label>
                        <input class="form-control mask-phone9"
                               type = "tel"
                               name = "telefone_emergencia"
                               value="<?php if (!empty($ClienteData['telefone_emergencia'])) echo $ClienteData['telefone_emergencia']; ?>"
                               title = "Informe o Telefone para Emergências do <?= $title; ?>"
                               placeholder="Telefone para Emergências do <?= $title; ?>"  disabled="disabled">
                    </div>
                </div>
                <hr>
                <div class="row form-group">
                    <div class="col-md-2">
                        <label>Está Alugado ?:</label>
                        <select class="form-control" name="alugado">
                            <option disabled="disabled" selected="selected"> Selecione</option>
                            <option value="Sim" <?=($ClienteData['alugado'] == 'Sim' ? 'selected="selected"' : '')?>  disabled="disabled">Sim</option>
                            <option value="Não" <?=($ClienteData['alugado'] == 'Não' ? 'selected="selected"' : '')?>  disabled="disabled">Não</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Nome do Inquilino</label>
                        <input class="form-control"
                               type = "text"
                               name = "nome_inquilino"
                               value="<?php if (!empty($ClienteData['nome_inquilino'])) echo $ClienteData['nome_inquilino']; ?>"
                               title = "Informe o Nome do Inquilino da <?= $title; ?>"
                               placeholder="Inquilino da <?= $title; ?>"  disabled="disabled">
                    </div>
                    <div class="col-md-2">
                        <label>Data de Nascimento</label>
                        <input class="form-control mask-date"
                               type = "text"
                               name = "data_nascimento"
                               value="<?php if (!empty($ClienteData['data_nascimento'])) echo $ClienteData['data_nascimento']; ?>"
                               title = "Informe a Data de Nascimento do Inquilino da <?= $title; ?>"
                               placeholder="Data de Nascimento do Inquilino da <?= $title; ?>"  disabled="disabled">
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
                               placeholder="CPF/CNPJ do <?= $title; ?>" disabled="disabled">
                    </div>
                    <div class="col-md-4">
                        <label>RG</label>
                        <input class="form-control"
                               type = "text"
                               name = "rg"
                               value="<?php if (!empty($ClienteData['rg'])) echo $ClienteData['rg']; ?>"
                               title = "Informe o RG do Endereço do <?= $title; ?>"
                               placeholder="RG do <?= $title; ?>" disabled="disabled">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Telefone</label>
                        <input class="form-control mask-phone9"
                               type = "tel"
                               name = "telefone"
                               value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>"
                               title = "Informe o Telefone do Inquilino da <?= $title; ?>"
                               placeholder="Telefone do Inquilino da <?= $title; ?>"  disabled="disabled">
                    </div>
                    <div class="col-md-4">
                        <label>Celular</label>
                        <input class="form-control mask-phone9"
                               type = "tel"
                               name = "celular"
                               value="<?php if (!empty($ClienteData['celular'])) echo $ClienteData['celular']; ?>"
                               title = "Informe o Celular do Inquilino da <?= $title; ?>"
                               placeholder="Celular do Inquilino da <?= $title; ?>"  disabled="disabled">
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
                               placeholder="E-mail do <?= $title; ?>"  disabled="disabled">
                    </div>
                </div>
                <hr>
                <h3>Dados do Adminstrador da Locação (Caso houver):</h3>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Nome</label>
                        <input class="form-control"
                               type = "text"
                               name = "nome_admin"
                               value="<?php if (!empty($ClienteData['nome_admin'])) echo $ClienteData['nome_admin']; ?>"
                               title = "Informe o Nome do Adminstrador da <?= $title; ?>"
                               placeholder="Nome do Adminstrador da <?= $title; ?>" disabled="disabled">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Endereço</label>
                        <input class="form-control"
                               type = "text"
                               name = "endereco_admin"
                               value="<?php if (!empty($ClienteData['endereco_admin'])) echo $ClienteData['endereco_admin']; ?>"
                               title = "Informe o Endereço do <?= $title; ?>"
                               placeholder="Endereço do <?= $title; ?>" disabled="disabled">
                    </div>
                    <div class="col-md-2">
                        <label>Número</label>
                        <input class="form-control"
                               type = "text"
                               name = "numero_admin"
                               value="<?php if (!empty($ClienteData['numero_admin'])) echo $ClienteData['numero_admin']; ?>"
                               title = "Informe o Número do Endereço do <?= $title; ?>"
                               placeholder="Número" disabled="disabled">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Complemento</label>
                        <input class="form-control"
                               type = "text"
                               name = "complemento_admin"
                               value="<?php if (!empty($ClienteData['complemento_admin'])) echo $ClienteData['complemento_admin']; ?>"
                               title = "Informe o Complemento do <?= $title; ?>"
                               placeholder="Complemento do <?= $title; ?>" disabled="disabled">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Bairro</label>
                        <input class="form-control"
                               type = "text"
                               name = "bairro_admin"
                               value="<?php if (!empty($ClienteData['bairro_admin'])) echo $ClienteData['bairro_admin']; ?>"
                               title = "Informe o Bairro do Adminstrador da <?= $title; ?>"
                               placeholder="Bairro do Adminstrador da <?= $title; ?>" disabled="disabled">
                    </div>
                    <div class="col-md-4">
                        <label>Cidade</label>
                        <input class="form-control"
                               type = "text"
                               name = "cidade_admin"
                               value="<?php if (!empty($ClienteData['cidade_admin'])) echo $ClienteData['cidade_admin']; ?>"
                               title = "Informe o Cidade do Adminstrador da <?= $title; ?>"
                               placeholder="Cidade do Adminstrador da <?= $title; ?>" disabled="disabled">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Estado</label>
                        <select class="form-control" name="estado_admin" disabled="disabled">
                            <option disabled="disabled" <?php if (empty($ClienteData['estado_admin'])) echo 'selected="selected"';?>>Selecione o Estado</option>
                            <option value="Acre" <?php if ($ClienteData['estado_admin'] == 'Acre') echo 'selected="selected"';?>>Acre</option>
                            <option value="Alagoas" <?php if ($ClienteData['estado_admin'] == 'Alagoas') echo 'selected="selected"';?>>Alagoas</option>
                            <option value="Amapá" <?php if ($ClienteData['estado_admin'] == 'Amapá') echo 'selected="selected"';?>>Amapá</option>
                            <option value="Amazonas" <?php if ($ClienteData['estado_admin'] == 'Amazonas') echo 'selected="selected"';?>>Amazonas</option>
                            <option value="Bahia" <?php if ($ClienteData['estado_admin'] == 'Bahia') echo 'selected="selected"';?>>Bahia</option>
                            <option value="Ceará" <?php if ($ClienteData['estado_admin'] == 'Ceará') echo 'selected="selected"';?>>Ceará</option>
                            <option value="Distrito Federal" <?php if ($ClienteData['estado_admin'] == 'Distrito Federal') echo 'selected="selected"';?>>Distrito Federal</option>
                            <option value="Espírito Santo" <?php if ($ClienteData['estado_admin'] == 'Espírito Santo') echo 'selected="selected"';?>>Espírito Santo</option>
                            <option value="Goiás" <?php if ($ClienteData['estado_admin'] == 'Goiás') echo 'selected="selected"';?>>Goiás</option>
                            <option value="Maranhão" <?php if ($ClienteData['estado_admin'] == 'Maranhão') echo 'selected="selected"';?>>Maranhão</option>
                            <option value="Mato Grosso" <?php if ($ClienteData['estado_admin'] == 'Mato Grosso') echo 'selected="selected"';?>>Mato Grosso</option>
                            <option value="Mato Grosso do Sul" <?php if ($ClienteData['estado_admin'] == 'Mato Grosso do Sul') echo 'selected="selected"';?>>Mato Grosso do Sul</option>
                            <option value="Minas Gerais" <?php if ($ClienteData['estado_admin'] == 'Minas Gerais') echo 'selected="selected"';?>>Minas Gerais</option>
                            <option value="Pará" <?php if ($ClienteData['estado_admin'] == 'Pará') echo 'selected="selected"';?>>Pará</option>
                            <option value="Paraíba" <?php if ($ClienteData['estado_admin'] == 'Paraíba') echo 'selected="selected"';?>>Paraíba</option>
                            <option value="Paraná" <?php if ($ClienteData['estado_admin'] == 'Paraná') echo 'selected="selected"';?>>Paraná</option>
                            <option value="Pernambuco" <?php if ($ClienteData['estado_admin'] == 'Pernambuco') echo 'selected="selected"';?>>Pernambuco</option>
                            <option value="Piauí" <?php if ($ClienteData['estado_admin'] == 'Piauí') echo 'selected="selected"';?>>Piauí</option>
                            <option value="Rio de Janeiro" <?php if ($ClienteData['estado_admin'] == 'Rio de Janeiro') echo 'selected="selected"';?>>Rio de Janeiro</option>
                            <option value="Rio Grande do Norte" <?php if ($ClienteData['estado_admin'] == 'Rio Grande do Norte') echo 'selected="selected"';?>>Rio Grande do Norte</option>
                            <option value="Rio Grande do Sul" <?php if ($ClienteData['estado_admin'] == 'Rio Grande do Sul') echo 'selected="selected"';?>>Rio Grande do Sul</option>
                            <option value="Rondônia" <?php if ($ClienteData['estado_admin'] == 'Rondônia') echo 'selected="selected"';?>>Rondônia</option>
                            <option value="Roraima" <?php if ($ClienteData['estado_admin'] == 'Roraima') echo 'selected="selected"';?>>Roraima</option>
                            <option value="São Paulo" <?php if ($ClienteData['estado_admin'] == 'São Paulo') echo 'selected="selected"';?>>São Paulo</option>
                            <option value="Sergipe" <?php if ($ClienteData['estado_admin'] == 'Sergipe') echo 'selected="selected"';?>>Sergipe</option>
                            <option value="Tocantins" <?php if ($ClienteData['estado_admin'] == 'Tocantins') echo 'selected="selected"';?>>Tocantins</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>CEP</label>
                        <input class="form-control mask-cep"
                               type = "text"
                               name = "cep_admin"
                               value="<?php if (!empty($ClienteData['cep_admin'])) echo $ClienteData['cep_admin']; ?>"
                               title = "Informe o CEP do Adminstrador da <?= $title; ?>"
                               placeholder="CEP do Adminstrador da <?= $title; ?>" disabled="disabled">
                    </div>

                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Telefone</label>
                        <input class="form-control"
                               type = "tel"
                               name = "tel_admin"
                               value="<?php if (!empty($ClienteData['tel_admin'])) echo $ClienteData['tel_admin']; ?>"
                               title = "Informe o Telefone do Adminstrador da <?= $title; ?>"
                               placeholder="Telefone do Adminstrador da <?= $title; ?>" disabled="disabled">
                    </div>
                    <div class="col-md-4">
                        <label>E-mail</label>
                        <input class="form-control"
                               type = "text"
                               name = "email_admin"
                               value="<?php if (!empty($ClienteData['email_admin'])) echo $ClienteData['email_admin']; ?>"
                               title = "Informe o E-mail do Adminstrador da <?= $title; ?>"
                               placeholder="E-mail do Adminstrador da <?= $title; ?>" disabled="disabled">
                    </div>
                </div>

                <input type = "text" hidden
                       name = "alterar"
                       value="1">

        </div><!-- /.box-body -->
        <div class="box-footer">
<!--            <?php /*if (!$ClienteData['alterar']): */?>
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Atualizar" class="btn btn-primary" /></span>
                <a href="painel.php?exe=<?/*=$modulo*/?>/index" class="btn btn-danger"><i class="<?/*=$botaoClass */?>"></i> <?/*=$botaoCR */?></a>
            </div>
            --><?php /*endif; */?>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->