<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
class CobrancaAction extends Action
{

  
  public function enviaEmailCobranca() {
    
    $cli_parcelas = new ClientesParcelasModel();
    $emailsys     = new EmailSystem();
    
    $data_hoje  = date('d/m/Y');
    $data_busca = Date::add(+5, $data_hoje);
    
    $emails_enviados = 0;
    $emails_erros    = 0;
    
    $cli_parcelas->query("
      SELECT cpa.*, c.nome, c.email
      FROM clientes_parcelas cpa
      INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
      INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
      WHERE (cpa.data_vencimento = '". Date::brTotimestamp($data_busca)  ."' OR
             cpa.data_vencimento = '". Date::brTotimestamp($data_hoje) ."') AND
             cpa.cod_status=4
    ");
    
    $row_parcela = $cli_parcelas->getResults();
    $total       = count($row_parcela);
    
    for ($i = 0; $i < $total; $i++) {
      
      echo $row_parcela[$i]['email'];
      
      if ($emailsys->enviaCobranca($row_parcela[$i])){
        echo ' - Enviado';
        $emails_enviados ++;
      } else {
        echo ' - Erro';
        $emails_erros ++;
      }
      echo '<br><br>';
    }

    echo $emails_enviados .' e-mails enviados, '. $emails_erros .' erros de envio.';
      
  }
  
  
  public function enviaEmailCobrancaVencidos1() {
    
    $cli_parcelas = new ClientesParcelasModel();
    $emailsys     = new EmailSystem();
    
    $data_hoje  = date('d/m/Y');
    $data_busca = Date::add(-5, $data_hoje);
    
    $emails_enviados = 0;
    $emails_erros    = 0;
    
    $cli_parcelas->query("
      SELECT cpa.*, c.nome, c.email
      FROM clientes_parcelas cpa
      INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
      INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
      WHERE (cpa.data_vencimento BETWEEN '". Date::brTotimestamp($data_busca)  ."' AND '". Date::brTotimestamp($data_hoje)  ."') AND
             cpa.cod_status=4
    ");
    
    $row_parcela = $cli_parcelas->getResults();
    $total       = count($row_parcela);
    
    for ($i = 0; $i < $total; $i++) {
      
      echo $row_parcela[$i]['email'];
      
      if ($emailsys->enviaCobrancaAtrasado($row_parcela[$i])){
        echo ' - Enviado';
        $emails_enviados ++;
      } else {
        echo ' - Erro';
        $emails_erros ++;
      }
      echo '<br><br>';
    }

    echo $emails_enviados .' e-mails enviados, '. $emails_erros .' erros de envio.';
      
  }
  
  
  public function enviaEmailCobrancaVencidos2() {
    
    $cli_parcelas = new ClientesParcelasModel();
    $emailsys     = new EmailSystem();
    
    $data_hoje  = date('d/m/Y');
    $data_busca = Date::add(-15, $data_hoje);
    
    $emails_enviados = 0;
    $emails_erros    = 0;
    
    $cli_parcelas->query("
      SELECT cpa.*, c.nome, c.email
      FROM clientes_parcelas cpa
      INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
      INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
      WHERE (cpa.data_vencimento <= '". Date::brTotimestamp($data_busca)  ."') AND
             cpa.cod_status=4
    ");
    
    $row_parcela = $cli_parcelas->getResults();
    $total       = count($row_parcela);
    
    for ($i = 0; $i < $total; $i++) {
      
      echo $row_parcela[$i]['email'];
      
      if ($emailsys->enviaCobrancaAtrasado($row_parcela[$i])){
        echo ' - Enviado';
        $emails_enviados ++;
      } else {
        echo ' - Erro';
        $emails_erros ++;
      }
      echo '<br><br>';
    }

    echo $emails_enviados .' e-mails enviados, '. $emails_erros .' erros de envio.';
      
  }
  
  
  public function getTotalApagar() {
    
    $cli_parcelas = new ClientesParcelasModel();
    
    $data_hoje  = date('d/m/Y');
    $data_busca = Date::add(+5, $data_hoje);
    
    $cli_parcelas->query("
      SELECT cpa.*, c.nome, c.email
      FROM clientes_parcelas cpa
      INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
      INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
      WHERE (cpa.data_vencimento = '". Date::brTotimestamp($data_busca)  ."' OR
             cpa.data_vencimento = '". Date::brTotimestamp($data_hoje) ."') AND
             cpa.cod_status=4
    ");
    //echo $cli_parcelas->getSql();
    $row['total'] = $cli_parcelas->getTotalRows();
    $row['data']  = $data_busca;
    
    return $row;
  }
  
  
  public function getTotalVencidos1() {
    
    $cli_parcelas = new ClientesParcelasModel();
    
    $data_hoje  = date('d/m/Y');
    $data_busca = Date::add(-5, $data_hoje);
    
    $cli_parcelas->query("
      SELECT cpa.*, c.nome, c.email
      FROM clientes_parcelas cpa
      INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
      INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
      WHERE (cpa.data_vencimento = '". Date::brTotimestamp($data_busca) ."') AND
             cpa.cod_status=4
    ");
    //echo $cli_parcelas->getSql();
    $row['total'] = $cli_parcelas->getTotalRows();
    $row['data']  = $data_busca;
    
    return $row;
  }
  
  
  public function getTotalVencidos2() {
    
    $cli_parcelas = new ClientesParcelasModel();
    
    $data_hoje  = date('d/m/Y');
    $data_busca = Date::add(-15, $data_hoje);
    
    $cli_parcelas->query("
      SELECT cpa.*, c.nome, c.email
      FROM clientes_parcelas cpa
      INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
      INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
      WHERE (cpa.data_vencimento <= '". Date::brTotimestamp($data_busca)  ."') AND
             cpa.cod_status=4
    ");

    $row['total'] = $cli_parcelas->getTotalRows();
    $row['data']  = $data_busca;
    
    return $row;
  }
  
  
}
?>
