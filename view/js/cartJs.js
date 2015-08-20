$(function(){
    $('.orderCount input').on('keyup',function (){
        var val = $(this).val();
        val = val.replace(/[^0-9]/g, "");
        $(this).val(val);
        
        setCart(this,val);    
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
//        cartArr.splice(arrId);
        console.log(cartArr);
//        var json = JSON.stringify(cartArr);
//        $.cookie('mlscart', json, { expires: 7 });
        $(this).parent().remove();
    });
});

function countTotal(cartArr){
    var total = 0;
    for(var i=0;i<cartArr.length;i++){
        total = total + parseInt(cartArr[i].count);
    }
    $.cookie('mlscartnum', total, { expires: 7 });
    $('#basketSmall span').html(total);
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
    $.ajax({
        url:'./?ajax=cart',
        type:'POST',
        data: {type:'price',rowID:productId},
        success: function (data, textStatus, jqXHR) {
            if(data.trim() !== 'error'){
                var totalPrice = data*val;
                $('.orderPrice.'+arrId+' span').html(totalPrice);
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