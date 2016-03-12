$(document).ready(function(){

	// Относительный URL скрипта submit.php.
	// Вероятно, вам нужно будет его поменять.
	var submitURL = './?ajax=feedback';

	// Кэшируем объект feedback:	
	var feedback = $('#feedback');

	$('#feedback h6').click(function(){

		// Значения свойств анимации хранятся
		// в отдельном объекте:
				
		var anim	= {		
			mb : 0,			// Поле снизу
			pt : 10			// Отступ сверху
		};
		
		var el = $(this).find('.arrow');
		
		if(el.hasClass('down')){
			anim = {
				mb : -330,
				pt : 10
			};
		}

		// Первая анимация пермещает вверх или вниз форму, а вторая перемещает 
		// заголовок, так что он выравнивается по минимизированной версии
		
		feedback.stop().animate({marginBottom: anim.mb});
		
		feedback.find('.section').stop().animate({paddingTop:anim.pt},function(){
			el.toggleClass('down up');
		});
	});
	
	$('#feedback a.submit').on('click',function(){
		var button = $(this);
		var textarea = feedback.find('textarea');
		
		// Мы используем класс working не только для задания стилей для кнопки отправки данных,
		// но и как своеобразный замок для предотварщения множественных генераций формы.
		
		if(button.hasClass('working') || textarea.val().length < 5){
			return false;
		}

		// Запираем форму и изменяем стиль кнопки:
		button.addClass('working');
		
		$.ajax({
			url		: submitURL,
			type	: 'post',
			data	: { message : textarea.val()},
			complete	: function(xhr){
				
				var text = xhr.responseText;
				
				// Жанная операция помогает пользователю определить ошибку:
				if(xhr.status == 404){
					text = 'К путь к скрипту submit.php не верный.';
				}

				// Прячем кнопку и область текста , после которой 
				// мы показывали полученный ответ из submit.php

				button.fadeOut();

				textarea.fadeOut(function(){
					var span = $('<span>',{
						className	: 'response',
						html		: text
					})
					.hide()
					.appendTo(feedback.find('.section'))
					.show();
				}).val('');
			}
		});
		
		return false;
	});
});
