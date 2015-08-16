<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
class Accessory {
    var $id;
    var $visible;
    var $title;
    var $translit;
    var $date_add;
    var $date_edit;
    var $articul;
    var $photo;
    var $gallery;
    var $video;
    var $instruction;
    var $age_from;
    var $age_to;
    var $description;
    var $price;
    var $male;
    var $female;
    var $el_number;
    var $size;
    var $discount;
    var $label_new;
    var $label_hit;
    var $label_action;
    var $label_exclusive;
    var $seo_description;
    var $seo_keywords;
    
    function __construct() {}
    /**
     * Get user fom database with selected values
     * @param array $selector, sql WHERE, array(key=>value,key=>value,key=>value,etc.)
     * @param mysqli $connection new mysqli(HOST, DB_USER , PASS, DB_NAME);
     * @return bool TRUE if success or FALSE
     */
    function getFomDb(array $selector, mysqli $connection){
        $str='';
        foreach ($selector as $key => $value) {
            $str.="$key='$value' AND ";
        }
        $selectorStr = substr_replace($str, '', strripos($str," AND "));
        $result = $connection->query("SELECT *  FROM accessories WHERE ({$selectorStr}) LIMIT 1");

        $record = $result->fetch_object();$result->free();
        if(is_null($record)){return FALSE;}
        foreach ($record as $name => $value) {
            $this->$name = $value;
        }
        return TRUE;
    }
    /**
     * Insert current user to table
     * @param mysqli $connection new mysqli(HOST, DB_USER , PASS, DB_NAME);
     * @return bool TRUE if success or FALSE
     */
    function insert(mysqli $connection){
        $class_vars = get_class_vars(get_class($this));
        unset($class_vars['id']);
        $fields='';
        $values='';
        foreach ($class_vars as $name => $value) {
            $fields.= $name.',';
            $values.= "'".$this->$name."',";
        }
        $fieldsStr = substr_replace($fields, '', strripos($fields,","));
        $valuesStr = substr_replace($values, '', strripos($values,","));
        $query = "INSERT INTO accessories ($fieldsStr) VALUES ($valuesStr)";
        if(!$connection->query($query)){
//            echo $connection->error;
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Update selected values in DB
     * @param array $value, sql SET, array(key=>value,key=>value,key=>value,etc.)
     * @param array $selector, sql WHERE, array(key=>value,key=>value,key=>value,etc.)
     * @param mysqli $connection new mysqli(HOST, DB_USER , PASS, DB_NAME);
     * @param String $divider selector divider 'AND/OR'
     * @return bool TRUE if success or FALSE
     */
    static function update(array $values,array $selector,$connection,$divider = 'AND'){
        $vStr='';
        foreach ($values as $key => $value) {
            $vStr.="$key='$value',";
        }
        $valuesStr = substr_replace($vStr, '', strripos($vStr,","));
        $sStr='';
        foreach ($selector as $key => $value) {
            $sStr.="$key='$value' $divider ";
        }
        $selectorStr = substr_replace($sStr, '', strripos($sStr," $divider "));
        $query = "UPDATE accessories SET $valuesStr WHERE $selectorStr";
        $result = $connection->query($query);
        if(!$result){
//            echo $connection->error;
            return FALSE;  
        }
        return TRUE;
    }
}
