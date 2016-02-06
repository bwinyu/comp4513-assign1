<?php

/*
   Represents a single row for the countries table.

   This a concrete implementation of the Domain Model pattern.
 */
class Countries extends DomainObject
{
    static function getFieldNames(){
        return array('ISO', 'fipsCountryCode', 'ISO3', 'ISONumeric', 'CountryName', 'Capital', 'GeoNameID', 'Area',
                     'Population', 'Continent', 'TopLevelDomain', 'CurrencyCode', 'CurrencyName', 'PhoneCountryCode',
                     'Languages', 'PostalCodeFormat', 'PostalCodeRegex', 'Neighbours', 'CountryDescription');
    }

    public function __construct(array $data, $generateExc){
        parent::__construct($data, $generateExc);
    }

}

?>