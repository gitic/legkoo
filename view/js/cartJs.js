$(function(){
    
    //проверка телефона
    $('.phone').on('change',function (){
        var value = $(this).val();
        value = value.replace(/[^0-9 () +]/g, "");
        $(this).val(value);
    });
    //Заполнение шага 4
    $('.inp.fio,.inp.email,.inp.phone').on('change',function (){
        var value = $(this).val();
        var cName = $(this).attr('class').split(' ')[1];
        $('#'+cName).html(value);
    });
    
    //Пользовательское соглашение и активация кнопки
    $('#aggr').click(function (){
        if($(this).is(':checked')){
            $('.send').prop('disabled', false);
            $('.send').attr('class','send btnEnable');
        }
        else{
            $('.send').prop('disabled', true);
            $('.send').attr('class','send btnDisable');
        }
    });
    
    $('.orderCount input').on('keyup',function (){
        var val = $(this).val();
        val = val.replace(/[^0-9]/g, "");
        $(this).val(val);
        if(val != '' && val != 0){
            setCart(this,val);
        }    
    });
    $('.orderCount input').on('change',function (){
        var val = $(this).val();
        val = val.replace(/[^0-9]/g, "");
        if(val=='' || val == 0){
            $(this).val(1);
            setCart(this,1);
        }
    });
    
    //Удаление товара
    $('.orderDel .del').on('click',function (){
        var arrId = $(this).parent().attr('class').split(' ')[1];
        var cart = $.cookie('mlscart');
        var cartArr = JSON.parse(cart);
        cartArr.splice(arrId,1);
        var json = JSON.stringify(cartArr);
        $.cookie('mlscart', json, { expires: 7 });
        $(this).parent().parent().remove();
        
        var i = 0;
        $('.orderCount').each(function (){
            var arrId = $(this).attr('class').split(' ')[1];
            if(parseInt(arrId)>=1){
                $(this).attr('class','orderCount '+i);
                i++;
            }
        });
        var i = 0;
        $('.orderPrice').each(function (){
            var arrId = $(this).attr('class').split(' ')[1];
            if(parseInt(arrId)>=1){
                $(this).attr('class','orderPrice '+i);
                i++;
            }
        });
        var i = 0;
        $('.orderDel').each(function (){
            var arrId = $(this).attr('class').split(' ')[1];
            if(parseInt(arrId)>=1){
                $(this).attr('class','orderDel '+i);
                i++;
            }
        });
        countTotal(cartArr);
    });
    
    //Отправка формы
    $('#cart_form').submit(function (e){
//        e.preventDefault();
        var fio = $.trim($('.fio').val());
        var email = $('.email').val();
        var phone = $('.phone').val();
        var deliveryType = $('.delivery_type').val();
        var paymentType = $('.payment_type').val();
        
        $('.fio').removeClass('errorClass');
        $('.email').removeClass('errorClass');
        $('.phone').removeClass('errorClass');
        $('#delivery_city').removeClass('errorClass');
        $('.delivery_type').removeClass('errorClass');
        $('.payment_type').removeClass('errorClass');
        $('#delivery_adress').removeClass('errorClass');
        
        if(fio === ''){
            $('.fio').addClass('errorClass');
            $('html, body').animate({ scrollTop: $('.fio').offset().top-50 }, 'slow');
            e.preventDefault();
        }
        else if(email === ''){
            $('.email').addClass('errorClass');
            $('html, body').animate({ scrollTop: $('.email').offset().top-50 }, 'slow');
            e.preventDefault();
        }
        else if(phone === ''){
            $('.phone').addClass('errorClass');
            $('html, body').animate({ scrollTop: $('.phone').offset().top-50 }, 'slow');
            e.preventDefault();
        }
        else if((deliveryType === '1' || deliveryType === '0') && $('#delivery_city').val() === ''){
            if(deliveryType === '1'){$('#delivery_city').addClass('errorClass');}
            else if(deliveryType === '0'){$('.delivery_type').addClass('errorClass');}    
            $('html, body').animate({ scrollTop: $('.delivery_type').offset().top-50 }, 'slow');
            e.preventDefault();
        }
        else if(deliveryType === '2' && $('#delivery_adress').val() === ''){
                $('#delivery_adress').addClass('errorClass');
                $('html, body').animate({ scrollTop: $('#delivery_adress').offset().top-50 }, 'slow');
                e.preventDefault();
        }
        else if(paymentType === '0'){
            $('.payment_type').addClass('errorClass');
            $('html, body').animate({ scrollTop: $('.payment_type').offset().top-50 }, 'slow');
            e.preventDefault();
        }
        
        if(deliveryType === '1'){
            var city = $('#delivery_city').val();
            var adress = $( "#select_delivery_adress option:selected" ).text();
            $('#delivery_adress').val(city+', '+adress);
        }
    });
    
    //Запросы к Новой почте
    setAutocomplete($('#delivery_city'));
    
    //Изменение способа доставки
    $('.delivery_type').on('change',function (){
        var val = $(this).val();      
        $('#delivery_city').val('');
        $('#select_delivery_adress').html("<option value='0'>---</option>");
        $('#delivery_adress').val('');
        $('#delivery_adress').attr('disabled',false);
        switch (val){
            case '0':
                $('.npBlock').css({'display':'none'});
                $('#delivery_adress').attr('type','hidden');
                break;
            case '1':
                $('.npBlock').css({'display':'block'});
                $('#delivery_adress').attr('type','hidden');
                break;
            case '2':
                $('.npBlock').css({'display':'none'});
                $('#delivery_adress').attr('type','text');
                break;
            case '3':
                $('.npBlock').css({'display':'none'});
                $('#delivery_adress').attr('type','text');
                $('#delivery_adress').val('ТЦ «Гранд Плаза», Днепропетровск просп. Карла Маркса 67-Д');
                $('#delivery_adress').attr('disabled',true);
                break;
        }
    });
});

function countTotal(cartArr){
    var total = 0;
    for(var i=0;i<cartArr.length;i++){
        total = total + parseInt(cartArr[i].count);
    }
    $.cookie('mlscartnum', total, { expires: 7 });
    $('#basketSmall span').html(total);
    var amount = 0;
    $('.orderPrice strong').each(function (){
        amount = amount + parseInt($(this).html());
    });
    $('.sum strong').html(amount);
    $('#price').html(amount+' грн');
    if(total == 0){
        $('#order').html('<p style="text-align: center">Корзина пуста</p>');
    }
}
function setCart(e,val){
    var arrId = $(e).parent().attr('class').split(' ')[1];
    var cart = $.cookie('mlscart');
    var cartArr = JSON.parse(cart);
    cartArr[arrId].count = val;
    var productId = cartArr[arrId].id;
    var json = JSON.stringify(cartArr);
    $.cookie('mlscart', json, { expires: 7 });
    $('.orderPrice.'+arrId+' strong').html("<img width='25px' src='view/images/loader.GIF'>");
    $.ajax({
        url:'./?ajax=cart',
        type:'POST',
        data: {type:'price',rowID:productId},
        success: function (data, textStatus, jqXHR) {
            if(data.trim() !== 'error'){
                var totalPrice = data*val;
                $('.orderPrice.'+arrId+' strong').html(totalPrice);
                countTotal(cartArr);
            }
            else{
                alert('Произошла ошибка');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus+' '+errorThrown);
        }
    });
}

function setAutocomplete(element){
    element.autocomplete({
        source: function( request, response ) {
            var city = request.term;
            $.ajax({
                url: "https://api.novaposhta.ua/v2.0/json/",
                dataType: "jsonp",
                data: {
                    "modelName": "Address",
                    "calledMethod": "getCities",
                    "methodProperties": {
                        "FindByString": city
                    },
                    "apiKey": "c676d6fb43bbd952ed71c119aed6417c"
                },
                success: function( data ) {
                    response( $.map( data.data, function( item ) {
                        return {
                            label: item.DescriptionRu,
                            value: item.DescriptionRu,
                            ref: item.Ref
                        };
                    }));
                }
            });
        },
        minLength: 3,
        select: function( event, ui ) {
            var cityRef = ui.item.ref;
            getNumbers(cityRef);
        },
        response: function( event, ui ) {
            var name = $(this).val();
            for(var i=0;i<ui.content.length;i++){
                if(ui.content[i].value.toLowerCase() == name.toLowerCase()){
                    $(this).attr('value',ui.content[i].value);
                    var cityRef = ui.content[i].ref;
                    getNumbers(cityRef);
                }
            }
        }
    });
}

function getNumbers(cityRef){
    $.ajax({
        url: "https://api.novaposhta.ua/v2.0/json/",
        dataType: "jsonp",
        data: {
            "modelName": "Address",
            "calledMethod": "getWarehouses",
            "methodProperties": {
                "CityRef": cityRef
            },
            "apiKey": "c676d6fb43bbd952ed71c119aed6417c"
        },
        success: function( data ) {
            data = data.data;
            $('#select_delivery_adress').html('');
            for(var i=0;i<data.length;i++){
                $('#select_delivery_adress').append("<option value='"+(i+1)+"'>"+data[i].DescriptionRu+"</option>");
            }
        }
    });
}