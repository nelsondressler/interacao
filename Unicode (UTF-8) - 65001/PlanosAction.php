<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
class PlanosAction extends Action
{

  public $pagination;

  
  public function listaPaginada($FORM) {
    
    $plano            = new PlanosModel();
    $this->pagination = new Pagination();
    
    $where     = '1=1';
    $join      = 'INNER JOIN periodos ON planos.cod_periodo = periodos.cod_periodo';
    $orderby   = 'planos.plano';
    
    if ($FORM['plano']) {
      $where .= " AND planos.plano LIKE '%". $FORM['plano'] ."%'";
    }

    if ($FORM['cod_periodo']) {
      $where .= " AND planos.cod_periodo=". $FORM['cod_periodo'];
    }
    
    $plano->selectOne('COUNT(*) as total', $where, $join);
    $row = $plano->getResults();
    $this->pagination->set($row['total'], 20, true, true);
    
    $plano->selectAll('planos.*, periodos.periodo', $where, $orderby, $this->pagination->getSQL(), $join);
    return $plano->getResults();
    
  }
  
  
  public function listaPeriodos() {
    
    $periodo = new PeriodosModel();
    $periodo->selectAll('*');
    return $periodo->getResults();
    
  }
  
  
  public function excluirSelecionados($cod) {
      
    for($i=0; $i < count($cod); $i++) {
      $this->excluir($cod[$i]);
    }
    
  }
  
  
  public function excluir($cod) {
    
    if ($cod) {
      
      $plano     = new PlanosModel();
      $cli_plano = new ClientesPlanosModel();
      
      $cli_plano->selectAll('*', $plano->getPrimaryKeyName() .'='. $cod);
      if ($cli_plano->getTotalRows() > 0) {
        $this->setReturnMensage('Alguns registros não foram excluidos pois\nexistem Clientes ligados a ele.');
      } else {
        
        $this->excluirArquivo($cod, 1);
        $this->excluirArquivo($cod, 2);
        $plano->delete($plano->getPrimaryKeyName() .'='. $cod);
      }
      
    }
  }

  
  
  public function exibe($cod) {
    
    if ($cod) {
      
      $plano = new PlanosModel();
      $plano->selectOne('*', $plano->getPrimaryKeyName() .'='. $cod);
      return $plano->getResults();
      
    }

  }

  public function excluirArquivo($cod, $numero) {
    
    if ($cod && $numero) {
      
      $plano    = new PlanosModel();
      $filesys  = new FileSystem();
      $where    = $plano->getPrimaryKeyName() .'='. $cod;
      
      $plano->selectOne('*', $where);
      $row = $plano->getResults();
      
      $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo'. $numero]);
      $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo'. $numero .'_original']);
      
      $field['arquivo'. $numero] = '';
      $field['arquivo'. $numero .'_original'] = '';
      
      $plano->update($field, $where);
      
    }
    
  }
  
  
  public function grava($incluir, $FORM) {
     
    $plano = new PlanosModel();
    $upload   = new Upload();
    
    $field['cod_periodo'] = $FORM['cod_periodo'];
    $field['plano']       = $FORM['plano'];
    $field['valor']       = Number::formatCurrencyUsa($FORM['valor']);
    $field['descricao']   = $FORM['descricao'];
    $field['texto2']      = $FORM['texto2'];
    $field['texto1']      = $FORM['texto1'];
    $field['texto3']      = $FORM['texto3'];

    if ($FORM['arquivo1']["name"]) {
      $field['arquivo1_original'] = $upload->saveResize(1000, 1000, $FORM['arquivo1'], SYS_CONTEUDO .'uploads/');
      $field['arquivo1'] = $upload->saveResizeCrop(290, 131, $FORM['arquivo1'], SYS_CONTEUDO .'uploads/');
    }
    if ($FORM['arquivo2']["name"]) {
      $field['arquivo2_original'] = $upload->saveResize(1000, 1000, $FORM['arquivo2'], SYS_CONTEUDO .'uploads/');
      $field['arquivo2'] = $upload->saveResizeCrop(558, 251, $FORM['arquivo2'], SYS_CONTEUDO .'uploads/');
    }
    
    // Inclui
    if ($incluir) {
      
      $plano->insert($field);
      $cod  = $plano->getLastInsertKey();
      
      $msg  = 'inserido';
      $link = System::thisFile() .'?cod='. $cod;
      
    // Alterar
    } else {
      
      $cod = $FORM['cod'];
      $plano->update($field, $plano->getPrimaryKeyName() .'='. $cod);
      
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