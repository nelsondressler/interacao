<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
class SiteClientesAction extends Action
{

  public $pagination;


  public function lembraSenha($login) {
    
    $cliente = new ClientesModel();
    $cliente->selectOne('*', "email='". $login ."'");
    
    $row = $cliente->getResults();
    
    if ($row) {
      
      $emailsys = new EmailSystem();
      $emailsys->enviaSenhaCliente($row['cod_cliente']);
      $this->setReturnMensage('Um lembrete de senha foi enviado para o e-mail '. $row['email'] );
      
    } else {
      
      $this->setReturnMensage('O e-mail '. $email .' não foi encontrado.');
      
    }
    
  }
  
  
  public function login($login, $senha) {
    
    $cliente = new ClientesModel();
    $cliente->selectOne('*', "email='". $login ."'");
    $row = $cliente->getResults();
    
    if ($row) {
      if ($row['senha'] == $senha) {
        
        if ($row['cod_status'] == 1) {
          
          $_SESSION["site_cod_cliente"]  = $row["cod_cliente"];
          $_SESSION["site_nome_cliente"] = $row["nome"];
          
        } else {
          $this->setReturnMensage('Seu cadastro não esta ativo.');
        }
        
      } else {
        $this->setReturnMensage('Senha incorreta.');
      }
      
    } else {
      $this->setReturnMensage('O e-mail não foi encontrado.');
    }
    
  }
  
  
  public function exibe($cod) {
    
    if ($cod) {
      
      $cliente = new ClientesModel();
      $cliente->selectOne('*', $cliente->getPrimaryKeyName() .'='. $cod);
      return $cliente->getResults();
      
    }

  }
  
  
  
  public function verificaEmail($email) {
     
    $cliente = new ClientesModel();
    $cliente->selectOne('*', "email='". $email ."' ");
    
    if ($cliente->getTotalRows() > 0) {
      return true;
    }
    
    return false;
    
  }
  
  
  
  public function grava($incluir, $FORM) {
     
    $cliente   = new ClientesModel();
    $email_sys = new EmailSystem();
    
    $where = '';
    $erros = false;
    
    if ($_SESSION["site_cod_cliente"]) {
      $where = 'AND NOT '. $cliente->getPrimaryKeyName() .'='. $_SESSION["site_cod_cliente"];
    }
    
    $cliente->selectOne('*', "email='". $FORM['email'] ."' ". $where);
    
    if ($cliente->getTotalRows() > 0) {
      
      $erros = true;
      $this->setReturnCode('email-existe');
      
    }
    
    if (!(trim($FORM['nome']) &&
        trim($FORM['cpf']) &&
        trim($FORM['telefone']) &&
        trim($FORM['email']) &&
        trim($FORM['senha']) &&
        trim($FORM['cep']) &&
        trim($FORM['endereco']) &&
        trim($FORM['numero']) &&
        trim($FORM['estado']) &&
        trim($FORM['cidade']) )
        ) {
          $erros = true;
          $this->setReturnCode('campos-invalidos');
        }

    
    if (!$erros) {
    
      $field['cod_status']    = 1;
      $field['nome']          = $FORM['nome'];
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
      $field['indicacao_qual']= $FORM['indicacao_qual']." - ".$FORM['indicacao_quando'];
      
      // Inclui
      if ($incluir) {
        
        $field['cpf'] = Useful::limpaDocumento($FORM['cpf']);
         
        if (!$_SESSION["site_cod_cliente"]) {
          
          $field['data_cadastro'] = date('Y-m-d');
          $cliente->insert($field);
          $cod_cliente = $cliente->getLastInsertKey();
          $email_sys->siteCadastro($cod_cliente);
          
          $_SESSION["site_cod_cliente"]  = $cod_cliente;
          $_SESSION["site_nome_cliente"] = $FORM['nome'];
          
        }
        
        $this->setReturnCode('cadastro-incluido');
        
      // Alterar
      } else {
        
        $cliente->update($field, $cliente->getPrimaryKeyName() .'='. $_SESSION["site_cod_cliente"]);
        $this->setReturnCode('cadastro-alterado');
            
      }
      
      
    }
    
  }
  
  
  public function listaPeriodos() {
    
    $cli_periodo = new ClientesPeriodosModel();
    
    $where   = 'clientes_periodos.cod_cliente='. $_SESSION["site_cod_cliente"];
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
    $where   = 'clientes_periodos.cod_cliente='. $_SESSION["site_cod_cliente"] . ' AND clientes_periodos.cod_cli_periodo='. $cod_cli_periodo;
    $join    = 'INNER JOIN periodos ON clientes_periodos.cod_periodo=periodos.cod_periodo';
    
    $cli_periodo->selectOne('*', $where, $join);
    $row['periodo'] = $cli_periodo->getResults();
    
    // planos
    $where = 'clientes_planos.cod_cli_periodo='. $cod_cli_periodo;
    $join  = 'INNER JOIN planos ON clientes_planos.cod_plano=planos.cod_plano';
    
    $cli_planos->selectAll('*', $where, null, null, $join);
    $row['planos'] = $cli_planos->getResults();
    
    
    // parcelas
    $where = 'clientes_parcelas.cod_cli_periodo='. $cod_cli_periodo . ' AND clientes_periodos.cod_cliente='. $_SESSION["site_cod_cliente"];
    $join  = 'INNER JOIN clientes_periodos ON clientes_parcelas.cod_cli_periodo=clientes_periodos.cod_cli_periodo
              INNER JOIN status ON clientes_parcelas.cod_status=status.cod_status';
    
    $cli_parcelas->selectAll('*', $where, 'data_vencimento', null, $join);
    $row['parcelas'] = $cli_parcelas->getResults();
    
    return $row;
    
  }
  
}
?>