<?php
class SitePlanosAction extends Action
{

  
  public function lista() {
    
    $plano   = new PlanosModel();
    
    $where   = '1=1';
    $join    = 'INNER JOIN periodos ON planos.cod_periodo = periodos.cod_periodo';
    $orderby = 'planos.valor DESC';

    $plano->selectAll('planos.*, periodos.periodo', $where, $orderby, null, $join);
    return $plano->getResults();
    
  }
  
  
  public function planoExiste($cod_plano, $cod_cliente) {
    
    if ($cod_plano && $cod_cliente) {
      
      $cli_plano = new ClientesPlanosModel();
      
      $join  = 'INNER JOIN clientes_periodos ON clientes_planos.cod_cli_periodo = clientes_periodos.cod_cli_periodo';
      $where = 'clientes_periodos.cod_cliente='. $cod_cliente .' AND clientes_planos.cod_plano='. $cod_plano;
      
      $cli_plano->selectOne('*', $where, $join);
      $row = $cli_plano->getResults();
      
      if (count($row) > 0) {
        return true;
      }
      
      return false;
      
    } else {
      return true;
    }
     
  }
    

  public function exibe($cod) {
    
    if ($cod) {
      
      $plano = new PlanosModel();
      $join  = 'INNER JOIN periodos ON planos.cod_periodo = periodos.cod_periodo';
      
      $plano->selectOne('planos.*, periodos.*', $plano->getPrimaryKeyName() .'='. $cod, $join);
      return $plano->getResults();
      
    }

  }

  
  public function calculaValores($FORM) {
    
    $planos  = $FORM['cod_plano'];
    $valores = array();
    
    for ($i = 0; $i < count($planos); $i++) {
      
      $row_plano = $this->exibe($planos[$i]);
      
      if (count($row_plano) > 0) {
        
        $desconto = 0;
        $porcentagem = 0;

        if ($FORM['comdesconto'. $planos[$i]]==1) {
          $desconto    = $row_plano['valor'] - ($row_plano['valor'] * (10/100));
          $porcentagem = 10;
        }
        
        $valores[$i]['valor']         = $row_plano['valor'];
        $valores[$i]['valor_desconto']= $desconto;
        $valores[$i]['desconto']      = $porcentagem;
        $valores[$i]['cod_plano']     = $planos[$i];
        
      }
    }
    
    return $valores;
    
  }
  
  
  public function incluirPlano($FORM) {
    
    $cli_periodo  = new ClientesPeriodosModel();
    $cli_plano    = new ClientesPlanosModel();
    $cli_parcelas = new ClientesParcelasModel();
    $emailsys     = new EmailSystem();
    
    $cod_cliente    = $_SESSION["site_cod_cliente"];
    $planos         = $FORM['cod_plano'];
    $dia_vencimento = (integer) $FORM['dia_vencimento'];
    
    if ($dia_vencimento) {
      $dia_vencimento = 7;
    }
    
    // Pega cod do período
    if (count($planos) > 0) {
      $row_plano   = $this->exibe($planos[0]);
      $cod_periodo = $row_plano['cod_periodo'];
      $data_inicio = $row_plano['data_inicio'];
      $data_fim    = $row_plano['data_fim'];
    }
    
    $meses = Date::diffMes( Date::timestampToBr($data_fim), date('d/m/Y'));
    $dia   = date('d');
    
    if ($meses > 12) $meses = 12;

    // Cadastra os planos no cliente
    if ($cod_periodo) {
      
      $valores     = $this->calculaValores($FORM);
      $valor_total = 0;
      
      for ($i = 0; $i < count($valores); $i++) {
        
        if ($valores[$i]['valor_desconto'] > 0) {
          $valor_total += $valores[$i]['valor_desconto'];
        } else {
          $valor_total += $valores[$i]['valor'];
        }
        
      }
      
      // periodo
      $field['cod_periodo']   = $cod_periodo;
      $field['cod_cliente']   = $cod_cliente;
      $field['data_inserido'] = date('Y-m-d');
      $field['valor_total']   = $valor_total;
      $field['dia_vencimento']= $dia_vencimento;
      
      //print_r($valores);
      $cli_periodo->insert($field);
      unset($field);
      
      $cod_cli_periodo = $cli_periodo->getLastInsertKey();
      
      // planos
      for ($i = 0; $i < count($valores); $i++) {
        
        $field['cod_cli_periodo'] = $cod_cli_periodo;
        $field['cod_plano']       = $valores[$i]['cod_plano'];
        $field['valor_real']      = $valores[$i]['valor'];
        $field['desconto']        = $valores[$i]['desconto'];
        
        if ($valores[$i]['valor_desconto'] > 0) {
          $field['valor'] = $valores[$i]['valor_desconto'];
        } else {
          $field['valor'] = $valores[$i]['valor'];
        }
        
        //print_r($field);
        $cli_plano->insert($field);
        unset($field);
        
      }
      //exit;
      unset($field);
      
      // parcelas
      // A primeira vence no dia, as seguintes vencem no dia que o cliente escolheu
      for ($i = 0; $i < $meses; $i++) {
        
        if ($i==0) {
          $data_vencimento = date("Y-m-d", mktime (0, 0, 0, date("m") + $i, $dia, date("Y")));
          
        } else {
          $data_vencimento = date("Y-m-d", mktime (0, 0, 0, date("m") + $i, $dia_vencimento, date("Y")));
        }
        
        if ($i == 0) {
          $field['pagamento'] = $FORM['pagamento'];
        }
        
        $field['cod_status']      = 4;
        $field['cod_cli_periodo'] = $cod_cli_periodo;
        $field['data_vencimento'] = $data_vencimento;
        $field['valor']           = $valor_total;
        
        $cli_parcelas->insert($field);
        $cod_cli_parcelas = $cli_parcelas->getLastInsertKey();
        unset($field);
        
        $field['num_pedido'] = $cod_cli_parcelas;
        
        $cli_parcelas->update($field, $cli_parcelas->getPrimaryKeyName() .'='. $cod_cli_parcelas);
        unset($field);
        
      }
      
      $emailsys->enviaCompraPlanos($cod_cli_periodo);
      
    }
    
    $_SESSION['insere_planos']   = false;
    $_SESSION['cod_cli_periodo'] = $cod_cli_periodo;
    
  }
  
  
  public function parcelaAVencer($mes, $ano) {
    
    $cod_cliente  = $_SESSION["site_cod_cliente"];
    
    if ($mes && $ano && $cod_cliente) {
      
      $cli_parcelas = new ClientesParcelasModel();
      
      $cli_parcelas->query("
        SELECT cpa.cod_cli_parcelas FROM clientes_parcelas cpa
        INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
        INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
        WHERE c.cod_cliente = ". $cod_cliente ." AND (MONTH(cpa.data_vencimento) = '". $mes ."' AND YEAR(cpa.data_vencimento) = '". $ano ."')
      ");
      
      $row = $cli_parcelas->getResults();
      
      return $row[0]['cod_cli_parcelas'];
      
    }
  }
  
  
  public function primeiraParcela() {
    
    $cod_cliente  = $_SESSION["site_cod_cliente"];
    
    if ($cod_cliente) {
      
      $cli_parcelas = new ClientesParcelasModel();
      
      $cli_parcelas->query("
        SELECT cpa.cod_cli_parcelas FROM clientes_parcelas cpa
        INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
        INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
        WHERE c.cod_cliente = ". $cod_cliente ."
        ORDER BY cpa.data_vencimento ASC
      ");
      
      $row = $cli_parcelas->getResults();
      
      return $row[0]['cod_cli_parcelas'];
      
    }
  }
  
  
  public function setPagamento($cod_cli_parcelas, $pagamento) {
    
    if ($cod_cli_parcelas && $pagamento) {
      
      $cli_parcelas = new ClientesParcelasModel();
      
      $field['pagamento'] = $pagamento;
      $cli_parcelas->update($field, $cli_parcelas->getPrimaryKeyName() .'='. $cod_cli_parcelas);

      
    }
  }
  
  
  
  public function setRetornoBcash($FORM) {
    
    $bcash        = new BCash();
    $cli_parcelas = new ClientesParcelasModel();
    
    $token          = '741A5CE66DB270A5F500B528CAB578D2';
    $id_transacao   = $FORM['id_transacao'];
    $status         = $FORM['status'];
    $cod_status     = $FORM['cod_status'];
    $valor_original = $FORM['valor_original'];
    $valor_loja     = $FORM['valor_loja'];
    $tipo_pagamento = $FORM['tipo_pagamento'];
    $data_transacao = $FORM['data_transacao'];
    $id_pedido      = $FORM['id_pedido'];
    
    $post = 'transacao='. $id_transacao.
            '&status='. $status.
            '&cod_status='. $cod_status.
            '&valor_original='. $valor_original.
            '&valor_loja='. $valor_loja.
            '&token='. $token;
    
    ob_start();
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, 'https://www.bcash.com.br/checkout/verify/');
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec ($ch);
    $resposta = ob_get_contents();
    ob_end_clean();

    if(trim($resposta)=='VERIFICADO') {
      
      if ($cod_status==1) {
        $field['data_pagamento'] = Date::brTotimestamp($data_transacao);
        $field['cod_status']     = 6;
      }
      
      $field['pagamento_nome']       = $tipo_pagamento;
      $field['pagamento_status']     = $status;
      $field['pagamento_cod']        = $cod_status;
      $field['pagamento_id']         = $id_transacao;
      $field['pagamento_trans_data'] = Date::brTotimestamp($data_transacao);
      
      if ($id_pedido) {
        $cli_parcelas->update($field, "num_pedido='". $id_pedido ."'");
      }
      
    }
    
    $bcash->saveRequest('retorno', $id_pedido);
      
  }
  
  
  public function setAvisoBcash($FORM) {
    
    $cli_parcelas = new ClientesParcelasModel();
    $bcash        = new BCash();
    
    $id_transacao = $FORM['id_transacao'];
    $status       = $FORM['status'];
    $id_pedido    = $FORM['id_pedido'];
    
    $field['pagamento_status'] = $status;
   
    if ($id_pedido) {
      $cli_parcelas->update($field, "num_pedido='". $id_pedido ."'");
    }
    
    $bcash->saveRequest('aviso', $id_pedido);

  }

  
  public function parcelaDados($cod_cli_parcelas) {
    
    if ($cod_cli_parcelas) {
      
      $cli_plano    = new ClientesPlanosModel();
      $cli_parcelas = new ClientesParcelasModel();
      
      $row = array();
      
      $cli_parcelas->query("
        SELECT cpa.*, cpi.*,c.cod_cliente, c.data_cadastro, c.nome, c.cpf, c.telefone, c.celular, c.email, c.senha, c.cep, c.endereco, c.numero, c.complemento, c.estado, c.cidade, c.bairro FROM clientes_parcelas cpa
        INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
        INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
        WHERE cpa.cod_cli_parcelas = ". $cod_cli_parcelas
      );
      
      $row_parcela = $cli_parcelas->getResults();
      $row         = $row_parcela[0];
      
      $cli_plano->query("
        SELECT p.plano, cp.*  FROM clientes_planos cp
        INNER JOIN planos p ON cp.cod_plano = p.cod_plano
        WHERE cp.cod_cli_periodo = ". $row_parcela[0]['cod_cli_periodo']
      );
      
      $row_planos = $cli_plano->getResults();
      $row['planos'] = $row_planos;
      
      return $row;
      
    }
    
  }
  
}
?>