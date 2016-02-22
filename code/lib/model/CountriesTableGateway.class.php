<?php

/*
  Table Data Gateway for the countries table.
 */
class CountriesTableGateway extends TableDataGateway
{
    public function __construct($dbAdapter)
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

    /**
     * Retrieves all countries and counts the number of IP visits from the visits table
     *
     * @return array - array of objects for each record returned
     */
    public function visitsByCountry($month)
    {

        $sql = 'SELECT ISO, countries.CountryName, Count(visits.ID) AS Visits FROM countries INNER JOIN visits
                ON countries.ISO = visits.country_code
                WHERE DATE_FORMAT(visits.visit_date, \'%b\') = ?
                GROUP BY countries.CountryName
                HAVING Count(visits.ID) > 10';

        $results = $this->dbAdapter->fetchAsArray($sql, $month);
        if (is_null($results))
            return $results;
        else
            return $this->convertRecordsToObjects($results);
    }

    public function countryLike($country)
    {
        $sql = $this->getSelectStatement() . ' WHERE CountryName LIKE ?';

        $results = $this->dbAdapter->fetchAsArray($sql, '%' . $country . '%');
        if (is_null($results))
            return $results;
        else
            return $this->convertRecordsToObjects($results);
    }

    public function fetchCountryNames(){
        $sql = 'SELECT CountryName FROM countries';

        $results = $this->dbAdapter->fetchAsArray($sql);
        if (is_null($results))
            return $results;
        else
            return $this->convertRecordsToObjects($results);
    }

    public function fetchCountryNamesTop10Visits(){
        $sql = 'SELECT Count(visits.id) AS Visits_Count, countries.CountryName
                FROM countries INNER JOIN visits ON countries.ISO = visits.country_code
                GROUP BY countries.CountryName
                ORDER BY Count(visits.id) DESC
                LIMIT 10;';

        $results = $this->dbAdapter->fetchAsArray($sql);
        if (is_null($results))
            return $results;
        else
            return $this->convertRecordsToObjects($results);
    }

}?>