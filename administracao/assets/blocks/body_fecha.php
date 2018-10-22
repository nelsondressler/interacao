</div>

</div>
  
<div id="rodape">
  
  <!-- Inicio rodape -->
  <div id="rodape_esquerdo">
    <div id="rodape_texto">
      <?php
      echo '<b>Data:</b> '. date("d/m/Y H:i") .' - <b>IP cliente:</b> '.
      $_SERVER["REMOTE_ADDR"] .' - <b>Mem:</b> '. number_format((memory_get_usage()/1024), 2, ',', '.') .' Kb'
      ?>
    </div>
  </div>
  
  <div id="rodape_direito"><a href="http://www.nannydesign.com.br" target="_blank" ><img src="assets/img/pix.gif" width="100" height="24" border="0" /></a></div>
  <!-- Fim rodape -->
  
</div>
  
</div>

</body>
</html>
