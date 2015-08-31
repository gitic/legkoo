$(function(){
    //Уведомления
        var notify = $.cookie('notify');
        if(notify == undefined){
            $.cookie('notify', 'none', { expires: 7 });
        }
        else if(notify == 'orderSend'){
            $('.orderSend').css({'display':'block'}); 
        }
    //Уведомления

    var total = $.cookie('mlscartnum');
    if(total == undefined){
        total = 0;  
    }
    $('#basketSmall span').html(total);
    
    //В Корзину
    $('.previewBtn span').on('click', function (){
        var bClass = $(this).attr('class');
        if(bClass !== 'disabled'){
            var productID = $(this).parent().attr('class').split(' ')[1];
            var productName = $(this).children('input').val();
            var num = 1;
            addToCart(productID,num,productName);
        }
    });
    $('.skipNotify').on('click',function (){
        $('.notify').css({'display':'none'});
        $.cookie('notify', 'none', { expires: 7 });
    });
    
    $('#searchField').submit(function (e){
        e.preventDefault();
        var query = $(this).children('.inp').val();
        window.location.href = "search="+query;
    });
    
    
});
function addToCart(productID,num,productName){
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
        $('.addNotify strong span').html(productName);
        $('.addNotify').css({'display':'block'});
}
function showError(text){
    if(text == undefined){text = 'Произошла ошибка';}
    $('.error').html(text);
    $('.error').css({'display':'block'});
}