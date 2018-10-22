<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

$rodape = new SiteConteudosAction();

$rodape->setTipo('pag_banner_rodape');



$row_rodape = $rodape->lista();

?>



<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td align="center" valign="top" bgcolor="#FFFFFF">

      <table width="0" border="0" align="center" cellpadding="0" cellspacing="0">

        <tr>

          <td>

            

            <?php

            for ($i = 0; $i < count($row_rodape); $i++) {

              

              if ($row_rodape[$i]['cod_conteudo']==16 || $row_rodape[$i]['cod_conteudo']==17 || $row_rodape[$i]['cod_conteudo']==18) {

                $row_assets = $rodape->listaAssets($row_rodape[$i]['cod_conteudo']);

                ?>

                <table align="left" cellpadding="0" cellspacing="0">

                  <tr>

                    <td width="190" align="center" class="td_logos_titulo">&nbsp;<?php echo $row_rodape[$i]['nome'] ?></td>

                    <td width="30" align="center" >&nbsp;</td>

                  </tr>

                  <tr>

                    <td class="td_line1">&nbsp;</td>

                    <td class="td_line1">&nbsp;</td>

                  </tr>

                  <tr>

                    <td>

                      <table width="114" align="center" cellpadding="0" cellspacing="0">

                        <tr>

                          <td class="td_logos_img">

                          <?php

                          for ($j = 0; $j < count($row_assets); $j++) {

                            

                            $link = '';

                            if ($row_assets[$j]['link']) {

                              $link = 'href="http://'. $row_assets[$j]['link'].'" target="_blank"';

                            }

                            

                            echo '<a '. $link .'><img src="'.  SYS_SITE_CONTEUDO .'uploads/'. $row_assets[$j]['arquivo1'] .'" width="132" height="102" border="0"/></a>';

                          }

                          ?>

                          </td>

                        </tr>

                      </table>

                    </td>

                    <td>&nbsp;</td>

                  </tr>

                </table>

                <?php

              }

            }

            ?>

          </td>

        </tr>

      </table>

    </td>

    <td width="324" valign="top" bgcolor="#FFFFFF">

      

      <?php

      $row_rodape = $rodape->exibeConteudo(19);

      $row_assets = $rodape->listaAssets($row_rodape['cod_conteudo']);

      ?>

      <table width="236" align="center" cellpadding="0" cellspacing="0">

        <tr>

          <td class="td_logos_titulo2">Parceiros</td>

        </tr>

        <tr>

          <td class="td_line1">&nbsp;</td>

        </tr>

        <tr>

          <td>

            

            <table width="114" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td class="td_logos_parceiros">

                  

                  <div id="cover" class="pics">

                  <?php

                  for ($j = 0; $j < count($row_assets); $j++) {

                    

                    $link = '';

                    if ($row_assets[$j]['link']) {

                      $link = 'onclick="window.open(\'http://'. $row_assets[$j]['link'] .'\')"  style="cursor: pointer;"';

                    }

                    

                    echo '<img src="'.  SYS_SITE_CONTEUDO .'uploads/'. $row_assets[$j]['arquivo1'] .'" '. $link .' />';

                  }

                  ?>

                  </div>

                  

                </td>

              </tr>

            </table>

            

          </td>

        </tr>

      </table>

      

    </td>

  </tr>

</table>