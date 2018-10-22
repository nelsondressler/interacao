<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
class PeriodosAction extends Action
{

  public $pagination;

  
  public function listaPaginada($FORM) {
    
    $periodo          = new PeriodosModel();
    $this->pagination = new Pagination();
    
    $where   = '1=1';
    $join    = '';
    $orderby = 'periodo';
    
    $periodo->selectOne('COUNT(*) as total', $where, $join);
    $row = $periodo->getResults();
    $this->pagination->set($row['total'], 5, true, true);
    
    $periodo->selectAll('*', $where, $orderby, $this->pagination->getSQL(), $join);
    return $periodo->getResults();
    
  }

  
  
  public function excluirSelecionados($cod) {
      
    for($i=0; $i < count($cod); $i++) {
      $this->excluir($cod[$i]);
    }
    
  }
  
  
  public function excluir($cod) {
    
    if ($cod) {
      
      $periodo = new PeriodosModel();
      $plano   = new PlanosModel();
      
      $plano->selectAll('*', $periodo->getPrimaryKeyName() .'='. $cod);
      if ($plano->getTotalRows() > 0) {
        $this->setReturnMensage('Alguns registros não foram excluidos pois\nexistem Planos ligados a ele.');
      } else {
        $periodo->delete($periodo->getPrimaryKeyName() .'='. $cod);
      }
      
    }
  }

  
  
  public function exibe($cod) {
    
    if ($cod) {
      
      $periodo = new PeriodosModel();
      $periodo->selectOne('*', $periodo->getPrimaryKeyName() .'='. $cod);
      return $periodo->getResults();
      
    }

  }

  
  
  public function grava($incluir, $FORM) {
     
    $periodo = new PeriodosModel();
    
    $field['vigente']     = $FORM['vigente'];
    $field['periodo']     = $FORM['periodo'];
    $field['data_inicio'] = Date::brTotimestamp($FORM['data_inicio']);
    $field['data_fim']    = Date::brTotimestamp($FORM['data_fim']);
    
    if ($FORM['vigente']) {
      $periodo->update(array('vigente'=>0));
    }
    
    // Inclui
    if ($incluir) {
      
      $periodo->insert($field);
      $cod  = $periodo->getLastInsertKey();
      
      $msg  = 'inserido';
      $link = System::thisFile() .'?cod='. $cod;
      
    // Alterar
    } else {
      
      $cod = $FORM['cod'];
      $periodo->update($field, $periodo->getPrimaryKeyName() .'='. $cod);
      
      $msg  = 'alterado';
      $link = System::thisFile() .'?cod='. $cod;
        
    }
    
    $this->setReturnMensage('
      <b>Registro '. $msg .' com sucesso!</b><p>
      <a href="'. $link .'"><img src="assets/img/voltar.png" width="16" height="16" border="0" align="absmiddle" /> Voltar ao registro</a> &nbsp;&nbsp;
      <a href="'. SystemLayout::getModule() .'_form.php"><img src="assets/img/mais.png" width="16" height="16" border="0" align="absmiddle" /> Novo registro</a> &nbsp;&nbsp;
      <a href="'. SystemLayout::getModule() .'.php"><img src="assets/img/lista.png" width="16" height="16" border="0" align="absmiddle" /> Voltar a lista</a>
      </p>
    ');
    
  }
  
  
}
?>