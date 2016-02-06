<?php

/*
  Table Data Gateway for the countries table.
 */
class CountriesTableGateway extends TableDataGateway
{
    public  function __construct($dbAdapter)
    {
        parent::__construct($dbAdapter);
    }

    protected function getDomainObjectClassName()
    {
        return "Countries";
    }

    protected function getTableName()
    {
        return "countries";
    }

    protected function getOrderFields()
    {
        return "CountryName";
    }
    protected function getPrimaryKeyName()
    {
        return "ISO";
    }
}?>