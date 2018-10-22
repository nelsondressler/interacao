<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
function switch_tabs(obj) {
  
  $('.tab-content').hide();
  $('.tabs a').removeClass("selected");
  
  var id = obj.attr("rel");
 
  $('#'+id).show();
  obj.addClass("selected");
  
}