<p>Prezado  amigo,<br />
  <br />
Este &eacute; um e-mail AUTOM&Aacute;TICO para lhe lembrar de sua mensalidade junto &agrave; InterA&Ccedil;&Atilde;O.
<br />
Caso ainda  n&atilde;o tenha efetuado o pagamento do vencimento abaixo, entre em <a href="<?php echo SYS_SITE ?>user-pagamento.php?p=<?php echo Security::encripty($row['cod_cli_parcelas']) ?>"><?php echo SYS_SITE ?>user-pagamento.php?p=<?php echo Security::encripty($row['cod_cli_parcelas']) ?></a> . <br />
Voc&ecirc; tamb&eacute;m pode efetuar o pagamento entrando na &ldquo;<a href="<?php echo SYS_SITE ?>user-login.php">Area  restrita</a>&rdquo; de nosso site, l&aacute; voc&ecirc; encontra as informa&ccedil;&otilde;es de cobran&ccedil;a e seus  dados.</p>
<p>  <strong>Vencimento:</strong> <?php echo Date::timestampToBr($row['data_vencimento']) ?><br />
  <strong>Valor:</strong> R$ <?php echo Number::formatCurrencyBr($row['valor']) ?><br />
  <br />
  Atenciosamente,<br />
  <br />
  Departamento Financeiro<br />
  <a href="http://www.interacao.gani.org.br">www.interacao.gani.org.br</a><a href="https://www.interacao.gani.org.br"></a></p>
