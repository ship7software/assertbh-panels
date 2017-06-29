<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$userId = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
$modulo = 'proprietarios';
$title = 'Proprietário';

require('_app/Models/AdminProprietario.class.php');

$ReadDados = new Read;
$ReadDados->ExeRead($modulo, "WHERE id = :propid", "propid={$userId}");

$condomino = new AdminUnidade();
$proprietario = new AdminUnidade();


$gerado = '<HTML><h2>Relatório de Proprietário</h2><br><br>
<div><div class="row">';

$gerado.= 'Nome Completo: '.$ReadDados->getResult()[0]['nome'].'<br>';
$gerado.= 'Nascimento: '.$ReadDados->getResult()[0]['data_nascimento'].'<br>';

$gerado.='</div></div></HTML>';

echo $gerado;

// Set parameters
$apikey = '2a8ee72e-b0c7-4aab-b6c5-a0a6274d233a';
$value = '<title>HTML to PDF conversion</title>A very long HTML body here..'; // can aso be a url, starting with http..

$postdata = http_build_query(
    array(
        'apikey' => $apikey,
        'value' => $gerado,
        'MarginBottom' => '30',
        'MarginTop' => '20'
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

// Convert the HTML string to a PDF using those parameters
$result = file_get_contents('http://api.html2pdfrocket.com/pdf', false, $context);

// Save to root folder in website
file_put_contents('mypdf-1.pdf', $result);
