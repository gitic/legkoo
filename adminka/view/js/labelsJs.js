$(function(){
    var page = 'labels';

    //Удаление товара
    $('body').on('click','.del',function (e){
        e.preventDefault();
        var className = $(this).prop('class');
        var rowID = className.split(' ')[2];
        if(confirm('Подтвердить удаление?')){
        $.ajax({
            url:'./?ajax='+page,
            type:'POST',
            data: {type:'del',rowID:rowID},
            success: function (data, textStatus, jqXHR) {
                if(data.trim() !== 'error'){
                    $('#ajaxContent').html(data);
                }
                else{
                    showError('Ошибка при удалении метки');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus+' '+errorThrown);
            }
        });
        }
    });
});
