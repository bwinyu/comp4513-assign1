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

}

?>