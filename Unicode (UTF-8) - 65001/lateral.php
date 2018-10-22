<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><table width="300" cellpadding="0" cellspacing="0">
		<tr>
			<td height="34">&nbsp;</td>
		</tr>
		</table>
<?php
$lateral_plano      = new SitePlanosAction();
$row_lateral_planos = $lateral_plano->lista();

for ($i = 0; $i < count($row_lateral_planos); $i++) {
	if ($row_lateral_planos[$i]['cod_plano']!=$cod) {
	?>
	<table width="300" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" class="bg_fts_qs"><img src="<?php echo SYS_SITE_CONTEUDO .'uploads/'. $row_lateral_planos[$i]['arquivo1'] ?>" width="290" height="131" /></td>
		</tr>
		<tr>
			<td colspan="2" class="titulo_planos_qs"><?php echo $row_lateral_planos[$i]['plano'] ?></td>
		</tr>
		<tr>
			<td class="texto_planos_qs"><?php echo $row_lateral_planos[$i]['texto2'] ?></td>
			<td width="100" class="botao_planos_qs">
				<table align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td class="button_qs"><a href="plano-descricao.php?cod=<?php echo $row_lateral_planos[$i]['cod_plano'] ?>">Saiba mais</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
	<?php
	}
}
?>