<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>

<div id="feedback">

    <!-- Пять цветных элементов span, смещенных влево один к другому -->
    <span class="color color-1"></span>
    <span class="color color-2"></span>
    <span class="color color-3"></span>
    <span class="color color-4"></span>
    <span class="color color-5"></span>
    
    <div class="section">   
    	<!-- Элемент span стрелки смещается вправо -->
        <h6><span class="arrow up"></span>Обратная связь</h6>      
        <p class="message">Пожалуйста, включите контактную информацию, если вы хотите получить ответ.</p>    
        <textarea></textarea>    
        <a class="submit" href="">Отправить</a>
    </div>
</div>