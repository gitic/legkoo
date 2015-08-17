$(function(){
    var page = 'products';
    
    //Поиск по товарам
    $('.sbox').keyup(function (){
        var sbox = $(this).val();
        $.ajax({
            url:'./?ajax='+page,
            type:'POST',
            data: {type:'search',sbox:sbox,rowID:'-1'},
            success: function (data, textStatus, jqXHR) {
                if(data.trim() !== 'error'){
                    $('#ajaxContent').html(data);
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
    //Удаление товара
    $('body').on('click','.del',function (e){
        e.preventDefault();
        var sbox = $('.sbox').val();
        var className = $(this).prop('class');
        var rowID = className.split(' ')[2];
        if(confirm('Подтвердить удаление?')){
        $.ajax({
            url:'./?ajax='+page,
            type:'POST',
            data: {type:'del',rowID:rowID,sbox:sbox},
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
    
    //Видимость товара
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
        var iName;
        switch (cName){
            case 'f1':
                iName = cName;
                iWidth = 1000;
                iHeight = 600;
                break;
            case 'f2':
                iName = cName;
                iWidth = 700;
                iHeight = 467;
                break;
            case 'gallery':
                iName = $('#gLastIndex').val();
                rowId = rowId+"/gallery";
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
                data:{dir:iconDir,rowId:rowId,image_name:iName,width:iWidth,height:iHeight},
                files: { photos: files[0] },
                filecomplete: function (err, xhr){
                    $(".loadstatus."+cName).hide();
                    $(el).val('');
                    if( !err ){
                        var str = xhr.responseText;
                        result = JSON.parse(str);
                        if(!result['error']){
                            switch (cName){
                                case 'gallery':
                                    $('.sortable').append("<li class='ui-state-default'><img class='gImg' src='"+result['data']+"' width='160' height='120' border='0'><span class='delFoto'><i class='fa fa-times'></i></span></li>");
                                    iName++;
                                    $('#gLastIndex').val(iName);
                                break;
                                default:
                                    $('.previewImg.'+cName).attr("src",result['data']);
                                break;
                            }
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
    
    //Удаление фотографии из галереи
    $('body').on('click','.delFoto',function (){
        e = this;
        var src = $(e).parent().children().attr('src');
        if(src.indexOf('tmp') == -1){
            src = src.substring(0,src.indexOf('?'));
            src = src.substring(src.lastIndexOf('/')+1);
            var toDelete = $('#galleryDelete').val();
            toDelete+=src+',';
            $('#galleryDelete').val(toDelete);
        }
        $(e).parent().remove();
    });
    
    //Отправка формы
    $('#edit_form').submit(function (e){
//        e.preventDefault();
        var lastId = $('#gLastIndex').val();
        var line = lastId;
        var toUpload = '';
        $('.gImg').each(function (){
            var src = $(this).attr('src');
            src = src.substring(3,src.indexOf('?'));
            line+=','+src;
            if(src.indexOf('tmp') != -1){
                toUpload+=src+',';
            }
        });
        line = line.replaceAll('/tmp','');
        $('#galleryRow').val(line);
        $('#galleryUpload').val(toUpload);
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
