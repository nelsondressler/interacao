<?php

class SiteContatosAction extends Action
{
  
  public function enviaContato($FORM) {
    

    if ($FORM['email'] && $FORM['nome']) {
      
      if ($_SESSION["site_idioma"]) {
        //include SYS_PATH .'app/idioma/'. $_SESSION["site_idioma"] .'.php';
      }
      
      $contato  = new ContatosModel();
      $emailsys = new EmailSystem();
  
      $field['nome']     = $FORM['nome'];
      $field['email']    = $FORM['email'];
      $field['telefone'] = $FORM['telefone'];
      $field['assunto']  = $FORM['assunto'];
      $field['mensagem'] = $FORM['mensagem'];
      $field['data']     = date("Y-m-d");
      
      $contato->insert($field);
      $emailsys->siteContato($contato->getLastInsertKey());
      
      $this->setReturnMensage('Mensagem enviada com sucesso!');
      
    }
      
  }
  
}
?>