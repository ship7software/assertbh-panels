<?php

$idboleto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$readBoleto = new Read;
$readBoleto->ExeRead("cobranca", "WHERE id = :user", "user={$idboleto}");
$readBoleto->getResult();

$readCondominio = new Read;
$readCondominio->ExeRead("condominios", "WHERE id = :user", "user={$readBoleto->getResult()[0]['id_condominio']}");


if ($readCondominio->getResult()[0]['banco_nome'] == 'Bradesco'):
    require ('../../_app/Library/boletophp/boleto_bradesco.php');
endif;

