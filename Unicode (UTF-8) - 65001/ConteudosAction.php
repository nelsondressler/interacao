<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class ConteudosAction extends Action
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
    
    $this->idioma = $_SESSION["login_idioma"];
    
  }
  
  
  public function listaPaginada($FORM = null, $orderby = 'ordem') {
    
    $conteudo         = new ConteudosModel();
    $this->pagination = new Pagination();
    $where            = $this->where;
   
    if ($FORM['nome']) {
      $where .= " AND nome LIKE '%". $FORM['nome'] ."%'";
    }
    if ($FORM['cod_conteudo_categoria']) {
      $where .= " AND cod_conteudo_categoria=". $FORM['cod_conteudo_categoria'];
    }
    
    $conteudo->selectOne('COUNT(*) as total', $where);
    $row = $conteudo->getResults();
    $this->pagination->set($row['total'], 25, true, true);
    
    $conteudo->selectAll('*', $where, $orderby, $this->pagination->getSQL());
    return $conteudo->getResults();
    
  }
  
  
  public function lista($FORM = null, $orderby = 'ordem') {
    
    $conteudo = new ConteudosModel();
    $where    = $this->where;
    
    if ($FORM['nome']) {
      $where .= " AND nome LIKE '%". $FORM['nome'] ."%'";
    }
    if ($FORM['cod_conteudo_categoria']) {
      $where .= " AND cod_conteudo_categoria=". $FORM['cod_conteudo_categoria'];
    }
    
    $conteudo->selectAll('*', $where, $orderby);
    return $conteudo->getResults();
    
  }
  
  
  public function listaCategorias() {
    
    $categorias = new ConteudosCategoriasModel();
    $categorias->selectAll('*', $this->where);
    return $categorias->getResults();
    
  }
  
  
  public function exibeCategoria($cod) {
    
    $categorias = new ConteudosCategoriasModel();
    $where      = $this->where .' AND '. $categorias->getPrimaryKeyName() .'='. $cod;
    
    $categorias->selectOne('*', $where);
    return $categorias->getResults();
    
  }
  
  
  public function listaAssets($cod, $ordem = 'ordem') {
    
    if ($cod) {
      
      $conteudo_assets = new ConteudosAssetsModel();
      $conteudo_assets->selectAll('*', "cod_conteudo=". $cod, $ordem);
      return $conteudo_assets->getResults();
      
    }
    
  }
  
  
  public function excluirAssets($cod) {
    
    if ($cod) {

      $conteudo_assets = new ConteudosAssetsModel();
      $filesys         = new FileSystem();
      $where           = $conteudo_assets->getPrimaryKeyName() .'='. $cod;
      
      $conteudo_assets->selectOne('*', $where);
      
      if($conteudo_assets->getTotalRows() > 0) {
        
        $row = $conteudo_assets->getResults();
        $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo1']);
        $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo1_original']);
        $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo2']);
        $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo2_original']);
        $conteudo_assets->delete($where);
        
      }
      
    }
  }
  
  
  public function excluirArquivoAssets($cod, $numero) {
    
    if ($cod && $numero) {

      $conteudo_assets = new ConteudosAssetsModel();
      $filesys         = new FileSystem();
      $where           = $conteudo_assets->getPrimaryKeyName() .'='. $cod;
      
      $conteudo_assets->selectOne('*', $where);
      
      if($conteudo_assets->getTotalRows() > 0) {
        
        $row = $conteudo_assets->getResults();
        $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo'. $numero]);
        $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo'. $numero .'_original']);
        
        $field['arquivo'. $numero]              = '';
        $field['arquivo'. $numero .'_original'] = '';
        
        $conteudo_assets->update($field, $where);
      }
      
    }
  }
  
  
  public function excluirConteudosSelecionados($cod) {
    
    if ($this->tipo) {
      
      for($i=0; $i < count($cod); $i++) {
        $this->excluirConteudo($cod[$i]);
      }
      
    }
    
  }
  
  
  public function excluirConteudo($cod) {
    
    if ($this->tipo && $cod) {
      
      $conteudo = new ConteudosModel();
      $conteudo->selectOne('*', 'cod_conteudo_pai='. $cod);
      
      if ($conteudo->getTotalRows() > 0) {
         
         $this->setReturnMensage('Este item não pode ser apagado, exclua antes os sub níveis que existem nele.');
         
      } else {
        
        $this->excluirArquivoConteudo($cod, 1);
        $this->excluirArquivoConteudo($cod, 2);
        
        foreach ($this->listaAssets($cod) as $row) {
          $this->excluirAssets($row['cod_cont_assets']);
        }
        
        $conteudo->delete($conteudo->getPrimaryKeyName() .'='. $cod);
        
      }
      
    }
  }
  
  
  public function excluirArquivoConteudo($cod, $numero) {
    
    if ($cod && $numero) {
      
      $conteudo = new ConteudosModel();
      $filesys  = new FileSystem();
      $where    = $conteudo->getPrimaryKeyName() .'='. $cod;
      
      $conteudo->selectOne('*', $where);
      $row = $conteudo->getResults();
      
      $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo'. $numero]);
      $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo'. $numero .'_original']);
      
      $field['arquivo'. $numero] = '';
      $field['arquivo'. $numero .'_original'] = '';
      
      $conteudo->update($field, $where);
      
    }
    
  }
  
  
  public function exibeConteudo($cod) {
    
    if ($cod) {
      
      $conteudo = new ConteudosModel();
      $conteudo->selectOne('*', $conteudo->getPrimaryKeyName() .'='. $cod);
      return $conteudo->getResults();
      
    }

  }
  
  
  public function setPrincipal($cod, $valor, $cod_cat = null) {
    
    if ($cod && $this->tipo) {
      
      $conteudo = new ConteudosModel();
      $where    = $this->where ;
      
      if ($cod_cat) {
        $where .= ' AND cod_conteudo_categoria='. $cod_cat;
      }
      
      $conteudo->update(array('principal'=>0), $where);
      $conteudo->update(array('principal'=>$valor), $where .' AND '. $conteudo->getPrimaryKeyName() .'='. $cod);
      
    }
    
  }
  
  
  public function setStatus($cod, $valor, $cod_cat = null) {
    
    if ($cod && $this->tipo) {
      
      $conteudo = new ConteudosModel();
      $where    = $this->where .' AND '. $conteudo->getPrimaryKeyName() .'='. $cod;
      
      if ($cod_cat) {
        $where .= ' AND cod_conteudo_categoria='. $cod_cat;
      }
      
      $conteudo->update(array('status'=>$valor), $where);
      
    }
    
  }
  
  
  public function grava($incluir, $FORM) {
    
    if ($this->tipo) {
      
      $conteudo = new ConteudosModel();
      $upload   = new Upload();
      $hora     = date('H:i');
      
      if ($FORM['hora']) {
        $hora = $FORM['hora'];
      }
      
      $field['idioma']                 = $this->idioma;
      $field['tipo']                   = $this->tipo;
      $field['cod_conteudo_pai']       = $FORM['cod_conteudo_pai'];
      $field['cod_conteudo_categoria'] = $FORM['cod_conteudo_categoria'];
      $field['status']                 = $FORM['status'];
      $field['principal']              = $FORM['principal'];
      $field['posicao']                = $FORM['posicao'];
      $field['ordem']                  = $FORM['ordem'];
      $field['data']                   = Date::brTotimestamp($FORM['data']) .' '. $hora;
      $field['link']                   = Useful::limpaLink($FORM['link']);
      $field['nome']                   = $FORM['nome'];
      $field['descricao']              = $FORM['descricao'];
      $field['texto1']                 = $FORM['texto1'];
      $field['texto2']                 = $FORM['texto2'];
      $field['texto3']                 = $FORM['texto3'];
      $field['urlrewrite']             = $conteudo->getNameUrlRewrite($FORM['nome'], $FORM['cod']);
    
      for ($i = 1; $i < 3; $i++) {
        
        if ($FORM['arquivo'. $i]["name"]) {
          
          $arquivo = $FORM['arquivo'. $i];
          $largura = $FORM['arquivo'. $i .'_largura'];
          $altura  = $FORM['arquivo'. $i .'_altura'];
          $crop    = $FORM['arquivo'. $i .'_resize_crop'];
          
          if ($largura !='' && $altura!='') {
            $field['arquivo'. $i .'_original'] = $upload->saveResize(1000, 1000, $arquivo, SYS_CONTEUDO .'uploads/');
            if ($crop) {
              $field['arquivo'. $i] = $upload->saveResizeCrop($largura, $altura, $arquivo, SYS_CONTEUDO .'uploads/');
            } else {
              $field['arquivo'. $i] = $upload->saveResize($largura, $altura, $arquivo, SYS_CONTEUDO .'uploads/');
            }
          } else {
            $field['arquivo'. $i] = $upload->save($arquivo, SYS_CONTEUDO .'uploads/');
          }
        }
        
      } // for
      
      if ($FORM['principal']) {
        if ($FORM['cod_conteudo_categoria']) {
          $conteudo->update(array('principal'=>0), $this->where .' AND cod_conteudo_categoria='. $FORM['cod_conteudo_categoria']);
        } else {
          $conteudo->update(array('principal'=>0), $this->where);
        }
      }
      
      // Inclui
      if ($incluir) {
        
        $conteudo->insert($field);
       
        $cod  = $conteudo->getLastInsertKey();
        $msg  = 'inserido';
        $link = System::thisFile() .'?cod='. $cod;
        
      // Alterar
      } else {
        
        $cod = $FORM['cod'];
        $conteudo->update($field, 'cod_conteudo='. $cod);
        
        $msg  = 'alterado';
        $link = System::thisFile() .'?cod='. $cod;
        
        $this->gravaAssets(false, $cod, $FORM);
          
      }
      
      if ($cod) {
        $this->gravaAssets(true, $cod, $FORM);
      }
      
      
      $mensage = '<b>Registro '. $msg .' com sucesso!</b><p>';
      $mensage .= '<a href="'. $link .'"><img src="assets/img/voltar.png" width="16" height="16" border="0" align="absmiddle" /> Voltar ao registro</a> &nbsp;&nbsp;';
      if ( SystemLayout::getPermissao(2) ) {
        $mensage .= '<a href="'. SystemLayout::getModule() .'_form.php"><img src="assets/img/mais.png" width="16" height="16" border="0" align="absmiddle" /> Novo registro</a> &nbsp;&nbsp;';
      }
      $mensage .= '<a href="'. SystemLayout::getModule() .'.php"><img src="assets/img/lista.png" width="16" height="16" border="0" align="absmiddle" /> Voltar a lista</a>';
      $mensage .= '</p>';

      $this->setReturnMensage($mensage);
      
    }
  }
  
  
  private function gravaAssets($incluir, $cod, $FORM) {
    
    $conteudo_assets = new ConteudosAssetsModel();
    $upload          = new Upload();
    
    // Quais arquivos serão utilizados (Ex.: 1,2)
    $assets_arquivos = explode(',', $FORM['assets_arquivos']);
    
    if ($incluir) {
      
      $assets_upload = $upload->normalizeArray($FORM['assets_upload']);
      
      for ($i=0; $i < count($FORM['assets_ordem']); $i++) {
        
        unset($field);
        if ($FORM['assets_nome'][$i] || $assets_upload[$i]["name"]) {
          
          $field['cod_conteudo'] = $cod;
          $field['tipo']         = $FORM['assets_tipo'][$i];
          $field['nome']         = $FORM['assets_nome'][$i];
          $field['descricao']    = $FORM['assets_descricao'][$i];
          $field['link']         = Useful::limpaLink($FORM['assets_link'][$i]);
          $field['texto1']       = $FORM['assets_texto1'][$i];
          $field['ordem']        = $FORM['assets_ordem'][$i];
          $field['urlrewrite']   = '';
          
          for ($n = 0; $n < count($assets_arquivos); $n++) {
            
            $numero = (integer) $assets_arquivos[$n];
            
            if ($assets_upload[$i]["name"]) {
              
              $arquivo = $assets_upload[$i];
              $largura = $FORM['assets_arquivo'. $numero .'_largura'];
              $altura  = $FORM['assets_arquivo'. $numero .'_altura'];
              $crop    = $FORM['assets_arquivo'. $numero .'_resize_crop'];
              
              $largura_orig = $FORM['assets_arquivo'. $numero .'_original_largura'];
              $altura_orig  = $FORM['assets_arquivo'. $numero .'_original_altura'];
              
              if ($largura !='' && $altura !='') {
                
                if ($largura_orig !='' && $altura_orig !='') {
                  $field['arquivo'. $numero .'_original'] = $upload->saveResize($largura_orig, $altura_orig, $arquivo, SYS_CONTEUDO .'uploads/');
                }
                
                if ($crop) {
                  $field['arquivo'. $numero] = $upload->saveResizeCrop($largura, $altura, $arquivo, SYS_CONTEUDO .'uploads/');
                } else {
                  $field['arquivo'. $numero] = $upload->saveResize($largura, $altura, $arquivo, SYS_CONTEUDO .'uploads/');
                }
                
              } else {
                $field['arquivo'. $numero] = $upload->save($arquivo, SYS_CONTEUDO .'uploads/');
              }
              
            }
            
          } // for
          
          $conteudo_assets->insert($field);
          
        }
        
      }
      
    } else {
      
      for ($i=0; $i < count($FORM['cod_cont_assets']); $i++) {
        
        unset($field);
        $field['nome']       = $FORM['assets_lista_nome'][$i];
        $field['descricao']  = $FORM['assets_lista_descricao'][$i];
        $field['link']       = Useful::limpaLink($FORM['assets_lista_link'][$i]);
        $field['texto1']     = $FORM['assets_lista_texto1'][$i];
        $field['ordem']      = $FORM['assets_lista_ordem'][$i];
        $field['urlrewrite'] = '';
        
        $conteudo_assets->update($field, $conteudo_assets->getPrimaryKeyName() .'='. $FORM['cod_cont_assets'][$i]);
        
      }
      
    }
  }
  
  
  public function alterarOrdem($FORM) {

    $conteudo = new ConteudosModel();
    
    for($i=0; $i < count($FORM['cod']); $i++) {
      $conteudo->update(array('ordem'=>$FORM['ordem'][$i]), $conteudo->getPrimaryKeyName() .'='. $FORM['cod'][$i]);
    }
    
  }
  
  
  public function proximaOrdenacao() {
    
    $conteudo = new ConteudosModel();
    $conteudo->selectOne('MAX(ordem) as ordem', $this->where);
    $row = $conteudo->getResults();
    return $row['ordem']+1;
    
  }
  
  
  public function getCodTipo() {
    
    if ( $this->tipo) {
      
      $conteudo = new ConteudosModel();
      $conteudo->selectOne('cod_conteudo', $this->where);
      
      $row =  $conteudo->getResults();
      return $row['cod_conteudo'];
      
    }
  }
  
}
?>