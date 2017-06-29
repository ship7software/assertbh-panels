<?php


require('../_app/Config.inc.php');

$idcobranca = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$readConfig = new Read;
$readConfig->ExeRead("boleto", "WHERE id = :user", "user=1");
$readConfig->getResult();

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


######################################################################################################################################################
# FUNCOES DO SISTEMA (NAO ALTERAR)
######################################################################################################################################################
function remover_acentos($str)
{
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'Ð', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', 'Œ', 'œ', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'Š', 'š', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Ÿ', 'Z', 'z', 'Z', 'z', 'Ž', 'ž', '?', 'ƒ', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?', 'ç', 'Ç', "'");
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o','c','C', " ");
    return str_replace($a, $b, $str);
}

function post_slug($str)
{
    return strtoupper(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'),
        array('', '-', ''), remover_acentos($str)));
}

/*Campos Numéricos (“Picture 9”)
• Alinhamento: sempre à direita, preenchido com zeros à esquerda, sem máscara de edição;
• Não utilizados: preencher com zeros.
*/

function picture_9($palavra,$limite){
    $var=str_pad($palavra, $limite, "0", STR_PAD_LEFT);
    return $var;
}

/*
Campos Alfanuméricos (“Picture X”)
• Alinhamento: sempre à esquerda, preenchido com brancos à direita;
• Não utilizados: preencher com brancos;
• Caracteres: maiúsculos, sem acentuação, sem ‘ç’, sem caracteres especiais.
*/

function picture_x( $palavra, $limite ){
    $var = str_pad( $palavra, $limite, " ", STR_PAD_RIGHT );
    $var = remover_acentos( $var );
    if( strlen( $palavra ) >= $limite ){
        $var = substr( $palavra, 0, $limite );
    }
    $var = strtoupper( $var );// converte em letra maiuscula
    return $var;
}

function sequencial($i)
{
    if($i < 10)
    {
        return zeros(0,5).$i;
    }
    else if($i > 10 && $i < 100)
    {
        return zeros(0,4).$i;
    }
    else if($i > 100 && $i < 1000)
    {
        return zeros(0,3).$i;
    }
    else if($i > 1000 && $i < 10000)
    {
        return zeros(0,2).$i;
    }
    else if($i > 10000 && $i < 100000)
    {
        return zeros(0,1).$i;
    }
}

function zeros($min,$max)
{
    $x = ($max - strlen($min));
    for($i = 0; $i < $x; $i++)
    {
        $zeros .= '0';
    }
    return $zeros.$min;
}

function complementoRegistro($int,$tipo)
{
    if($tipo == "zeros")
    {
        $space = '';
        for($i = 1; $i <= $int; $i++)
        {
            $space .= '0';
        }
    }
    else if($tipo == "brancos")
    {
        $space = '';
        for($i = 1; $i <= $int; $i++)
        {
            $space .= ' ';
        }
    }

    return $space;
}

function picture_99($palavra,$limite){
    $var=str_pad($palavra, $limite, "0", STR_PAD_LEFT);
    return $var;
}

// achar o digito verificador do nosso numero

function digitoVerificador_nossonumero($numero) {
    $resto2 = modulo_11($numero, 7, 1);
    $digito = 11 - $resto2;
    if ($digito == 10) {
        $dv = "P";
    } elseif($digito == 11) {
        $dv = 0;
    } else {
        $dv = $digito;
    }
    return $dv;
}


function modulo_11($num, $base=9, $r=0)  {
    /**
     *   Autor:
     *           Pablo Costa <pablo@users.sourceforge.net>
     *
     *   Função:
     *    Calculo do Modulo 11 para geracao do digito verificador
     *    de boletos bancarios conforme documentos obtidos
     *    da Febraban - www.febraban.org.br
     *
     *   Entrada:
     *     $num: string numérica para a qual se deseja calcularo digito verificador;
     *     $base: valor maximo de multiplicacao [2-$base]
     *     $r: quando especificado um devolve somente o resto
     *
     *   Saída:
     *     Retorna o Digito verificador.
     *
     *   Observações:
     *     - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
     *     - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste script.
     */

    $soma = 0;
    $fator = 2;

    /* Separacao dos numeros */
    for ($i = strlen($num); $i > 0; $i--) {
        // pega cada numero isoladamente
        $numeros[$i] = substr($num,$i-1,1);
        // Efetua multiplicacao do numero pelo falor
        $parcial[$i] = $numeros[$i] * $fator;
        // Soma dos digitos
        $soma += $parcial[$i];
        if ($fator == $base) {
            // restaura fator de multiplicacao para 2
            $fator = 1;
        }
        $fator++;
    }

    /* Calculo do modulo 11 */
    if ($r == 0) {
        $soma *= 10;
        $digito = $soma % 11;
        if ($digito == 10) {
            $digito = 0;
        }
        return $digito;
    } elseif ($r == 1){
        $resto = $soma % 11;
        return $resto;
    }
}


// final da funcao


######################################################################################################################################################
// VARIAVEIS 
// ( ALTERE CONFORME SEUS DADOS BANCARIOS )
######################################################################################################################################################

// dados do arquivo de remessa a ser gerado
$arq                       = "CB".date("d").date("m").date("Y");            // nome do seu arquivo de remessa a ser gerado
//$arq                       = "TESTE001";                             // nome do seu arquivo de remessa a ser gerado 
$extensao                  = "REM";                                    // extensao do arquivo. .TST = Remessas Testes / REM = Remessas producao

// dados da remessa
$pasta_destino             = "remessa/";                               // local onde ficarao seus arquivos de remessa em seu servidor

$valor_multa               = "200";                                    // MULTA EM PORCENTAGEM CONTENDO 2 CASAS DECIMAIS, P.EX. "200" = 2%
$carteira                  = "09";                                     // CODIGO DA CARTEIRA
$cpf_cnpj                  = "11839737000208";                         // CNPJ
$agencia                   = "3787";                                   // AGENCIA DA CONTA DA EMPRESA
$dv_agencia                = "0";                                      // DIGITO DA AGENCIA
$conta                     = "13797";                                  // CONTA CORRENTE
$dv_conta                  = "0";                                      // DIGITO DA CONTA
$dv_ag_conta               = "0";                                      // DIGITO DA AGENCIA/CONTA (VERIFICAR E OBTER COM O SEU BANCO)
$num_banco                 = "237";                                    // '237' = COD. DO BANCO BRADESCO
$nome_banco                = "BRADESCO SA";                            // NOME DO BANCO = BRADESCO SA
$codigo_beneficiario       = "7778549";                                // COD. BENEFICIARIO OU COD. DO CONVENIO
$conta_cedente             = "7778549";                                // COD. DO CEDENTE (OBTER COM O SEU BANCO)
$empresa_beneficiario      = "BRUNO MARTINS RODRIGUES ME";             // NOME DA EMPRESA

// dados do boleto
$nosso_num                 = "32244";                                  // NOSSO NUMERO => NUMERO DO SEU BOLETO. P.EX. ==> BOLETO Nº 32244;

$data_vencimento_boleto    = "05012017";                                                 // VENCIMENTO DO BOLETO -> DDMMYYYY
$data_multa                = "06012017";                                                 // DATA DA MULTA -> DDMMYYYY
$data_emissao_boleto       = "03012017";                                                 // EMISSAO DO BOLETO -> DDMMYYYY
$valor_boleto              = "35000";                                                     // 35000'; //350,00
$data_juros                = "06012017";                                                 // DATA LIMITE PARA COBRAR JUROS E MULTA -> DDMMYYYY
$valor_juros               = "0034";                                                     // JUROS EM TAXA PERCENTUAL 0034 ou 350,00, depende se em valor ou em taxa
$data_desconto             = "05012017";                                                 // DATA LIMITE PARA DESCONTO -> DDMMYYYY
$valor_desconto            = "500";                                                      // VALOR DO DESCONTO EM PORCENTAGEM
$valor_iof                 = "000";                                                      // VALOR DO IOF (DEIXAR ZERADO)
$valor_abatimento          = "000";                                                      // DEIXAR 000

// dados do pagador                                                                     
$tipo_inscricao_pagador    = "1";                                                        // tipo de inscrição do pagador 1 pessoa fisica 2 pessoa juridica
$numero_inscricao_pagador  = "40329543765";                                              // cpf ou cnpj do pagador
$nome_pagador              = "JOSE MELO REGO";                                           // NOME DO PAGADOR
$endereco_pagador          = "AV ALFA QUADRA 15 CASA 29";                                // ENDERECO
$bairro_pagador            = "PARQUE ATHENAS";                                           // BAIRRO
$cep_pagador               = "65073";                                                    // PRIMEIROS 5 DIGITOS DO CEP
$cep_pagador_sufixo        = "300";                                                      // TRES ULTIMOS DIGITOS DO CEP
$cidade_pagador            = "SAO LUIS";                                                 // CIDADE
$estado_pagador            = "MA";                                                       // ESTADO
$email_pagador             = "ALEXANDRE890@YAHOO.COM.BR";                                // EMAIL

######################################################################################################################################################
// CONFIGURACOES 
// ( NAO PODE ALTERAR )
######################################################################################################################################################

$fusohorario         = 3; // como o servidor de hospedagem é a dreamhost pego o fuso para o horario do brasil
$timestamp           = mktime(date("H") - $fusohorario, date("i"), date("s"), date("m"), date("d"), date("Y"));

$DATAHORA['PT'][$i]  = gmdate("d/m/Y H:i:s", $timestamp);
$DATAHORA['EN'][$i]  = gmdate("Y-m-d H:i:s", $timestamp);
$DATA['PT'][$i]      = gmdate("d/m/Y", $timestamp);
$DATA['EN'][$i]      = gmdate("Y-m-d", $timestamp);
$DATA['DIA'][$i]     = gmdate("d",$timestamp);
$DATA['MES'][$i]     = gmdate("m",$timestamp);
$DATA['ANO'][$i]     = gmdate("Y",$timestamp);
$HORA                = gmdate("H:i:s", $timestamp);
$HORA1               = gmdate("His", $timestamp);

define("REMESSA",$PATH."",true);

$arquivo         = $arq.".".$extensao;
$filename        = $arquivo;

$conteudo        = '';
$lote_sequencial = 1;
$lote_servico    = 1;

$header          = '';
$header_lote     = '';

$linha_p         = '';
$linha_q         = '';
$linha_r         = '';

$linha_5         = '';

$linha_9         = '';

$conteudo_meio   = '';

$qtd_titulos     = 0;
$total_valor     = 0;

$num_seg_linha_p_q_r = 1;

$xnumero_seq = 1;
$numero_sequencial_arquivo = $xnumero_seq; // cada arquivo gerado deverá ter uma sequencia (vide arquivo anterior .php)

######################################################################################################################################################
// REGISTRO HEADER - ( TIPO 0 )
// PARTE 1
// NAO ALTERAR 
######################################################################################################################################################

$header .= picture_9($num_banco,3);                     // 01.0 -> Cod. do banco. (104=caixa/237=bradesco)
$header .= complementoRegistro(4,"zeros");              // 02.0 -> Cod. do lote
$header .= complementoRegistro(1,"zeros");              // 03.0 -> Tipo de Registro
$header .= complementoRegistro(9,"brancos");            // 04.0 -> CNAB literal remessa escr. extenso 003 009 X(07)
$header .= '2';                                         // 05.0 -> Tipo de inscrição do beneficiario : um se pessoa fisico (1) ou juridica (2)
$header .= picture_9($cpf_cnpj,14);                     // 06.0 -> Nº de Inscrição do  Beneficiario cpf ou cnpj
$header .= picture_9($codigo_beneficiario,20);          // 07.0 -> Convenio -> Codigo do convenio no banco
$header .= picture_9($agencia,5);                       // 08.0 -> Cod. da agencia mantenedora da conta
$header .= picture_x($dv_agencia,1);                    // 09.0 -> Digito verificador
$header .= picture_9($conta,12);                        // 10.0 -> Num. da conta corrente
$header .= picture_x($dv_conta,1);                      // 11.0 -> Digito verificador da conta corrente
$header .= complementoRegistro(1,"brancos");            // 12.0 -> Digito verificador da ag/conta - deixar em branco
$header .= picture_x($empresa_beneficiario,30);         // 13.0 -> Nome da empresa
$header .= picture_x($nome_banco,30);                   // 14.0 -> Nome do banco, neste caso: CAIXA ECONOMICA FEDERAL ate completar 30 espacos
$header .= complementoRegistro(10,"brancos");           // 15.0 -> 10 espaços em banco
$header .='1';                                          // 16.0 -> Cod. (1) = Remessa ou (2) = Retorno.
$header .= $DATA['DIA'][$i].$DATA['MES'][$i].$DATA['ANO'][$i];      // 17.0 -> Data da geracao arquivo 
$header .= $HORA1;                                      // 18.0 -> Hora da geracao arquivo 
$header .= picture_9($numero_sequencial_arquivo,6);     // 19.0 -> Sequencial do arquivo um numero novo para cada arquivo de remessa que for gerado
$header .='084';                                        // 20.0 -> Nova versao da leitura
$header .= complementoRegistro(5,"zeros");              // 21.0 -> Densidade de Gravacao do Arquivo
$header .= complementoRegistro(20,"brancos");           // 22.0 -> Filler
$header .= complementoRegistro(20,"brancos");           // 23.0 -> Preencher com ‘REMESSA-TESTE' na fase de testes(simulado) ou REMESSA-PRODUCAO quando OK
$header .= complementoRegistro(29,"brancos");           // 24.0 -> Preencher com espacos
$header .= chr(13).chr(10);                             // QUEBRA DE LINHA

######################################################################################################################################################
// DESCRICAO DE REGISTRO - ( TIPO 1 )
// HEADER DE LOTE DE ARQUIVO REMESSA
// PARTE 2
// NAO ALTERAR
######################################################################################################################################################

$header_lote .= picture_9($num_banco,3);                     // 01.1 -> Cod. do banco, neste caso = 104
$header_lote .= picture_9($lote_servico,4);                  // 02.1 -> Lote de servico = igual ao campo 02.1 do header acima
$header_lote .='1';                                          // 03.1 -> Preencher '1’ (equivale a Header de Lote)
$header_lote .='R';                                          // 04.1 -> Preencher ‘R’ (equivale a Arquivo Remessa)
$header_lote .='01';                                         // 05.1 -> Preencher com ‘01', se Cobrança Registrada; ou ‘02’, se Cobrança Sem Registro/Serviços
$header_lote .= complementoRegistro(2,"brancos");            // 06.1 -> Preencher com brancos
$header_lote .='042';                                        // 07.1 -> No. da versão do layout. Preencher com 030
$header_lote .= complementoRegistro(1,"brancos");            // 08.1 -> Preencher com espacos
$header_lote .= '2';                                         // 09.1 -> Tipo de inscrição do beneficiario : um se pessoa fisico (1) ou juridica (2)
$header_lote .= picture_9($cpf_cnpj,15);                     // 10.1 -> CNPJ = Número de Inscrição do  Beneficiário cpf ou cnpj
$header_lote .= picture_9($codigo_beneficiario,20);          // 11.1 -> COD. CEDENTE ou COD. DO CONVENIO NO BANCO = código do beneficiário fornecido pelo banco 
$header_lote .= picture_9($agencia,5);                       // 12.1 -> Agencia mantenedora da conta
$header_lote .= picture_9($dv_agencia,1);                    // 13.1 -> Digito verificador
$header_lote .= picture_9($conta,12);                        // 14.1 -> Num. da conta corrente
$header_lote .= picture_x($dv_conta,1);                      // 15.1 -> digito verificador da conta corrente
$header_lote .= complementoRegistro(1,"brancos");            // 16.1 -> Uso exclusivo da caixa
$header_lote .= picture_x($empresa_beneficiario,30);         // 17.1 -> Nome da empresa
$header_lote .= complementoRegistro(40,"brancos");           // 18.1 -> mensagem 1
$header_lote .= complementoRegistro(40,"brancos");           // 19.1 -> mensagem 2
$header_lote .= picture_9($numero_sequencial_arquivo,8);     // 20.1 -> Controle de cobranca - No. da remessa, mesmo que 19.0
$header_lote .= $DATA['DIA'][$i].$DATA['MES'][$i].$DATA['ANO'][$i];      // 21.1 -> Controle de cobranca - Data de gravacao do arquivo de remessa
$header_lote .= complementoRegistro(8,"zeros");              // 22.1 -> Data do credito. Preencher com zeros
$header_lote .= complementoRegistro(33,"brancos");           // 23.1 -> CNAB. Preencher com espacos 
$header_lote .= chr(13).chr(10);                             // Quebra de linha

// *****************************************************************************************************************
// DESCRICAO DE REGISTRO - ( TIPO 3 ) , Segmento "P":
// DADOS DO TITULO
// PARTE 3
// TAMANHO DO REGISTRO = 240 CARACTERES
// *****************************************************************************************************************
// NAO PODE ALTERAR
// *****************************************************************************************************************

$numero_documento                = $nosso_num;                                                 // documento numero == nosso numero
$nosso_numero                    = picture_99( $nosso_num, 11 );                               // DEIXA O NOSSO NUMERO COM 11 DIGITOS SENDO ZEROS A ESQUERDA
$dv_nn                           = digitoVerificador_nossonumero( "09".$nosso_numero );        // incluido a carteira 09 e obtendo o digito verificador do Nosso numero
$dv_nosso_numero                 = $dv_nn;

$linha_p .= picture_9($num_banco,3);                 // 01.3P -> CCONTROLE. COD. DO BANCO, Neste caso = 104 = caixa / 237 = bradesco
$linha_p .= picture_9($lote_servico,4);              // 02.3P -> CONTROLE. LOTE DE SERVICO. TEM QUE SER IGUAL AO HEADER DE LOTE DO CAMPO 02.1
$linha_p .= '3';                                     // 03.3P -> CONTROLE. TIPO DE REGISTRO. Preencher com 3 (EQUIVALE A DETALHE DO LOTE)
$linha_p .= picture_9($num_seg_linha_p_q_r,5);       // 04.3P -> SERVICO. Nº Sequencial do Registro no Lote. (G038). EVOLUIR DE 1 EM 1 PARA CADA SEGMENTO DO LOTE
$linha_p .= 'P';                                     // 05.3P -> SERVICO. Cód. Segmento do Registro Detalhe, PREENCHER P
$linha_p .= complementoRegistro(1,"brancos");        // 06.3P -> SERVICO. Preencher com espaco
$linha_p .= picture_9('01',2);                       // 07.3P -> SERVICO. Cod. de movimento remessa. 1=entrada/2=baixa/6=alterar vencimento (C004)
$linha_p .= picture_9($agencia,5);                   // 08.3P -> COD. ID. BENEFICIARIO. Agencia mantenedora da conta
$linha_p .= picture_x($dv_agencia,1);                // 09.3P -> COD. ID. BENEFICIARIO. Digito verificador
$linha_p .= picture_9($conta,12);                    // 10.3P -> NUMERO DA CONTA CORRENTE
$linha_p .= picture_x($conta_dv,1);                  // 11.3P -> DIGITO VERIFICADOR DA CONTA CORRENTE
$linha_p .= picture_x($dv_ag_conta,1);               // 12.3P -> DIGITO VERIFICADOR DA AG/CONTA
$linha_p .= picture_9($carteira,3);                  // 13.3P -> G069 (identificacao do produto - *carteira?)
$linha_p .= complementoRegistro(5,"zeros");          // 13.3P -> zeros
$linha_p .= picture_9($numero_documento,11);         // 13.3P -> nosso_numero
$linha_p .= picture_9($dv_nosso_numero,1);           // 13.3P -> digito verificador do nosso numero
$linha_p .='1';                                      // 14.3P -> codigo da carteira (1) equivale a cobrança simples (C006)
$linha_p .='1';                                      // 15.3P -> Forma de Cadastramento do Título no Banco. 1=cobranca registrada / 2=cobranca sem registro
$linha_p .='2';                                      // 16.3P -> Tipo de Documento - Preencher '2’ (equivale a Escritural)
$linha_p .='2';                                      // 17.3P -> Identificação da Emissao do boleto. 1 = Banco emite/ 2 = Cliente emite (C009)
$linha_p .='0';                                      // 18.3P -> Identificacao da Entrega do boleto. (C010)
$linha_p .= picture_x($numero_documento,15);         // 19.3P -> Numero do documento de cobranca. (C011) = meu numero de boleto
$linha_p .= picture_9($data_vencimento_boleto,8);    // 20.3P -> Data de vencimento do título, no formato DDMMAAAA (Dia, Mêse Ano);
$linha_p .= picture_9($valor_boleto,15);             // 21.3p -> Valor nominal do título,utilizando 2 casas decimais (exemplo:título de valor 530,44 - preencher 0000000053044)
$linha_p .= complementoRegistro(5,"zeros");          // 22.3P -> Agência Encarregada da Cobrança (Preencher com zeros)
$linha_p .= picture_x($dv_agencia,1);                // 23.3P -> DV da agencia (G009)
$linha_p .= picture_x('99',2);                       // 24.3P -> Espécie do Título (NF: NOTA FISCAL, DD:DOCUMENTO DE DIVIDA, CPR: CÉDULA DE PRODUTO RURAL, OU:OUTROS = 99
$linha_p .= picture_x('N',1);                        // 25.3P -> Aceite. preencher com ‘A’ (Aceite) ou‘N’ (Não Aceite)
$linha_p .= picture_9($data_emissao_boleto,8);       // 26.3P -> Data de emissjão do título, no formato DDMMAAAA (Dia, Mêse Ano);
$linha_p .= picture_9('2',1);                        // 27.3P -> Juros de mora;preencher com o tipo de preferência:‘1’ (Valor por Dia); ou ‘2’ (Taxa Mensal); ou ‘3’(Isento)
$linha_p .= picture_9($data_juros,8);                // 28.3P -> Data para início da cobrança de Juros de Mora, no formato DDMMAAAA (Dia, Mês e Ano). 0 = dia posterior venc.
//          devendo ser maior que a Data de Vencimento; ATENÇÃO, caso a informação seja inválida ou nãoinformada,
//          o sistema assumirá data igual à Datade Vencimento + 1
$linha_p .= picture_9($valor_juros,15);              // 29.3P -> Juros de Mora por Dia/Taxa

// Se houver taxa de desconto nesse boleto
if( $valor_desconto >0 ){
    $linha_p .= picture_9('2',1);                        // 30.3P -> DESCONTO 1. Cod. do desconto. tipo desconto Pagador / 0=Sem Desconto / 1=Valor Fixo / 2 = Percentual
    $linha_p .= picture_9($data_desconto,8);             // 31.3P -> DESCONTO 1. Data do desconto
    $linha_p .= picture_9($valor_desconto,15);           // 32.3P -> DESCONTO 1. Valor/percentual do desconto a ser concedido
}else{
    $linha_p .= picture_9('0',1);                        // 30.3P -> DESCONTO 1. Cod. do desconto. tipo desconto Pagador / 0=Sem Desconto / 1=Valor Fixo / 2 = Percentual
    $linha_p .= picture_9('0',8);                        // 31.3P -> DESCONTO 1. Data do desconto
    $linha_p .= picture_9('0',15);                       // 32.3P -> DESCONTO 1. Valor/percentual do desconto a ser concedido
}

$linha_p .= picture_9($valor_iof,15);                // 33.3P -> VLR. IOF. Valor do IOF a ser recolhido
$linha_p .= picture_9($valor_abatimento,15);         // 34.3P -> Valor do abatimento
$linha_p .= picture_x($numero_documento,25);         // 35.3P -> Uso empresa cedente. Identificacao do titulo na empresa. Identico ao campo 19.3P
$linha_p .= '3';                                     // 36.3P -> Código para Protesto. 1 = protestar / 3 = nao protestar
$linha_p .= '00';                                    // 37.3P -> Prazo para protesto. Numero de dias para  Protesto
$linha_p .= '1';                                     // 38.3P -> Código p/ Baixa/Devolução: Preencher - vencido: '1’ (Baixar/ Devolver) ou ‘2’ (Não Baixar / Não Devolver
$linha_p .= picture_9('090',3);                      // 39.3P -> Prazo p/ baixa/devolucao. Numero de dias para baixa/devolucao
$linha_p .= picture_9('9',2);                        // 40.3P -> Codigo da moeda. 09 = REAL
$linha_p .= complementoRegistro(10,"zeros");         // 41.3P -> Preencher com zeros
$linha_p .= complementoRegistro(1,"brancos");        // 42.3P -> Preencher com espacos
$linha_p .= chr(13).chr(10);                         // essa é a quebra de linha

$num_seg_linha_p_q_r++;

$qtd_titulos++;

$total_valor+=$valor_boleto;

// *****************************************************************************************************************
// DESCRICAO DE REGISTRO - ( TIPO 3 ) , Segmento "Q":
// DADOS DO PAGADOR E SACADOR/AVALISTA
// PARTE 4
// TAMANHO DO REGISTRO = 240 CARACTERES
// *****************************************************************************************************************

$linha_q .= picture_9($num_banco,3);                 // 01.3Q -> Cod. Banco. Caixa = 104
$linha_q .= picture_9($lote_servico,4);              // 02.3Q -> Lote de serviço
$linha_q .= '3';                                     // 03.3Q -> tipo de registro. Equivalente a detalhe de lote. preencher '3'
$linha_q .= picture_9($num_seg_linha_p_q_r,5);       // 04.3Q -> Nº Sequencial do Registro no Lote
$linha_q .= 'Q';                                     // 05.3Q -> Cód. Segmento do Registro Detalhe
$linha_q .= complementoRegistro(1,"brancos");        // 06.3Q -> Espaco
$linha_q .= picture_9('01',2);                       // 07.3Q -> Cod de Movimento Remessa
$linha_q .= $tipo_inscricao_pagador;                 // 08.3Q -> Tipo de Inscricao do Pagador (1) CPF (pessoa física) (2) CNPJ Pessoa jurídica
$linha_q .= picture_9($numero_inscricao_pagador,15); // 09.3Q -> cpf ou cnpj
$linha_q .= picture_x($nome_pagador,40);             // 10.3Q -> Nome do pagador
$linha_q .= picture_x($endereco_pagador,40);         // 11.3Q -> Endereco do pagador
$linha_q .= picture_x($bairro_pagador,15);           // 12.3Q -> Bairro
$linha_q .= picture_9($cep_pagador,5);               // 13.3Q -> Cep
$linha_q .= picture_9($cep_pagador_sufixo,3);        // 14.3Q -> Cep (sufixo)
$linha_q .= picture_x($cidade_pagador,15);           // 15.3Q -> Cidade
$linha_q .= picture_x($estado_pagador,2);            // 16.3Q -> UF

$linha_q .= '0';                                     // 17.3Q -> Tipo de Inscrição do sacador AVALISTA (0) nenhum (1) CPF (pessoa física) (2) CNPJ Pessoa jurídica
$linha_q .= picture_9('0',15);                       // 18.3Q -> CPF ou CNPJ do Sacador avalista

$linha_q .= complementoRegistro(40,"brancos");       // 19.3Q -> nome do sacador avalista
$linha_q .= complementoRegistro(3,"brancos");        // 20.3Q -> Zeros
$linha_q .= complementoRegistro(20,"brancos");       // 21.3Q -> Espaco
$linha_q .= complementoRegistro(8,"brancos");        // 22.3Q -> Espaco

$tam_linha_q  = strlen($linha_q);
$zeros_rest_2 = 240 - $tam_linha_q;
$linha_q      = $linha_q.complementoRegistro($zeros_rest_2,"zeros");

$linha_q .= chr(13).chr(10);                         // essa é a quebra de linha

$num_seg_linha_p_q_r++;


// ********************

// *****************************************************************************************************************
// DESCRICAO DE REGISTRO - ( TIPO 3 ) , Segmento "R":
// DADOS DO PAGADOR E SACADOR/AVALISTA
// PARTE 4
// TAMANHO DO REGISTRO = 240 CARACTERES
// *****************************************************************************************************************

$linha_r .= picture_9($num_banco,3);                 // 01.3R -> Cod. Banco. Caixa = 104
$linha_r .= picture_9($lote_servico,4);              // 02.3R -> Lote de serviço
$linha_r .= '3';                                     // 03.3R -> tipo de registro. Equivalente a detalhe de lote. preencher '3'
$linha_r .= picture_9($num_seg_linha_p_q_r,5);       // 04.3R -> Nº Sequencial do Registro no Lote
$linha_r .= 'R';                                     // 05.3R -> Cód. Segmento do Registro Detalhe
$linha_r .= complementoRegistro(1,"brancos");        // 06.3R -> Espaco
$linha_r .= picture_9('01',2);                       // 07.3R -> Cod. Movimento Rem = 01 => Entrada de titulo Nota Explicativa: (C004)
$linha_r .= '0';                                     // 08.3R -> DESCONTO-2. COD. DESCONTO / 0=sem / 1=valor fixo / 2=valor percentual
$linha_r .= picture_9('0',8);                        // 09.3R -> DESCONTO-2. DATA DESCONTO
$linha_r .=	picture_9('0',15);                       // 10.3R -> DESCONTO-2. VALOR DO DESCONTO
$linha_r .= '0';                                     // 11.3R -> DESCONTO-3. COD. DESCONTO / 0=sem / 1=valor fixo / 2=valor percentual
$linha_r .= picture_9('0',8);                        // 12.3R -> DESCONTO-3. DATA DESCONTO
$linha_r .=	picture_9('0',15);                       // 13.3R -> DESCONTO-3. VALOR DO DESCONTO
$linha_r .= '2';                                     // 14.3R -> MULTA. / 0=sem / 1=valor fixo / 2=valor percentual
$linha_r .= picture_9($data_juros,8);                // 15.3R -> MULTA. DATA DA MULTA
$linha_r .=	picture_9($valor_multa,15);              // 16.3R -> MULTA. VALOR
$linha_r .= complementoRegistro(10,"brancos");       // 17.3R -> INFORMACAO AO PAGADOR - preencher com espacos
$linha_r .= complementoRegistro(40,"brancos");       // 18.3R -> INFORMACAO 3 - mensagem 3
$linha_r .= complementoRegistro(40,"brancos");       // 19.3R -> INFORMACAO 4 - Mensagem 4
$linha_r .= complementoRegistro(20,"brancos");       // 20.3R -> CNAB uso exclusivo
$linha_r .= complementoRegistro(8,"zeros");          // 21.3R -> cod. ocor. do pagador

$linha_r .= picture_9($num_banco,3);                 // 22.3R -> numero do banco
$linha_r .= picture_9($agencia,5);                   // 23.3R -> numero da agencia
$linha_r .= picture_9($dv_agencia,1);                // 24.3R -> numero do digito verificador da agencia
$linha_r .= picture_9($conta,12);                    // 25.3R -> numero da conta corrente
$linha_r .= picture_x($dv_conta,1);                  // 26.3R -> numero do digito verificador da conta
$linha_r .= picture_x($dv_ag_conta,1);               // 27.3R -> numero do digito verificador da agencia/conta
$linha_r .= '2';                                     // 28.3R -> ID aviso deb. auto. (01=emite aviso endereco informado remessa /02=nao emite/03=emite aviso end. cadas. banco)
$linha_r .= complementoRegistro(9,"brancos");        // 29.3R -> preencher com brancos
$linha_r .= chr(13).chr(10);                         // essa é a quebra de linha

$lote_sequencial++;

$num_seg_linha_p_q_r++;

$conteudo_meio .= $linha_p.$linha_q.$linha_r;

$linha_p = "";
$linha_q = "";
$linha_r = "";


// *****************************************************************************************************************
// DESCRICAO DE REGISTRO TIPO "5"
// TRAILER DE LOTE DE ARQUIVO REMESSA
// PARTE 5 - PNULTIMA LINHA DO ARQUIVO
// TAMANHO DO REGISTRO = 240 CARACTERES
// *****************************************************************************************************************

$linha_5 .= picture_9($num_banco,3);                 // 01.5 -> COD. DO BANCO. ( CAIXA = 104 / BRADESCO = 237 )
$linha_5 .= picture_9($lote_servico,4);              // 02.5 -> CONTROLE -> Lote de servico equivalente a 02.1
$linha_5 .= '5';                                     // 03.5 -> CONTROLE -> Tipo de registro, preencher com '5' //         equivalente a (Trailer de Lote).
$linha_5 .= complementoRegistro(9,"brancos");        // 04.5 -> CNAB. FIller, preencher com espacos

$qtd_registros = ($lote_sequencial*3)+2-1-1;
$linha_5 .= picture_9(($qtd_registros-1),6);         // 05.5 -> Qtd. de registros no lote. Somatoria dos registros
//         de tipo 1, 3 e 5 ( obs alex = total de linhas -2 )

$linha_5 .= picture_9($qtd_titulos,6);               // 06.5 -> TOTALIZACAO COBRANCA SIMPLES - Preencher com a qtd. de titulos informados no lote
$linha_5 .=	picture_9($total_valor,17);              // 07.5 -> TOTALIZACAO COBRANCA SIMPLES - Preencher com o valor total de titulos informados no lote
$linha_5 .= complementoRegistro(6,"zeros");          // 08.5 -> cobranca vinculada -> qtd. titulos
$linha_5 .= complementoRegistro(17,"zeros");         // 09.5 -> cobranca vinculada -> valor total dos titulos
$linha_5 .= complementoRegistro(6,"zeros");          // 10.5 -> cobranca caucionada -> qtd. titulos
$linha_5 .= complementoRegistro(17,"zeros");         // 11.5 -> cobranca caucionada -> valor total dos titulos
$linha_5 .= complementoRegistro(6,"zeros");          // 12.5 -> cobranca descontada -> qtd. titulos
$linha_5 .= complementoRegistro(17,"zeros");         // 13.5 -> cobranca descontada -> valor total dos titulos

$linha_5 .= complementoRegistro(8,"brancos");        // 14.5 -> numero do aviso de lancamento
$linha_5 .= complementoRegistro(117,"brancos");      // 15.5 -> CNAB -> Filler -> Preencher com espacos

$linha_5 .= chr(13).chr(10);                         // essa é a quebra de linha

// *****************************************************************************************************************
// DESCRICAO DE REGISTRO TIPO "9"
// TRAILER DE ARQUIVO REMESSA
// PARTE 5 - FINAL OU RODAPE DO ARQUIVO
// TAMANHO DO REGISTRO = 240 CARACTERES
// *****************************************************************************************************************

$linha_9 .= picture_9($num_banco,3);                 // 01.9 -> COD. DO BANCO. CAIXA = 104
$linha_9 .= '9999';                                  // 02.9 -> lote de serviço. Preencher '9999'
$linha_9 .= '9';                                     // 03.9 -> Tipo de registro. Preencher '9'
$linha_9 .= complementoRegistro(9,"brancos");        // 04.9 -> CNAB. FIller
$qtd_lotes_arquivo = $lote_servico;
$linha_9 .= picture_9($qtd_lotes_arquivo,6);         // 05.9 -> Quantidade de lotes do arquivo

$qtd_reg_arq = ($lote_sequencial*3)+2-1+1-1;
$linha_9 .= picture_9($qtd_reg_arq,6);               // 06.9 -> Quantidade de registros no arquivo

$linha_9 .= complementoRegistro(6,"zeros");          // 07.9 -> Quantidade de contas p/ conciliacao (lotes) ==> *(G037)
$linha_9 .= complementoRegistro(205,"brancos");      // 08.9 -> Espacos

//echo "<br>Tamanho linha 9 = ".strlen($linha_9);

$conteudo = $header.$header_lote.$conteudo_meio.$linha_5.$linha_9;


// Em nosso exemplo, nós vamos abrir o arquivo $filename
// em modo de adição. O ponteiro do arquivo estará no final
// do arquivo, e é pra lá que $conteudo irá quando o 
// escrevermos com fwrite().
// 'w+' e 'w' apaga tudo e escreve do zero
// 'a+' comeca a escrever do inicio para o fim preservando o conteudo do arquivo

if (!$handle = fopen($filename, 'w+')){
    erro("<br>Não foi possível abrir o arquivo ($filename)");
}

// Escreve $conteudo no nosso arquivo aberto.
if (fwrite($handle, "$conteudo") === FALSE){
    echo "<br>Não foi possível escrever no arquivo ($filename)";
}
fclose($handle);
echo "<br>Arquivo de remessa gerado com sucesso!";

?>


<?php
// TRANSFERIR O ARQUIVO PARA O SERVIDOR

$xdestino = $pasta_destino.$filename;
$xorigem = $filename;
@copy($xorigem,$xdestino);

$arquivo = $filename;
//echo "<br>passei aqui na hora de copiar....";

?>

<p>Faça o download do Arquivo de Remessa: <a href="remessa/<?php echo $arquivo;?>" target="_blank"><?php echo "remessa/".$arquivo;?></a></p>