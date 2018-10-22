<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
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
    
  public function getCodCliPeriodo($cod_cliente, $cod_periodo){
      $cli_periodo = new ClientesPeriodosModel();
      
      $where = 'cod_cliente='. $cod_cliente .' AND cod_periodo='. $cod_periodo;
      
      $cli_periodo->selectOne('*', $where);
      $row = $cli_periodo->getResults();
      
      if (count($row) > 0) {
          return $row['cod_cli_periodo'];
      } else {
          return false;
      }
  }
  
  public function getCodPeriodo($FORM){
    $planos = $FORM['cod_plano'];
    if (count($planos) > 0) {
        $row_plano   = $this->exibe($planos[0]);
        $cod_periodo = $row_plano['cod_periodo'];
        return $cod_periodo;
    } else {
        return false;
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
        $valores[$i]['valor']         = $row_plano['valor'];
        $valores[$i]['valor_desconto']= 0;
        $valores[$i]['desconto']      = 0;
        $valores[$i]['cod_plano']     = $planos[$i];
      }
    }
    
    sort($valores);
    $totalv = count($valores);
    
    if ($totalv == 2) {
      $valores[0]['desconto']       = 10;
      $valores[0]['valor_desconto'] = $valores[0]['valor'] - ($valores[0]['valor'] * ($valores[0]['desconto']/100));
      
    } else if ($totalv == 3) {
      $valores[0]['desconto']       = 10;
      $valores[0]['valor_desconto'] = $valores[0]['valor'] - ($valores[0]['valor'] * ($valores[0]['desconto']/100));
      $valores[1]['desconto']       = 10;
      $valores[1]['valor_desconto'] = $valores[1]['valor'] - ($valores[1]['valor'] * ($valores[1]['desconto']/100));
    }
    
    return $valores;
    
  }
  
  
  public function incluirPlano($FORM) {
    
    $cli_periodo  = new ClientesPeriodosModel();
    $cli_plano    = new ClientesPlanosModel();
    $cli_parcelas = new ClientesParcelasModel();
    $emailsys     = new EmailSystem();
    
    $cod_cliente    = $FORM['usuario'];//$_SESSION["site_cod_cliente"];
    $planos         = $FORM['cod_plano'];

    
    
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
      $field['dia_vencimento']= $dia;
      
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

          $data_vencimento = date("Y-m-d", mktime (0, 0, 0, date("m") + $i, $dia, date("Y")));
        
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
      
 //     $emailsys->enviaCompraPlanos($cod_cli_periodo);
      
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
  
  
  
  public function setRetornoPagseguro($FORM) {
    

      
  }
  
  
  public function setAvisoPagseguro($FORM) {

    $cli_parcelas = new ClientesParcelasModel();
    $pagseguro    = new Pagseguro();
    
    if(PAG_AMBIENTE == "sandbox")
    {
        $pagseguro->setAuth(PAG_USUARIO,PAG_TOKEN_SAND);
    } else {
        $pagseguro->setAuth(PAG_USUARIO, PAG_TOKEN_PROD);
    }
    
    $pagseguro->setEnviroment(PAG_AMBIENTE);
    $xml = $pagseguro->getDataByCode($FORM);
    $filesys= new FileSystem();
    $filesys->cria(SYS_CONTEUDO .'temp/pagseguro/geral_'. date('Y-m-d H-i-s') .'.txt', print_r($xml,true));
    if($xml->getName() == 'preApproval'){
        $reference = $xml->reference;
        if(strpos($reference,'-')){
            $comb=explode('-',$reference);
            $tipo=$comb[0];
            $dado=$comb[1];
            if($tipo=='assinatura'){
                $post=$this->decodificaPostInserir($dado);
                $cod_cliente=$post['usuario'];
                $cod_periodo=$this->getCodPeriodo($post);
                $cod_cli_periodo=$this->getCodCliPeriodo($cod_cliente, $cod_periodo);
                if(!$cod_cli_periodo){
                    $this->incluirPlano($post);
                }
            }
        }
        $filesys= new FileSystem();
        $filesys->cria(SYS_CONTEUDO .'temp/pagseguro/preApproval_'. date('Y-m-d H-i-s') .'.txt', print_r($xml,true));
    }
    if($xml->getName() == 'transaction'){
        $reference = $xml->reference;
        $filesys= new FileSystem();
        $filesys->cria(SYS_CONTEUDO .'temp/pagseguro/transaction_'. date('Y-m-d H-i-s') .'.txt', print_r($xml,true));
        if(strpos($reference,'-')){
            $comb=explode('-',$reference);
            $tipo=$comb[0];
            $dado=$comb[1];
            if($tipo=='assinatura'){
                if($xml->status==3){
                    $post=$this->decodificaPostInserir($dado);
                    $cod_cliente=$post['usuario'];
                    $cod_periodo=$this->getCodPeriodo($post);
                    $cod_cli_periodo=$this->getCodCliPeriodo($cod_cliente, $cod_periodo);
                    if(!$cod_cli_periodo){
                        $this->incluirPlano($post);
                        $cod_cli_periodo = $_SESSION['cod_cli_periodo'];
                    }
                    $cli_parcelas->query("
                      SELECT cpa.cod_cli_parcelas FROM clientes_parcelas cpa
                      INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
                      INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
                      WHERE cpa.cod_status <> 6 AND cpa.cod_cli_periodo = ". $cod_cli_periodo ." ORDER BY cod_cli_parcelas ASC LIMIT 1
                    ");
                    $row = $cli_parcelas->getResults();
                    $parcela = $row[0]['cod_cli_parcelas'];
                    
                    $field=array(
                        'cod_status' => 6,
                        'pagamento' => 'pagseguro',
                        'pagamento_status' => 'Aprovado',
                        'pagamento_nome' => 'Pagseguro Assinatura',
                        'pagamento_id' => $xml->code,
                        'pagamento_trans_data' => date('Y-m-d'),
                        'data_pagamento' => date('Y-m-d')
                    );
                    $cli_parcelas->update($field, "cod_cli_parcelas=". $parcela);
                }
            }
            if($tipo=='pagamento'){
                if($xml->status==3){
                    $field=array(
                        'cod_status' => 6,
                        'pagamento' => 'pagseguro',
                        'pagamento_status' => 'Aprovado',
                        'pagamento_nome' => 'Pagseguro Avulso',
                        'pagamento_id' => $xml->code,
                        'pagamento_trans_data' => date('Y-m-d'),
                        'data_pagamento' => date('Y-m-d')
                    );
                    $cli_parcelas->update($field, "cod_cli_parcelas=". $dado);
                }
            }
        }
    }
    
//    $bcash->saveRequest('aviso', $id_pedido);

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
  
  public function codificaPostInserir($POST) {
    $planos = $POST['cod_plano'];
    $saida=array();
    if (count($planos) > 0) {
        foreach ($planos as $plano){
            $saida[]=$plano.'-'.$POST['valor'.$plano];
        }
    }
    $saida['u']=$POST['usuario'];
    $saida_json = json_encode($saida);
    return Security::encripty($saida_json);
  }
  
  public function decodificaPostInserir($post_codificado) {
    $post=array();
    $post_json = Security::decripty($post_codificado);
    $dados=json_decode($post_json, true);
    if(is_array($dados)){
        $post['usuario']=$dados['u'];
        unset($dados['u']);
        foreach ($dados as $dado){
            $info=explode('-', $dado);
            $post['cod_plano'][]=$info[0];
            $post['valor'.$info[0]] = $info[1];
        }
        $post['acao']='inserir';
    } else {
        return array();
    }
    return $post;
  }
  
  public function criaAssinatura($FORM){
      $clientes = new SiteClientesAction();
      $pagseguro = new Pagseguro();
      $codificado=$this->codificaPostInserir($FORM);

      $valores     = $this->calculaValores($FORM);
      $valor_total = 0;
      
      for ($i = 0; $i < count($valores); $i++) {
        
        if ($valores[$i]['valor_desconto'] > 0) {
          $valor_total += $valores[$i]['valor_desconto'];
        } else {
          $valor_total += $valores[$i]['valor'];
        }
      }

      $nome_planos=array();
      $planos         = $FORM['cod_plano'];
      $txt_planos='dos planos';
      if(count($planos)==1) {
          $txt_planos='do plano';
      }
        foreach ($planos as $plano){
            $row_plano   = $this->exibe($plano);
            $nome_planos[]=$row_plano['plano'];
        }
        //$row_plano['data_fim'];
        $data_fim_plano=date('Y-m-d', strtotime($row_plano['data_fim']));
        $data_maxima_fim_plano=date('Y-m-t', strtotime($data_fim_plano)); //pega o ultimo dia do mes do fim do plano
        $data_fim_assinatura=date('Y-m-d',strtotime("+12 months"));
        if($data_fim_assinatura > $data_maxima_fim_plano){
                $data_fim=$data_maxima_fim_plano;
        } else {
                $data_fim=date('Y-m-t', strtotime($data_fim_assinatura)); //Ultimo dia do mes da data da assinatura +12 meses
        }
        
        $periodicidade = 'Monthly';
        
        if(isset($FORM['teste']) && $FORM['teste']=='teste'){
            $valor_total=1;
            $periodicidade = 'WEEKLY';
        }
        
        $data_fim.='T00:00:000-03:00';
        $dados_assinatura = "Assinatura $txt_planos: " . utf8_encode(implode(', ',$nome_planos));
       
        $dados=array(
            'charge'=>'auto',
            'name'=> $dados_assinatura,
            'details'=>utf8_encode('Todo mês neste dia será cobrado o valor de R$'.  number_format($valor_total,2,',','')." referente à assinatura $txt_planos"),
            'amountPerPayment'=>number_format($valor_total,2,'.',''),
            'period'=> $periodicidade,
            'finalDate'=>$data_fim,
            'maxTotalAmount'=>number_format($valor_total * 12,2,'.','')
        );
//print_r($dados); die();
        if(PAG_AMBIENTE == "sandbox")
        {
            $pagseguro->setAuth(PAG_USUARIO,PAG_TOKEN_SAND);
        } else {
            $pagseguro->setAuth(PAG_USUARIO, PAG_TOKEN_PROD);
        }
        $pagseguro->setEnviroment(PAG_AMBIENTE);
        $pagseguro->setRedirectUrl('http://www.interacao.gani.org.br/pagseguro-retorno.php');
        $pagseguro->setNotificationUrl('http://www.interacao.gani.org.br/pagseguro-aviso.php');

        $pagseguro->setReference('assinatura-'.$codificado);
        $pagseguro->setPreApproval($dados);
        $retorno = $pagseguro->sendRequest();
        if($retorno){
                //echo $retorno;
                $pagseguro->redirect($retorno);
        } else {
                echo $pagseguro->error();
        }
  }
  
  
  
  
  public function setAvisoPagseguroTeste($xml) {

    $cli_parcelas = new ClientesParcelasModel();
    
    
    if($xml->getName() == 'preApproval'){
        $reference = $xml->reference;
        if(strpos($reference,'-')){
            $comb=explode('-',$reference);
            $tipo=$comb[0];
            $dado=$comb[1];
            if($tipo=='assinatura'){
                $post=$this->decodificaPostInserir($dado);
                $cod_cliente=$post['usuario'];
                $cod_periodo=$this->getCodPeriodo($post);
                $cod_cli_periodo=$this->getCodCliPeriodo($cod_cliente, $cod_periodo);
                if(!$cod_cli_periodo){
                    $this->incluirPlano($post);
                }
            }
        }
        $filesys= new FileSystem();
        $filesys->cria(SYS_CONTEUDO .'temp/pagseguro/preApproval_'. date('Y-m-d H-i-s') .'.txt', print_r($xml,true));
    }
    if($xml->getName() == 'transaction'){
        $reference = $xml->reference;
        $filesys= new FileSystem();
        $filesys->cria(SYS_CONTEUDO .'temp/pagseguro/transaction_'. date('Y-m-d H-i-s') .'.txt', print_r($xml,true));
        if(strpos($reference,'-')){
            $comb=explode('-',$reference);
            $tipo=$comb[0];
            $dado=$comb[1];
            if($tipo=='assinatura'){
                if($xml->status==3){
                    $post=$this->decodificaPostInserir($dado);
                    $cod_cliente=$post['usuario'];
                    $cod_periodo=$this->getCodPeriodo($post);
                    $cod_cli_periodo=$this->getCodCliPeriodo($cod_cliente, $cod_periodo);
                    if(!$cod_cli_periodo){
                        $this->incluirPlano($post);
                    }
                    $cli_parcelas->query("
                      SELECT cpa.cod_cli_parcelas FROM clientes_parcelas cpa
                      INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
                      INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
                      WHERE cpa.cod_status <> 6 AND cpa.cod_cli_periodo = ". $cod_cli_periodo ." ORDER BY cod_cli_parcelas ASC LIMIT 1
                    ");
                    $row = $cli_parcelas->getResults();
                    $parcela = $row[0]['cod_cli_parcelas'];
                    
                    $field=array(
                        'cod_status' => 6,
                        'pagamento' => 'pagseguro',
                        'pagamento_status' => 'Aprovado',
                        'pagamento_nome' => 'Pagseguro Assinatura',
                        'pagamento_id' => $xml->code,
                        'pagamento_trans_data' => date('Y-m-d'),
                        'data_pagamento' => date('Y-m-d')
                    );
                    $cli_parcelas->update($field, "cod_cli_parcelas=". $parcela);
                }
            }
            if($tipo=='pagamento'){
                if($xml->status==3){
                    $field=array(
                        'cod_status' => 6,
                        'pagamento' => 'pagseguro',
                        'pagamento_status' => 'Aprovado',
                        'pagamento_nome' => 'Pagseguro Avulso',
                        'pagamento_id' => $xml->code,
                        'pagamento_trans_data' => date('Y-m-d'),
                        'data_pagamento' => date('Y-m-d')
                    );
                    $cli_parcelas->update($field, "cod_cli_parcelas=". $dado);
                }
            }
        }
    }
    
//    $bcash->saveRequest('aviso', $id_pedido);

  }
  
  
  
}
?>
