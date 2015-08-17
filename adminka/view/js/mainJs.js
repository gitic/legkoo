function showError(errorStr){
    if(!("wait" in window)){
        $('.error').css({'display':'block','opacity':1});
        $('.error > span').html(errorStr);
        wait=1;
        setTimeout (function(){
            $(".error").animate({opacity: 0},800,function (){
                $('.error').css({'display':'none'});
                delete wait;
            });
        }, 2000);
    }
}
function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  text =  text.replace(/[&<>"']/g, function(m) { return map[m]; });
  text = addslashes(text);
  return text;
}
function addslashes(string) {
    return string.replace(/\\/g, '').
        replace(/\u0008/g, '').
        replace(/\t/g, '').
        replace(/\n/g, '').
        replace(/\f/g, '').
        replace(/\r/g, '').
        replace(/'/g, '').
        replace(/"/g, '');
}
String.prototype.replaceAll=function(find, replace_to){
    return this.replace(new RegExp(find, "g"), replace_to);
};