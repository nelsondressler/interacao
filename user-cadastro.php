<?php
require_once 'bootstrap.php';
require_once 'assets/includes/login.php';

$cliente = new SiteClientesAction();

if ($_REQUEST['acao']=='alterar') {
  
  $cliente->grava(false, $_POST);
  
}

$row_cliente = $cliente->exibe($_SESSION["site_cod_cliente"]);

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

  fc.submit();
  
}

function escolheIndicacao(cod) {

  var texto = '';
  
  $('input[name=indicacao_qual]').hide();
  $('#indicacao_texto').hide();

  if (cod) {

    if (cod=='1') {
      texto = ' &nbsp; Nome:';
    } else if (cod=='2') {
      texto = ' &nbsp; Nome:';
    } else if (cod=='3') {
      texto = ' &nbsp; Qual:';
    } else if (cod=='4') {
      texto = ' &nbsp; Qual:';
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
  escolheIndicacao('<? echo $row_cliente['indicacao'] ?>');
  
});
</script>

<script type="text/javascript">

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
            <td class="td_main5">&Aacute;rea restrita<br /> <span class="td_main2">Para sócios</span></td>
            <td class="td_main1">conhe&ccedil;a os Planos <br /> <span class="td_main2">Compre o seu plano ON-LINE</span></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width="4">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFFF">
      
        <table width="100%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="36%" align="left"><span class="texto_destaque2">Seus dados</span></td>
                  <td width="23%" align="right">&nbsp;</td>
                  <td width="26%" align="right"><a href="user-cadastro.php" class="texto_destaque2"><img src="assets/images/icones/adim.png" width="24" height="24" border="0" align="absmiddle" />MeuS Dados</a></td>
                  <td width="15%" align="right"><a href="user-login.php?acao=logoff" class="texto_destaque2"><img src="assets/images/icones/cancel.png" width="24" height="24" border="0" align="absmiddle" />Sair</a></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="td_main8">
              
<?php if (!$cliente->getReturnCode()) { ?>

              <table width="558" align="center" cellpadding="0" cellspacing="0">
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
                            <input name="nome" type="text" class="form" id="nome" value="<? echo $row_cliente['nome'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">CPF:</td>
                          <td height="25" colspan="2" class="texto_form">
                            <? echo Useful::formatCpf($row_cliente['cpf']) ?>
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Telefone:</td>
                          <td height="25" colspan="2" class="texto_form">
                            <input name="telefone" type="text" class="form" id="telefone" value="<? echo $row_cliente['telefone'] ?>" size="20" maxlength="20" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Celular:</td>
                          <td height="25" colspan="2" class="texto_form">
                            <input name="celular" type="text" class="form" id="celular" value="<? echo $row_cliente['celular'] ?>" size="20" maxlength="20" />
                          </td>
                        </tr>
                        <tr>
                          <td height="25" class="texto_form">Indica&ccedil;&atilde;o:</td>
                          <td width="171" height="25" class="texto_form">
                              
                              <?php echo Html::select('indicacao', ClienteHelper::getIndicacoes(), 'nome', 'cod', $row_cliente['indicacao'], 'form', 'escolheIndicacao(this.value)') ?>
                              
                          </td>
                          <td width="229" class="texto_form"><span id="indicacao_texto">&nbsp;</span>
                              <input name="indicacao_qual" type="text" value="<? echo $row_cliente['indicacao_qual'] ?>" style="width:150px" maxlength="100" class="form" /></td>
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
                            <input name="cep" type="text" class="form" id="cep"  value="<? echo $row_cliente['cep'] ?>" size="9" maxlength="9" />
                          </td>
                          <td height="25" align="right">&nbsp;<img src="assets/images/load1.gif" name="cep_carregando" align="absmiddle" id="cep_carregando" style="display: none" /> &nbsp;<a href="javascript:void(0)" class="link-esqueci-senha" onclick="return pegaEndereco(fc)">Consultar</a> | <a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank" class="link-esqueci-senha">N&atilde;o sei o CEP</a></td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Endere&ccedil;o:</td>
                          <td height="25" colspan="2">
                            <input name="endereco" type="text" class="form" id="endereco" value="<? echo $row_cliente['endereco'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">N&uacute;mero:</td>
                          <td height="25" colspan="2">
                            <input name="numero" type="text" class="form" id="numero" value="<? echo $row_cliente['numero'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Complemento:</td>
                          <td height="25" colspan="2">
                            <input name="complemento" type="text" class="form" id="complemento" value="<? echo $row_cliente['complemento'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Estado:</td>
                          <td height="25" colspan="2"><?php echo Useful::selectEstados('estado', $row_cliente['estado'], 'form') ?></td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Cidade:</td>
                          <td height="25" colspan="2">
                            <input name="cidade" type="text" class="form" id="cidade" value="<? echo $row_cliente['cidade'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="25" class="texto_form">Bairro:</td>
                          <td height="25" colspan="2">
                            <input name="bairro" type="text" class="form" id="bairro" value="<? echo $row_cliente['bairro'] ?>" maxlength="100" />
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
                            <input name="email" type="text" class="form" id="email" value="<? echo $row_cliente['email'] ?>" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td height="25" class="texto_form">Senha:</td>
                          <td height="25">
                            <input name="senha" type="password" class="form" id="senha" value="<? echo $row_cliente['senha'] ?>" size="20" maxlength="20" />
                          </td>
                        </tr>
                      </table>
                      <input type="hidden" name="acao" value="alterar" />
                      <input type="hidden" name="cpf" value="1" />
                    </form>
                  </td>
                </tr>
              </table>
              <br />
              <table align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="button_cp"> <a href="javascript:void(0)" onclick="validaDados()">Alterar <img src="assets/images/load2.gif" name="load_cadastro" align="absmiddle" id="load_cadastro" style="display: none" /></a> </td>
                </tr>
              </table>
              
<?php } else { ?>
        
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="td_main8">
              
              <?php if ($cliente->getReturnCode() == 'email-existe') { ?>
                
                <p class="texto_form_mensagens">O e-mail digitado já est&aacute; cadastrado!</p>
                <br>
                
                <p>
                <table align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="button_cp"> <a href="user-cadastro.php" >Voltar ao cadastro</a> </td>
                  </tr>
                </table>
                </p>

              
              <?php } if ($cliente->getReturnCode() == 'campos-invalidos') { ?>
              
                <p class="texto_form_mensagens">Existem campos em branco!</p>
                <br>
                
                <p>
                <table align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="button_cp"> <a href="user-cadastro.php" >Voltar ao cadastro</a> </td>
                  </tr>
                </table>
                </p>
 
              
              <?php } if ($cliente->getReturnCode() == 'cadastro-alterado') { ?>
              
                <p class="texto_form_mensagens">
                <?php echo $_SESSION["site_nome_cliente"] ?>, seu cadastro foi alterado com sucesso!
                </p>
                <br>
                 
                <p>
                <table align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="button_cp"> <a href="user-login.php">Continuar</a> </td>
                  </tr>
                </table>
                </p>
                
              <?php } ?>
              
            </td>
          </tr>
        </table>
        
<?php } ?>
              
              
              </td>
          </tr>
        </table>


      </td>
      <td width="324" valign="top" bgcolor="#FFFFFF"><table width="300" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100" height="34" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td class="texto_destaque3">Compre os Planos da InterA&Ccedil;&Atilde;O On-Line e escolha pagar atrav&eacute;s do Pagseguro.</td>
          </tr>
          <tr>
            <td><table width="300" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center"><img src="assets/images/planos/pagseguro.png" width="120" height="133" /></td>
                </tr>
              </table></td>
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
var fc = document.frm_cadastro;
</script>

</html>
