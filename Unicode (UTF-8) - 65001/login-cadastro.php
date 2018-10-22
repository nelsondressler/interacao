<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require_once 'bootstrap.php';

$cod = (integer) $_SESSION["site_cod_cliente"];

if ($cod) {
  header ("Location: planos-comprar.php");
  exit;
}

$cliente = new SiteClientesAction();

if ($_REQUEST['acao']=='inserir') {
  
  $cliente->grava(true, $_POST);
  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9">
<title>InterA&Ccedil;&Atilde;O</title>

<?php include 'assets/includes/js_css.php' ?>
<script type="text/javascript" src="assets/js/cpf_cnpj.js"></script>
<script type="text/javascript" src="assets/js/formulario.js"></script>
<script type="text/javascript" src="assets/js/jquery_maskedinput.js"></script>

<script type="text/javascript">
function validaDados() {

  if(validaTexto(fc.nome)) {
    return abreAlerta("Digite o Nome.");
  }

  if(validaCpf(fc.cpf)) {
    return abreAlerta("Digite um CPF correto.");
  }

  if(validaTexto(fc.telefone)) {
    return abreAlerta("Digite um Telefone.");
  }

  if(validaTexto(fc.endereco)) {
    return abreAlerta("Digite o Endereço.");
  }
  
  if(validaTexto(fc.numero)) {
    return abreAlerta("Digite o Número do endereço.");
  }
  
  if(validaTexto(fc.cidade)) {
    return abreAlerta("Digite a Cidade.");
  }
  
  if(validaSelecao(fc.estado)) {
    return abreAlerta("Escolha um estado.");
  }
  
  if(validaCep(fc.cep)) {
    return abreAlerta("Digite o CEP.");
  }
  
  if(validaEmail(fc.email)) {
    return abreAlerta("Digite o e-mail.");
  }

  if(validaTexto(fc.senha)) {
    return abreAlerta("Digite a Senha.");
  }

  verificaEmail();
  
}

function escolheIndicacao(cod) {

  var texto = '';
  
  $('input[name=indicacao_qual]').hide();
  $('#indicacao_texto').hide();    $('input[name=indicacao_quando]').hide();    $('#indicacao_texto_de').hide();

  if (cod) {

    if (cod=='1') {
      texto = ' &nbsp; Nome:';
    } else if (cod=='2') {
      texto = ' &nbsp; Nome:';
    } else if (cod=='3') {
      texto = ' &nbsp; Qual:';
    } else if (cod=='4') {
      texto = ' &nbsp; De:';
    } else if (cod=='5') {      texto = ' &nbsp; Qual:';    }
    	if (cod=='4') {	  texto2 = 'Até:';      $('input[name=indicacao_quando]').show();	  $('#indicacao_texto_de').show();	  $('#indicacao_texto_de').html(texto2);    }
    $('#indicacao_texto').show();
    $('#indicacao_texto').html(texto);
    $('input[name=indicacao_qual]').show();
    
  }
  
}

function verificaEmail() {

  $('#load_cadastro').show();
  
  $.ajax({
    type: "POST",
    data: $(fc).serialize(),
    success: function(resposta) {
      $('#load_cadastro').hide();
      if(resposta) {
        alert(resposta)
      } else {
        fc.acao.value = 'inserir';
        fc.submit();
      }
    }
  });
  
}

function verificaLogin() {

  if(validaTexto(fl.email)) {
    return abreAlerta('Digite seu E-mail.');
  }
  
  if(validaTexto(fl.senha)) {
    return abreAlerta('Digite sua Senha');
  }

  $('#load_login').show();
  $.ajax({
    data: $(frm_login).serialize(),
    success: function(resposta) {
      $('#load_login').hide();
      if(resposta) {
        alert(resposta);
      } else {
        window.location = 'planos-comprar.php';
      }
    }
  });
  
}

function lembrarSenha() {
  
  if(validaEmail(fl.email)) {
    return abreAlerta('Digite seu E-mail');
  }

  fl.acao.value = 'lembra_senha';
  $('#load_senha').show();
  
  $.ajax({
    data: $(frm_login).serialize(),
    success: function(resposta) {
      resposta = trim(resposta);
      if(resposta) {
        $('#load_senha').hide();
        alert(resposta);
        fl.acao.value = 'site_login';
      }
    }
  });
  
}


$(function($) {

  $('input[name=indicacao_qual]').hide();
  $('#indicacao_texto').hide();
  $('input[name=indicacao_qual]').val('');
  $('input[name=cep]').mask("99999-999");

  
  
});
</script>
</head>

<body>
  <table width="100%" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="header">
        <?php include 'assets/includes/topo1.php' ?>
      </td>
    </tr>
  </table>
  <table width="980" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="75">&nbsp;</td>
    </tr>
  </table>
  <table width="980" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="bg_top_main2"><table width="972" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="td_main5">adquirindo plano da intera&ccedil;&atilde;o <br /> <span class="td_main2">A&ccedil;&atilde;o entre amigos </span></td>
            <td class="td_main1">conhe&ccedil;a os Planos <br /> <span class="td_main2">Compre o seu plano ON-LINE</span></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width="4">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFFF">
      
<?php if (!$cliente->getReturnCode()) { ?>
        <table width="100%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6"><span class="texto_destaque2">se voc&ecirc; j&aacute; &eacute; s&oacute;cio da intera&ccedil;&atilde;o, digite seu login e senha</span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><table width="558" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="368" valign="top">
                  
                  <form id="frm_login" name="frm_login" method="post" action="<?php echo System::thisFile() ?>" onsubmit="return false">
                      <table width="368" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="80" class="texto_form">E-mail:</td>
                          <td colspan="3" class="texto_form"><input name="email" type="text" class="form" id="email" /></td>
                        </tr>
                        <tr>
                          <td width="80" class="texto_form">Senha:</td>
                          <td width="160" class="texto_form"><input name="senha" type="password" class="form" id="senha" /></td>
                          <td width="21" align="center"></td>
                          <td width="107" align="center">
                            <input name="button" type="button" class="form" id="button" value="OK" onclick="verificaLogin()" style="width: 50px" />
                            <img src="assets/images/load1.gif" name="load_cadastro" align="absmiddle" id="load_login" style="display: none" />
                            <input type="hidden" name="acao" value="site_login" />
                          </td>
                        </tr>
                      </table>
                    </form>
                    
                  </td>
                  <td width="190" align="center">
                  <a href="javascript:void(0)" onclick="lembrarSenha()" class="link-esqueci-senha">Esqueci minha senha</a>
                  <img src="assets/images/load1.gif" name="load_senha" align="absmiddle" id="load_senha" style="display: none" />
                  </td>
                </tr>
                <tr>
                  <td colspan="2" valign="top" class="td_line">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6"><span class="texto_destaque2">se voc&ecirc; ainda n&atilde;o &eacute; s&oacute;cio da intera&ccedil;&atilde;o, preencha o cadastro abaixo e siga o passo a passo para efetuar o pagamento</span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><table width="558" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="368" valign="top">
                  
                    <form id="frm_cadastro" name="frm_cadastro" method="post" action="<?php echo System::thisFile() ?>" onsubmit="return false">
                      <table width="500" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td colspan="3" class="texto_form_titulo">Dados Gerais</td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Nome:</td>
                          <td height="25" colspan="2" class="texto_form">
                            <input name="nome" type="text" class="form" id="nome" value="<? echo $_POST['nome'] ?>" maxlength="100" />

                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">CPF:</td>
                          <td height="25" colspan="2" class="texto_form">
                            <input name="cpf" type="text" class="form" id="cpf" value="<? echo $_POST['cpf'] ?>" size="12" maxlength="12" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Telefone:</td>
                          <td height="25" colspan="2" class="texto_form">
                            <input name="telefone" type="text" class="form" id="telefone" value="<? echo $_POST['telefone'] ?>" size="20" maxlength="20" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Celular:</td>
                          <td height="25" colspan="2" class="texto_form">
                            <input name="celular" type="text" class="form" id="celular" value="<? echo $_POST['celular'] ?>" size="20" maxlength="20" />
                          </td>
                        </tr>
                        <tr>
                          <td height="25" class="texto_form">Indica&ccedil;&atilde;o:</td>
                          <td width="171" height="25" class="texto_form">
                              
                              <?php echo Html::select('indicacao', ClienteHelper::getIndicacoes(), 'nome', 'cod', $row['indicacao'], 'form', 'escolheIndicacao(this.value)') ?>
                              
                              
                          </td>
                          <td width="229" class="texto_form">
                          <span id="indicacao_texto">&nbsp;</span>
                              <input name="indicacao_qual" type="text" value="<?php echo $row['indicacao_qual'] ?>" style="width:150px" maxlength="100" class="form" /></td></tr>						<tr>							<td width="71" height="25" class="texto_form"></td>							<td width="171" height="25" class="texto_form"></td>							<td width="229" height="25" class="texto_form">							<span id="indicacao_texto_de">&nbsp;</span>							<input name="indicacao_quando" type="text" style="width: 150px; display: none;" style="width:150px" maxlength="100" class="form" /></td>
                        </tr>
                      </table>
                      <br />
                      <table width="500" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td height="30" colspan="3" class="texto_form_titulo">Endere&ccedil;o</td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">CEP:</td>
                          <td width="166" height="25">
                            <input name="cep" type="text" class="form" id="cep"  value="<? echo $_POST['cep'] ?>" size="9" maxlength="9" />
                          </td>
                          <td height="25" align="right">&nbsp;<img src="assets/images/load1.gif" name="cep_carregando" align="absmiddle" id="cep_carregando" style="display: none" /> &nbsp;<a href="javascript:void(0)" class="link-esqueci-senha" onclick="return pegaEndereco(fc)">Consultar</a> | <a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank" class="link-esqueci-senha">N&atilde;o sei o CEP</a></td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Endere&ccedil;o:</td>
                          <td height="25" colspan="2">
                            <input name="endereco" type="text" class="form" id="endereco" value="<? echo $_POST['endereco'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">N&uacute;mero:</td>
                          <td height="25" colspan="2">
                            <input name="numero" type="text" class="form" id="numero" value="<? echo $_POST['numero'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Complemento:</td>
                          <td height="25" colspan="2">
                            <input name="complemento" type="text" class="form" id="complemento" value="<? echo $_POST['complemento'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Estado:</td>
                          <td height="25" colspan="2"><?php echo Useful::selectEstados('estado', $_POST['estado'], 'form') ?></td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Cidade:</td>
                          <td height="25" colspan="2">
                            <input name="cidade" type="text" class="form" id="cidade" value="<? echo $_POST['cidade'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Bairro:</td>
                          <td height="25" colspan="2">
                            <input name="bairro" type="text" class="form" id="bairro" value="<? echo $_POST['bairro'] ?>" maxlength="100" />
                          </td>
                        </tr>
                      </table>
                      <br />
                      <table width="500" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td height="30" colspan="2" class="texto_form_titulo">Dados para o login</td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">E-mail:</td>
                          <td height="25">
                            <input name="email" type="text" class="form" id="email" value="<? echo $_POST['email'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td height="25" class="texto_form">Senha:</td>
                          <td height="25">
                            <input name="senha" type="password" class="form" id="senha" value="<? echo $_POST['senha'] ?>" size="20" maxlength="20" />
                          </td>
                        </tr>
                      </table>
                      
                      <input type="hidden" name="acao" value="verifica_email" />
                  </form>
                  
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6"><table align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="button_cp">
                  <a href="javascript:void(0)" onclick="validaDados()">pr&oacute;ximo <img src="assets/images/load2.gif" name="load_cadastro" align="absmiddle" id="load_cadastro" style="display: none" /></a>
                  
                  </td>
                </tr>
              </table></td>
          </tr>
        </table>
        
<?php } else { ?>
        
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="td_main8">
              
              <?php if ($cliente->getReturnCode() == 'email-existe') { ?>
                
                <p class="texto_form_mensagens">O e-mail digitado já esta cadastrado!</p>
                <br>
                
                <p>
                <table align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="button_cp"> <a href="javascript:document.frm_voltar.submit()" >Voltar ao cadastro</a> </td>
                  </tr>
                </table>
                </p>
                
                <form action="<?php echo System::thisFile() ?>" name="frm_voltar" method="post">
                <?php echo Useful::convertRequestToHidden(array('acao')) ?>
                </form>
              
              <?php } if ($cliente->getReturnCode() == 'campos-invalidos') { ?>
              
                <p class="texto_form_mensagens">Existem campos em branco!</p>
                <br>
                
                <p>
                <table align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="button_cp"> <a href="javascript:document.frm_voltar.submit()" >Voltar ao cadastro</a> </td>
                  </tr>
                </table>
                </p>
                
                <form action="<?php echo System::thisFile() ?>" name="frm_voltar" method="post">
                <?php echo Useful::convertRequestToHidden(array('acao')) ?>
                </form>
              
              <?php } if ($cliente->getReturnCode() == 'cadastro-incluido') { ?>
              
                <p class="texto_form_mensagens">
                <?php echo $_SESSION["site_nome_cliente"] ?>, seu cadastro foi efetuado com sucesso! <br />
                Clique em &quot;Continuar&quot;
                para escolher os planos que voc&ecirc; deseja adquirir.</p>
                <br>
                 
                <p>
                <table align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="button_cp"> <a href="planos-comprar.php">Continuar</a> </td>
                  </tr>
                </table>
                </p>
                
              <?php } ?>
              
            </td>
          </tr>
        </table>
        
<?php } ?>
      </td>
      <td width="324" valign="top" bgcolor="#FFFFFF"><table width="300" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100" height="34" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td class="texto_destaque3">Compre os Planos da InterA&Ccedil;&Atilde;O On-Line e escolha pagar atrav&eacute;s do Pagseguro.</td>
          </tr>
          <tr>
            <td align="center"><img src="assets/images/planos/pagseguro.png" alt="" width="120" height="133" /></td>
          </tr>
        </table>
        <?php include 'assets/includes/lateral.php' ?>
      </td>
      <td width="4">&nbsp;</td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#FFFFFF" class="td_line">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" valign="top" bgcolor="#FFFFFF">
        <?php include 'assets/includes/rodape1.php' ?>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div id="footer">
    <table width="900" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="40" valign="bottom" class="texto-footer"><nobr> <a href="index.php" class="link-footer">Home</a> | <a href="quem-somos.php" class="link-footer">Quem Somos </a> | <a href="plano-ferias.php" class="link-footer">Plano F&eacute;rias </a> | <a href="plano-luz.php" class="link-footer">Plano Luz </a> | <a href="plano-arte.php" class="link-footer">Plano Arte </a> | <a href="duvidas.php" class="link-footer">Dúvidas </a> | <a href="contato.html" class="link-footer">Contato </a> | <a
            href="area-restrita.html" class="link-footer">Área Restrita </a>
        
        </td>
      </tr>
      <tr>
        <td height="40" class="texto-footer">InterA&Ccedil;&Atilde;O © 2013 - Todos os direitos reservados | <a href="http://www.nannydesign.com.br/" target="_blank" class="link-nyd">Design by Nannydesign</a></td>
      </tr>
    </table>
  </div>
  
  </footer>
  
</body>

<script type="text/javascript">
var fl = document.frm_login;
var fc = document.frm_cadastro;
</script>

</html>
