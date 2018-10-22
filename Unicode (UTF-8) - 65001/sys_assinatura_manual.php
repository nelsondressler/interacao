<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Criar assinatura manual');
SystemLayout::setModule('sys_assinatura_manual');

SystemLayout::addNavigate('Assinatura manual');
SystemLayout::addNavigate('Criar');

SystemLayout::setBack('home.php');
SystemLayout::setSubTitle("");

if (!SystemLayout::getPermissao(1)) {
    header('location: semacesso.php');
    exit;
}

$template_email = '../app/template_email/assinatura_manual.php';
$jvs = "";
if ($_POST['acao'] == 'incluir') {

    $dados = $_POST;
    $dados['valor'] = number_format(floatval(preg_replace("/[^0-9.,]/", "", $dados['valor'])), 2, ".", "");
    $dados['cep'] = str_replace("-", "", $dados['cep']);
    $dados['referencia'] = $dados['referencia'] . '-' . Date("U");

    $data_fim = Date('Y-m-d\TH:i:s\.\0\0\0\-\0\3\:\0\0', strtotime("+" . intval($dados['meses']) - 1 . " months"));


    if ($dados['dados'] == 'adm') {

        $pagseguro = new Pagseguro();


        if (PAG_AMBIENTE == "sandbox") {
            $pagseguro->setAuth(PAG_USUARIO, PAG_TOKEN_SAND);
        } else {
            $pagseguro->setAuth(PAG_USUARIO, PAG_TOKEN_PROD);
        }
        $pagseguro->setEnviroment(PAG_AMBIENTE);


        $assinatura = array(
            'charge' => 'auto',
            'name' => $dados['nome_assinatura'],
            'details' => $dados['descricao'],
            'amountPerPayment' => $dados['valor'],
            'period' => 'Monthly',
            'finalDate' => $data_fim,
            'maxTotalAmount' => number_format(floatval($dados['valor']) * intval($dados['meses']), 2, '.', '')
        );

        $endereco = array(
            'street' => $dados['rua'],
            'number' => $dados['numero'],
            'complement' => $dados['complemento'],
            'district' => $dados['estado'],
            'postalCode' => $dados['cep'],
            'city' => $dados['cidade'],
            'state' => $dados['estado'],
            'country' => 'BRA'
        );
        $fone = array(
            'areaCode' => $dados['ddd'],
            'number' => $dados['telefone']
        );
        //$pagseguro->setAuth('c.prates@yahoo.com.br', 'CF9804A85E4445809C64443EE5F69834');
        //$pagseguro->setEnviroment('sandbox');
        $pagseguro->setRedirectUrl('http://www.interacao.gani.org.br');
        $pagseguro->setNotificationUrl('http://www.interacao.gani.org.br');

        $pagseguro->setReference($dados['referencia']);
        $pagseguro->setSender($dados['nome'], $dados['email'], $fone, $endereco);
        $pagseguro->setPreApproval($assinatura);
        $retorno = $pagseguro->sendRequest();
        if ($retorno) {
            //echo $retorno;
            $pagseguro->redirect($retorno);
        } else {
            echo $pagseguro->error();
        }
    } else {
        $conteudo_email = $dados['conteudo_email'];

        if ($dados['salvar'] == 'Salvar') {
            file_put_contents($template_email, $dados['conteudo_email']);
        }
        unset(
                $dados['button'], $dados['acao'], $dados['cod'], $dados['dados'], $dados['salvar'], $dados['conteudo_email']
        );
        $adiciona = new AssinaturasManuaisModel();
        $adiciona->insert($dados);
        $novo_id = $adiciona->getLastInsertKey();

        $dados['id'] = $novo_id;

        $link_pag = SYS_SITE . 'user-assinatura.php?p=' . base64_encode($novo_id);
        $conteudo_email = str_replace('{LINK}', $link_pag, $conteudo_email);
        $emailsys = new EmailSystem();
        $emailsys->enviaAssinaturaManual($dados, $conteudo_email);
        $jvs = "<script>alert('Email enviado com sucesso!!!'); </script>";
    }
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/js/date_input/date_input.css"/>
<script type="text/javascript" src="assets/js/date_input/jquery.date_input.js"></script>
<script type="text/javascript" charset="utf-8"  src="assets/js/ckeditor/ckeditor.js"></script>

<script>

    $(function ($) {

        $('input[name=cep]').mask("99999-999");

        $('.linha_conteudo_email').hide();
        $('#dados').change(function () {
            if (this.value == 'cliente') {
                $('.linha_conteudo_email').show();
            } else {
                $('.linha_conteudo_email').hide();
            }
        });

    });

</script>

<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>


<form name="frm" action="<?php echo System::thisFile() ?>" method="post" onSubmit="return validaDados(this)" enctype="multipart/form-data">

    <div id="painel_geral">

        Campos na cor cinza, são obrigatórios

    </div>



    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">

        <tr>

            <td>Dados da Assinatura</td>

        </tr>

    </table>

    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">

        <tr>

            <td height="30" class="input_title">Nome Assinatura: </td>

            <td height="30"><input name="nome_assinatura" type="text" class="requerido" id="nome_assinatura" value="" size="100" maxlength="100" placeholder="COLOQUE UM NOME PARA ESTA ASSINATURA"/></td>

        </tr>

        <tr>

            <td height="30" class="input_title">Descrição: </td>

            <td height="30"><input name="descricao" type="text" id="descricao" value="" size="100" maxlength="100" placeholder="COLOQUE A DESCRIÇÃO DA ASSINATURA"/></td>

        </tr>

        <tr>

            <td height="30" class="input_title">Referência: </td>

            <td height="30"><input name="referencia" type="text" id="referencia" value="" size="100" maxlength="100" placeholder="COLOQUE UMA REFERENCIA PARA CONTROLE DA ASSINATURA"/></td>

        </tr>

        <tr>

            <td height="30" class="input_title">Valor:</td>

            <td height="30"><input name="valor" type="text" class="requerido" id="valor" value="" size="12" maxlength="12" placeholder="0,00" /><span class="input_title" style="margin-left:30px; margin-right:10px;">QTD de meses:</span>
                <select class="requerido" name="meses" id="meses">
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12" SELECTED>12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                </select>
            </td>

        </tr>

        <tr>

            <td height="30" class="input_title">Fornecimento dos dados do cartão:</td>

            <td height="30">
                <select name="dados" id="dados" class="requerido">
                    <option value="adm">Eu fornecerei os dados</option>
                    <option value="cliente">Enviar email ao cliente</option>
                </select>
            </td>

        </tr>

        <tr class="linha_conteudo_email">

            <td height="30" class="input_title">Salvar:</td>

            <td height="30">
                <input type="checkbox" name="salvar" id="salvar" value="Salvar">Salvar conteúdo do email como padrão
            </td>

        </tr>
        <tr class="linha_conteudo_email">

            <td height="30" class="input_title">Conteúdo do email enviado ao cliente:</td>

            <td height="30">
                <textarea name="conteudo_email" id="conteudo_email" rows="10" cols="80">
<?php
if (file_exists($template_email)) {
    include($template_email);
}
?>
                </textarea>
            </td>

        </tr>

    </table>

    <br />


    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">

        <tr>

            <td>Dados do Cliente</td>

        </tr>

    </table>

    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">

        <tr>

            <td height="30" class="input_title">Nome: </td>

            <td height="30"><input name="nome" type="text" class="requerido" id="nome" value="" size="100" maxlength="100" placeholder="NOME"/></td>

        </tr>

        <tr>

            <td height="30" class="input_title">Email:</td>

            <td height="30"><input name="email" type="text" class="requerido" id="email" value="" size="100" maxlength="100" placeholder="EMAIL" /></td>

        </tr>

        <tr>

            <td height="30" class="input_title">Telefone:</td>

            <td height="30"><input name="ddd" type="text" class="requerido" id="ddd" value="" placeholder="DDD Ex.11" size="10" maxlength="2" /><input name="telefone" type="text" class="requerido" id="telefone" value="" size="20" maxlength="20" placeholder="TELEFONE" style="margin-left: 10px;"/></td>

        </tr>

    </table>

    <br />



    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">

        <tr>

            <td>Endere&ccedil;o</td>

        </tr>

    </table>

    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">

        <tr>

            <td width="100" height="30" class="input_title">CEP:</td>

            <td height="30">

                <input name="cep" type="text" id="cep" class="requerido"  value="" size="10" maxlength="9" />

                <img src="assets/img/aguarde2.gif" name="cep_carregando" align="absmiddle" id="cep_carregando" style="display: none" />

                <a href="javascript:void(0)" class="color" onclick="return pegaEndereco(f)">Consultar</a> |

                <a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank" class="color">N&atilde;o sei o CEP</a> </td>

        </tr>

        <tr>

            <td height="30" class="input_title">Rua:</td>

            <td height="30">

                <input name="rua" type="text" class="requerido" id="rua" value="" size="100" maxlength="100" />

            </td>

        </tr>

        <tr>

            <td height="30" class="input_title">N&uacute;mero:</td>

            <td height="30">

                <input name="numero" type="text" class="requerido" id="numero" value="" size="10" maxlength="10" />

            </td>

        </tr>

        <tr>

            <td height="30" class="input_title">Complemento:</td>

            <td height="30">

                <input name="complemento" type="text" id="complemento" value="" size="50" maxlength="100" />

            </td>

        </tr>

        <tr>

            <td height="30" class="input_title">Bairro:</td>

            <td height="30">

                <input name="bairro" type="text" id="bairro" value="" size="100" maxlength="100" />

            </td>

        </tr>

        <tr>

            <td height="30" class="input_title">Estado:</td>

            <td height="30"><?php echo Useful::selectEstados('estado', '', 'requerido') ?></td>

        </tr>

        <tr>

            <td height="30" class="input_title">Cidade:</td>

            <td height="30">

                <input name="cidade" type="text" class="requerido" id="cidade" value="" size="100" maxlength="100" />

            </td>

        </tr>

    </table>

    <br />

<?php
$acao = '';



if (SystemLayout::getPermissao(2) && !$cod) {

    $botao_submit = 'Criar';

    $acao = 'incluir';
}



if (SystemLayout::getPermissao(3) && $cod) {

    $botao_submit = 'Alterar';

    $acao = 'alterar';
}



if ($acao) {

    echo '<div id="painel_submit">

    <input name="button" type="submit" class="botao_submit" value="' . $botao_submit . '" />

    <input type="hidden" name="acao" value="' . $acao . '">

    <input type="hidden" name="cod" value="' . $cod . '">

    </div>';
}
?>



</form>

    <?php
    echo $jvs;
    ?>

<script type="text/javascript">

    var f = document.frm;
    CKEDITOR.replace('conteudo_email', {
        language: 'pt-br'
    });


</script>

<br />

<?php require 'assets/blocks/body_fecha.php'; ?>