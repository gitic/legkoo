$(function(){
    setAutocompleteSearch($('.searchField'));
});

//Функция автозаполнения
function setAutocompleteSearch(element){
    element.autocomplete({
        source: "./?ajax=search",
        minLength: 1,
        select: function( event, ui ) {
            
            var id = ui.item.id;
            if(id == 'fullSearch'){
                event.preventDefault();
                var query = ui.item.query;
                window.location.href = "search="+query;
            }
            else{
                var query = $('.inp.searchField').val();
                var translit = ui.item.translit;
                var articul = ui.item.articul;
                window.location.href = "product-"+id+"-lego-"+translit+"-"+articul;
            }
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        var result = '';
        var id = item.id;
        if(id != 'fullSearch'){
            var photo = '';
            var translit = item.translit;
            var articul = item.articul;
            if(item.photo != ''){photo = item.photo;}
            var link = $("<a style='display:block;' href='product-"+id+"-lego-"+translit+"-"+articul+"'></a>")
            .append("<img style='position:relative;left:0px;' src='"+photo+"' width='50' border='0'><span style='position:absolute;top:0;left:65px;'>" + item.value + " <i>(" + item.articul + ")</i></span>");
            result = $( "<li style='margin:0;padding:0 0 0 5px' id='"+id+"'>" )
                    .append(link)
                    .appendTo( ul );
        }
        else{
            result = $( "<li id='"+id+"'>"+item.value+"</li>" ).appendTo( ul );
        }
        return result;
    };
}