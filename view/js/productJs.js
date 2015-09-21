$(function(){
    var screenWidth = screen.width;
    var screenHeight = screen.height;
    // переключение фото
    $('.productGallery span > img').on('click', function (){
        var src = $(this).attr('src');
        $('.bigFoto').attr('src',src);
        if (screenWidth >= 768 && screenHeight >= 768){
            $('.bigFoto').attr('data-zoom-image',src);
            var ez = $('.bigFoto').data('elevateZoom');
            ez.swaptheimage(src, src);
        }
        
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
        var bClass = $(this).children('span').attr('class');
        if(bClass !== 'disabled'){
            var productID = $('.productID').val();
            var productName = $(this).children('input').val();
            var num = $('.numbers > input').val();
            addToCart(productID,num,productName);
            $('.numbers > input').val(1);
        }
        
    });
    //One Click Button
    $('.oneClickBtn').on('click',function (){
        $('.oneClick').css({'display':'block'});
    });
    $('#submitOneClick').on('click',function (){
        var rowId = $('.rowId').val();
        var phone = $('.oneClickPhone').val();
        if($.trim(phone) === ''){
            $('.oneClickPhone').addClass('errorClass');
            return;
        }
        $.ajax({
            url:'./?ajax=one_click',
            type:'POST',
            data: {rowId:rowId,phone:phone},
            success: function (data, textStatus, jqXHR) {
                if(data.trim() !== 'error'){
                    $('.skipNotify').click();
                    $('.orderSend').css({'display':'block'}); 
                }
                else{
                    alert('Произошла ошибка');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus+' '+errorThrown);
            }
        });
    });
    //ZOOM
    if (screenWidth >= 768 && screenHeight >= 768){
        $('.bigFoto').elevateZoom();
    }
});