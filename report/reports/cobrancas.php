<?php

require('../../painel/_app/Config.inc.php');
$id = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

$read = new Read;
$read->ExeRead("condominios", "WHERE id = :userid", "userid={$id}");

$cobrancas = new Read;
$cobrancas->ExeRead("cobranca", "WHERE id_condominio = :userid", "userid={$id}");

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
$html = '<h2 style="text-align: center; text-decoration: underline">Cobranças em Aberto</h2>
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
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->lastPage();

//Close and output PDF document
$pdf->Output('cobrancasEmAberto.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+