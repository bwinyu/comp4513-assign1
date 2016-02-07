<?php
/*
   Represents a single row for the visits table.

   This a concrete implementation of the Domain Model pattern.
 */
class Visits extends DomainObject
{

    static function getFieldNames() {
        return array('id','ip_address', 'country_code', 'visit_date','visit_time', 'device_type_id', 'device_brand_id',
                     'referrer_id', 'os_id');
    }

    public function __construct(array $data, $generateExc)
    {
        parent::__construct($data, $generateExc);
    }

    // implement any setters that need input checking/validation
}

?>