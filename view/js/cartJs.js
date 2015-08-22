$(function(){
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
    $('.orderDel').on('click',function (){
        var arrId = $(this).attr('class').split(' ')[1];
        var cart = $.cookie('mlscart');
        var cartArr = JSON.parse(cart);
        cartArr.splice(arrId,1);
        var json = JSON.stringify(cartArr);
        $.cookie('mlscart', json, { expires: 7 });
        $(this).parent().remove();
        
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
});

function countTotal(cartArr){
    var total = 0;
    for(var i=0;i<cartArr.length;i++){
        total = total + parseInt(cartArr[i].count);
    }
    $.cookie('mlscartnum', total, { expires: 7 });
    $('#basketSmall span').html(total);
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
    countTotal(cartArr);
    $('.orderPrice.'+arrId+' strong').html("<img width='25px' src='view/images/loader.GIF'>");
    $.ajax({
        url:'./?ajax=cart',
        type:'POST',
        data: {type:'price',rowID:productId},
        success: function (data, textStatus, jqXHR) {
            if(data.trim() !== 'error'){
                var totalPrice = data*val;
                $('.orderPrice.'+arrId+' strong').html(totalPrice+'');
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
function clearCart(){
    
}