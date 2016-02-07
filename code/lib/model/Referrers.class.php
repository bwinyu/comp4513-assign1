<?php

/*
   Represents a single row for the referrers table.

   This a concrete implementation of the Domain Model pattern.
 */
class Referrers extends DomainObject
{
    static function getFieldNames(){
        return array('id', 'name');
    }

    public function __construct(array $data, $generateExc){
        parent::__construct($data, $generateExc);
    }
}

?>