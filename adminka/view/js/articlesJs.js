$(function(){
    var page = 'articles';
    //Удаление статьи
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
                    showError('Ошибка при удалении статьи');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus+' '+errorThrown);
            }
        });
        }
    });
    
    //Видимость сайта
    $('body').on('click','.visible',function (e){
        e.preventDefault();
        var btn = $(this).children();
        var className = btn.prop('class');
        var rowID = className.split(' ')[2];
        var visClass = btn.children().prop('class');
        switch (visClass){
            case 'fa fa-circle-o':
                var setVisible = 1;
                break;
            case 'fa fa-circle':
                var setVisible = 0;
                break;
        }
        $.ajax({
            url:'./?ajax='+page,
            type:'POST',
            data: {type:'visible',visible:setVisible,rowID:rowID},
            success: function (data, textStatus, jqXHR) {
                if(data.trim() !== 'error'){
                    if(data == 0){
                        $('.row.visible.'+rowID+'').children().prop('class','fa fa-circle-o');
                    }
                    else{$('.row.visible.'+rowID+'').children().prop('class','fa fa-circle');}
                }
                else{
                    showError('Произошла ошибка');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus+' '+errorThrown);
            }
        });
    });
    
    //AJAX загрузка иконки
    var iconDir = page;
    $('body').on('click','.fileUpload',function(){
        var uploaderName = $(this).attr('class');
        var cName = uploaderName.split(' ')[1];
        var rowId = $('.rowId').val();
        var iWidth;
        var iHeight;
        switch (cName){
            case 'f1':
                iWidth = 1000;
                iHeight = 600;
                break;
            case 'f2':
                iWidth = 700;
                iHeight = 467;
                break;
        }

        el = document.getElementsByClassName(uploaderName)[0];
        FileAPI.event.one(el, 'change', function (evt){
            $(".loadstatus."+cName).css({'display':'inline'});
            var files = FileAPI.getFiles(evt);
            var xhr = FileAPI.upload({
                url: './?ajax=ImgUpload',
                data:{dir:iconDir,rowId:rowId,image_name:cName,width:iWidth,height:iHeight},
                files: { photos: files[0] },
                filecomplete: function (err, xhr){
                    $(".loadstatus."+cName).hide();
                    if( !err ){
                        var str = xhr.responseText;
                        result = JSON.parse(str);
                        if(!result['error']){
                            $('.previewImg.'+cName).attr("src",result['data']);
                        }
                        else{
                            alert(result['error']);
                        }
                    }
                }
            });
        });
    });
    $('.loadUrlBtn').click(function(){
        var uploaderName = $(this).attr('class');
        var cName = uploaderName.split(' ')[1];
        var rowId = $('.rowId').val();
        var url = $('.loadUrlInp.'+cName).val();
        var iWidth;
        var iHeight;
        switch (cName){
            case 'f1':
                iWidth = 1000;
                iHeight = 600;
                break;
            case 'f2':
                iWidth = 700;
                iHeight = 467;
                break;
        }
        if((url.indexOf('http://') !== -1) || (url.indexOf('https://') !== -1)){
            $('.previewImg.'+cName).attr("src",'');
            $(".loadstatus."+cName).show();
            $('.loadUrlInp.'+cName).val('');
            $.ajax({
                url:'./?ajax=imgUpload',
                type:'POST',
                dataType: 'json',
                data: {type:'loadUrl',url:url,rowId:rowId,image_name:cName,dir:iconDir,width:iWidth,height:iHeight},
                success: function (data, textStatus, jqXHR) {
                    if(!data['error']){
                        $('.previewImg.'+cName).attr("src",data['data']);
                    }
                    else{
                        alert(data['error']);
                    }
                    $(".loadstatus."+cName).hide();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus+' '+errorThrown);
                    $(".loadstatus."+cName).hide();
                } 
            });
        }
        else{
            alert('Неверный формат ссылки');
        }
    });
    
    //Транслит имени
    $('body').on('keyup','#title', function(){
        var title = $('#title').val();
        $.ajax({
            url:'./?ajax=main',
            type:'POST',
            data: {type:'translit',str:title},
            success: function (data, textStatus, jqXHR) {
                if(data.trim() !== 'error'){
                    $('#translit').val(data);
                }
                else{
                    showError('Произошла ошибка');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus+' '+errorThrown);
            }
        });
    });
});
