<?php
//Переменная доступа
define('ACCESS_VALUE', 'LegoShop');
define(ACCESS_VALUE, TRUE);
//Подключение файла конфигурации
require_once 'config.php';

$imp = new DOMImplementation();
$dtd = $imp->createDocumentType('yml_catalog', '', 'shops.dtd');
// Создает объект DOMDocument
$dom = $imp->createDocument("", "", $dtd);
$dom->encoding = 'UTF-8';
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;        
        
        
//добавление корня - <yml_catalog> 
$yml_catalog = $dom->appendChild($dom->createElement('yml_catalog'));
$date = date('Y-m-d H:i');
$yml_catalog->appendChild($dom->createAttribute("date"))->appendChild($dom->createTextNode(date('Y-m-d H:i')));

$shop = $yml_catalog->appendChild($dom->createElement('shop'));
$name = $shop->appendChild($dom->createElement('name'))->appendChild($dom->createTextNode("Legkoo.com.ua"));
$company = $shop->appendChild($dom->createElement('company'))->appendChild($dom->createTextNode("магазин детских конструкторов Лего"));
$url = $shop->appendChild($dom->createElement('url'))->appendChild($dom->createTextNode("http://legkoo.com.ua"));

$currencies = $shop->appendChild($dom->createElement('currencies'));
$currency = $currencies->appendChild($dom->createElement('currency'));
    $currency->appendChild($dom->createAttribute('id'))->appendChild($dom->createTextNode('UAH'));
    $currency->appendChild($dom->createAttribute('rate'))->appendChild($dom->createTextNode('1'));
    $currency->appendChild($dom->createAttribute('plus'))->appendChild($dom->createTextNode('0'));
$categories = $shop->appendChild($dom->createElement("categories"));
$result = $conn->query("SELECT * FROM categories WHERE visible='1'");
while ($record = $result->fetch_object()){
    $category = $categories->appendChild($dom->createElement("category"));
    $category->appendChild($dom->createAttribute('id'))->appendChild($dom->createTextNode($record->id));
    $category->appendChild($dom->createTextNode(htmlspecialchars($record->title)));
}

$offers = $shop->appendChild($dom->createElement("offers"));
$result = $conn->query("SELECT * FROM products WHERE visible = '1' AND quantity > '0'");
while($record = $result->fetch_object()){
    $offer = $offers->appendChild($dom->createElement("offer"));
        $offer->appendChild($dom->createAttribute('id'))->appendChild($dom->createTextNode($record->id));
        $offer->appendChild($dom->createAttribute('available'))->appendChild($dom->createTextNode("true"));
    $url = $offer->appendChild($dom->createElement('url'))->appendChild($dom->createTextNode("http://legkoo.com.ua/product-$record->id-lego-$record->translit-$record->articul"));
    if($record->old_price != 0){
        $oldprice = $offer->appendChild($dom->createElement('oldprice'))->appendChild($dom->createTextNode($record->old_price));
    }
    $price = $offer->appendChild($dom->createElement('price'))->appendChild($dom->createTextNode($record->price));
    $currencyId = $offer->appendChild($dom->createElement('currencyId'))->appendChild($dom->createTextNode("UAH"));
    $categoryId = $offer->appendChild($dom->createElement('categoryId'))->appendChild($dom->createTextNode($record->category));
    $picture = $offer->appendChild($dom->createElement('picture'))->appendChild($dom->createTextNode("http://legkoo.com.ua/".$record->photo));
    $name = $offer->appendChild($dom->createElement('name'))->appendChild($dom->createTextNode(htmlspecialchars($record->title)));
    $vendor = $offer->appendChild($dom->createElement('vendor'))->appendChild($dom->createTextNode("Lego"));
    $vendorCode = $offer->appendChild($dom->createElement('vendorCode'))->appendChild($dom->createTextNode($record->articul));
    $description = $offer->appendChild($dom->createElement('description'))->appendChild($dom->createTextNode(htmlspecialchars(strip_tags($record->description))));
}


$xml_string = htmlspecialchars_decode($dom->saveXML());
echo html_entity_decode($xml_string);