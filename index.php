<?php

require_once 'bootstrap.php';



$conteudo = new SiteConteudosAction();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<meta http-equiv="X-UA-Compatible" content="IE=9">

  <title>InterA&Ccedil;&Atilde;O</title>

  <link href="assets/css/estilo.css" rel="stylesheet" type="text/css" />

  <link href='http://fonts.googleapis.com/css?family=Sansita+One' rel='stylesheet' type='text/css'>

    <link rel='stylesheet' id='options_typography_Oswald-css' href='http://fonts.googleapis.com/css?family=Oswald' type='text/css' media='all' />

    <!--======inicio menu=======-->

    <script type='text/javascript' src='assets/js/jquery-1.6.4.min.js'></script>

    <script type="text/javascript">

    // initialise plugins

    jQuery(function(){

      // main navigation init

      jQuery('ul.sf-menu').superfish({

        delay:       1000, 		// one second delay on mouseout

        animation:   {opacity:'show',height:'show'}, // fade-in and slide-down animation

        speed:       'normal',  // faster animation speed

        autoArrows:  true,   // generation of arrow mark-up (for submenu)

        dropShadows: false   // drop shadows (for submenu)

      });

    });

  </script>

    <!--======fim menu=======-->

    <!--======início rolagem parceiros=======-->

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

    <script type="text/javascript" src="assets/js/jquery.cycle.all.js"></script>

    <script type="text/javascript">

var $a=jQuery.noConflict();

$a(function() {

    $a('#cover').cycle({

         fx:        'cover',

         delay:    -2000,

    before: function(curr, next, opts) {

      opts.animOut.opacity = 0;

    }

    });

    $a('#uncover').cycle({

         fx:        'uncover',

    before: function(curr, next, opts) {

      opts.animOut.opacity = 0;

    }

    });

});

</script>

    <!--======fim rolagem parceiros=======-->

    <!--======inicio slides=======-->

    <link rel="stylesheet" href="assets/css/style_slides.css" type="text/css" media="screen">

      <link rel="stylesheet" href="assets/css/grid_slides.css" type="text/css" media="screen">

        <script src="assets/js/jquery-1.6.2.min.js" type="text/javascript"></script>

        <script src="assets/js/cufon-yui.js" type="text/javascript"></script>

        <script src="assets/js/cufon-replace.js" type="text/javascript"></script>

        <script src="assets/js/superfish.js" type="text/javascript"></script>

        <script src="assets/js/FF-cash.js" type="text/javascript"></script>

        <script src="assets/js/script.js" type="text/javascript"></script>

        <script src="assets/js/jquery.easing.1.3.js" type="text/javascript"></script>

        <script type="text/javascript" src="assets/js/tms-0.3.js"></script>

        <script type="text/javascript" src="assets/js/tms_presets.js"></script>

        <!--[if lt IE 7]>

        <div style=' clear: both; text-align:center; position: relative;'>

            <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0"  alt="" /></a>

        </div>

  <![endif]-->

        <!--[if lt IE 9]>

       <script type="text/javascript" src="js/html5.js"></script>

        <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">

  <![endif]-->



        <!--======fim slides=======-->



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

      <td height="50">&nbsp;</td>

    </tr>

    <tr>

      <td class="td-bg_slides"><table width="800" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td><div class="clear"></div>

              <div class="grid_24 border-bot indent-bot">

                

                <div class="slider">

                  <ul class="items">

                    

                    <?php

                    $conteudo->setTipo('pag_banner_home');

                    $row_banner = $conteudo->lista();

                    

                    for ($i = 0; $i < count($row_banner); $i++) {

                    ?>

                    

                    <li><img src="<?php echo SYS_SITE_CONTEUDO .'uploads/'. $row_banner[$i]['arquivo1'] ?>" alt="" />

                      <div class="banner">

                        <div class="padding">

                          

                          <?php

                          echo '<strong class="text-1">'. nl2br($row_banner[$i]['nome']) .'</strong>';

                          echo '<strong class="text-2a">'. nl2br($row_banner[$i]['texto1']) .'</strong>';

                          echo '<strong class="text-4">'. nl2br($row_banner[$i]['texto2']) .'</strong>';

                          echo '<strong class="text-3">'. nl2br($row_banner[$i]['texto3']) .'</strong>';

                          ?>

 

                        </div>

                      </div>

                    </li>

                    <?php

                    }

                    ?>

                    

                    <div class="ls-layer" data-bg="<?php echo SYS_SITE_CONTEUDO .'uploads/'. $row_banner[$i]['arquivo2'] ?>" style="slidedelay: 5000; transition2d: 76, 77, 78, 79;">

                      <h2 class="ls-s-1 sh" style="top: 30px; left: 40px; slidedirection: fade; slideoutdirection: top; durationin: 750; durationout: 750; scalein: 0; width: 350px;">

                        <?php echo $row_banner[$i]['nome'] ?>

                      </h2>

                      <p class="ls-s-1 sp" style="top: 150px; left: 40px; width: 400px; slidedirection: fade; slideoutdirection: left; durationin: 1000; durationout: 1000; easingin: easeInOutQuint; easingout: easeInOutQuint;">

                      <?php echo $row_banner[$i]['descricao'] ?>

                      </p>

                      

                      <?php if ($row_banner[$i]['link']) { ?>

                      <a href="http://<?php echo $row_banner[$i]['link'] ?>" class="ls-s-1 yellow button" style="top: 280px; left: 40px; slidedirection: bottom; slideoutdirection: bottom; durationin: 500; durationout: 500; easingin: easeInOutQuint; easingout: easeInOutQuint;">Saiba Mais</a>

                      <?php } ?>

                      

                      <div class="ls-s-1" style="top: 25px; left: 565px; slidedirection: fade; slideoutdirection: fade; durationin: 1500; durationout: 1500;">

                        <img src="<?php echo SYS_SITE_CONTEUDO .'uploads/'. $row_banner[$i]['arquivo1'] ?>" width="560" height="296">

                      </div>

                    </div>

                    

 

                  </ul>

                </div>

                

                <ul class="pagination">

                  <li><a href="#">1</a></li>

                  <li><a href="#">2</a></li>

                  <li><a href="#">3</a></li>

                  <li><a href="#">4</a></li>

                  <li><a href="#">5</a></li>

                  <li><a href="#">6</a></li>

                  <li><a href="#">7</a></li>

                </ul>

                

              </div>

              <div class="clear"></div> <script type="text/javascript"> Cufon.now(); </script> <script type="text/javascript">

  var $j=jQuery.noConflict();

      $j(window).load(function(){

       $j('.slider')._TMS({

      duration:800,

      easing:'easeOutQuad',

      preset:'simpleFade',

      pagination:'.pagination',

      slideshow:8000,

      banners:'fromLeft',

      waitBannerAnimation:false,

      pauseOnHover:true

       })

    })

  </script></td>

          </tr>

        </table></td>

    </tr>

    <tr>

      <td height="40">&nbsp;</td>

    </tr>

  </table>

  <table width="980" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td colspan="5" class="bg_top_main"><table width="972" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td class="td_main1">Plano F&Eacute;RIAS <br /> <span class="td_main2">A sua viagem para Israel</span></td>

            <td class="td_main1">Plano luz <br /> <span class="td_main2">Menor&aacute; de prata - HAZORFIM 925 </span></td>

            <td class="td_main1">Plano ARTE <br /> <span class="td_main2">"Quando Mashiach chegar"</span></td>

          </tr>

        </table></td>

    </tr>

    <tr>

      <td width="4">&nbsp;</td>

      <td width="324" bgcolor="#FFFFFF" class="td_main3">Atenção, passageiros!<br /> Próxima parada: Israel!<br /> Ajude a escola, escolha a melhor data para embarcar e faça as malas.</td>

      <td width="324" bgcolor="#FFFFFF" class="td_main4">Ao adquirir o Plano Luz, você aciona o interruptor da escola e acende as luzes, ilumina os corredores e faz brilhar os estudos de cada aluno.</td>

      <td width="324" bgcolor="#FFFFFF" class="td_main4">Com o Plano Arte, você contribui para a escola e concorre a um belo quadro que ilustra a vinda de Mashiach e de como serão as maravilhas do mundo.</td>

      <td width="4">&nbsp;</td>

    </tr>

    <tr>

      <td>&nbsp;</td>

      <td bgcolor="#FFFFFF"><table align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td class="button"><a href="plano-descricao.php?cod=2">Saiba mais</a>

            </td>

          </tr>

        </table></td>

      <td bgcolor="#FFFFFF"><table align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td class="button"><a href="plano-descricao.php?cod=3">Saiba mais</a>

            </td>

          </tr>

        </table></td>

      <td bgcolor="#FFFFFF"><table align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td class="button"><a href="plano-descricao.php?cod=4">Saiba mais</a>

            </td>

          </tr>

        </table></td>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td>&nbsp;</td>

      <td colspan="3" bgcolor="#FFFFFF" class="td_line">&nbsp;</td>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td>&nbsp;</td>

      <td height="30" colspan="2" bgcolor="#FFFFFF">&nbsp;</td>

      <td bgcolor="#FFFFFF">&nbsp;</td>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td>&nbsp;</td>

      <td colspan="3" valign="top" bgcolor="#FFFFFF">

        <?php include 'assets/includes/rodape1.php' ?>

      </td>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td>&nbsp;</td>

      <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td>&nbsp;</td>

      <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>

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


