<?php
require('../_app/Config.inc.php');

$idcobranca = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$readCobranca = new Read;
$readCobranca->ExeRead("cobranca", "WHERE id = :user", "user={$idcobranca}");
$readCobranca->getResult();

$readCondominio = new Read;
$readCondominio->ExeRead("condominios", "WHERE id = :user", "user={$readCobranca->getResult()[0]['id_condominio']}");
$readCondominio->getResult();

$readProprietario = new Read;
$readProprietario->ExeRead("proprietarios", "WHERE id = :user", "user={$readCobranca->getResult()[0]['id_proprietario']}");
$readProprietario->getResult();

$readUnidade = new Read;
$readUnidade->ExeRead("unidades", "WHERE id = :user", "user={$readCobranca->getResult()[0]['id_unidade']}");
$readUnidade->getResult();


if ($readCondominio->getResult()[0]['cobranca'] == 1):
    $cliente = $readProprietario->getResult()[0]['nome'];
    $cliente_endereco1 = $readProprietario->getResult()[0]['endereco'].','.$readProprietario->getResult()[0]['numero'].' - '.$readProprietario->getResult()[0]['complemento'];
    $cliente_endereco2 = $readProprietario->getResult()[0]['bairro'].' / '.$readProprietario->getResult()[0]['cidade'].' - '.$readProprietario->getResult()[0]['cep'];
elseif ($readCondominio->getResult()[0]['cobranca'] == 2):
    if ($readUnidade->getResult()[0]['alugado'] == 'Sim'):
        $cliente = $readUnidade->getResult()[0]['nome_inquilino'];
        $cliente_endereco1 = $readCondominio->getResult()[0]['endereco'].','.$readProprietario->getResult()[0]['numero'].' - '.$readProprietario->getResult()[0]['complemento'].' - Bloco:'.$readUnidade->getResult()[0]['bloco'].' - Apto/Sala'.$readUnidade->getResult()[0]['apto_sala'];
        $cliente_endereco2 = $readCondominio->getResult()[0]['bairro'].' / '.$readProprietario->getResult()[0]['cidade'].' - '.$readProprietario->getResult()[0]['cep'];
    else:
        $cliente = $readProprietario->getResult()[0]['nome'];
        $cliente_endereco1 = $readProprietario->getResult()[0]['endereco'].','.$readProprietario->getResult()[0]['numero'].' - '.$readProprietario->getResult()[0]['complemento'];
        $cliente_endereco2 = $readProprietario->getResult()[0]['bairro'].' / '.$readProprietario->getResult()[0]['cidade'].' - '.$readProprietario->getResult()[0]['cep'];
    endif;

elseif ($readCondominio->getResult()[0]['cobranca'] == 3):
    if ($readCondominio->getResult()[0]['ambos'] == 1):
        $cliente = $readProprietario->getResult()[0]['nome'];
        $cliente_endereco1 = $readProprietario->getResult()[0]['endereco'].','.$readProprietario->getResult()[0]['numero'].' - '.$readProprietario->getResult()[0]['complemento'];
        $cliente_endereco2 = $readProprietario->getResult()[0]['bairro'].' / '.$readProprietario->getResult()[0]['cidade'].' - '.$readProprietario->getResult()[0]['cep'];
    else:
        if ($readUnidade->getResult()[0]['alugado'] == 'Sim'):
            $cliente = $readUnidade->getResult()[0]['nome_inquilino'];
            $cliente_endereco1 = $readCondominio->getResult()[0]['endereco'].','.$readProprietario->getResult()[0]['numero'].' - '.$readProprietario->getResult()[0]['complemento'].' - Bloco:'.$readUnidade->getResult()[0]['bloco'].' - Apto/Sala'.$readUnidade->getResult()[0]['apto_sala'];
            $cliente_endereco2 = $readCondominio->getResult()[0]['bairro'].' / '.$readProprietario->getResult()[0]['cidade'].' - '.$readProprietario->getResult()[0]['cep'];
        else:
            $cliente = $readProprietario->getResult()[0]['nome'];
            $cliente_endereco1 = $readProprietario->getResult()[0]['endereco'].','.$readProprietario->getResult()[0]['numero'].' - '.$readProprietario->getResult()[0]['complemento'];
            $cliente_endereco2 = $readProprietario->getResult()[0]['bairro'].' / '.$readProprietario->getResult()[0]['cidade'].' - '.$readProprietario->getResult()[0]['cep'];
        endif;
    endif;
endif;


$mes = date("m",  strtotime($readCobranca->getResult()[0]['vencimento']));
$ano = date("Y",  strtotime($readCobranca->getResult()[0]['vencimento']));
$numero_documento = $readUnidade->getResult()[0]['bloco'].$readUnidade->getResult()[0]['apto_sala'].$mes.$ano;

// DADOS DO BOLETO PARA O SEU CLIENTE
//$dias_de_prazo_para_pagamento = $readConfig->getResult()[0]['prazo'];
$taxa_boleto = $readCondominio->getResult()[0]['taxa'];

$data_venc = date("d/m/Y",  strtotime($readCobranca->getResult()[0]['vencimento']));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $readCobranca->getResult()[0]['valor']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $numero_documento;  // Nosso numero sem o DV - REGRA: M�ximo de 11 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $cliente;
$dadosboleto["endereco1"] = $cliente_endereco1;
$dadosboleto["endereco2"] = $cliente_endereco2;

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = $readCondominio->getResult()[0]['demonstrativo1'];
$dadosboleto["demonstrativo2"] = $readCondominio->getResult()[0]['demonstrativo2'];
$dadosboleto["demonstrativo3"] = $readCondominio->getResult()[0]['demonstrativo3'];
$dadosboleto["instrucoes1"] = $readCondominio->getResult()[0]['instrucoes1'];
$dadosboleto["instrucoes2"] = $readCondominio->getResult()[0]['instrucoes2'];
$dadosboleto["instrucoes3"] = $readCondominio->getResult()[0]['instrucoes3'];
$dadosboleto["instrucoes4"] = $readCondominio->getResult()[0]['instrucoes4'];

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";


// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = $readCondominio->getResult()[0]['agencia']; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = $readCondominio->getResult()[0]['agencia_dv']; // Digito do Num da agencia
$dadosboleto["conta"] = $readCondominio->getResult()[0]['conta']; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = $readCondominio->getResult()[0]['conta_dv']; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = $readCondominio->getResult()[0]['conta'];  // ContaCedente do Cliente, sem digito (Somente N�meros)
$dadosboleto["conta_cedente_dv"] = $readCondominio->getResult()[0]['conta_dv'];; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = $readCondominio->getResult()[0]['carteira'];;  // C�digo da Carteira: pode ser 06 ou 03

// SEUS DADOS
$dadosboleto["identificacao"] = "Boleto de Cobrança";
$dadosboleto["cpf_cnpj"] = $readCondominio->getResult()[0]['cnpj'];
$dadosboleto["endereco"] = "Rua Padre Eustáquio, 2912 . Sala 305 . Bairro Padre Eustáquio";
$dadosboleto["cidade_uf"] = "Belo Horizonte . MG";
$dadosboleto["telefones"] = "(31) 2510.7032 / (31) 9.8409.9347";
$dadosboleto["email"] = "gestao@assertbh.com.br";
$dadosboleto["cedente"] = $readCondominio->getResult()[0]['nome'];

// N�O ALTERAR!
include("include/funcoes_bradesco.php");
include("include/layout_bradesco.php");
?>
