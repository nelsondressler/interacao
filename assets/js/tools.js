$.ajaxSetup({  url: sys_site +'assets/includes/ajax.php'});
function trim(str, chars) {  return ltrim(rtrim(str, chars), chars);}
function ltrim(str, chars) {  chars = chars || "\\s";  return str.replace(new RegExp("^[" + chars + "]+", "g"), "");}function rtrim(str, chars) {  chars = chars || "\\s";  return str.replace(new RegExp("[" + chars + "]+$", "g"), "");}function cleanDoc(str) {    str = str.toString().replace(/\\/g, "");  str = str.toString().replace(/\//g, "");  str = str.toString().replace(/\./g, "");  str = str.toString().replace(/\_/g, "");  str = str.toString().replace(/\-/g, "");    return str;  }