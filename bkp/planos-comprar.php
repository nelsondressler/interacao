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
function validaDados() {

  var f = document.frm_planos;
  
  if(validaOpcao(f['cod_plano[]'])) {
    return abreAlerta("Escolha pelo menos 1 plano para prossegui.");
  }

  if(validaOpcao(f['dia_vencimento'])) {
    return abreAlerta("Escolha o dia de pagamento.");
  }
  
  f.action = 'planos-inserir.php';
  f.acao.value = 'inserir';
  f.submit();
  
}

var codplano_1 = 0;

function getCalculo(obj) {

  var codplano    = obj.value;
  var ckeck       = obj.checked;
  var total       = 0;
  var valor_total = 0;
  var f           = document.frm_planos;
  var cssdisplay  = '';
  
  $('#valor_total').html('0,00');
      
  for(var i = 0; i < f['cod_plano[]'].length; i++) {
    if ( f['cod_plano[]'][i].checked ) total++;
    f['comdesconto'+ f['cod_plano[]'][i].value ].value = 0;
  }

  if (total==1) {
    for(var i = 0; i < f['cod_plano[]'].length; i++) {
      if ( f['cod_plano[]'][i].checked ) {
        codplano_1 = f['cod_plano[]'][i].value;
        //valor_total += f['cod_plano[]'][i].value;
      }
    }
  }
 
  if (total > 1 ) {

    for(var i = 0; i < f['cod_plano[]'].length; i++) {
      if ( f['cod_plano[]'][i].checked) {

        if ( f['cod_plano[]'][i].value != codplano_1) {
          $('#descricao'+ f['cod_plano[]'][i].value ).hide();
          $('#descricao_desc'+ f['cod_plano[]'][i].value).show();
        }
        
      } else {
        
        if(f['cod_plano[]'][i].value != codplano_1) {
          $('#descricao'+ f['cod_plano[]'][i].value ).show();
          $('#descricao_desc'+ f['cod_plano[]'][i].value).hide();
        }
        
      }
    }

    // hack, caso o primeiro selecionado seja desclicado e sobre 2 com desconto.
    if(total==2) {

      var dois = new Array();
      var x    = 0;
      
      for(var i = 0; i < f['cod_plano[]'].length; i++) {
        if ( f['cod_plano[]'][i].checked ) {
          dois[x]    = new Array();
          dois[x][0] = f['cod_plano[]'][i].value;
          //dois[x][1] = $('#planovalor'+ f['cod_plano[]'][i].value).val();
          x++;
        }
      }

      /*dois = dois.sort(function(a,b) {
        return a[1] > b[1];
      });*/

      if (dois[0][0] != codplano_1) {
        $('#descricao'+ dois[0][0]).show();
        $('#descricao_desc'+ dois[0][0]).hide();
      }
      /*for(var i = 0; i < dois.length; i++) {
        alert(dois[i][0] +' = '+ dois[i][1]);
      }*/
      
    }
    
  } else {
    
    for(var i = 0; i < f['cod_plano[]'].length; i++) {
      $('#descricao'+ f['cod_plano[]'][i].value ).show();
      $('#descricao_desc'+ f['cod_plano[]'][i].value).hide();
    }

  }


  for(var i = 0; i < f['cod_plano[]'].length; i++) {
    if ( f['cod_plano[]'][i].checked ) {
      cssdisplay = $('#descricao_desc'+ f['cod_plano[]'][i].value).css('display');
      if (cssdisplay == 'inline') {
        valor_total += parseFloat(f['desconto'+ f['cod_plano[]'][i].value ].value);
        f['comdesconto'+ f['cod_plano[]'][i].value ].value = 1;
      } else {
        valor_total += parseFloat(f['valor'+ f['cod_plano[]'][i].value ].value);
        f['comdesconto'+ f['cod_plano[]'][i].value ].value = 0;
      }
    }
  }
  
  $('#valor_total').html(formataPreco(valor_total));

  
}


$(function($) {
  
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
                      <strong>Valor de s&oacute;cio: <br />
                      
                      <span id="descricao<?php echo $row['cod_plano'] ?>">R$ <?php echo Number::formatCurrencyBr($row['valor']) ?> mensais.</span>
                      
                      <span id="descricao_desc<?php echo $row['cod_plano'] ?>" style="color:#cc0000; display:none"> de <s>R$
                      <?php echo Number::formatCurrencyBr($row['valor']) ?></s> por R$
                      <?php echo Number::formatCurrencyBr($row['valor'] - ($row['valor'] * (10/100))) ?> mensais.</span>
                      
                      <br /> Plano de 12 meses.</strong>
                      
                      </td>
                    </tr>
                    <tr>
                      <td align="center" class="texto_destaque1">
                        <input name="cod_plano[]" type="checkbox" value="<?php echo $row['cod_plano'] ?>" onclick="getCalculo(this)" />
                        <input name="valor<?php echo $row['cod_plano'] ?>" value="<?php echo $row['valor'] ?>" type="hidden" />
                        <input name="desconto<?php echo $row['cod_plano'] ?>" value="<?php echo $row['valor'] - ($row['valor'] * (10/100)) ?>" type="hidden" />
                        <input name="comdesconto<?php echo $row['cod_plano'] ?>" value="0" type="hidden" />
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
                  <td align="left" valign="top"  class="texto_form">Escolha um dia para o pagamento das pr&oacute;ximas parcelas:</td>
                  <td align="left" valign="top" class="texto_form">
                    <input type="radio" name="dia_vencimento" value="7" /> Dia 7<br />
                    <input type="radio" name="dia_vencimento" value="18" /> Dia 18
                  </td>
                </tr>
                <tr>
                  <td  class="texto_form_titulo">&nbsp;</td>
                  <td class="texto_form_titulo">&nbsp;</td>
                </tr>
                <tr>
                  <td  class="texto_form_titulo">&nbsp; </td>
                  <td width="237" class="texto_form_titulo">Valor total: R$ <span id="valor_total">0,00</span></td>
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
            <td colspan="2" class="texto_destaque3">Compre os Planos da InterA&Ccedil;&Atilde;O On-Line e escolha pagar atrav&eacute;s de Boleto Banc&aacute;rio ou pelo BCash.</td>
          </tr>
          <tr>
            <td colspan="2"><table width="300" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="150" align="center"><img src="assets/images/planos/icone_bbancario.gif" width="130" height="56" /></td>
                  <td width="150" align="center"><img src="assets/images/planos/bcash.jpg" alt="" width="87" height="56" /></td>
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
</html>
