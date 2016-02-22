<?php
/*
  Table Data Gateway for the Browser table.
 */
class BrowserTableGateway extends TableDataGateway
{    
   public function __construct($dbAdapter) 
   {
      parent::__construct($dbAdapter);
   }
  
   protected function getDomainObjectClassName()  
   {
      return "Browser";
   } 
   protected function getTableName()
   {
      return "browsers";
   }
   protected function getOrderFields() 
   {
      return 'name';
   }
  
   protected function getPrimaryKeyName() {
      return "id";
   }

   public function visitsByBrowser()
   {

      $sql = 'SELECT browsers.ID, browsers.name, Count(visits.ID) AS Visits FROM browsers INNER JOIN visits
                ON browsers.ID = visits.browser_id
                GROUP BY browsers.name';

      $results = $this->dbAdapter->fetchAsArray($sql);
      if (is_null($results))
         return $results;
      else
         return $this->convertRecordsToObjects($results);
   }

}

?>