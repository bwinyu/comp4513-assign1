<?php
/*
  Table Data Gateway for the visits table.
 */
class VisitsTableGateway extends TableDataGateway
{
    public function __construct($dbAdapter)
    {
        parent::__construct($dbAdapter);
    }

    protected function getDomainObjectClassName()
    {
        return "Visits";
    }
    protected function getTableName()
    {
        return "visits";
    }
    protected function getOrderFields()
    {
        return 'visit_date, visit_time';
    }

    protected function getPrimaryKeyName() {
        return "id";
    }

    /**
     * Retrieves all entries with a specific ISO country code
     *
     * @param $code - two-character ISO country code to filter by [e.g. 'CA']
     * @return array - all records matching ISO country code
     */
    public function filterByCountryCode($code)
    {
        $where = 'country_code=?';
        $param = ($code);
        $results = $this->findBy($where, $param);

        return $results;
    }

    /**
     * Retrieves all entries with a specific browser ID
     *
     * @param $browser_id - numeric browser ID to filter by [e.g. 1]
     * @return array - all records matching browser ID
     */
    public function filterByBrowser($browserID)
    {
        $where = 'browser_id=?';
        $param = ($browserID);
        $results = $this->findBy($where, $param);

        return $results;
    }



}

?>