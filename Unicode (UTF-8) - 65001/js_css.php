<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script type="text/javascript">
var sys_site = '<?php echo SYS_HTTP ?>';
</script>


<link href="assets/css/estilo.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Sansita+One' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' id='options_typography_Oswald-css'  type='text/css' media='all' />
<link href="assets/css/editor.css" rel="stylesheet" type="text/css"  />

<script type='text/javascript' charset="iso-8859-1" src='assets/js/jquery-1.6.4.min.js'></script>
<script type="text/javascript" charset="iso-8859-1" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript" charset="iso-8859-1" src="assets/js/jquery.cycle.all.js"></script>
<script type="text/javascript" charset="iso-8859-1" src="assets/js/superfish.js" ></script>
<script type="text/javascript" charset="iso-8859-1" src="assets/js/tools.js"></script>

<script type="text/javascript">
$(function() {

  jQuery('ul.sf-menu').superfish({
    delay:       1000,
    animation:   {opacity:'show',height:'show'},
    speed:       'normal',
    autoArrows:  true,
    dropShadows: false
  });

  $('#cover').cycle({
    fx:        'cover',
    delay:    -2000,
    before: function(curr, next, opts) {
      opts.animOut.opacity = 0;
    }
  });

  $('#uncover').cycle({
    fx:        'uncover',
    before: function(curr, next, opts) {
      opts.animOut.opacity = 0;
    }
  });
  
});
</script>

<? echo OpcoesHelper::get('google_analytics') ?>
