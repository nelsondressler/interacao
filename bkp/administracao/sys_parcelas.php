<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Administrar parcelas');
SystemLayout::setModule('sys_parcelas');

SystemLayout::addNavigate('Administrar parcelas');
SystemLayout::addNavigate('Parcelas');

SystemLayout::setBack('home.php');
SystemLayout::setSubTitle($row_cliente['nome']);

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$parcela  = new ParcelasAction();

if ($_REQUEST['acao'] == 'status_pago') {
  
  if ( SystemLayout::getPermissao(3) ) {
    $parcela->mudaStatus($_REQUEST['cod']);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/js/date_input/date_input.css"/>
<script type="text/javascript" src="assets/js/date_input/jquery.date_input.js"></script>

<script type="text/javascript">
function alterar() {

  msg = confirm("* ATENÇÃO *\n\nDeseja realmente dar baixa nas parcelas selecionadas?");
  if(msg) {
    
    for (var i=0; i< $(f['cod[]']).length; i++) {
      $(f['cod[]'])[i].checked = true;
    }
    
    f.acao.value = 'status_pago';
    f.submit();
  }

}

function enviarCobranca() {

  if(confirm("* ATENÇÃO *\n\nDeseja realmente enviar os e-mails de cobrança para as parcelas selecionadas?")){
    
    f.acao.value = 'envia_cobranca_unica';
    modalProcessing('Aguarde, enviando emails ...');

    $.ajax({
      data: $(f).serialize(),
      success: function() {
        $.modal.close();
        f.acao.value = '';
        alert('E-mails enviados.')
      }
    });
    
  }
}

$(function($) {
  
  $('#data1').mask("99/99/9999");
  $('#data1').date_input();

  $('#data2').mask("99/99/9999");
  $('#data2').date_input();

  //$('#cpf').numeric();
  
});
</script>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<div id="painel_geral">
<table width="100%" cellspacing="0" cellpadding="0">
<form name="frm_busca" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
 <tr>
   <td height="25" class="input_title">N&uacute;mero do pedido:</td>
   <td width="180" height="25" class="input_title">CPF do cliente</td>
   <td width="200" class="input_title">Entre data de vencimento:</td>
   <td height="25" align="right">&nbsp;</td>
 </tr>
 <tr>
   <td height="25"><input name="num_pedido" type="text" class="input_text" id="num_pedido" value="<?php echo $_REQUEST['num_pedido'] ?>" size="20" /></td>
   <td height="25">
     <input name="cpf" type="text" class="input_text" id="cpf" value="<?php echo $_REQUEST['cpf'] ?>" size="20" />
   </td>
   <td height="25">
   de <input name="data1" type="text" class="input_text" id="data1" value="<?php echo $_REQUEST['data1'] ?>" size="10" /> at&eacute;
     <input name="data2" type="text" class="input_text" id="data2" value="<?php echo $_REQUEST['data2'] ?>" size="10" />
   </td>
   <td height="25" align="right">
     <input name="Button" type="button" class="botao_cancelar" value="Limpar" onclick="limparBusca()" />
     <input name="Submit" type="submit" class="botao_busca" value="Busca" />
   </td>
 </tr>
</form>
</table>
</div>

<?php
if ($_REQUEST['num_pedido'] || $_REQUEST['cpf']  || ($_REQUEST['data1'] && $_REQUEST['data2'])) {
  
  $row_baixa = $parcela->listaParcelas($_POST);
  $total = count($row_baixa);
  
  if ($total > 0) {
  ?>
  <br>
  <div id="painel_acoes">
    <?php
    if ( SystemLayout::getPermissao(3) ) {
      echo '<input type="button" onclick="alterar()" class="botao_ok" value="Marcar como pago" /> &nbsp;';
    }
    echo '<input type="button" onclick="enviarCobranca()" class="botao_email" value="Enviar e-mail decobrança" /> &nbsp;';
    ?>
  </div>
  <table width="783" border="0" cellpadding="0" cellspacing="0" class="table_grid">
    
    <form name="frm" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
    <tr class="table_grid_top">
      <td>Cliente</td>
      <td>Vencimento</td>
      <td>Valor</td>
      <td>N&ordm; Pedido</td>
      <td>Forma</td>
      <td>Transa&ccedil;&atilde;o</td>
      <td>Status</td>
      <td width="25" align="center">
        <?php
        if ( SystemLayout::getPermissao(4) ) {
          echo '<input type="checkbox" onclick="selecionarTodos(this,f)" name="checkbox" /> ';
        }
        ?>
      </td>
    </tr>
    
      <?php foreach ($parcela->listaParcelas($_POST) as $row) { ?>
      <tr>
        <td valign="top"><?php echo $row['nome'] ?><br>CPF: <?php echo $row['cpf'] ?></td>
        <td valign="top"><?php echo Date::timestampToBr($row['data_vencimento']) ?></td>
        <td valign="top">
          R$ <?php echo Number::formatCurrencyBr($row['valor_total']) ?></td>
        <td valign="top"><?php echo $row['num_pedido'] ?></td>
        <td valign="top"><?php echo $row['pagamento'] .'('. $row['pagamento_nome'] .')<br>'. $row['pagamento_status'] ?></td>
        <td valign="top"><?php echo $row['pagamento_id'] ?></td>
        <td valign="top">
          <strong style="color:<?php echo '#'. Useful::statusCor($row['cod_status']) ?>"><?php echo $row['status'] ?></strong>
        </td>
        <td align="center" valign="top">
          <?php
          if ( SystemLayout::getPermissao(4) ) {
            echo '<input type="checkbox" name="cod[]" value="'. $row['cod_cli_parcelas'] .'" />';
          }
          ?>
        </td>
      </tr>
      <?php
    }
    ?>
    <input type="hidden" name="acao" value="">
    <?php echo Useful::convertRequestToHidden(array('acao')) ?>
    </form>
  </table>
  
  <div id="painel_acoes">
    <?php
    if ( SystemLayout::getPermissao(3) ) {
      echo '<input type="button" onclick="alterar()" class="botao_ok" value="Marcar como pago" /> &nbsp;';
    }
    echo '<input type="button" onclick="enviarCobranca()" class="botao_email" value="Enviar e-mail decobrança" /> &nbsp;';
    ?>
  </div>
  
  <?php
  } else {
    ?>
    <table width="783" border="0" cellpadding="0" cellspacing="0" class="table_form">
      <tr>
        <td height="100" align="center" class="sub_titulo">Nenhum registro encontrado!</td>
      </tr>
    </table>
    <?php
  }
} else {
?>
<table width="783" border="0" cellpadding="0" cellspacing="0" class="table_form">
  <tr>
    <td height="100" align="center" class="sub_titulo">Digite acima os dados para fazer a busca.</td>
  </tr>
</table>
<?php
}
?>

<script type="text/javascript">
var f = document.frm;

<?php
if ($parcela->getReturnMensage()) {
  echo 'alert("'. $parcela->getReturnMensage() .'");';
}
?>
</script>

<?php require 'assets/blocks/body_fecha.php'; ?>