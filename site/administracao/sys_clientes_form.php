<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Clientes');
SystemLayout::setModule('sys_clientes');

SystemLayout::addNavigate(SystemLayout::getTitle(), SystemLayout::getModule() .'.php');
SystemLayout::addNavigate('Cadastro');
SystemLayout::setBack( SystemLayout::getModule() .'.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$clientes = new ClientesAction();
$cod     = $_REQUEST['cod'];

// Inclui
if ($_POST['acao'] == 'incluir') {
  
  if ( SystemLayout::getPermissao(2) ) {
    $clientes->grava(true, array_merge($_POST, $_FILES));
  }
  
  
// Altera
} else if ($_POST['acao'] == 'alterar') {
  
  if ( SystemLayout::getPermissao(3) ) {
    $clientes->grava(false, array_merge($_POST, $_FILES));
  }
  
// Outros
} else {

  if ($cod) {
    $row = $clientes->exibe($cod);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<script type="text/javascript">
function validaDados(f) {

  if(validaSelecao(f.cod_status)) {
    return abreAlerta("Escolha o Status.");
  }
  
  if(validaTexto(f.nome)) {
    return abreAlerta("Digite o Nome.");
  }

  if(validaCpf(f.cpf)) {
    return abreAlerta("Digite um CPF correto.");
  }

  if(validaTexto(f.telefone)) {
    return abreAlerta("Digite um Telefone.");
  }

  if(validaTexto(f.endereco)) {
    return abreAlerta("Digite o Endereço.");
  }
  
  if(validaTexto(f.numero)) {
    return abreAlerta("Digite o Número do endereço.");
  }
  
  if(validaTexto(f.cidade)) {
    return abreAlerta("Digite a Cidade.");
  }
  
  if(validaSelecao(f.estado)) {
    return abreAlerta("Escolha um estado.");
  }
  
  if(validaCep(f.cep)) {
    return abreAlerta("Digite o CEP.");
  }
  
  if(validaEmail(f.email)) {
    return abreAlerta("Digite o e-mail.");
  }

  if(validaTexto(f.senha)) {
    return abreAlerta("Digite a Senha.");
  }
  
  modalProcessing('Aguarde ...');
  
}

function escolheIndicacao(cod) {

  var texto = '';
  
  $('input[name=indicacao_qual]').hide();
  $('#indicacao_texto').hide();

  if (cod) {

    if (cod=='1') {
      texto = ' Nome:';
    } else if (cod=='2') {
      texto = ' Nome:';
    } else if (cod=='3') {
      texto = ' Qual:';
    } else if (cod=='4') {
      texto = ' Qual:';
    }
      
    $('#indicacao_texto').show();
    $('#indicacao_texto').html(texto)
    $('input[name=indicacao_qual]').show();
    
  }
  
}

$(function($) {

  $('input[name=cep]').mask("99999-999");
  $('input[name=indicacao_qual]').hide();
  $('#indicacao_texto').hide();
  escolheIndicacao('<? echo $row['indicacao'] ?>');
  
});
</script>

<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<?php
if ($clientes->getReturnMensage()) {
  
  echo SystemLayout::msgBox($clientes->getReturnMensage());
  
} else {
?>
<br>

<form name="frm" action="<?php echo System::thisFile() ?>" method="post" onSubmit="return validaDados(this)" enctype="multipart/form-data">
<div id="painel_geral">
  Campos na cor cinza, são obrigatórios
</div>

  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>Dados gerais</td>
    </tr>
  </table>
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <?php if ($cod) { ?>
    <tr>
      <td width="100" height="30" class="input_title">Data cadastro:</td>
      <td width="712" height="30"><?php echo Date::timestampToBr($row['data_cadastro']) ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td width="100" height="30" class="input_title">Status:</td>
      <td height="30"><?php echo Html::select('cod_status', $clientes->listaStatus(), 'status', 'cod_status', $row['cod_status'], 'requerido') ?></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Nome: </td>
      <td height="30"><input name="nome" type="text" class="requerido" id="nome" value="<? echo $row['nome'] ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <td height="30" class="input_title">CPF:</td>
      <td height="30"><input name="cpf" type="text" class="requerido" id="cpf" value="<? echo $row['cpf'] ?>" size="12" maxlength="12" /></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Telefone:</td>
      <td height="30"><input name="telefone" type="text" class="requerido" id="telefone" value="<? echo $row['telefone'] ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Celular:</td>
      <td height="30">
        <input name="celular" type="text" id="celular" value="<? echo $row['celular'] ?>" size="20" maxlength="20" />
      </td>
    </tr>
    <tr>
      <td height="30" class="input_title">Indica&ccedil;&atilde;o:</td>
      <td height="30">
        <?php echo Html::select('indicacao', ClienteHelper::getIndicacoes(), 'nome', 'cod', $row['indicacao'], '', 'escolheIndicacao(this.value)') ?>
        
        <span id="indicacao_texto"></span>
        <input name="indicacao_qual" type="text" value="<? echo $row['indicacao_qual'] ?>" size="30" maxlength="100" />
        
      </td>
    </tr>
  </table>
  <br />
  
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>Endere&ccedil;o</td>
    </tr>
  </table>
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td width="100" height="30" class="input_title">CEP:</td>
      <td height="30">
        <input name="cep" type="text" id="cep" class="requerido"  value="<? echo $row['cep'] ?>" size="10" maxlength="9" />
        <img src="assets/img/aguarde2.gif" name="cep_carregando" align="absmiddle" id="cep_carregando" style="display: none" />
        <a href="javascript:void(0)" class="color" onclick="return pegaEndereco(f)">Consultar</a> |
        <a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank" class="color">N&atilde;o sei o CEP</a> </td>
    </tr>
    <tr>
      <td height="30" class="input_title">Endere&ccedil;o:</td>
      <td height="30">
        <input name="endereco" type="text" class="requerido" id="endereco" value="<? echo $row['endereco'] ?>" size="100" maxlength="100" />
      </td>
    </tr>
    <tr>
      <td height="30" class="input_title">N&uacute;mero:</td>
      <td height="30">
        <input name="numero" type="text" class="requerido" id="numero" value="<? echo $row['numero'] ?>" size="50" maxlength="100" />
      </td>
    </tr>
    <tr>
      <td height="30" class="input_title">Complemento:</td>
      <td height="30">
        <input name="complemento" type="text" id="complemento" value="<? echo $row['complemento'] ?>" size="50" maxlength="100" />
      </td>
    </tr>
    <tr>
      <td height="30" class="input_title">Estado:</td>
      <td height="30"><?php echo Useful::selectEstados('estado', $row['estado'], 'requerido') ?></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Cidade:</td>
      <td height="30">
        <input name="cidade" type="text" class="requerido" id="cidade" value="<? echo $row['cidade'] ?>" size="100" maxlength="100" />
      </td>
    </tr>
    <tr>
      <td height="30" class="input_title">Bairro:</td>
      <td height="30">
        <input name="bairro" type="text" id="bairro" value="<? echo $row['bairro'] ?>" size="100" maxlength="100" />
      </td>
    </tr>
  </table>
  <br />
  
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>Dados para o login</td>
    </tr>
  </table>
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td width="100" height="30" class="input_title">E-mail:</td>
      <td height="30">
        <input name="email" type="text" class="requerido" id="email" value="<? echo $row['email'] ?>" size="100" maxlength="100" />
      </td>
    </tr>
    <tr>
      <td height="30" class="input_title">Senha:</td>
      <td height="30">
        <input name="senha" type="password" class="requerido" id="senha" value="<? echo $row['senha'] ?>" size="20" maxlength="20" />
      </td>
    </tr>
  </table>
  <?php
  $acao = '';
    
  if ( SystemLayout::getPermissao(2) && !$cod) {
    $botao_submit = 'Incluir';
    $acao         = 'incluir';
  }
    
  if ( SystemLayout::getPermissao(3) && $cod) {
    $botao_submit = 'Alterar';
    $acao         = 'alterar';
  }
  
  if ($acao) {
    echo '<div id="painel_submit">
    <input name="button" type="submit" class="botao_submit" value="'. $botao_submit .'" />
    <input type="hidden" name="acao" value="'. $acao .'">
    <input type="hidden" name="cod" value="'. $cod .'">
    </div>';
  }
  ?>
  
</form>
  
  <script type="text/javascript">
  var f = document.frm;
  </script>
  
  <?php
}
?>

<?php require 'assets/blocks/body_fecha.php'; ?>