$(function(){
    var total = $.cookie('mlscartnum');
    if(total == undefined){
        total = 0;  
    }
    $('#basketSmall span').html(total);
});