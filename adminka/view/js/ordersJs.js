$(function(){
    $('.editOrder,.save').on('click',function (e){
        e.preventDefault();
        var val = $('.inp').attr('disabled');
        switch (val){
            case 'disabled':
                $('.inp').each(function (){
                    $(this).attr('disabled',false);
                });
                var els = $('.del').length;
                if(els != 1){
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