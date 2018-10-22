<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class AdministracaoConfigAction extends Action
{
  
  public function grava($incluir, $FORM) {
    
    if (!$incluir) {
      
      OpcoesHelper::set('email_sistema_login', $FORM['email_sistema_login']);
      OpcoesHelper::set('email_sistema_senha', Security::encripty($FORM['email_sistema_senha']));
      OpcoesHelper::set('email_sistema_host', $FORM['email_sistema_host']);
      OpcoesHelper::set('email_sistema_porta', $FORM['email_sistema_porta']);
      OpcoesHelper::set('email_sistema_seguranca', $FORM['email_sistema_seguranca']);
      OpcoesHelper::set('email_contato', $FORM['email_contato']);
      OpcoesHelper::set('google_analytics', $FORM['google_analytics']);
      OpcoesHelper::set('google_maps', $FORM['google_maps']);
      OpcoesHelper::set('social_facebook', $FORM['social_facebook']);
      
      $this->setReturnMensage('Configurações alteradas.');
      
    }
  }
  
}

?>