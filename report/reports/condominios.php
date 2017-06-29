<?php

require('../../painel/_app/Config.inc.php');
$id = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

$read = new Read;
$read->ExeRead("condominios", "WHERE id = :userid", "userid={$id}");

$bancos = new Read;
$bancos->ExeRead('especies_titulo', "WHERE id = :userid", "userid={$read->getResult()[0]['banco']}");
if ($bancos->getResult()):
$banco = $bancos->getResult()[0]['banco'].' - '.$bancos->getResult()[0]['codigo_banco'].' - '.$bancos->getResult()[0]['codigo_especie'].' - '.$bancos->getResult()[0]['sigla_boleto'].
     ' - '.$bancos->getResult()[0]['descricao'];
else:
    $banco = '';
endif;

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('ASSERTBH Gestão de Condomínios');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// create some HTML content
$html = '<h2 style="text-align: center; text-decoration: underline">Ficha de Condomínio</h2>
<br>

<table>
	<tr>
		<th><span style="font-weight: bold;">Nome: </span><br>'.$read->getResult()[0]['nome'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 70%"><span style="font-weight: bold;">Razão Social: </span><br>'.$read->getResult()[0]['razao_social'].'</th>
		<th><span style="font-weight: bold;">Email: </span><br>'.$read->getResult()[0]['email'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">CNPJ: </span><br>'.$read->getResult()[0]['cnpj'].'</th>
		<th><span style="font-weight: bold;">Número de Unidades: </span><br>'.$read->getResult()[0]['numero_unidades'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 70%"><span style="font-weight: bold;">Endereço: </span><br>'.$read->getResult()[0]['endereco'].'</th>
		<th><span style="font-weight: bold;">Número: </span><br>'.$read->getResult()[0]['numero'].'</th>
	</tr>
	<br>
	<tr>
		<th><span style="font-weight: bold;">Complemento: </span><br>'.$read->getResult()[0]['complemento'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Bairro: </span><br>'.$read->getResult()[0]['bairro'].'</th>
		<th><span style="font-weight: bold;">Cidade: </span><br>'.$read->getResult()[0]['cidade'].'</th>
    </tr>	
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Estado: </span><br>'.$read->getResult()[0]['estado'].'</th>
		<th><span style="font-weight: bold;">CEP: </span><br>'.$read->getResult()[0]['cep'].'</th>
    </tr>	
	<br>
    <tr>
    <th style="width: 100%"><h4 style="text-align: center;text-decoration: underline;">Corpo Diretivo:</h4></th>
    </tr>
	<br>
	<tr>
		<th><span style="font-weight: bold;">Nome do Síndico: </span><br>'.$read->getResult()[0]['nome_sindico'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Telefone do Síndico: </span><br>'.$read->getResult()[0]['telefone_sindico'].'</th>
		<th><span style="font-weight: bold;">Unidade do Síndico: </span><br>'.$read->getResult()[0]['unidade_sindico'].'</th>
    </tr>	
	<br>
	<tr>
		<th><span style="font-weight: bold;">Nome do Subsíndico: </span><br>'.$read->getResult()[0]['nome_subsindico'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Telefone do Subsíndico: </span><br>'.$read->getResult()[0]['telefone_subsindico'].'</th>
		<th><span style="font-weight: bold;">Unidade do Subsíndico: </span><br>'.$read->getResult()[0]['unidade_subsindico'].'</th>
    </tr>	
	<br>
    <tr>
    <th style="width: 100%"><h4 style="text-align: center;text-decoration: underline;">Conselho Consultivo:</h4></th>
    </tr>
	<br>
	<tr>
		<th><span style="font-weight: bold;">Nome do Conselheiro 1: </span><br>'.$read->getResult()[0]['conselho1'].'</th>
	</tr>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Telefone do Conselheiro 1: </span><br>'.$read->getResult()[0]['telefone_conselho1'].'</th>
		<th><span style="font-weight: bold;">Unidade do Conselheiro 1: </span><br>'.$read->getResult()[0]['unidade_conselho1'].'</th>
    </tr>	
	<br>
	<tr>
		<th><span style="font-weight: bold;">Nome do Conselheiro 2: </span><br>'.$read->getResult()[0]['conselho2'].'</th>
	</tr>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Telefone do Conselheiro 2: </span><br>'.$read->getResult()[0]['telefone_conselho2'].'</th>
		<th><span style="font-weight: bold;">Unidade do Conselheiro 2: </span><br>'.$read->getResult()[0]['unidade_conselho2'].'</th>
    </tr>	
	<br>
	<tr>
		<th><span style="font-weight: bold;">Nome do Conselheiro 3: </span><br>'.$read->getResult()[0]['conselho3'].'</th>
	</tr>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Telefone do Conselheiro 3: </span><br>'.$read->getResult()[0]['telefone_conselho3'].'</th>
		<th><span style="font-weight: bold;">Unidade do Conselheiro 3: </span><br>'.$read->getResult()[0]['unidade_conselho3'].'</th>
    </tr>	
</table>

';
$pdf->writeHTML($html, true, false, true, false, '');

// add a page
$pdf->AddPage();

// create some HTML content
$html = '
<table>
    <tr>
    <th style="width: 100%"><h3 style="text-align: center;text-decoration: underline;">Financeiro:</h3></th>
    </tr>
    <br>
    <tr>
    <th style="width: 100%"><h3>Forma de Rateio Atual de Despesas:</h3></th>
    </tr>
    <br>
	<tr>
		<th><span style="font-weight: bold;">Divisão por: </span><br>( '.($read->getResult()[0]['rateio_divisao']==1?'X':' ').' ) Despesas Previstas     ( '.($read->getResult()[0]['rateio_divisao']==2?'X':' ').' ) Despesas Efetivas</th>
	</tr>
	<br>
	<tr>
		<th><span style="font-weight: bold;">Despesas Ordinárias: </span><br>( '.($read->getResult()[0]['despesas_ordinarias']==1?'X':' ').' ) Igualitário  ( '.($read->getResult()[0]['despesas_ordinarias']==2?'X':' ').' ) Fração Ideal
		( '.($read->getResult()[0]['despesas_ordinarias']==3?'X':' ').' ) Outro   '.($read->getResult()[0]['despesas_ordinarias']==3? ' - '.$read->getResult()[0]['despesas_ord_outros'] :' ').'
		</th>
	</tr>
	<br>
	<tr>
		<th><span style="font-weight: bold;">Despesas Extraordinárias: </span><br>( '.($read->getResult()[0]['despesas_extraordinarias']==1?'X':' ').' ) Igualitário  ( '.($read->getResult()[0]['despesas_extraordinarias']==2?'X':' ').' ) Fração Ideal
		( '.($read->getResult()[0]['despesas_extraordinarias']==3?'X':' ').' ) Outro   '.($read->getResult()[0]['despesas_extraordinarias']==3? ' - '.$read->getResult()[0]['despesas_ord_outros'] :' ').'
		</th>
	</tr>
	<br>
	<tr>
    <th style="width: 100%"><h3>Em caso de Inadimplência:</h3></th>
    </tr>
    <br>
	<tr>
    <th style="width: 100%"><h4>Multas e Juros:</h4></th>
    </tr>
    <br>
	<tr>
		<th><span style="font-weight: bold;">Aplicar Multa de: </span>'.$read->getResult()[0]['multa'].'%  - ('.($read->getResult()[0]['multa_naoaplicar']? 'X' :' ').') Não Aplicar  </th>
	</tr>
	<tr>
		<th><span style="font-weight: bold;">Aplicar Juros Moratórios de: </span>'.$read->getResult()[0]['juros'].'% a.m. Pro rata die  - ('.($read->getResult()[0]['juros_naoaplicar']? 'X' :' ').') Não Aplicar  </th>
	</tr>
	<br>
	<tr>
    <th style="width: 100%"><h3>Cartas de Cobrança:</h3></th>
    </tr>
	<br>	
	<tr>
		<th><span style="font-weight: bold;">Enviar e-mails de cobrança para: </span><br>( '.($read->getResult()[0]['cobranca']==1?'X':' ').' ) Proprietário  ( '.($read->getResult()[0]['cobranca']==2?'X':' ').' ) Inquilino 
		( '.($read->getResult()[0]['cobranca']==3?'X':' ').' ) Ambos
		</th>
	</tr>
	<tr>
		<th><span style="font-weight: bold;">Se ambos, direcionado ao: </span><br>( '.($read->getResult()[0]['ambos']==1?'X':' ').' ) Proprietário  ( '.($read->getResult()[0]['ambos']==2?'X':' ').' ) Inquilino 
		( '.($read->getResult()[0]['ambos']==3?'X':' ').' ) Não Aplicável
		</th>
	</tr>
	<br>
	<tr>
    <th style="width: 100%"><h3>Fundos do Condomínio:</h3></th>
    </tr>
	<br>	
	<tr>
		<th style="width: 35%"><span style="font-weight: bold;">Nome do Fundo 1: </span><br>'.$read->getResult()[0]['fundo1'].'</th>
		<th><span style="font-weight: bold;">Valor Médio de Contribuição por Condômino: </span><br>'.$read->getResult()[0]['taxa_fundo1'].' ( '.($read->getResult()[0]['tipofundo1']==1?'X':' ').' ) Valor Fixo em R$(reais)
		  ( '.($read->getResult()[0]['tipofundo1']==2?'X':' ').' ) % da Taxa de Condomínio</th>
    </tr>
	<br>	
	<tr>
		<th style="width: 35%"><span style="font-weight: bold;">Nome do Fundo 2: </span><br>'.$read->getResult()[0]['fundo2'].'</th>
		<th><span style="font-weight: bold;">Valor Médio de Contribuição por Condômino: </span><br>'.$read->getResult()[0]['taxa_fundo2'].' ( '.($read->getResult()[0]['tipofundo2']==1?'X':' ').' ) Valor Fixo em R$(reais)
		  ( '.($read->getResult()[0]['tipofundo2']==2?'X':' ').' ) % da Taxa de Condomínio</th>
    </tr>
	<br>	
	<tr>
		<th style="width: 35%"><span style="font-weight: bold;">Nome do Fundo 3: </span><br>'.$read->getResult()[0]['fundo3'].'</th>
		<th><span style="font-weight: bold;">Valor Médio de Contribuição por Condômino: </span><br>'.$read->getResult()[0]['taxa_fundo3'].' ( '.($read->getResult()[0]['tipofundo3']==1?'X':' ').' ) Valor Fixo em R$(reais)
		  ( '.($read->getResult()[0]['tipofundo3']==2?'X':' ').' ) % da Taxa de Condomínio</th>
    </tr>
	<br>	
	<tr>
		<th style="width: 35%"><span style="font-weight: bold;">Nome do Fundo 4: </span><br>'.$read->getResult()[0]['fundo4'].'</th>
		<th><span style="font-weight: bold;">Valor Médio de Contribuição por Condômino: </span><br>'.$read->getResult()[0]['taxa_fundo2'].' ( '.($read->getResult()[0]['tipofundo4']==1?'X':' ').' ) Valor Fixo em R$(reais)
		  ( '.($read->getResult()[0]['tipofundo4']==2?'X':' ').' ) % da Taxa de Condomínio</th>
    </tr>
	<br>	
	<tr>
		<th style="width: 35%"><span style="font-weight: bold;">Nome do Fundo 5: </span><br>'.$read->getResult()[0]['fundo5'].'</th>
		<th><span style="font-weight: bold;">Valor Médio de Contribuição por Condômino: </span><br>'.$read->getResult()[0]['taxa_fundo2'].' ( '.($read->getResult()[0]['tipofundo5']==1?'X':' ').' ) Valor Fixo em R$(reais)
		  ( '.($read->getResult()[0]['tipofundo5']==2?'X':' ').' ) % da Taxa de Condomínio</th>
    </tr>
</table>

';
$pdf->writeHTML($html, true, false, true, false, '');

// add a page
$pdf->AddPage();

// create some HTML content
$html = '
<table>
    <tr>
    <th style="width: 100%"><h3 style="text-align: center;text-decoration: underline;">Contábil:</h3></th>
    </tr>
    <br>
    <tr>
    <th style="width: 100%"><h3>Dados Contábeis:</h3></th>
    </tr>
    <br>
    <tr>
    <th style="width: 100%"><h4>Síndico:</h4></th>
    </tr>
    <br>
    <tr>
		<th><span style="font-weight: bold;">Recebe Remuneração ?: </span>( '.($read->getResult()[0]['sindico_remuneracao']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['sindico_remuneracao']==2?'X':' ').' ) Não    R$'.$read->getResult()[0]['sindico_remu_valor'].'</th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Recebe Desconto no Condomínio ?: </span>( '.($read->getResult()[0]['sindico_desconto']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['sindico_desconto']==2?'X':' ').' ) Não    R$'.$read->getResult()[0]['sindico_desc_valor'].'</th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Desconto em Despesas ?: </span>( '.($read->getResult()[0]['sindico_desc_despesas']==1?'X':' ').' ) Ordinárias
		  ( '.($read->getResult()[0]['sindico_desc_despesas']==2?'X':' ').' ) Extraordinárias  ( '.($read->getResult()[0]['sindico_desc_despesas']==3?'X':' ').' ) Ambos 
		  ( '.($read->getResult()[0]['sindico_desc_despesas']==4?'X':' ').' ) Não Aplicável '.($read->getResult()[0]['sindico_desc_desp_outro']?'<br>'.$read->getResult()[0]['sindico_desc_desp_outro']:' ').'
		</th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Deve ser recolhido Contribuição Patronal (20% do valor do desconto) ?: </span>( '.($read->getResult()[0]['sindico_patronal']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['sindico_patronal']==2?'X':' ').' ) Não </th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Deve ser recolhido INSS (11% do valor do desconto) ?: </span>( '.($read->getResult()[0]['sindico_inss']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['sindico_inss']==2?'X':' ').' ) Não </th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Se SIM: </span>( '.($read->getResult()[0]['sindico_inss_paga']==1?'X':' ').' ) Pago pelo Condomínio
		  ( '.($read->getResult()[0]['sindico_inss_paga']==2?'X':' ').' ) Pago pelo Síndico ( '.($read->getResult()[0]['sindico_inss_paga']==3?'X':' ').' ) Não Aplicável</th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Síndico recebe algum outro benefício ?: </span>( '.($read->getResult()[0]['sindico_beneficio']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['sindico_beneficio']==2?'X':' ').') Não '.($read->getResult()[0]['sindico_beneficio']==1?' - <span style="font-weight: bold;">Benefício: </span>'.$read->getResult()[0]['sindico_bene_nome']:' ').'</th>
    </tr>
    <br>
    <tr>
    <th style="width: 100%"><h4>Subsíndico:</h4></th>
    </tr>
    <br>
    <tr>
		<th><span style="font-weight: bold;">Recebe Remuneração ?: </span>( '.($read->getResult()[0]['subsindico_remuneracao']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['subsindico_remuneracao']==2?'X':' ').' ) Não    R$'.$read->getResult()[0]['subsindico_remu_valor'].'</th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Recebe Desconto no Condomínio ?: </span>( '.($read->getResult()[0]['subsindico_desconto']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['subsindico_desconto']==2?'X':' ').' ) Não    R$'.$read->getResult()[0]['subsindico_desc_valor'].'</th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Desconto em Despesas ?: </span>( '.($read->getResult()[0]['subsindico_desc_despesas']==1?'X':' ').' ) Ordinárias
		  ( '.($read->getResult()[0]['subsindico_desc_despesas']==2?'X':' ').' ) Extraordinárias  ( '.($read->getResult()[0]['subsindico_desc_despesas']==3?'X':' ').' ) Ambos 
		  ( '.($read->getResult()[0]['subsindico_desc_despesas']==4?'X':' ').' ) Não Aplicável '.($read->getResult()[0]['subsindico_desc_desp_outro']?'<br>'.$read->getResult()[0]['subsindico_desc_desp_outro']:' ').'
		</th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Deve ser recolhido Contribuição Patronal (20% do valor do desconto) ?: </span>( '.($read->getResult()[0]['subsindico_patronal']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['subsindico_patronal']==2?'X':' ').' ) Não </th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Deve ser recolhido INSS (11% do valor do desconto) ?: </span>( '.($read->getResult()[0]['subsindico_inss']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['subsindico_inss']==2?'X':' ').' ) Não </th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Se SIM: </span>( '.($read->getResult()[0]['subsindico_inss_paga']==1?'X':' ').' ) Pago pelo Condomínio
		  ( '.($read->getResult()[0]['subsindico_inss_paga']==2?'X':' ').' ) Pago pelo Síndico ( '.($read->getResult()[0]['subsindico_inss_paga']==3?'X':' ').' ) Não Aplicável</th>
    </tr>
    <tr>
		<th><span style="font-weight: bold;">Síndico recebe algum outro benefício ?: </span>( '.($read->getResult()[0]['subsindico_beneficio']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['subsindico_beneficio']==2?'X':' ').') Não '.($read->getResult()[0]['subsindico_beneficio']==1?' - <span style="font-weight: bold;">Benefício: </span>'.$read->getResult()[0]['subsindico_bene_nome']:' ').'</th>
    </tr>
    <br>
    <tr>
    <th style="width: 100%"><h3>Informações à Receita Federal:</h3></th>
    </tr>
    <br>
    <tr>
		<th><span style="font-weight: bold;">Quando houver alteração do Síndico, deve ser alterado o nome junto ao CNPJ/RECEITA FEDERAL ?: </span>( '.($read->getResult()[0]['sindico_receita_federal']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['sindico_receita_federal']==2?'X':' ').') Não </th>
    </tr>
    <br>
    <tr>
    <th style="width: 100%"><h3>Declarações ao governo a serem entregues pela administração:</h3></th>
    </tr>
    <br>
    <tr>
		<th><span style="font-weight: bold;">DIRF - Declaração de Imposto de Renda Retido na Fonte (Somente se houver Imposto de Renda Retido na Fonte): </span>( '.($read->getResult()[0]['dirf']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['dirf']==2?'X':' ').') Não </th>
    </tr>
    <br>
    <tr>
		<th><span style="font-weight: bold;">DES - Declaração Eletrônica de Serviços (Se tiver tomado serviço com Nota Fiscal): </span>( '.($read->getResult()[0]['des']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['des']==2?'X':' ').') Não </th>
    </tr>
    <br>
    <tr>
		<th><span style="font-weight: bold;">RAIS - Relação Anual de Informação Social (Informações dos Funcionários): </span>( '.($read->getResult()[0]['rais']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['rais']==2?'X':' ').') Não </th>
    </tr>
    <br>
    <tr>
		<th><span style="font-weight: bold;">CAGED - Cadastro Geral de Empregados e Desempregados (Somente se houver funcionários próprios do condomínio): </span>( '.($read->getResult()[0]['caged']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['caged']==2?'X':' ').') Não </th>
    </tr>
    <br>
    <tr>
    <th style="width: 100%"><h3>Informações à Receita Federal:</h3></th>
    </tr>
    <br>
     <tr>
		<th><span style="font-weight: bold;">RECOLHER ISS (% DO VALOR DO SERVIÇO CONFORME CADASTRO DO AUTÔNOMO NA PREFEITURA): </span>( '.($read->getResult()[0]['iss_recolher']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['iss_recolher']==2?'X':' ').') Não ( '.($read->getResult()[0]['iss_recolher']==3?'X':' ').') Solicitar definição do Síndico </th>
    </tr>   
    <br>
     <tr>
		<th><span style="font-weight: bold;">Recolher INSS (11% do valor do Serviço): </span>( '.($read->getResult()[0]['inss_recolher']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['inss_recolher']==2?'X':' ').') Não ( '.($read->getResult()[0]['inss_recolher']==3?'X':' ').') Solicitar definição do Síndico </th>
    </tr>   
    <br>
     <tr>
		<th><span style="font-weight: bold;">Recolher Contribuição Patronal pelo Condomínio (20% do valor do serviço): </span>( '.($read->getResult()[0]['patronal_recolher']==1?'X':' ').' ) Sim
		  ( '.($read->getResult()[0]['patronal_recolher']==2?'X':' ').') Não ( '.($read->getResult()[0]['patronal_recolher']==3?'X':' ').') Solicitar definição do Síndico </th>
    </tr>   
    
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');



// add a page
$pdf->AddPage();

// create some HTML content

$html = '
<table>
    <tr>
    <th style="width: 100%"><h3>Dados da Conta Bancária:</h3></th>
    </tr>
    <br>
    <tr>
		<th><span style="font-weight: bold;">Banco - Espécie de Título: </span><br>'.$banco.'</th>
	</tr>
	<br>
    <tr>
		<th style="width: 30%"><span style="font-weight: bold;">Agência: </span><br>'.$read->getResult()[0]['agencia'].'</th>
		<th style="width: 20%"><span style="font-weight: bold;">DV: </span><br>'.$read->getResult()[0]['agencia_dv'].'</th>
		<th style="width: 30%"><span style="font-weight: bold;">Conta: </span><br>'.$read->getResult()[0]['conta'].'</th>
		<th style="width: 20%"><span style="font-weight: bold;">DV: </span><br>'.$read->getResult()[0]['conta_dv'].'</th>
	</tr>
		<br>
    <tr>
		<th style="width: 50%"><span style="font-weight: bold;">Convênio: </span><br>'.$read->getResult()[0]['convenio'].'</th>
		<th style="width: 50%"><span style="font-weight: bold;">Carteira: </span><br>'.$read->getResult()[0]['carteira'].'</th>
	</tr>
	<br>
    <tr>
		<th style="width: 40%"><span style="font-weight: bold;">Dia de Vencimento do Boleto: </span><br>'.$read->getResult()[0]['vencimento'].'</th>
		<th style="width: 30%"><span style="font-weight: bold;">Próximo Nosso Número: </span><br>'.$read->getResult()[0]['proximo_nosso_numero'].'</th>
		<th style="width: 30%"><span style="font-weight: bold;">Próximo Número Remessa: </span><br>'.$read->getResult()[0]['proximo_numero_remessa'].'</th>
	</tr>
	<br>
    <tr>
    <th style="width: 100%"><h3>Configuração do Boleto:</h3></th>
    </tr>
    <br>
    <tr>
		<th><span style="font-weight: bold;">Taxa do Boleto: </span><br>'.$read->getResult()[0]['taxa'].'</th>
	</tr>  
	<br>
    <tr>
    <th style="width: 100%"><h3>Demonstrativo:</h3></th>
    </tr>
    <br>
    <tr>
		<th style="width: 100%">'.$read->getResult()[0]['demonstrativo1'].'</th>
		</tr>
		<tr>
		<th style="width: 100%">'.$read->getResult()[0]['demonstrativo2'].'</th>
		</tr>
		<tr>
		<th style="width: 100%">'.$read->getResult()[0]['demonstrativo3'].'</th>
	</tr>  
	<br>
    <tr>
    <th style="width: 100%"><h3>Instruções:</h3></th>
    </tr>
    <br>
    <tr>
		<th style="width: 100%">'.$read->getResult()[0]['instrucoes1'].'</th>
		</tr>
		<tr>
		<th style="width: 100%">'.$read->getResult()[0]['instrucoes2'].'</th>
		</tr>
		<tr>
		<th style="width: 100%">'.$read->getResult()[0]['instrucoes3'].'</th>
		</tr>
		<tr>
		<th style="width: 100%">'.$read->getResult()[0]['instrucoes4'].'</th>
	</tr>  
    <br>
    <tr>
    <th style="width: 100%"><h3>Pastas Acessíveis para o Condomínio:</h3></th>
    </tr>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Documentos Gerais: </span><br>'.$read->getResult()[0]['docgerais'].'</th>
		<th><span style="font-weight: bold;">Comunicados e Informações: </span><br>'.$read->getResult()[0]['comuinfo'].'</th>
    </tr>	
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Gestão: </span><br>'.$read->getResult()[0]['gestao'].'</th>
		<th><span style="font-weight: bold;">Contabilidade: </span><br>'.$read->getResult()[0]['contabil'].'</th>
    </tr>	
    <br>
    <br>
    <tr>
    <th style="width: 100%"><h3>Observações:</h3></th>
    </tr>
	<tr>
		<th style="width: 100%">'.$read->getResult()[0]['observacoes'].'</th>
    </tr>
    
    
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->lastPage();

//Close and output PDF document
$pdf->Output('condominio.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
