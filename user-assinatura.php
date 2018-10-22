<?php

require_once 'bootstrap.php';
require_once SYS_PATH . 'app/components/PagSeguroLibrary/PagSeguroLibrary.php';

//echo Security::encripty('10');

$id = base64_decode($_REQUEST['p']);
if (!$id)
    exit;


$assinatura = new AssinaturasManuaisModel();
$assinatura->selectOne('*', 'id=' . $id);
if (!$assinatura->getTotalRows())
    exit;
$dados = $assinatura->getResults();

$pagseguro = new Pagseguro();


if (PAG_AMBIENTE == "sandbox") {
    $pagseguro->setAuth(PAG_USUARIO, PAG_TOKEN_SAND);
} else {
    $pagseguro->setAuth(PAG_USUARIO, PAG_TOKEN_PROD);
}
$pagseguro->setEnviroment(PAG_AMBIENTE);


$data_fim = Date('Y-m-d\TH:i:s\.\0\0\0\-\0\3\:\0\0', strtotime("+" . intval($dados['meses']) - 1 . " months"));

$assinatura = array(
    'charge' => 'auto',
    'name' => $dados['nome_assinatura'],
    'details' => $dados['descricao'],
    'amountPerPayment' => $dados['valor'],
    'period' => 'Monthly',
    'finalDate' => $data_fim,
    'maxTotalAmount' => number_format(floatval($dados['valor']) * intval($dados['meses']), 2, '.', '')
);

$endereco = array(
    'street' => $dados['rua'],
    'number' => $dados['numero'],
    'complement' => $dados['complemento'],
    'district' => $dados['estado'],
    'postalCode' => $dados['cep'],
    'city' => $dados['cidade'],
    'state' => $dados['estado'],
    'country' => 'BRA'
);
$fone = array(
    'areaCode' => $dados['ddd'],
    'number' => $dados['telefone']
);
//$pagseguro->setAuth('c.prates@yahoo.com.br', 'CF9804A85E4445809C64443EE5F69834');
//$pagseguro->setEnviroment('sandbox');
$pagseguro->setRedirectUrl('http://www.interacao.gani.org.br');
$pagseguro->setNotificationUrl('http://www.interacao.gani.org.br');

$pagseguro->setReference($dados['referencia']);
$pagseguro->setSender($dados['nome'], $dados['email'], $fone, $endereco);
$pagseguro->setPreApproval($assinatura);
$retorno = $pagseguro->sendRequest();
if ($retorno) {
    //echo $retorno;
    $pagseguro->redirect($retorno);
} else {
    echo $pagseguro->error();
}
die();