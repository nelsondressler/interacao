<?php
require_once 'bootstrap.php';
require_once 'assets/includes/login.php';

$plano = new SitePlanosAction();

$_SESSION['insere_planos'] = true;

$total_planos = 0;

foreach ($plano->lista() as $row) {
  $plano_exixte = $plano->planoExiste($row['cod_plano'], $_SESSION["site_cod_cliente"]);
  if (!$plano_exixte) $total_planos ++;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9">
<title>InterA&Ccedil;&Atilde;O</title>

<?php include 'assets/includes/js_css.php' ?>
<script type="text/javascript" src="assets/js/formulario.js"></script>

<script type="text/javascript">
var valores_atuais;

function validaDados() {

  var f = document.frm_planos;
  
  if(validaOpcao(f['cod_plano[]'])) {
    return abreAlerta("Escolha pelo menos 1 plano para prosseguir.");
  }

  
  f.action = 'planos-inserir.php';
  f.acao.value = 'inserir';
  f.submit();
  
}

function getCalculo() {

  var f = document.frm_planos;
  var d = new Date();
  var total = 0;
  var total2 = 0;
  var total3 = 0;
  var x =0;
  
  $('#valor_total').html('0,00');
  
  $('.cod_plano').each( function() {
    $('#descricao'+ $(this).val()).html(valores_atuais[x]);
    x++;
  });
  
  $.ajax({
    dataType: "json",
    data: d.getTime() +'&'+ $(f).serialize(),
    success: function(data) {

      if (data.length > 0){
        for(i=0; i < data.length; i++) {

          if (parseFloat(data[i].desconto) > 0) {
            
            $('#descricao'+ data[i].cod_plano).html('<span>R$ '+ formataPreco(data[i].valor) +' mensais</span>');
            $('#descricao'+ data[i].cod_plano).html('<span style="color:#cc0000"> de <s>R$ '+ formataPreco(data[i].valor) +'</s> por R$ '+ formataPreco(data[i].valor_desconto) +' mensais </span>');
            total += parseFloat(data[i].valor);
			total2 += parseFloat(data[i].valor_desconto);
		
		  } else if (data.length == 3) {

            $('#descricao3').html('<span style="color:#cc0000"> de <s>R$ 108,00</s> por R$ 97,20 mensais </span>');
            $('#descricao4').html('<span style="color:#cc0000"> de <s>R$ 54,00</s> por R$ 48,60 mensais </span>');

            total = 342;		
            
          } else {

            $('#descricao'+ data[i].cod_plano).html(' R$ '+ formataPreco(data[i].valor) +' mensais');
            total += parseFloat(data[i].valor);
            total2 += parseFloat(data[i].valor);

          }
          
        }
      }


      if (total2 < total) {
	  if (total >= 342.00) {
		total2 = 325.80;
	  }
	  $('#valor_total').html('<span style="color:#cc0000"> de <s>R$ '+ formataPreco(total) +'</s></span><br><span style="color:#375F90"> por R$ '+ formataPreco(total2) +' mensais </span>');
	  total = total2;
      } else {
	
      $('#valor_total').html(formataPreco(total));

      }


    }
  });
  
}


$(function($) {

  valores_atuais = new Array();
  var x =0;
  
  $('.cod_plano').each( function() {

    valores_atuais[x] = $('#descricao'+ $(this).val()).html();
    x++;
    
    $(this).click(function(){
      getCalculo();
    });
    
  });

  
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
      
  <?php
  if ($total_planos) {
  ?>
      <form action="<?php echo System::thisFile() ?>" name="frm_planos" method="post" onsubmit="return false">
      
        <table width="100%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6"><span class="texto_destaque2">escolha os planos que deseja adquirir</span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">
            
              <table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
                <?php
                foreach ($plano->lista() as $row) {
                  
                  $plano_exixte = $plano->planoExiste($row['cod_plano'], $_SESSION["site_cod_cliente"]);
                  
                  if (!$plano_exixte) {
                    ?>
                    <tr>
                      <td width="300" rowspan="3">
                      
                      <table width="300" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="bg_fts_qs"><img src="<?php echo SYS_SITE_CONTEUDO .'uploads/'. $row['arquivo1'] ?>" width="290" height="131" /></td>
                        </tr>
                      </table>
                      
                      </td>
                      <td width="18" align="center" class="texto_destaque2">&nbsp;</td>
                      <td width="237" align="center" class="texto_destaque2"><?php echo $row['plano'] ?></td>
                    </tr>
                    <tr>
                      <td rowspan="2" class="texto_destaque1">&nbsp;</td>
                      <td class="texto_destaque1">
                      
                      <?php echo $row['descricao'] ?>
                      <br /><br />
                      <strong>Valor de s&oacute;cio: <br /><span id="descricao<?php echo $row['cod_plano'] ?>">R$ <?php echo Number::formatCurrencyBr($row['valor']) ?> mensais</span>.<br /> Plano de 12 meses.</strong>
                      
                      </td>
                    </tr>
                    <tr>
                      <td align="center" class="texto_destaque1">
                        <input name="cod_plano[]" type="checkbox" class="cod_plano" value="<?php echo $row['cod_plano'] ?>" />
                        <input name="valor<?php echo $row['cod_plano'] ?>" value="<?php echo $row['valor'] ?>" type="hidden" />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3" class="td_line">&nbsp;</td>
                    </tr>
                    <?php
                  }
                }
                ?>
              </table>
              
              <table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td  class="texto_form_titulo">&nbsp;</td>
                  <td class="texto_form_titulo">&nbsp;</td>
                </tr>
                <tr>
                  <td  class="texto_form_titulo">&nbsp; </td>
                  <td width="237" class="texto_form_titulo">Valor total: R$ <span id="valor_total">0,00</span></td>
                </tr>
                <tr>
                  <td  class="texto_form_titulo">&nbsp;</td>
                  <td class="texto_form_titulo">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" valign="top"  class="texto_form" colspan="2">Ao finalizar você será direcionado ao Pagseguro para informar os dados do pagamento </td>
                </tr>
              </table>
              </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6"><table align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="button_cp"><a href="javascript:void(0)" onclick="validaDados()">Finalizar a aquisição</a></td>
                </tr>
              </table></td>
          </tr>
        </table>
        
          <input type="hidden" name="acao" value="calcula_desconto" />
        </form>
  <?php
  } else {
  ?>
  <table width="100%" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="200" align="center" bgcolor="#FFFFFF" class="td_main8"><span class="texto_destaque2">Você já adquiriu todos os planos poss&iacute;veis!</span></td>
    </tr>
  </table>
  
  <?php
  }
  ?>
        </td>
      <td width="324" valign="top" bgcolor="#FFFFFF"><table width="300" cellpadding="0" cellspacing="0">
          <tr>
            <td height="34" colspan="2" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="texto_destaque3">Compre os Planos da InterA&Ccedil;&Atilde;O On-Line e escolha pagar atrav&eacute;s do Pagseguro.</td>
          </tr>
          <tr>
            <td colspan="2"><table width="300" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center"><img src="assets/images/planos/pagseguro.png" alt="" width="120" height="133" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="2" class="td_line2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="titulo_planos_qs">d&uacute;vidas sobre os planos</td>
          </tr>
          <tr>
            <td class="texto_planos_qs">Perguntas e respostas sobre a aquisi&ccedil;&atilde;o dos Planos.</td>
            <td width="100" class="botao_planos_qs"><table align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="button_qs"><a href="duvidas.php">Acesse aqui</a></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="titulo_outros_planos_comprando3">conhe&ccedil;a a intera&ccedil;&atilde;o</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="td_main7"><span class="texto_destaque3">InterAÇÃO</span> mantém o elo de gratidão entre o ex-aluno e sua escola, entre o pai e o professor, entre a comunidade e a escola judaica religiosa. Ao adquirir um dos planos <span class="texto_destaque3">- FÉRIAS, LUZ ou ARTE -</span>, você contribui para as Escolas e patrocina o aprendizado de um aluno. Ao final, um prêmio referente a cada pacote será sorteado. É uma influência recíproca, uma manifestação de reconhecimento,
              uma maneira de interagir com quem fez parte de sua história.</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><table align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="button_qs"><a href="quem-somos.php">Saiba mais</a></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
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
