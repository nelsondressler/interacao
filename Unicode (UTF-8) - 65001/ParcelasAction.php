<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
class ParcelasAction extends Action
{

  public function listaStatusParcela() {
    
    $status = new StatusModel();
    $status->selectAll('*', "tipo='parcela'");
    return $status->getResults();
    
  }
  
  
  public function listaParcelas($FORM) {
    
    $cli_parcelas = new ClientesParcelasModel();
    
    $where = '1=1';
    
    if ($FORM['num_pedido']) {
      $where .= " AND clientes_parcelas.num_pedido='". $FORM['num_pedido'] ."'";
    }
    if ($FORM['cpf']) {
      $where .= " AND clientes.cpf='". Useful::limpaDocumento($FORM['cpf']) ."'";
    }
    if ($FORM['data1'] && $FORM['data2']) {
      $where .= " AND ( clientes_parcelas.data_vencimento BETWEEN '". Date::brTotimestamp($FORM['data1']) ."' AND '". Date::brTotimestamp($FORM['data2']) ."')";
    }
    

    $cli_parcelas->query('
      SELECT
        clientes_parcelas.*,
        clientes_periodos.*,
        periodos.*,
        clientes.nome,
        clientes.cpf,
        status.status
      FROM clientes_parcelas
      INNER JOIN clientes_periodos ON clientes_parcelas.cod_cli_periodo=clientes_periodos.cod_cli_periodo
      INNER JOIN status ON clientes_parcelas.cod_status=status.cod_status
      INNER JOIN periodos ON clientes_periodos.cod_periodo=periodos.cod_periodo
      INNER JOIN clientes ON clientes.cod_cliente=clientes_periodos.cod_cliente
      WHERE '. $where .'
      ORDER BY clientes_parcelas.data_vencimento
    ');
    
    $row = $cli_parcelas->getResults();
    
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
  
  
  public function mudaStatus($cod) {
    
    $cli_parcelas = new ClientesParcelasModel();
    
    for($i=0; $i < count($cod); $i++) {
      $cli_parcelas->update(
      array(
        'cod_status'=>6,
        'data_pagamento'=> date('Y-m-d')
      ), $cli_parcelas->getPrimaryKeyName() .'='. $cod[$i]);
    }
    
    $this->setReturnMensage('As parcelas selecionadas foram marcadas como pagas.');
    
  }
  
  
  public function emailCobranca($cod_cli_parcelas) {
    
    if ($cod_cli_parcelas) {
    
      $cli_parcelas = new ClientesParcelasModel();
      $emailsys     = new EmailSystem();
      
      $cli_parcelas->query('
        SELECT
          clientes_parcelas.*,
          clientes_periodos.*,
          periodos.*,
          clientes.email
        FROM clientes_parcelas
        INNER JOIN clientes_periodos ON clientes_parcelas.cod_cli_periodo=clientes_periodos.cod_cli_periodo
        INNER JOIN periodos ON clientes_periodos.cod_periodo=periodos.cod_periodo
        INNER JOIN clientes ON clientes.cod_cliente=clientes_periodos.cod_cliente
        WHERE clientes_parcelas.cod_cli_parcelas='. $cod_cli_parcelas .' AND NOT (clientes_parcelas.cod_status=6)
      ');
      
      $row_parcela = $cli_parcelas->getResults();
      $row         = $row_parcela[0];
      
      $emailsys->enviaCobranca($row);
      
    }
  }
  
  
}
?>