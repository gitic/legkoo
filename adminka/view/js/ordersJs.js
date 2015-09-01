$(function(){
    var page = 'orders';
    
    $('.inp.count').on('focus',function (){
        alert('dsfdaas');
    });
    $('.editOrder,.save').on('click',function (e){
        e.preventDefault();
        var val = $('.inp.fio').attr('disabled');
        switch (val){
            case 'disabled':
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
                //СОХРАНИТЬ
                var i=0;
                var products = new Array();
                $('.product').each(function (){
                    var pId = $(this).children('td:nth-child(1)').children('.pId').val();
                    var articul = $(this).children('td:nth-child(1)').children('span').html();
                    var src = $(this).children('td:nth-child(2)').children('img').attr('src').substring(3);
                    var title = $(this).children('td:nth-child(2)').children('span').html();
                    var count = $(this).children('td:nth-child(3)').children('input').val();
                    var price = $(this).children('td:nth-child(4)').children('input').val();
                    products[i] = {id:pId,title:title,articul:articul,count:count,price:price,img:src};
                    i++;
                });
                products = JSON.stringify(products);
                $('#products').val(products);
                $('.loaderGif').css({'display':'block'});
                var mdata = $('#edit_form').serialize();
                mdata+= "&type=save";
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
                    $(this).attr('disabled',true);
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
    $('.del').on('click',function (){
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
    
    $('.inp.count,.inp.price,#orderDiscount,#orderDelivery').on('change',function (){
        var text = $(this).val();
        if(text == ''){$(this).val(0);}
        text = text.replace(/\,/, ".");
        text = text.replace(/[^0-9.]/g, "");
        $(this).val(text);
        onChangeProduct();
    });
});

function onChangeProduct(){
    var total = 0;
    $('.inp.count').each(function (){
        var id = $(this).attr('class').split(' ')[2];
        var v1 = parseInt($(this).val());$(this).val(v1);
        var v2 = parseFloat($('.inp.price.'+id).val());
        var sum = v1*v2;
        total = total+sum;
    });
    $('#orderSum').val(total);
    var discount = parseFloat($('#orderDiscount').val());
    var delivery = parseFloat($('#orderDelivery').val());
    total = total-discount+delivery;
    $('#orderTotal').val(total);
}