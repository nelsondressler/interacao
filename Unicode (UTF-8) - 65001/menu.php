<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
foreach (AdministracaoHelper::listaMenu() as $list_titulo) {

  if ($list_titulo['menu'] !=0) {
    
    $menu_css  = 'none';
    $menu_html = '';
    
    foreach (AdministracaoHelper::listaPermissoes() as $list_menu) {
      
      if ($list_menu['menu'] == $list_titulo['menu']) {
        
        if ($list_menu['divisor']) {
          $menu_html .= '<div class="divisor">'. $list_menu['nome'] .'</div>';
        }
        
        if ( SystemLayout::getPermissao(1, $list_menu['modulo']) ) {
          if ($list_menu['link']) {
            $menu_html .= '<li><a href="'. $list_menu['link'] .'">'. $list_menu['nome'] .'</a></li>';
          } else {
            $menu_html .= '<li><a href="'. $list_menu['modulo'] .'.php">'. $list_menu['nome'] .'</a></li>';
          }
          $menu_css = 'block';
        }
      }
      
    }
    
    echo '<div id="menu_topo" style="display:'. $menu_css .'"></div>
          <div id="menu_meio" style="display:'. $menu_css .'">
           
           <div id="menu_titulo">'. $list_titulo['nome'] .'</div>
           <ul id="menu_lista">'. $menu_html .'</ul>
           
          </div>
          <div id="menu_rodape" style="display:'. $menu_css .'"></div>';
    
  }
  
}
?>