<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class SiteConteudosAction extends Action
{
  
  private $tipo;
  
  private $idioma;
  
  private $where;
  
  public $pagination;
  
  
  public function setTipo($tipo) {
    $this->tipo  = $tipo;
    $this->where = "tipo='". $this->tipo ."' AND idioma='". $this->idioma ."'";
  }
  
  
  public function getTipo() {
    return $this->tipo;
  }
  
  
  public function __construct() {
    
    $this->idioma = $_SESSION["site_idioma"];
    
  }
  
  
  public function listaPaginada($FORM = null, $orderby = 'ordem', $paginas = 20) {
    
    $conteudo         = new ConteudosModel();
    $this->pagination = new PaginationUri();
    $where            = $this->where .' AND status=1';
   
    if ($FORM['nome']) {
      $where .= " AND nome LIKE '%". $FORM['nome'] ."%'";
    }
    if ($FORM['cod_conteudo_categoria']) {
      $where .= " AND cod_conteudo_categoria=". $FORM['cod_conteudo_categoria'];
    }
    
    $conteudo->selectOne('COUNT(*) as total', $where);
    $row = $conteudo->getResults();
    $this->pagination->set($row['total'], $paginas);
    
    $conteudo->selectAll('*', $where, $orderby, $this->pagination->getSQL());
    return $conteudo->getResults();
    
  }
  
  
  public function lista($FORM = null, $orderby = 'ordem') {
    
    $conteudo = new ConteudosModel();
    $where    = $this->where .' AND status=1';
    
    if ($FORM['nome']) {
      $where .= " AND nome LIKE '%". $FORM['nome'] ."%'";
    }
    if ($FORM['mes']) {
      $where .= " AND MONTH(data) = '". $FORM['mes'] ."'";
    }
    if ($FORM['ano']) {
      $where .= " AND YEAR(data) = '". $FORM['ano'] ."'";
    }
    if ($FORM['cod_conteudo_categoria']) {
      $where .= " AND cod_conteudo_categoria=". $FORM['cod_conteudo_categoria'];
    }
    
    $conteudo->selectAll('*', $where, $orderby);
    return $conteudo->getResults();
    
  }
  
  
  public function listaHome() {
    
    $conteudo = new ConteudosModel();
    $where    = $this->where .' AND status=1 AND home=1';

    $conteudo->selectAll('*', $where, 'ordem');
    return $conteudo->getResults();
    
  }
  
  
  public function listaMenu($orderby = 'ordem') {
    
    $conteudo = new ConteudosModel();
    $where    = $this->where .' AND status=1 AND NOT principal=1';
    
    $conteudo->selectAll('nome, cod_conteudo, urlrewrite', $where, $orderby);
    return $conteudo->getResults();
    
  }
  
  public function listaCategorias($ordem = 'ordem') {
    
    $categorias = new ConteudosCategoriasModel();
    $categorias->selectAll('*', $this->where, $ordem);
    return $categorias->getResults();
    
  }
  
  
  public function exibeCategoria($cod) {
    
    $categorias = new ConteudosCategoriasModel();
    $where      = $this->where .' AND '. $categorias->getPrimaryKeyName() .'='. $cod;
    
    $categorias->selectOne('*', $where);
    return $categorias->getResults();
    
  }
  
  
  public function getCodCategoriaUri($urlrewrite) {
    
    $categorias = new ConteudosCategoriasModel();
    
    if ($urlrewrite) {

      $categorias->selectOne($categorias->getPrimaryKeyName(), "urlrewrite='". $urlrewrite ."' AND ". $this->where );
      $row = $categorias->getResults();
      
    }
    
    return $row[$categorias->getPrimaryKeyName()];
    
  }
  
  
  public function listaAssets($cod, $orderby = 'ordem') {
    
    if ($cod) {
      
      $conteudo_assets = new ConteudosAssetsModel();
      $conteudo_assets->selectAll('*', "cod_conteudo=". $cod, $orderby);
      return $conteudo_assets->getResults();
      
    }
    
  }
  
  
  public function exibeConteudo($cod) {
    
    if ($cod) {
      
      $conteudo = new ConteudosModel();
      $conteudo->selectOne('*', $conteudo->getPrimaryKeyName() .'='. $cod .' AND status=1');
      
      $row = $conteudo->getResults();
      $row['texto1'] = $this->modParse($row);
      return $row;
      
    }

  }

  
  public function getPrincipal($cod_cat = null) {
      
    $conteudo = new ConteudosModel();
    $where    = $this->where ." AND status=1 AND principal=1";
    
    if ($cod_cat) {
      $where .= ' AND cod_conteudo_categoria='. $cod_cat;
    }
    
    $conteudo->selectOne('*', $where);
    
    $row = $conteudo->getResults();
    $row['texto1'] = $this->modParse($row);
    return $row;
      
  }
  
  
  public function getCodTipo() {
    
    if ( $this->tipo) {
      
      $conteudo = new ConteudosModel();
      $conteudo->selectOne('cod_conteudo', $this->where .' AND status=1');

      $row =  $conteudo->getResults();
      return $row['cod_conteudo'];
      
    }
  }
  
  public function getCodConteudoUri($urlrewrite) {
    
    $conteudo = new ConteudosModel();
    
    if ($urlrewrite) {

      $conteudo->selectOne($conteudo->getPrimaryKeyName(), "urlrewrite='". $urlrewrite ."' AND ". $this->where );
      $row = $conteudo->getResults();
      
    } else {
      
      $row = $this->exibe();
      
    }
    
    return $row[$conteudo->getPrimaryKeyName()];
    
  }
  
  
  public function modParse($row) {
    
    if ($this->idioma) {
      //include SYS_PATH .'app/idioma/'. $this->idioma .'.php';
    }
    
    $modparse_html = $row['texto1'];
    //$cod_conteudo           = $row['cod_conteudo'];
    //$cod_conteudo_categoria = $row['cod_conteudo_categoria'];
    
    $modparse_mod = array (
      array("mod"=>"#MOD_FORMULARIO_CONTATO#", 'arquivo'=>'formulario_contato.php'),
      array("mod"=>"#MOD_GOOGLE_MAPS#",        'arquivo'=>'google_maps.php'),
      array("mod"=>"#MOD_BANNER#",             'arquivo'=>'banner.php'),
      array("mod"=>"#MOD_REVESTIMENTO#",       'arquivo'=>'revestimento.php')
    );
    
    foreach ($modparse_mod as $modparse_list) {
      
      $modparse_pos      = strpos($modparse_html, $modparse_list['mod']);
      $modparse_conteudo = '';
      
      if ($modparse_pos) {
        
        if($modparse_list['mod']=='#MOD_BANNER#') {
        
          preg_match_all("/\#MOD_BANNER\#.(\d{1,4})/", $modparse_html, $matches);
          foreach ($matches[1] as $var1) {
            ob_start();
            include(SYS_PATH .'assets/modulos/'. $modparse_list['arquivo']);
            $modparse_conteudo = ob_get_contents();
            ob_end_clean();
            $modparse_html = str_replace('#MOD_BANNER#='. $var1, $modparse_conteudo, $modparse_html);
          }
          
        } else if($modparse_list['mod']=='#MOD_REVESTIMENTO#') {
        
          preg_match_all("/\#MOD_REVESTIMENTO\#.(\d{1,4})/", $modparse_html, $matches);
          foreach ($matches[1] as $var1) {
            ob_start();
            include(SYS_PATH .'assets/modulos/'. $modparse_list['arquivo']);
            $modparse_conteudo = ob_get_contents();
            ob_end_clean();
            $modparse_html = str_replace('#MOD_REVESTIMENTO#='. $var1, $modparse_conteudo, $modparse_html);
          }
          
        } else {
          
          ob_start();
          include(SYS_PATH .'assets/modulos/'. $modparse_list['arquivo']);
          $modparse_conteudo = ob_get_contents();
          ob_end_clean();
          $modparse_html = str_replace($modparse_list['mod'], $modparse_conteudo, $modparse_html);
          
        }
      }
      
    }
    //echo $modparse_html;
    //exit;
    return $modparse_html;
    
  }
  
  
  public function listaAnos() {
    
    $conteudo = new ConteudosModel();
    $where    = $this->where ." AND status=1 ";
    
    $conteudo->selectAll('DISTINCT YEAR(data) as ano', $where, 'data ASC');
    
    return $conteudo->getResults();
    
  }
  
  
  public function listaMeses($ano) {
    
    if ($ano) {

      $conteudo = new ConteudosModel();
      $where = $this->where ." AND status=1 AND YEAR(data) = '". $ano ."'";
      $conteudo->selectAll('DISTINCT MONTH(data) as mes', $where, 'data ASC');
      return $conteudo->getResults();
      
    }
    
  }
  
}
?>