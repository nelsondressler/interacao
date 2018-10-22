<?php

require_once 'bootstrap.php';

$cod_cli_parcelas = (integer) Security::decripty($_REQUEST['p']);
if (!$cod_cli_parcelas) exit;

$plano    = new SitePlanosAction();
$bcash    = new BCash();
$shopline = new ItauShopline();

$row_dados = $plano->parcelaDados($cod_cli_parcelas);
$plano->setPagamento($cod_cli_parcelas, 'BCash');

$row_dados = $plano->parcelaDados($cod_cli_parcelas);

if ($row_dados['pagamento']=='BCash') {
  $pagamento_form = $bcash->checkout($row_dados);
    
} else if ($row_dados['pagamento']=='Itau-Shopline') {
  //$pagamento_form = $shopline->checkout($row_dados);
  
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<body>

<?php echo $pagamento_form ?>

</body>

<script type="text/javascript">
document.frm_pagamento.submit();
</script>

</html>