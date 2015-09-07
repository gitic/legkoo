$(function(){
    var page = 'articles';
    
    $('#edit_form').submit(function (e){
//        e.preventDefault();
        var sortedIDs = $( ".sortable" ).sortable("toArray",{attribute:'class'});
        var products = '';
        for(var i=0;i<sortedIDs.length;i++){
            var cName = sortedIDs[i].split(' ')[1];
            products+=cName+',';
        };
        products = products.substr(0,products.length-1);
        $('#products').val(products);
    });
    
    //Добавление товара
    $('.add_tag').on('click',function (){
        var title = $('.productName').val();
        if(title != ''){
            var id = $('.productName').attr('id');
            var node = "<li class='ui-state-default'><img class='gImg' src='../content/products/14/photo.jpg' width='100' border='0'><span class='pTitle'>Товар 1<br><i>артикул: 14</i></span><span class='delFoto'><i class='fa fa-times'></i></span></li>";
            $('.sortable').append(node);
        }
    });
    //Удаление товара
    $('body').on('click','.delFoto',function (){
        e = this;
        $(e).parent().remove();
    });
    
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
                iHeight = 300;
                break;
            case 'f2':
                iWidth = 300;
                iHeight = 300;
                break;
        }

        el = document.getElementsByClassName(uploaderName)[0];
        FileAPI.event.one(el, 'change', function (evt){
            $(".loadstatus."+cName).css({'display':'inline'});
            var files = FileAPI.getFiles(evt);
            var xhr = FileAPI.upload({
                url: './?ajax=imgUpload',
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
                iHeight = 300;
                break;
            case 'f2':
                iWidth = 300;
                iHeight = 300;
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
    setAutocomplete($('.productName'));
});
//Функция автозаполнения
function setAutocomplete(element){
    element.autocomplete({
        source: "./?ajax=articles",
        minLength: 1,
        select: function( event, ui ) {
            var id = ui.item.id;
            var title = ui.item.value;
            var articul = ui.item.articul;
            var photo = ui.item.photo;
            var node = "<li class='ui-state-default "+id+"'><img class='gImg' src='../"+photo+"' width='100' border='0'><span class='pTitle'>"+title+"<br><i>артикул: "+articul+"</i></span><span class='delFoto'><i class='fa fa-times'></i></span></li>";
            $('.sortable').append(node);
        },
        search: function( event, ui ) {
            $(this).attr('id','new');
        },
        response: function( event, ui ) {
            console.log(ui.content);
            var name = $(this).val();
            for(var i=0;i<ui.content.length;i++){
                if(ui.content[i].value.toLowerCase() == name.toLowerCase()){
                    $(this).attr('id',ui.content[i].id);
                }
            }
        },
        close: function( event, ui ) {$('.productName').val('');}
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        var photo = '';
        if(item.photo != ''){photo = '../'+item.photo;}
        return $( "<li style='width:700px;'><img style='position:relative;left:0px;' src='"+photo+"' width='50' border='0'>" )
        .append( "<a style='position:absolute;top:0;left:65px'>" + item.value + "<br><i>артикул: " + item.articul + "</i></a>" )
        .appendTo( ul );
    };
}
