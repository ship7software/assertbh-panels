<?php

require('../../painel/_app/Config.inc.php');
$id = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

$unidade = new Read;
$unidade->ExeRead("unidades", "WHERE id = :userid", "userid={$id}");

$condominio = new Read;
$condominio->ExeRead('condominios', "WHERE id = :condid", "condid={$unidade->getResult()[0]['id_condominio']}");

$proprietario = new Read;
$proprietario->ExeRead('proprietarios', "WHERE id = :condid", "condid={$unidade->getResult()[0]['id_proprietario']}");


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
$html = '<h2 style="text-align: center; text-decoration: underline">Ficha de Unidade</h2>
<br>

<table>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Condomínio: </span><br>'.$condominio->getResult()[0]['nome'].'</th>
		<th><span style="font-weight: bold;">Proprietário: </span><br>'.$proprietario->getResult()[0]['nome'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Bloco: </span><br>'.$unidade->getResult()[0]['bloco'].'</th>
		<th><span style="font-weight: bold;">Apartamento/Sala: </span><br>'.$unidade->getResult()[0]['apto_sala'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Nome de Contato para Emergência: </span><br>'.$unidade->getResult()[0]['contato_emergencia'].'</th>
		<th><span style="font-weight: bold;">Telefone para Emergência: </span><br>'.$unidade->getResult()[0]['telefone_emergencia'].'</th>
	</tr>
	<br>
	<tr>
		<th><span style="font-weight: bold;">Está Alugado ?: </span><br>'.$unidade->getResult()[0]['alugado'].'</th>
	</tr>
	<br>
		<tr>
		<th style="width: 70%"><span style="font-weight: bold;">Nome do Inquilino: </span><br>'.$unidade->getResult()[0]['nome_inquilino'].'</th>
		<th><span style="font-weight: bold;">Data de Nascimento: </span><br>'.date('d/m/Y', strtotime($unidade->getResult()[0]['data_nascimento'])).'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">CPF / CNPJ: </span><br>'.$unidade->getResult()[0]['cpf_cnpj'].'</th>
		<th><span style="font-weight: bold;">RG: </span><br>'.$unidade->getResult()[0]['rg'].'</th>
	</tr>
	<br>
	<tr>
		<th><span style="font-weight: bold;">E-mail: </span><br>'.$unidade->getResult()[0]['email'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Telefone: </span><br>'.$unidade->getResult()[0]['telefone'].'</th>
		<th><span style="font-weight: bold;">Celular: </span><br>'.$unidade->getResult()[0]['celular'].'</th>
    </tr>
    <br>
    <tr>
	<th style="width: 100%;"><h3 style=" text-align: center; text-decoration: underline">Dados do Administrador da Locação (Caso houver):</h3></th>
	</tr>
	<br>
	<tr>
		<th><span style="font-weight: bold;">Nome Completo: </span><br>'.$unidade->getResult()[0]['nome_admin'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 70%"><span style="font-weight: bold;">Endereço: </span><br>'.$unidade->getResult()[0]['endereco_admin'].'</th>
		<th><span style="font-weight: bold;">Número: </span><br>'.$unidade->getResult()[0]['numero_admin'].'</th>
	</tr>
	<br>
	<tr>
		<th><span style="font-weight: bold;">Complemento: </span><br>'.$unidade->getResult()[0]['complemento_admin'].'</th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Bairro: </span><br>'.$unidade->getResult()[0]['bairro_admin'].'</th>
		<th><span style="font-weight: bold;">Cidade: </span><br>'.$unidade->getResult()[0]['cidade_admin'].'</th>
    </tr>	
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Estado: </span><br>'.$unidade->getResult()[0]['estado_admin'].'</th>
		<th><span style="font-weight: bold;">CEP: </span><br>'.$unidade->getResult()[0]['cep_admin'].'</th>
    </tr>	
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Telefone: </span><br>'.$unidade->getResult()[0]['tel_admin'].'</th>
		<th><span style="font-weight: bold;">E-mail: </span><br>'.$unidade->getResult()[0]['email_admin'].'</th>
	</tr>
	<br>

</table>

';
$pdf->writeHTML($html, true, false, true, false, '');

// add a page
$pdf->AddPage();

// create some HTML content
$html = '
<table>
	<tr>
	<th style="width: 100%;"><h4 style="text-align: center; text-decoration: underline">Pastas Acessíveis para o Proprietário da Unidade:</h4></th>
	</tr>
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Documentos Gerais: </span><br>'.$unidade->getResult()[0]['docgerais'].'</th>
		<th><span style="font-weight: bold;">Comunicados e Informações: </span><br>'.$unidade->getResult()[0]['comuinfo'].'</th>
    </tr>	
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Gestão: </span><br>'.$unidade->getResult()[0]['gestao'].'</th>
		<th><span style="font-weight: bold;">Contabilidade: </span><br>'.$unidade->getResult()[0]['contabil'].'</th>
    </tr>	
    <br>
    <tr><th style="width: 100%;" >
	<h4 style="text-align: center; text-decoration: underline">Pastas Acessíveis para o Inquilino da Unidade:</h4>
	</th></tr>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Documentos Gerais: </span><br>'.$unidade->getResult()[0]['docgeraisinc'].'</th>
		<th><span style="font-weight: bold;">Comunicados e Informações: </span><br>'.$unidade->getResult()[0]['comuinfoinc'].'</th>
    </tr>	
	<br>
	<tr>
		<th style="width: 50%"><span style="font-weight: bold;">Gestão: </span><br>'.$unidade->getResult()[0]['gestaoinc'].'</th>
		<th><span style="font-weight: bold;">Contabilidade: </span><br>'.$unidade->getResult()[0]['contabilinc'].'</th>
    </tr>	

</table>

';
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
$pdf->Output('unidade.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
