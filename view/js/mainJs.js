$(function(){
    var total = $.cookie('mlscartnum');
    if(total == undefined){
        total = 0;  
    }
    $('#basketSmall span').html(total);
    
    $('.previewBtn span').on('click', function (){
//        $.removeCookie('mlscart');
//        $.removeCookie('mlscartnum');
        var productID = $(this).parent().attr('class').split(' ')[1];
        var num = 1;
        addToCart(productID,num);
    });
    $('.skipNotify').on('click',function (){
        $('.addNotify').css({'display':'none'});
    });
});
function addToCart(productID,num){
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
            total = num;
        }
        $.cookie('mlscartnum', total, { expires: 7 });
        $('#basketSmall span').html(total);
        $('.addNotify').css({'display':'block'});
}