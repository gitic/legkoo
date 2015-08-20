$(function(){
    // переключение фото
    $('.productGallery span > img').on('click', function (){
        var src = $(this).attr('src');
        $('.bigFoto').attr('src',src);
    });
    // плюс 1
    $('.plusBtn').on('click',function (){
        var num = $('.numbers > input').val();
        num++;
        $('.numbers  > input').val(num);
    });
    // минус 1
    $('.minusBtn').on('click',function (){
        var num = $('.numbers  > input').val();
        if(num != 1){
            num--;
        }
        $('.numbers  > input').val(num);
    });
    // в корзиу
    $('.buy').on('click',function (){
//        $.removeCookie('mlscart');
//        $.removeCookie('mlscartnum');
        var productID = $('.productID').val();
        var num = $('.numbers > input').val();
        var cart = $.cookie('mlscart');
        var cartArr = new Array();
        
        if(cart !== undefined){
            var inArray = false;
            var cartArr = JSON.parse(cart);
                for(var i=0;i<cartArr.length;i++){
                    if(cartArr[i].id == productID){
                        inArray = true;
                        cartArr[i].count = parseInt(cartArr[i].count) + parseInt(num);
                    }
                }
                if(!inArray){              
                    cartArr[cartArr.length] =  {
                                                    id : productID,
                                                    count : num
                                                };
                }
            var json = JSON.stringify(cartArr);
            $.cookie('mlscart', json, { expires: 7 });
        }
        else{
            cartArr[0] = {
                id : productID,
                count : num
            };
            var json = JSON.stringify(cartArr);
            $.cookie('mlscart', json, { expires: 7 });
        }
        var total = $.cookie('mlscartnum');
        if(total != undefined){
            total = parseInt(total) + parseInt(num);   
        }
        else{
            total = 1;
        }
        $.cookie('mlscartnum', total, { expires: 7 });
        $('#basketSmall span').html(total);
    });
});