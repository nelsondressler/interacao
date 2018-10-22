<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class ContatosAction extends Action
{
  
  public $pagination;
  
  
  public function lista($FORM) {
    
    $contato          = new ContatosModel();
    $this->pagination = new Pagination();
    $where            = '1=1';
    $orderby          = 'data DESC';
    
    if ($FORM['nome']) {
      $where .= " AND nome LIKE '%". $FORM['nome'] ."%'";
    }
    if ($FORM['email']) {
      $where .= " AND email = '". $FORM['email'] ."'";
    }
    if ($FORM['data1'] && $FORM['data2']) {
      $where .= " AND ( DATE(data) BETWEEN '". Date::brTotimestamp($FORM['data1']) ."' AND '". Date::brTotimestamp($FORM['data2']) ."')";
    }
    
    $contato->selectOne('COUNT(*) as total', $where);
    $row = $contato->getResults();
    $this->pagination->set($row['total'], 20, true, true);
    
    $contato->selectAll('*', $where, $orderby, $this->pagination->getSQL());
    
    return $contato->getResults();
    
  }
  
  
  public function listaExcel() {
    
    $contato = new ContatosModel();
    
    $contato->selectAll('*', '', 'data DESC');
    return $contato->getResults();
    
  }
  
  
  public function excluirLista($cod) {
    
    $contato = new ContatosModel();
     
    for($i=0; $i < count($cod); $i++) {
      $contato->delete($contato->getPrimaryKeyName() .'='. $cod[$i]);
    }
    
  }
  
  
  public function exibe($cod) {
    
    if ($cod) {
      $contato = new ContatosModel();
      $contato->selectOne('*', $contato->getPrimaryKeyName() .'='. $cod);
      return $contato->getResults();
    }
    
  }

  
}
?>