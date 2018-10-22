<?php
class AtividadesAction extends Action
{

  public $pagination;

  
  public function listaPaginada($FORM) {
    
    $atividade         = new AtividadesModel();
    $this->pagination = new Pagination();
    $where            = '1=1';
    $orderby          = 'atividade';
    
    if ($FORM['atividade']) {
      $where .= " AND atividade LIKE '%". $FORM['atividade'] ."%'";
    }
    
    $atividade->selectOne('COUNT(*) as total', $where);
    $row = $atividade->getResults();
    $this->pagination->set($row['total'], 5, true, true);
    
    $atividade->selectAll('*', $where, $orderby, $this->pagination->getSQL());
    return $atividade->getResults();
    
  }

  
  
  public function excluirSelecionados($cod) {
    
    for($i=0; $i < count($cod); $i++) {
      $this->excluir($cod[$i]);
    }
    
  }
  

  public function excluir($cod) {
    
    if ($cod) {
      
      $atividade = new AtividadesModel();
      $clientes  = new ClientesModel();
      
      $clientes->selectAll('*', $atividade->getPrimaryKeyName() .'='. $cod);
      
      if ($clientes->getTotalRows() > 0) {
        
        $this->setReturnMensage('Alguns registros não foram excluidos pois\nexistem Clientes ligados a eles.');
        
      } else {
        
        $atividade->delete($atividade->getPrimaryKeyName() .'='. $cod);
        
      }
      
    }
  }

  
  
  public function exibe($cod) {
    
    if ($cod) {
      
      $atividade = new AtividadesModel();
      $atividade->selectOne('*', $atividade->getPrimaryKeyName() .'='. $cod);
      return $atividade->getResults();
      
    }

  }

  
  
  public function grava($incluir, $FORM) {
      
    $atividade = new AtividadesModel();

    $field['atividade'] = $FORM['atividade'];
    
    // Inclui
    if ($incluir) {
      
      $atividade->insert($field);

      $cod  = $atividade->getLastInsertKey();
      $msg  = 'inserido';
      $link = System::thisFile() .'?cod='. $cod;
      
    // Alterar
    } else {
      
      $cod = $FORM['cod'];
      $atividade->update($field, $atividade->getPrimaryKeyName() .'='. $cod);
      
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