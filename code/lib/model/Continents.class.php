<?php

/*
   Represents a single row for the continents table.

   This a concrete implementation of the Domain Model pattern.
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