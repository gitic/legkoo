$(function(){
    //Заполнение шага 4
    $('.inp.fio,.inp.email,.inp.phone').on('change',function (){
        var value = $(this).val();
        var cName = $(this).attr('class').split(' ')[1];
        $('#'+cName).html(value);
    });
    
    //Пользовательское соглашение и активация кнопки
    $('#aggr').click(function (){
        if($(this).is(':checked')){
            $('.send').prop('disabled', false);
            $('.send').attr('class','send btnEnable');
        }
        else{
            $('.send').prop('disabled', true);
            $('.send').attr('class','send btnDisable');
        }
    });
    
    $('.orderCount input').on('keyup',function (){
        var val = $(this).val();
        val = val.replace(/[^0-9]/g, "");
        $(this).val(val);
        if(val != '' && val != 0){
            setCart(this,val);
        }    
    });
    $('.orderCount input').on('change',function (){
        var val = $(this).val();
        val = val.replace(/[^0-9]/g, "");
        if(val=='' || val == 0){
            $(this).val(1);
            setCart(this,1);
        }
    });
    
    //Удаление товара
    $('.orderDel .del').on('click',function (){
        var arrId = $(this).parent().attr('class').split(' ')[1];
        var cart = $.cookie('mlscart');
        var cartArr = JSON.parse(cart);
        cartArr.splice(arrId,1);
        var json = JSON.stringify(cartArr);
        $.cookie('mlscart', json, { expires: 7 });
        $(this).parent().parent().remove();
        
        var i = 0;
        $('.orderCount').each(function (){
            var arrId = $(this).attr('class').split(' ')[1];
            if(parseInt(arrId)>=1){
                $(this).attr('class','orderCount '+i);
                i++;
            }
        });
        var i = 0;
        $('.orderPrice').each(function (){
            var arrId = $(this).attr('class').split(' ')[1];
            if(parseInt(arrId)>=1){
                $(this).attr('class','orderPrice '+i);
                i++;
            }
        });
        var i = 0;
        $('.orderDel').each(function (){
            var arrId = $(this).attr('class').split(' ')[1];
            if(parseInt(arrId)>=1){
                $(this).attr('class','orderDel '+i);
                i++;
            }
        });
        countTotal(cartArr);
    });
    
    //Отправка формы
    $('#cart_form').submit(function (e){
//        e.preventDefault();
        var fio = $.trim($('.fio').val());
        var email = $('.email').val();
        var phone = $('.phone').val();
        
        $('.fio').removeClass('errorClass');
        $('.email').removeClass('errorClass');
        $('.phone').removeClass('errorClass');
        
        if(fio === ''){
            $('.fio').addClass('errorClass');
            $('html, body').animate({ scrollTop: $('.fio').offset().top-50 }, 'slow');
            e.preventDefault();
        }
        if(email === ''){
            $('.email').addClass('errorClass');
            $('html, body').animate({ scrollTop: $('.email').offset().top-50 }, 'slow');
            e.preventDefault();
        }
        if(phone === ''){
            $('.phone').addClass('errorClass');
            $('html, body').animate({ scrollTop: $('.phone').offset().top-50 }, 'slow');
            e.preventDefault();
        }
    });
});

function countTotal(cartArr){
    var total = 0;
    for(var i=0;i<cartArr.length;i++){
        total = total + parseInt(cartArr[i].count);
    }
    $.cookie('mlscartnum', total, { expires: 7 });
    $('#basketSmall span').html(total);
    var amount = 0;
    $('.orderPrice strong').each(function (){
        amount = amount + parseInt($(this).html());
    });
    $('.sum strong').html(amount);
    $('#price').html(amount+' грн');
    if(total == 0){
        $('#order').html('<p style="text-align: center">Корзина пуста</p>');
    }
}
function setCart(e,val){
    var arrId = $(e).parent().attr('class').split(' ')[1];
    var cart = $.cookie('mlscart');
    var cartArr = JSON.parse(cart);
    cartArr[arrId].count = val;
    var productId = cartArr[arrId].id;
    var json = JSON.stringify(cartArr);
    $.cookie('mlscart', json, { expires: 7 });
    $('.orderPrice.'+arrId+' strong').html("<img width='25px' src='view/images/loader.GIF'>");
    $.ajax({
        url:'./?ajax=cart',
        type:'POST',
        data: {type:'price',rowID:productId},
        success: function (data, textStatus, jqXHR) {
            if(data.trim() !== 'error'){
                var totalPrice = data*val;
                $('.orderPrice.'+arrId+' strong').html(totalPrice);
                countTotal(cartArr);
            }
            else{
                alert('Произошла ошибка');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus+' '+errorThrown);
        }
    });
}