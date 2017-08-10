<?php

require('../../painel/_app/Config.inc.php');
$id = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
$dataInicio = filter_input(INPUT_GET, 'dataInicio', FILTER_DEFAULT);
$dataFim = filter_input(INPUT_GET, 'dataFim', FILTER_DEFAULT);

$timeInicio = strtotime($dataInicio);
$dataInicioStr = date('d/m/Y',$timeInicio);

$timeFim = strtotime($dataFim);
$dataFimStr = date('d/m/Y',$timeFim);

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

$read = new Read;
$read->ExeRead("condominios", "WHERE id = :userid", "userid={$id}");

$cobrancas = new Read;
$cobrancas->FullRead("SELECT unid.bloco, unid.apto_sala, cob.mes_ref, DATE_FORMAT(cob.data,'%d/%m/%Y') as data, DATE_FORMAT(cob.vencimento,'%d/%m/%Y') as vencimento, DATE_FORMAT(cob.pagamento,'%d/%m/%Y') as pagamento, cob.vencimentoBoleto, FORMAT(cob.valor_pago, 2, 'de_DE') as valorPago, FORMAT(cob.valorOriginal, 2, 'de_DE') as valorOriginal
FROM `cobranca` cob
	JOIN condominios cond ON cond.id = cob.id_condominio
    JOIN unidades unid ON unid.id = cob.id_unidade
    JOIN proprietarios prop ON prop.id = cob.id_proprietario
WHERE cob.baixa = 1 AND cob.id_condominio = :userid AND cob.pagamento >= :dataInicio AND cob.pagamento <= :dataFim
ORDER BY cob.pagamento, unid.bloco, unid.apto_sala", "userid={$id}&dataInicio={$dataInicio}&dataFim={$dataFim}");

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
$html = '<h2 style="text-align: center; text-decoration: underline">Cobranças Pagas</h2>
<br>

<table>
	<tr>
		<th style="width: 70%"><span style="font-weight: bold;">Condomínio: </span><br>'.$read->getResult()[0]['nome'].'</th>
		<th><span style="font-weight: bold;">Data/Hora Geração: </span><br>'.date('d/m/Y H:i').'</th>
	</tr>
	<tr>
		<th colspan="2"><span style="font-weight: bold;">Período: </span><br>'.$dataInicioStr.' à '.$dataFimStr.'</th>
	</tr>
	<br/><br/>';
	$html = $html.'<table style="border: 1px solid black;">
		<tr style="background: #ddd">
			<td style="border: 1px solid black; font-weight: bold; width: 70px">Bloco</td>
			<td style="border: 1px solid black; font-weight: bold; width: 80px">Apto/Sala</td>
			<td style="border: 1px solid black; font-weight: bold;">Ref.</td>
			<td style="border: 1px solid black; font-weight: bold; width: 100px">Vencimento</td>
			<td style="border: 1px solid black; font-weight: bold">Pagamento</td>
			<td style="border: 1px solid black; font-weight: bold; width: 100px; text-align: right">Valor Original</td>
			<td style="border: 1px solid black; font-weight: bold; text-align: right">Valor Pago</td>
		</tr>';
		
	foreach ($cobrancas->getResult() as $dados):
			extract($dados);
			$html = $html.'<tr>';
			$html = $html.'<td style="border: 1px solid black;">'.$bloco.'</td>';
			$html = $html.'<td style="border: 1px solid black;">'.$apto_sala.'</td>';
			$html = $html.'<td style="border: 1px solid black;">'.$mes_ref.'</td>';
			$html = $html.'<td style="border: 1px solid black;">'.$vencimento.'</td>';
			$html = $html.'<td style="border: 1px solid black;">'.$pagamento.'</td>';
			$html = $html.'<td style="border: 1px solid black; text-align: right;">R$ '.$valorOriginal.'</td>';
			$html = $html.'<td style="border: 1px solid black; text-align: right;">R$ '.$valorPago.'</td></tr>';
	endforeach;
$html = $html.'	</table></table>';
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->lastPage();

//Close and output PDF document
$pdf->Output('cobrancasEmAberto.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
