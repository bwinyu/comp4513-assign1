<?php

/*
   Represents a single row for the operating_systems table.

   This a concrete implementation of the Domain Model pattern.
 */
class OperatingSystems extends DomainObject
{
    static function getFieldNames(){
        return array('id', 'name');
    }

    public function __construct(array $data, $generateExc){
        parent::__construct($data, $generateExc);
    }
}

?>