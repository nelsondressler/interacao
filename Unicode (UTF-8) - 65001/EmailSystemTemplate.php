<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class EmailSystemTemplate
{
  
  protected function emailHeader ($titulo, $body) {
    
    return '
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <style type="text/css">
      body {
        margin: 0;
        padding: 0;
        border: none;
        font: 12px Arial;
      }
      </style>
      </head>
      <body leftmargin="2" topmargin="2" marginwidth="2" marginheight="2">
      <p><strong><font size="3"> '. $titulo .' </font></strong></p>
      
      '. $body .'
      
      </body>
      </html>
      ';
  }
  
 
  protected function getTemplate($arquivo) {
    
    return SYS_PATH .'app/template_email/'. $arquivo;
    
  }
  
}