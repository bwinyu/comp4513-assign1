<?php

/**
 * Created by PhpStorm.
 * User: matt
 * Date: 04/02/16
 * Time: 10:20 PM
 */
class Continents extends DomainObject
{
    static function getFieldNames(){
        return array('ContinentCode', 'ContinentName', 'GeoNameId');
    }

    public function __construct(array $data, $generateExc){
        parent::__construct($data, $generateExc);
    }
}