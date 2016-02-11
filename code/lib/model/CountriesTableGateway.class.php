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

    /**
     * Retrieves all entries with a specific continent code
     *
     * @param $continentCode - contenent code to filter by
     * @return array - all records matching contenent code
     */
    public function filterByContinentCode($continentCode)
    {
        $where = 'continent=?';
        $param = ($continentCode);
        $results = $this->findBy($where, $param);

        return $results;
    }
}?>