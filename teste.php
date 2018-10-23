<?php

require_once 'bootstrap.php';


$dado='96g2w2g243d2t2q2r2t2x2u2w2r2c2l2c2m4e2f4p333x2n3t4';

$plano = new SitePlanosAction();
$post=$plano->decodificaPostInserir($dado);

print_r($post);


die();

$referencia="assinatura-96g2w2g243d2s2q2r213p2u2w2r2c2l2c2m4e2f4p333x2n3t4";
$code="4F7C4B46-CE7A-400B-BDF0-559615655B6E";

$retorno = <<<EOD
<transaction>
        <reference>$referencia</reference>
        <status>3</status>
        <code>$code</code>
</transaction>
EOD;

$plano = new SitePlanosAction();

$xml=simplexml_load_string($retorno);

$plano->setAvisoPagseguroTeste($xml);