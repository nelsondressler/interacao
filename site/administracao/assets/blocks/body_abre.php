<body>

<div id="principal">

<div id="topo">
  
  <!-- Inicio Topo menu -->
  <table width="980" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="58" align="left">
        <div id="topo_titulo">

          <?php
          $idioma_lista = IdiomasHelper::getLista();
          $idioma_count = count($idioma_lista);
          $idioma_link  = '';
          
          echo SYS_NOME;
          echo ' - <font color="#999999">Admin</font>';
          
          echo '<font color="#999999">';
          
          if ($idioma_count > 1) {
            for ($i = 0; $i < $idioma_count; $i++) {
              
              if ($idioma_lista[$i]['sigla'] == $_SESSION["login_idioma"]) {
                echo ' em '. $idioma_lista[$i]['nome'];
              } else {
                $idioma_link = ' <a href="home.php?acao=idioma&idioma='. $idioma_lista[$i]['sigla'] .'"><img src="assets/img/'. $idioma_lista[$i]['imagem'] .'" width="16" height="11"></a> ';
              }
                            
            }
          }
          
          echo $idioma_link;
          echo '</font>';
          ?>

        </div>
      </td>
      <td height="58" align="right">
        
        <table width="346" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="28" background="assets/img/topo_menu.gif">
              
               <div id="topo_menu">
                 <a class="topo_menu_usuario" href="adm_usuarios.php">Usu&aacute;rios</a>
                 <div id="topo_menu_divisor"></div>
                 
                 <a href="<?php echo SYS_SITE ?>" target="_blank" class="topo_menu_web" >Ir para o site</a>
                 <div id="topo_menu_divisor"></div>
                 
                 <a class="topo_menu_config" href="adm_configuracao.php">Configuração</a>
                 <div id="topo_menu_divisor"></div>
                 
                 <a class="topo_menu_sair" href="index.php?acao=logoff">Sair</a>
                </div>
  
            </td>
          </tr>
        </table>
        
      </td>
    </tr>
  </table>
  <!-- Fim Topo menu -->
  
</div>

<div id="topo_barra">
  
  <!-- Inicio Topo login -->
  <table width="980" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="25" height="42">&nbsp;</td>
      <td width="150" align="left">
      
        <div id="texto_login">
          <b>Usuário</b> <br> <?php echo $_SESSION["login_nome"]  ?>
        </div>
      
      </td>
      <td>
        
        <div id="topo_nav">
          <ul>
            <?php
            if (System::thisFile()!='home.php') {
              echo '<li><a href="home.php"><img src="assets/img/home.png" border="0" /></a></li>';
            }
            SystemLayout::renderNavigate()
            ?>
          </ul>
        </div>
        
      </td>
      <td align="right">
        
        <div id="topo_nav_voltar">
          <div id="topo_nav">
            <ul>
              <?php SystemLayout::getBack() ?>
            </ul>
          </div>
        </div>
        
      </td>
    </tr>
  </table>
  <!-- Fim Topo login -->
  
</div>

<div id="meio">
  
<div id="menu_lateral">
    <?php require 'menu.php'; ?>
</div>

<div id="conteudo">

<table width="783" border="0" cellpadding="0" cellspacing="0" id="painel_titulo">
  <tr>
    <td>
    <?php
    echo SystemLayout::getTitle();
    
    if (SystemLayout::getSubTitle()) {
      echo ' - <span class="sub_titulo">'. SystemLayout::getSubTitle() .'</span>';
    }
    ?>
    </td>
  </tr>
</table>