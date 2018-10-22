<table width="980" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="220" height="120"><a href="<?php echo SYS_SITE?>"><img src="assets/images/Logo_IA.png" width="220" height="120" /></a></td>
    <td width="610">
      <nav class="primary">
        <ul id="topnav" class="sf-menu">
          <li id="menu-item-205" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-205"><a href="index.php">Home</a></li>
          <li id="menu-item-21" class="menu-item menu-item-type-post_type menu-item-object-page page_item page-item-203  menu-item-21"><a href="quem-somos.php">Quem Somos</a></li>
          <li id="menu-item-19" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-19"><a href="planos.php">Planos</a>

            <ul class="sub-menu">
            <?php
            $menu     = new SitePlanosAction();
            $row_menu = $menu->lista();
            
            for ($i = 0; $i < count($row_menu); $i++) {
              echo '<li id="menu-item-40" class="menu-item menu-item-type-post_type menu-item-object-page">
                    <a href="plano-descricao.php?cod='. $row_menu[$i]['cod_plano'] .'">'. $row_menu[$i]['plano'] .'</a></li>';
           }
            ?>
            </ul>
            
          </li>
          <li id="menu-item-105" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-105"><a href="duvidas.php">D&uacute;vidas</a></li>
          <li id="menu-item-17" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17"><a href="contato.php">Contato</a></li>
        </ul>
      </nav>
    </td>
    <td width="150"><a href="user-login.php"><img src="assets/images/bot_arestr.png" width="150" height="120" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
