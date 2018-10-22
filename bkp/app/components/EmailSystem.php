<?php

class EmailSystem extends EmailSystemTemplate
{
  
  private $emailsend;
  
  public $erro_msg;
  
  public function __construct() {
    
    $this->emailsend = new SendEmail();
    $this->erro_msg  = '';
    
  }

  
  public function lembraSenha($nome, $email, $senha) {
    
    $template = new Template( parent::getTemplate('lembra_senha.php') );
    
    $array['nome']  = $nome;
    $array['senha'] = $senha;
    
    $template->setDados('row', $array);
    $html = $template->getHtml();
    
    $email_contato = OpcoesHelper::get('email_sistema_login');
    $body = parent::emailHeader('LEMBRETE DE SENHA', $html);
    
    $this->emailsend->fastSend($email_contato, SYS_NOME, '',  $email_contato, 'Lembrete de senha', $body);
    
  }
  
  
  public function siteContato($cod) {
    
    if ($cod) {
      
      $template = new Template( parent::getTemplate('site_contato.php') );
      $contato  = new ContatosModel();

      $contato->selectOne('*', $contato->getPrimaryKeyName() .'='. $cod);
      $row = $contato->getResults();
      
      $template->setDados('row', $row);
      $html = $template->getHtml();
      
      $from_email = OpcoesHelper::get('email_contato');
      $from_name  = 'InterAчуo';
      $to_email   = OpcoesHelper::get('email_contato');
      $to_name    = 'InterAчуo';
      $subject    = 'Contato enviado pelo site';
      $body       = parent::emailHeader('InterAчуo', $html);
      
      $this->emailsend->fastSend($from_email, $from_name, $to_email, $to_name, $subject, $body);
      
    }
  }

  
  
  public function enviaSenhaCliente($cod_cliente = null) {
    
    if ($cod_cliente) {
      
      $template = new Template( parent::getTemplate('lembra_senha_site.php') );
      
      $cliente = new ClientesModel();
      $cliente->selectOne('*', $cliente->getPrimaryKeyName() .'='. $cod_cliente);
      $row = $cliente->getResults();
      
      $template->setDados('row', $row);
      $html = $template->getHtml();
      
      $from_email = OpcoesHelper::get('email_contato');
      $from_name  = 'InterAчуo';
      $to_email   = $row['email'];
      $to_name    = 'InterAчуo';
      $subject    = 'Seu acesso ao site';
      $body       = parent::emailHeader('Lembrete de senha', $html);
      
      $this->emailsend->fastSend($from_email, $from_name, $to_email, $to_name, $subject, $body);
      
    }
    
  }
  
  
  public function enviaCompraPlanos($cod_cli_periodo) {
    
    if ($cod_cli_periodo) {
      
      $row = array();
      
      $cli_periodo  = new ClientesPeriodosModel();
      $cli_planos   = new ClientesPlanosModel();
      $cli_parcelas = new ClientesParcelasModel();
      $template     = new Template( parent::getTemplate('compra_plano.php') );
      
      // periodo
      $where   = 'clientes_periodos.cod_cli_periodo='. $cod_cli_periodo;
      $join    = 'INNER JOIN periodos ON clientes_periodos.cod_periodo=periodos.cod_periodo
                  INNER JOIN clientes ON clientes.cod_cliente=clientes_periodos.cod_cliente';
      
      $cli_periodo->selectOne('*', $where, $join);
      $row['periodo'] = $cli_periodo->getResults();
      
      // planos
      $where = 'clientes_planos.cod_cli_periodo='. $cod_cli_periodo;
      $join  = 'INNER JOIN planos ON clientes_planos.cod_plano=planos.cod_plano';
      
      $cli_planos->selectAll('*', $where, null, null, $join);
      $row['planos'] = $cli_planos->getResults();
      
      // parcela
      $cli_parcelas->query("
        SELECT cpa.* FROM clientes_parcelas cpa
        INNER JOIN clientes_periodos cpi ON cpi.cod_cli_periodo = cpa.cod_cli_periodo
        INNER JOIN clientes c ON c.cod_cliente = cpi.cod_cliente
        WHERE c.cod_cliente = ". $row['periodo']['cod_cliente'] ."
        ORDER BY cpa.data_vencimento ASC
      ");
      
      $row_parcela    = $cli_parcelas->getResults();
      $row['parcela'] = $row_parcela[0];
      
      $template->setDados('row', $row);
      $html = $template->getHtml();
      
      $from_email = '';
      $from_name  = 'InterAчуo';
      $to_email   = $row['periodo']['email'];
      $to_name    = 'InterAчуo';
      $subject    = 'Aquisiчуo de novo plano na InterAчуo';
      $body       = parent::emailHeader('Aquisiчуo de novo plano', $html);
      
      return $this->emailsend->fastSend($from_email, $from_name, $to_email, $to_name, $subject, $body);
      
    }
    
  }
  
  
  public function enviaCobranca($row) {
    
    if ($row) {
      
      $template = new Template( parent::getTemplate('cobranca_apagar.php') );
      
      $template->setDados('row', $row);
      $html = $template->getHtml();
      
      $from_email = '';
      $from_name  = 'InterAчуo';
      $to_email   = $row['email'];
      $to_name    = 'InterAчуo';
      $subject    = 'Lembrete de vencimento da mensalidade';
      $body       = parent::emailHeader('Vencimento da mensalidade', $html);
      
      return $this->emailsend->fastSend($from_email, $from_name, $to_email, $to_name, $subject, $body);
      
    }
    
  }
  
  
  public function enviaCobrancaAtrasado($row) {
    
    if ($row) {
      
      $template = new Template( parent::getTemplate('cobranca_atrasado.php') );
      
      $template->setDados('row', $row);
      $html = $template->getHtml();
      
      $from_email = '';
      $from_name  = 'InterAчуo';
      $to_email   = $row['email'];
      $to_name    = 'InterAчуo';
      $subject    = 'Aviso de mensalidade atrasada';
      $body       = parent::emailHeader('Aviso de atraso', $html);
      
      return $this->emailsend->fastSend($from_email, $from_name, $to_email, $to_name, $subject, $body);
      
    }
    
  }
  
  
}
?>