<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
class SendEmail
{
    
  public function fastSend($from_email, $from_name, $to_email, $to_name, $subject, $body, $attachment = null) {
    
    require_once SYS_FRAMEWORK .'email/class.phpmailer.php';
    
    if (!$from_name) {
      $from_name = 'InterAção';
    }
    
    $lista_to_email = explode(';', $to_email);
    $principal = trim($lista_to_email[0]);
    
    if(!$to_name) {
      $to_name = $principal;
    }
    
    $mail = new PHPMailer();
    $mail->SetLanguage('br', SYS_FRAMEWORK .'/email/language/phpmailer.lang-br.php');
    
    $mail->From     = OpcoesHelper::get('email_sistema_login');
    $mail->FromName = $from_name;
    $mail->Subject  = $subject;
    $mail->AddAddress($principal, $to_name);
    
    //echo $principal;
    
    for ($i = 1; $i < count($lista_to_email); $i++) {
      if ($lista_to_email[$i]) {
        $mail->AddCC(trim($lista_to_email[$i]), $lista_to_email[$i]);
        //echo $lista_to_email[$i] .'<br>';
      }
    }
    
    if ($attachment) {
      $mail->AddAttachment($attachment);
    }
    
    //exit;
    $mail->MsgHTML( $body );
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    
    $mail->Port     = OpcoesHelper::get('email_sistema_porta');
    $mail->Host     = OpcoesHelper::get('email_sistema_host');
    $mail->Username = OpcoesHelper::get('email_sistema_login');
    $mail->Password = Security::decripty(OpcoesHelper::get('email_sistema_senha'));
    
    $seguranca = OpcoesHelper::get('email_sistema_seguranca');
    
    if ($seguranca) {
      $mail->SMTPSecure = $seguranca;
    }

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    //$mail->SMTPDebug = 1;
    //$mail->Debugoutput = 'html';
    
    $retorno = $mail->Send();
    
    if ($retorno) {
      return true;
    } else {
      echo $mail->ErrorInfo;
      return false;
    }
    
  }
  
  
}
?>