/* global */

$( function (){

	// PRINT
	$('a.btImprimir').click(function(){
		$(this).parent('div').printArea();
		//window.print();
		return false;
	});
	
	$('#entenda li.first').addClass('ativo');
	
	$('#topicos h5').click(function(){
		if ($(this).hasClass('ativo')){
			$('#topicos div').slideUp();
			$('#topicos h5').removeClass('ativo');
		} else {
			$('#topicos h5').removeClass('ativo');
			$('#topicos div').slideUp();
			$(this).next('div').slideDown();
			$(this).addClass('ativo');
		}
	});
	
	$('ul#listaLegislacao a').click(function(){
		var abaLegis = $(this).attr('id');
		if ($(this).hasClass('ativo')) {
			} else {
				$('#listaLegislacao a').removeClass('ativo');
				$(this).addClass('ativo');
				$('.boxLegis').hide();
				$('.'+ abaLegis ).fadeIn();
			}
		return false;
	});
	
	$('#topicos h6').click(function(){
		$(this).next('div').slideToggle();		
	});
	
	$('p.showInfoProblem a').click(function(){
		$('.infoProblem').slideToggle();
		return false;
	});
	
	// Altera tamanho da fonte no body
	$('.abaFonte a').click(function(){
		$('ul#alteraFonte li').removeClass('alteraSeleciona');
		if ($(this).hasClass('diminuir')){
			$('body').css('font-size', '.82em');
		} else {
			if ($(this).hasClass('normal')){
				$('body').css('font-size', '1em');
			} else {
				if ($(this).hasClass('aumentar')){
					$('body').css('font-size', '1.2em');
				}
			}
		return false;
		}
		$(this).addClass('alteraSeleciona');
		return false;
	});
	
});

$(function(){
	$('body#inicio #avisoModal').click(function(){
		$('#avisoModal').fadeOut();
		$('#bodyAviso').fadeOut();
	});
	$('a.btFecharAviso').click(function(){
		$('#avisoModal').fadeOut();
		$('#bodyAviso').fadeOut();
		return false;
	});
	
	var modalHeight = $('#bodyAviso').height();
	$('#bodyAviso').css({ 'height': modalHeight, 'marginTop': -(modalHeight/2) });

});
	
function abreSubmenu( ) {
	$('li.first').toggleClass('ativo');
	$('ul.subMenu').slideToggle();
	return false;
}
	
(function($) {
    var printAreaCount = 0;

    $.fn.printArea = function()
        {
            var ele = $(this);

            var idPrefix = "printArea_";

            removePrintArea( idPrefix + printAreaCount );

            printAreaCount++;

            var iframeId = idPrefix + printAreaCount;
            var iframeStyle = 'position:absolute;width:0px;height:0px;left:-500px;top:-500px;';

            iframe = document.createElement('IFRAME');

            $(iframe).attr({ style : iframeStyle,
                             id    : iframeId
                           });

            document.body.appendChild(iframe);

            var doc = iframe.contentWindow.document;

            $(document).find("link")
                .filter(function(){
                        return $(this).attr("rel").toLowerCase() == "stylesheet";
                    })
                .each(function(){
                        doc.write('<link type="text/css" rel="stylesheet" href="' + $(this).attr("href") + '" >');
                    });

            doc.write('<div class="' + $(ele).attr("class") + '">' + $(ele).html() + '</div>');
            doc.close();

            var frameWindow = iframe.contentWindow;
            frameWindow.close();
            frameWindow.focus();
            frameWindow.print();
        }

    var removePrintArea = function(id)
        {
            $( "iframe#" + id ).remove();
        };

})(jQuery);