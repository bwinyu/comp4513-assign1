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

    /**
     * Retrieves all entries with a specific device type ID
     *
     * @param $deviceTypeID - numeric device type ID to filter by [e.g. 1]
     * @return array - all records matching device type ID
     */
    public function filterByDeviceType($deviceTypeID)
    {
        $where = 'device_type_id=?';
        $param = ($deviceTypeID);
        $results = $this->findBy($where, $param);

        return $results;
    }

    /**
     * Retrieves all entries with a specific device brand ID
     *
     * @param $deviceBrandID - numeric device brand ID to filter by [e.g. 1]
     * @return array - all records matching device brand ID
     */
    public function filterByDeviceBrand($deviceBrandID)
    {
        $where = 'device_brand_id=?';
        $param = ($deviceBrandID);
        $results = $this->findBy($where, $param);

        return $results;
    }

    /**
     * Retrieves all entries with a specific OS ID
     *
     * @param $osID - numeric OS ID to filter by [e.g. 1]
     * @return array - all records matching OSID
     */
    public function filterByOS($osID)
    {
        $where = 'os_id=?';
        $param = ($osID);
        $results = $this->findBy($where, $param);

        return $results;
    }

    /**
     * Retrieves all entries with a referrer ID
     *
     * @param $referrerID - numeric referrer ID to filter by [e.g. 1]
     * @return array - all records matching referrer ID
     */
    public function filterByReferrer($referrerID)
    {
        $where = 'referrer_id=?';
        $param = ($referrerID);
        $results = $this->findBy($where, $param);

        return $results;
    }

    /**
     * Retrieves count of entries with ISO code
     *
     * @param $code two-character ISO country code to filter by [e.g. 'CA']
     * @return integer - count of entries matching country code
     */
    public function countByCountryCode($code){
        $where = 'country_code=?';
        $param = ($code);
        $results = $this->countBy($where, $param);

        return $results;
    }

    /**
     * Retrieves count of entries device type ID
     *
     * @param $deviceTypeID - numeric device type ID [e.g. 1]
     * @return integer - count of entries matching device type ID
     */
    public function countByDeviceType($deviceTypeID){
        $where = 'device_type_id=?';
        $param = ($deviceTypeID);
        $results = $this->countBy($where, $param);

        return $results;
    }

    /**
     * Retrieves count of entries device brand ID
     *
     * @param $deviceBrandID - numeric device brand ID [e.g. 1]
     * @return integer - count of entries matching device brand ID
     */
    public function countByDeviceBrand($deviceBrandID){
        $where = 'device_brand_id=?';
        $param = ($deviceBrandID);
        $results = $this->countBy($where, $param);

        return $results;
    }

    /**
     * Retrieves count of entries browser ID
     *
     * @param $browserID - numeric browser ID [e.g. 1]
     * @return integer - count of entries matching browser ID
     */
    public function countByBrowser($browserID){
        $where = 'browser_id=?';
        $param = ($browserID);
        $results = $this->countBy($where, $param);

        return $results;
    }

    /**
     * Retrieves count of entries referrer ID
     *
     * @param $referrerID - numeric referrer ID [e.g. 1]
     * @return integer - count of entries matching referrer ID
     */
    public function countByReferrer($referrerID){
        $where = 'referrer_id=?';
        $param = ($referrerID);
        $results = $this->countBy($where, $param);

        return $results;
    }

    /**
     * Retrieves count of entries OS ID
     *
     * @param $osID - numeric OS ID [e.g. 1]
     * @return integer - count of entries matching OS ID
     */
    public function countByOS($osID){
        $where = 'referrer_id=?';
        $param = ($osID);
        $results = $this->countBy($where, $param);

        return $results;
    }

    /**
     * Retrieves count of entries by month, gets current year and uses that as per data
     *
     * @param $month numerical value of month to filter by [e.g. '12' for December]
     * @return integer - count of entries matching country code
     */
    public function countByMonth($month){
        $where = 'DATE_FORMAT(visit_date, \'%Y\') = DATE_FORMAT(SYSDATE(), \'%Y\')
        AND DATE_FORMAT(visit_date, \'%b\') = ?';

        $param = ($month);
        $results = $this->countBy($where, $param);

        return $results;
    }


    /**
     * Retrieves the number of visits per day for a given month
     *
     * @param $month - month to filter by - i.e. 'jan'
     * @return array of visit objects
     */
    public function visitsByDayForMonth($month){
        $sql = 'SELECT count(id) AS Visits, DATE(visit_date) AS Date from visits
                WHERE DATE_FORMAT(visit_date, \'%Y\') = DATE_FORMAT(SYSDATE(), \'%Y\')
                AND DATE_FORMAT(visit_date, \'%b\') = ?
                GROUP BY visit_date';


        $param = ($month);

        $results = $this->dbAdapter->fetchAsArray($sql, $param);
        if (is_null($results))
            return $results;
        else
            return $this->convertRecordsToObjects($results);
    }

    /**
     * Joins all the tables and returns the human readable data. i.e country name, OS name rather than ISO code or osID
     *
     * @param null $where - Column names for where clause
     * @param null $param Parameters for where clause in. Must be in an Array i.e. ('Canada', 'USA')
     * @return array - array of records returned from query
     */
    public function filterVisitsData($where=null, $param=null){
        $sql = 'SELECT visits.id, visits.ip_address, countries.CountryName AS Country, DATE(visits.visit_date) AS Date, TIME(visits.visit_time) AS Time, device_types.name as DeviceType,
                device_brands.name as DeviceBrand, browsers.name AS Browser, referrers.name as Referrer, operating_systems.name AS OS FROM referrers INNER JOIN (operating_systems
                INNER JOIN (device_types INNER JOIN (device_brands INNER JOIN (countries INNER JOIN (browsers INNER JOIN visits
                ON browsers.ID = visits.browser_id) ON countries.ISO = visits.country_code) ON device_brands.ID = visits.device_brand_id)
                ON device_types.ID = visits.device_type_id) ON operating_systems.ID = visits.os_id) ON referrers.id = visits.referrer_id';

        if($where != null){
            // Building where parameters
            $clause = ' ' . $where[0] . '=?';
            for($i = 1; $i< sizeof($where); $i++){
                $clause .= ' AND ' . $where[$i] . "=?";
            }
            // Using HAVING instead of WHERE since it recognizes aliases
            $sql.=' HAVING ' . $clause;
            $sql.= ' ORDER BY Date, Time';
        }

        $sql.= ' LIMIT 100';



        $results = $this->dbAdapter->fetchAsArray($sql, $param);
        if (is_null($results))
            return $results;
        else
            return $this->convertRecordsToObjects($results);
    }

    /**
     * Counts the visits for 3 countries in the months of Jan, May , and Sept
     *
     * @param $param Array of months
     * @return array - array of objects for records
     */
    public function visitsForBarChart($param){

        $sql = 'SELECT count(id) AS Visits, countries.CountryName, MONTHNAME(visits.visit_date) as MonthName
                FROM countries JOIN visits ON countries.ISO = visits.country_code
                WHERE DATE_FORMAT(visit_date, \'%Y\') = DATE_FORMAT(SYSDATE(), \'%Y\')
                AND DATE_FORMAT(visit_date, \'%b\') IN (\'Jan\', \'May\', \'Sep\')
                AND countries.CountryName IN (?, ?, ?)
                GROUP BY MONTHNAME(visits.visit_date), countries.CountryName
                ORDER BY MONTHNAME(visits.visit_date)';

        $results = $this->dbAdapter->fetchAsArray($sql, $param);
        if (is_null($results))
            return $results;
        else
            return $this->convertRecordsToObjects($results);
    }


}

?>