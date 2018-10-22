<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

require_once 'bootstrap.php';
require_once SYS_PATH.'app/components/PagSeguroLibrary/PagSeguroLibrary.php';

$cod_cli_parcelas = (integer) Security::decripty($_REQUEST['p']);
if (!$cod_cli_parcelas) exit;

$plano    = new SitePlanosAction();
$paymentRequest = new PagSeguroPaymentRequest();

$row_dados = $plano->parcelaDados($cod_cli_parcelas);
//$plano->setPagamento($cod_cli_parcelas, 'BCash');

$row_dados = $plano->parcelaDados($cod_cli_parcelas);

$planos=array();
$total=0;
foreach ($row_dados['planos'] as $plano){
    $planos[]=$plano['plano'];
    $total+=$plano['valor'];
}
$planos = implode(', ', $planos);

$paymentRequest->setCurrency("BRL");
$paymentRequest->addItem(1, "Pagamento da Assinatura dos planos: $planos", 1, $total);
$paymentRequest->setReference('pagamento-'.$cod_cli_parcelas);
$paymentRequest->setShipping(3);
$paymentRequest->setRedirectUrl("http://www.interacao.gani.org.br/pagseguro-retorno.php");
$paymentRequest->addParameter('notificationURL', 'http://www.interacao.gani.org.br/pagseguro-aviso.php');
$credentials = PagSeguroConfig::getAccountCredentials(); 
$url = $paymentRequest->register($credentials);
header("Location: $url");
