<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$idcond = filter_input(INPUT_GET, 'id2', FILTER_VALIDATE_INT);
$idunid = filter_input(INPUT_GET, 'id1', FILTER_VALIDATE_INT);
$modulo = 'unidades';
$title = 'Unidade';

require('_app/Models/AdminUnidade.class.php');

$ReadDados = new Read;
$ReadDados->ExeRead($modulo, "WHERE id = :unidadeid", "unidadeid={$idunid}");

$condomino = new AdminUnidade();
$proprietario = new AdminUnidade();

require('_app/Library/phpToPDF.php');

$gerado = '<HTML><h2>Relatório de Unidade</h2><br><br>
<div><div class="row">';

$gerado.= 'Condominio: '.$condomino->getCondominio($idcond).'<br>';
$gerado.= 'Proprietário: '.$proprietario->getProprietario($ReadDados->getResult()[0]['id_proprietario']).'<br>';

$gerado.='</div></div></HTML>';

$pdf_options = array(
    "source_type" => 'html',
    "source" => $gerado,
    "action" => 'download',
    "page_size" => 'letter',
    "file_name" => 'doc.pdf');

phptopdf($pdf_options);
