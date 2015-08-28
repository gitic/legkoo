$(function(){
    // переключение фото
    $('.productGallery span > img').on('click', function (){
        var src = $(this).attr('src');
        $('.bigFoto').attr('src',src);
        $('.bigFoto').attr('data-zoom-image',src);
        var ez = $('.bigFoto').data('elevateZoom');
        ez.swaptheimage(src, src);
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
        var productID = $('.productID').val();
        var productName = $(this).children('input').val();
        var num = $('.numbers > input').val();
        addToCart(productID,num,productName);
        $('.numbers > input').val(1);
    });
    //ZOOM
    $('.bigFoto').elevateZoom();
});