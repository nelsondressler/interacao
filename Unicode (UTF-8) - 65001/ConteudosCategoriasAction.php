<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class ConteudosCategoriasAction extends Action
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
  
  
  public function lista() {
    
    $categoria        = new ConteudosCategoriasModel();
    $this->pagination = new Pagination();
    $where            = $this->where;
    
    $categoria->selectOne('COUNT(*) as total', $where);
    $row = $categoria->getResults();
    $this->pagination->set($row['total'], 5, true, true);

    $categoria->selectAll('*', $where, $orderby, $this->pagination->getSQL());
    
    return $categoria->getResults();
    
  }
  
  
  public function excluirLista($cod) {
    
    if ($this->tipo) {
      
      $categoria = new ConteudosCategoriasModel();
      $conteudo  = new ConteudosModel();
      
      for($i=0; $i < count($cod); $i++) {
      
        $conteudo->selectOne('*', 'cod_categoria='. $cod[$i]);
        if ($conteudo->getTotalRows() > 0) {
          $this->setReturnMensage('Este item não pode ser apagado, pois estão sendo usados em algum texto.');
          
        } else {
          $categoria->delete($categoria->getPrimaryKeyName() .'='. $cod[$i]);
        }
        
      } //for
      
    }
  }
  
  
  public function exibe($cod) {
    
    $categoria = new ConteudosCategoriasModel();
    $where = $categoria->getPrimaryKeyName() .'='. $cod;
    
    $categoria->selectOne('*', $where);
    return $categoria->getResults();
    
  }
  
  
  public function grava($incluir, $FORM) {
    
    if ($this->tipo) {
    
      $categoria = new ConteudosCategoriasModel();

      $field['idioma'] = $this->idioma;
      $field['tipo']   = $this->tipo;
      $field['ordem']  = $FORM['ordem'];
      $field['nome']   = $FORM['nome'];
      
      // Inclui
      if ($incluir) {
        
        $categoria->insert($field);
        $cod  = $categoria->getLastInsertKey();
        $msg  = 'inserido';
        $link = System::thisFile() .'?cod='. $cod;
        
      // Alterar
      } else {
        
        $cod = $FORM['cod'];
        $categoria->update($field, $categoria->getPrimaryKeyName() .'='. $cod);
        $msg  = 'alterado';
        $link = System::thisFile() .'?cod='. $cod;
        
      }
      
      $this->setReturnMensage('
        <b>Registro '. $msg .' com sucesso!</b>
        <p><a href="'. $link .'&tipo='. $this->tipo .'">Voltar ao registro</a> |
        <a href="'. SystemLayout::getModule() .'.php?tipo='.  $this->tipo .'">Voltar a lista</a></p>
      ');
      
    }
  }
  
  
  public function alterarOrdem($FORM) {

    $categoria = new ConteudosCategoriasModel();
    
    for($i=0; $i < count($FORM['cod']); $i++) {
      $categoria->update(array('ordem'=>$FORM['ordem'][$i]), 'cod_conteudo_categoria='. $FORM['cod'][$i]);
    }
    
  }

  
}
?>