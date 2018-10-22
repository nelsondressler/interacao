<?php

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
      table td {
        font: 12px Arial;
        color: #00000;
      }
      </style>
      </head>
      <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
      <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="left" bgcolor="#F0F0F0"><strong><font size="5">'. SYS_NOME .'</font></strong></td>
          <td align="right" bgcolor="#F0F0F0">&nbsp;</td>
        </tr>
        <tr>
          <td height="50" colspan="2">
            <strong><font size="3"> '. $titulo .' </font></strong>
          </td>
        </tr>
        <tr>
          <td height="1" colspan="2"> </td>
        </tr>
        <tr>
          <td colspan="2" valign="top"> '. $body .' </td>
        </tr>
        <tr>
          <td height="1" colspan="2"> </td>
        </tr>
      </table>
      </body>
      </html>
      ';
  }
  
 
  protected function getTemplate($arquivo) {
    
    return SYS_PATH .'app/template_email/'. $arquivo;
    
  }
  
}