$(function(){
    $('.productGallery span > img').on('click', function (){
        var src = $(this).attr('src');
        $('.big').attr('src',src);
    });
    
    $('.plusBtn').on('click',function (){
        var num = $('.numbers > input').val();
        num++;
        $('.numbers  > input').val(num);
    });
    
    $('.minusBtn').on('click',function (){
        var num = $('.numbers  > input').val();
        if(num != 1){
            num--;
        }
        $('.numbers  > input').val(num);
    });
});