<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

require_once '../lib/simple_html_dom.php';

$html = file_get_html('../content/text.htm');

foreach ($html->find('tr') as $row) { //выбираем все tr сообщений
    if($row->find('td', 3) && $row->find('td', 6)){
        $item['title'] = $row->find('td', 1)->plaintext; // парсим название в html формате
        $item['articul'] = intval($row->find('td', 3)->plaintext); // парсим артикул в html формате
        $item['count'] = intval($row->find('td', 6)->plaintext); // парсим количество
//        $item['price'] = floatval($row->find('td', 7)->plaintext); // парсим цену
        if($item['articul'] != 0){
            $rows[] = $item; // пишем в массив
        }
    }
}
$rows= array_map("unserialize", array_unique( array_map("serialize", $rows) ));
print_arr($rows);

$html->clear(); 
unset($html);