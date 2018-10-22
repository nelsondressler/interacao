<p>
  Prezado amigo,<br /> <br /> Seja bem vindo a InterA&Ccedil;&Atilde;O, <span class="texto_form_mensagens">voc&ecirc; receber&aacute; um e-mail todo o m&ecirc;s para lembrar o pagamento da sua parcela at&eacute; a data do sorteio. </span>
</p>
<p>
  Sua aquisição foi:<strong>
  <?php
  foreach ($row['planos'] as $list) {
    echo $list['plano'] .', ';
  }
  ?>
  </strong>
</p>
<p>
  Caso ainda n&atilde;o tenha efetuado o pagamento da sua primeira parcela, entre em <a href="<?php echo SYS_SITE ?>user-pagamento.php?p=<?php echo Security::encripty($row['parcela']['cod_cli_parcelas']) ?>"><?php echo SYS_SITE ?>user-pagamento.php?p=<?php echo Security::encripty($row['parcela']['cod_cli_parcelas']) ?> </a> . <br /> Voc&ecirc; tamb&eacute;m pode efetuar o pagamento entrando na &ldquo;<a href="<?php echo SYS_SITE ?>user-login.php">Area restrita</a>&rdquo; de nosso site, l&aacute; voc&ecirc; encontra as
  informa&ccedil;&otilde;es de cobran&ccedil;a e seus dados.
</p>
<p>
  <strong>Vencimento:</strong>
  <?php echo Date::timestampToBr($row['parcela']['data_vencimento']) ?>
  <br /> <strong>Valor:</strong> R$
  <?php echo Number::formatCurrencyBr($row['parcela']['valor']) ?>
  <br /> <br /> Atenciosamente,<br /> <br /> Comissão de Pais e Ex-Alunos<br /> Lubavitch-Gani<br /> <a href="http://www.interacao.gani.org.br">www.interacao.gani.org.br</a>
</p>
