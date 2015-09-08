$(function(){
    var page = 'orders';
    setAutocomplete($('.productName'));
    
    $('.state').on('change',function (){
        var val = $(this).val();
        var rowId = $('.rowId').val();
        $.ajax({
            url:'./?ajax='+page,
            type:'POST',
            data: {type:'state',rowId:rowId,state:val},
            success: function (data, textStatus, jqXHR) {
                $('.notifyState').css({'display':'inline-block','opacity':1});
                setTimeout (function(){
                    $(".notifyState").animate({opacity: 0},800,function (){
                        $('.notifyState').css({'display':'none'});
                    });
                }, 2000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus+' '+errorThrown);
            }
        });
    });
    $('.editOrder,.save').on('click',function (e){
        e.preventDefault();
        var val = $('.inp.fio').attr('disabled');
        switch (val){
            case 'disabled':
                $('.productName').css({'display':'block'});
                $('.inp').each(function (){
                    var exeptArr = ['date_add','comment']; 
                    var cName = $(this).attr('class').split(' ')[1];
                    if(exeptArr.indexOf(cName) === -1){
                       $(this).attr('disabled',false); 
                    }
                });
                var els = $('.del').length;
                if(els !== 1){
                    $('.del').each(function (){
                        $(this).css({'display':'block'});
                    });
                }
                $('.editOrder').css({'display':'none'});
                $('.save').css({'display':'inline-block'});
                $('.cancel.back').css({'display':'none'});
                $('.cancel.reload').css({'display':'inline-block'});
                break;
            default :
                $('.productName').css({'display':'none'});
                //СОХРАНИТЬ
                var i=0;
                var products = new Array();
                var p_unique = 0;
                var p_total = 0;
                $('.product').each(function (){
                    var pId = $(this).children('td:nth-child(1)').children('.pId').val();
                    var pCat = $(this).children('td:nth-child(1)').children('.pCat').val();
                    var articul = $(this).children('td:nth-child(1)').children('span').html();
                    var src = $(this).children('td:nth-child(2)').children('img').attr('src').substring(3);
                    var title = $(this).children('td:nth-child(2)').children('span').html();
                    var count = $(this).children('td:nth-child(3)').children('input').val();
                    var price = $(this).children('td:nth-child(4)').children('input').val();
                    products[i] = {id:pId,title:title,articul:articul,category:pCat,count:count,price:price,img:src};
                    i++;
                    p_unique++;
                    p_total = parseInt(p_total) + parseInt(count);
                });
                products = JSON.stringify(products);
                $('#products').val(products);
                $('.loaderGif').css({'display':'block'});
                var mdata = $('#edit_form').serialize();
                mdata+= "&type=save&p_unique="+p_unique+"&p_total="+p_total;
                $.ajax({
                    url:'./?ajax='+page,
                    type:'POST',
                    data: mdata,
                    success: function (data, textStatus, jqXHR) {
                        $('.loaderGif').css({'display':'none'});
                        if(data.trim() !== 'error'){
                            $('.notify').html('Обновлено');
                        }
                        else{
                            $('.notify').html('Произошла ошибка');
                        }
                        $('.notify').css({'display':'block','opacity':1});
                        setTimeout (function(){
                            $(".notify").animate({opacity: 0},800,function (){
                                $('.notify').css({'display':'none'});
                            });
                        }, 2000);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus+' '+errorThrown);
                    }
                });
                $('.inp').each(function (){
                    var exeptArr = ['state']; 
                    var cName = $(this).attr('class').split(' ')[1];
                    if(exeptArr.indexOf(cName) === -1){
                       $(this).attr('disabled',true); 
                    }
                });
                $('.del').each(function (){
                    $(this).css({'display':'none'});
                });
                $('.editOrder').css({'display':'inline-block'});
                $('.save').css({'display':'none'});
                $('.cancel.back').css({'display':'inline-block'});
                $('.cancel.reload').css({'display':'none'});
                break;  
        }
    });
    $('body').on('click','.del',function (){
        $(this).parent().parent().remove();
        var els = $('.del').length;
        if(els == 1){
            $('.del').css({'display':'none'});
        }
        onChangeProduct();
    });
    
    $('.reload').on('click',function (e){
        e.preventDefault();
        window.location.reload();
    });
    
    $('body').on('change','.inp.count,.inp.price,#orderDiscount,#orderDelivery',function (){
        var text = $(this).val();
        if(text === ''){$(this).val('0');text='0';}
        text = text.replace(/\,/, ".");
        text = text.replace(/[^0-9.]/g, "");
        text = parseFloat(text);
        $(this).val(text);
        onChangeProduct();
    });
});

function onChangeProduct(){
    var str = "";
    $('.inp.count').each(function (){
        var id = $(this).attr('class').split(' ')[2];
        var v1 = $(this).val();$(this).val(v1);
        var v2 = $('.inp.price.'+id).val();
        str += ','+v1+'x'+v2;
    });
    str = str.substr(1);
    var discount = $('#orderDiscount').val();
    var delivery = $('#orderDelivery').val();
    $.ajax({
            url:'./?ajax=orders',
            type:'POST',
            data: {type:'count',rowId:'0',string:str,discount:discount,delivery:delivery},
            success: function (data, textStatus, jqXHR) {
                data = data.split('+');
                $('#orderSum').val(data[0]);
                $('#orderTotal').val(data[1]);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus+' '+errorThrown);
            }
        });
}

//Функция автозаполнения
function setAutocomplete(element){
    element.autocomplete({
        source: "./?ajax=orders",
        minLength: 1,
        select: function( event, ui ) {
            var id = ui.item.id;
            var title = ui.item.value;
            var articul = ui.item.articul;
            var photo = ui.item.photo;
            var price = ui.item.price;
            var cat = ui.item.category;
            var node = "<tr class='product "+title+"'>\n\
                            <td><input hidden class='pId "+id+"' value='"+id+"'/><input hidden class='pCat "+cat+"' value='"+cat+"'/><span>"+articul+"</span></td>\n\
                            <td valign='top'><img style='float: left' width='70' src='../"+photo+"'><span>"+title+"</span></td>\n\
                            <td><input class='inp count "+id+"' value='1'/></td>\n\
                            <td><input class='inp price "+id+"' value='"+price+"'/></td>\n\
                            <td><i style='display:none;cursor:pointer' class='fa fa-times del'></i></td>\n\
                        </tr>";
            $('.table tbody').append(node);
            onChangeProduct();
            $('.del').css({'display':'block'});
        },
        search: function( event, ui ) {
            $(this).attr('id','new');
        },
        response: function( event, ui ) {
            console.log(ui.content);
            var name = $(this).val();
            for(var i=0;i<ui.content.length;i++){
                if(ui.content[i].value.toLowerCase() == name.toLowerCase()){
                    $(this).attr('id',ui.content[i].id);
                }
            }
        },
        close: function( event, ui ) {$('.productName').val('');}
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        var photo = '';
        if(item.photo != ''){photo = '../'+item.photo;}
        return $( "<li style='width:700px;'><img style='position:relative;left:0px;' src='"+photo+"' width='50' border='0'>" )
        .append( "<a style='position:absolute;top:0;left:65px'>" + item.value + "<br><i>артикул: " + item.articul + "</i></a>" )
        .appendTo( ul );
    };
}