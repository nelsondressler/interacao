<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
class ClientesAction extends Action
{

  public $pagination;

  
  public function listaPaginada($FORM) {
    
    $cliente          = new ClientesModel();
    $this->pagination = new Pagination();
    
    $where            = '1=1';
    $join             = '';
    $orderby          = 'nome';
    
    if ($FORM['nome']) {
      $where .= " AND nome LIKE '%". $FORM['nome'] ."%'";
    }

    if ($FORM['cpf']) {
      $where .= " AND cpf='". $FORM['cpf'] ."' ";
    }
    
    if ($FORM['email']) {
      $where .= " AND email LIKE '%". $FORM['email'] ."%'";
    }
    
    $cliente->selectOne('COUNT(*) as total', $where, $join);
    $row = $cliente->getResults();
    $this->pagination->set($row['total'], 20, true, true);
    
    $cliente->selectAll('*', $where, $orderby, $this->pagination->getSQL(), $join);
    return $cliente->getResults();
    
  }

  
  public function lista() {
    
    $cliente = new ClientesModel();
    
    $orderby = 'nome';

    $cliente->selectAll('*', '', $orderby);
    return $cliente->getResults();
    
  }
  
  
  public function listaStatus() {
    
    $status = new StatusModel();
    $status->selectAll('*', "tipo='cliente'");
    return $status->getResults();
    
  }
  
  
  public function excluirSelecionados($cod) {
      
    for($i=0; $i < count($cod); $i++) {
      $this->excluir($cod[$i]);
    }
    
  }
  
  
  public function excluir($cod) {
    
    if ($cod) {
      
      $cliente          = new ClientesModel();
      $cliente_periodos = new ClientesPeriodosModel();
      $cliente_planos   = new ClientesPlanosModel();
      $cliente_parcelas = new ClientesParcelasModel();
      
      // periodos
      $cliente_periodos->selectAll('*', 'cod_cliente='. $cod);
      $row_periodo = $cliente_periodos->getResults();
      
      for ($i = 0; $i < count($row_periodo); $i++) {
        
        // planos
        $cliente_planos->delete('cod_cli_periodo='. $row_periodo[$i]['cod_cli_periodo']);
        
        // parcelas
        $cliente_parcelas->delete('cod_cli_periodo='. $row_periodo[$i]['cod_cli_periodo']);
        
      }
      
      $cliente_periodos->delete('cod_cliente='. $cod);
      $cliente->delete($cliente->getPrimaryKeyName() .'='. $cod);
      
    }
  }

  
  
  public function exibe($cod) {
    
    if ($cod) {
      
      $cliente = new ClientesModel();
      $cliente->selectOne('*', $cliente->getPrimaryKeyName() .'='. $cod);
      return $cliente->getResults();
      
    }

  }

  
  
  public function grava($incluir, $FORM) {
     
    $cliente = new ClientesModel();
    
    $where = '';
    $erros = false;
    
    if ($FORM['cod']) {
      $where = 'AND NOT '. $cliente->getPrimaryKeyName() .'='. $FORM['cod'];
    }
    
    $cliente->selectOne('*', "email='". $FORM['email'] ."' ". $where);
    
    if ($cliente->getTotalRows() > 0) {
      
      $erros = true;
      $this->setReturnMensage('
        <b style="color:#CC0000">Já existe um Usuário com este email!</b>
        <p><a href="javascript:history.go(-1)">Voltar ao registro</a>
      ');
      
    }

    if (!$erros) {
    
      $field['cod_status']    = $FORM['cod_status'];
      $field['nome']          = $FORM['nome'];
      $field['cpf']           = Useful::limpaDocumento($FORM['cpf']);
      $field['telefone']      = $FORM['telefone'];
      $field['celular']       = $FORM['celular'];
      $field['email']         = $FORM['email'];
      $field['senha']         = $FORM['senha'];
      $field['cep']           = $FORM['cep'];
      $field['endereco']      = $FORM['endereco'];
      $field['numero']        = $FORM['numero'];
      $field['complemento']   = $FORM['complemento'];
      $field['estado']        = $FORM['estado'];
      $field['cidade']        = $FORM['cidade'];
      $field['bairro']        = $FORM['bairro'];
      $field['indicacao']     = $FORM['indicacao'];
      $field['indicacao_qual']= $FORM['indicacao_qual'];
      
      // Inclui
      if ($incluir) {
        
        $field['data_cadastro'] = date('Y-m-d');
        
        $cliente->insert($field);
        
        $cod  = $cliente->getLastInsertKey();
        $msg  = 'inserido';
        $link = System::thisFile() .'?cod='. $cod;
        
      // Alterar
      } else {
        
        $cod = $FORM['cod'];
        $cliente->update($field, $cliente->getPrimaryKeyName() .'='. $cod);
        
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
  
  
  /*
   * planos e parcelas
   *
   */
  
  public function listaStatusParcela() {
    
    $status = new StatusModel();
    $status->selectAll('*', "tipo='parcela'");
    return $status->getResults();
    
  }
  
  public function listaPeriodos($cod_cliente) {
    
    $cli_periodo = new ClientesPeriodosModel();
    
    $where   = 'clientes_periodos.cod_cliente='. $cod_cliente;
    $join    = 'INNER JOIN periodos ON clientes_periodos.cod_periodo=periodos.cod_periodo';
    $orderby = 'clientes_periodos.data_inserido';
    
    $cli_periodo->selectAll('*', $where, $orderby, null, $join);
    return $cli_periodo->getResults();
    
  }
  
  
  public function listaPlanos($cod_cli_periodo) {
    
    $cli_planos = new ClientesPlanosModel();

    $where = 'clientes_planos.cod_cli_periodo='. $cod_cli_periodo;
    $join  = 'INNER JOIN planos ON clientes_planos.cod_plano=planos.cod_plano';
    
    $cli_planos->selectAll('*', $where, null, null, $join);
    return $cli_planos->getResults();
    
  }
  
  
  public function listaAquisicao($cod_cli_periodo) {
    
    $row = array();
    
    $cli_periodo  = new ClientesPeriodosModel();
    $cli_planos   = new ClientesPlanosModel();
    $cli_parcelas = new ClientesParcelasModel();
    $status       = new StatusModel();
    
    // periodo
    $where   = 'clientes_periodos.cod_cli_periodo='. $cod_cli_periodo;
    $join    = 'INNER JOIN periodos ON clientes_periodos.cod_periodo=periodos.cod_periodo';
    
    $cli_periodo->selectOne('*', $where, $join);
    $row['periodo'] = $cli_periodo->getResults();
    
    // planos
    $where = 'clientes_planos.cod_cli_periodo='. $cod_cli_periodo;
    $join  = 'INNER JOIN planos ON clientes_planos.cod_plano=planos.cod_plano';
    
    $cli_planos->selectAll('clientes_planos.*, planos.plano', $where, null, null, $join);
    $row['planos'] = $cli_planos->getResults();
     
    // parcelas
    $where = 'clientes_parcelas.cod_cli_periodo='. $cod_cli_periodo;
    $join  = 'INNER JOIN clientes_periodos ON clientes_parcelas.cod_cli_periodo=clientes_periodos.cod_cli_periodo
              INNER JOIN status ON clientes_parcelas.cod_status=status.cod_status';
    
    $cli_parcelas->selectAll('*', $where, 'data_vencimento', null, $join);
   
    $row['parcelas'] = $cli_parcelas->getResults();
    
    return $row;
    
  }
  
  
  public function exibeParcela($cod_cli_parcelas) {
    
    $cli_parcelas = new ClientesParcelasModel();
    $cli_planos   = new ClientesPlanosModel();
    
    // parcela
    $where = 'clientes_parcelas.cod_cli_parcelas='. $cod_cli_parcelas;
    $join  = 'INNER JOIN clientes_periodos ON clientes_parcelas.cod_cli_periodo=clientes_periodos.cod_cli_periodo
              INNER JOIN status ON clientes_parcelas.cod_status=status.cod_status
              INNER JOIN periodos ON clientes_periodos.cod_periodo=periodos.cod_periodo';
    
    $cli_parcelas->selectOne('*', $where,  $join);
    $row = $cli_parcelas->getResults();
    
    // planos
    $where = 'clientes_planos.cod_cli_periodo='. $row['cod_cli_periodo'];
    $join  = 'INNER JOIN planos ON clientes_planos.cod_plano=planos.cod_plano';
    
    $cli_planos->selectAll('*', $where, null, null, $join);
    $row['planos'] = $cli_planos->getResults();
    
    return $row;
    
  }
  
  
  public function alteraParcela($FORM) {
    
    $cli_parcelas = new ClientesParcelasModel();
   
    $field['cod_status'] = $FORM['cod_status'];
    $cli_parcelas->update($field, $cli_parcelas->getPrimaryKeyName() .'='. $FORM['cod_cli_parcelas']);
    
    $row_parcela = $this->exibeParcela($FORM['cod_cli_parcelas']);
    
    $this->setReturnMensage('
      <b>Parcela Alterada com sucesso!</b><p>
      <a href="'. SystemLayout::getModule() .'.php?cod_cli_periodo='. $row_parcela['cod_cli_periodo'] .'"><img src="assets/img/lista.png" width="16" height="16" border="0" align="absmiddle" /> Voltar a lista</a>
      </p>
    ');
    
  }
  
  
}
?>