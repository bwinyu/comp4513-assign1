<?php
/*
  Encapsulates common functionality needed by all table gateway objects.
 
  Table Data Gateway is an enterprise data pattern identified by Fowler. This pattern's 
  intent is to encapsulate the full interaction with a database table. It is also 
  referred to by some as the data access object (DAO) pattern.
 
  Inspiration:
         http://martinfowler.com/eaaCatalog/tableDataGateway.html
         http://css.dzone.com/books/practical-php-patterns-table
         https://speakerdeck.com/hhamon/database-design-patterns-with-php-53
 */
 
abstract class TableDataGateway
{
   protected $dbAdapter;
   
   public function __construct($dbAdapter) 
   {
      if (is_null($dbAdapter) )
         throw new Exception("Database adapter is null");
         
      $this->dbAdapter = $dbAdapter;
   }
   
   /*
     The name of the table in the database
   */    
   abstract protected function getTableName(); 
   /*
     The class name for the row items for this table
   */   
   abstract protected function getDomainObjectClassName();
   /*
     A list of fields that define the sort order
   */   
   abstract protected function getOrderFields();
   
   /*
     The name of the primary keys in the database ... this can be overridden by subclasses
   */    
   protected function getPrimaryKeyName() {
      return "ID";
   }
     
   // PUBLIC FINDERS 
   //
   // All of these finders return either a single or array of the appropriate DomainObject subclasses
   //
   
   /*
      Returns all the records in the table
   */
   public function findAll($sortFields=null)
   {
      $sql = $this->getSelectStatement();
      // add sort order if required
      if (! is_null($sortFields)) {
         $sql .= ' ORDER BY ' . $sortFields;
      }   
      $results = $this->dbAdapter->fetchAsArray($sql);
      if (is_null($results))
          return $results;
      else         
          return $this->convertRecordsToObjects($results);
   }  
    
   /*
      Returns all the records in the table sorted by the specified sort order
   */
   public function findAllSorted($ascending)
   {
      $sql = $this->getSelectStatement() . ' ORDER BY ' . $this->getOrderFields();
      if (! $ascending) {
         $sql .= " DESC";  
      }         
      return $this->convertRecordsToObjects($this->dbAdapter->fetchAsArray($sql));
   } 
    
   /*
      Returns all the records that match the criteria specified by the passed WHERE clause
      
      $whereClause - the WHERE clause [e.g., 'ID=? or Name Like ?' or 'price>?' ]
      $parameterValues - an array of parameter values [e.g., Array(6,'Fred') or Array(6) ]
      $sortFields - optional string containing field name list to sort on [e.g., 'CountryName' or 'CountryName DESC']
   */
   public function findBy($whereClause, $parameterValues=array(), $sortFields=null)
   {
      $sql = $this->getSelectStatement() . ' WHERE ' . $whereClause;
      // add sort order if required
      if (! is_null($sortFields)) {
         $sql .= ' ORDER BY ' . $sortFields;
      }
      $result = $this->dbAdapter->fetchAsArray($sql, $parameterValues); 
      if (is_null($results))
          return $results;
      else          
          return $this->convertRecordsToObjects($result);
   }  
   /*
      Returns a record for the specificed ID
   */
   public function findById($id)
   {
      $sql = $this->getSelectStatement() . ' WHERE ' . $this->getPrimaryKeyName() . '=:id';
      $results = $this->dbAdapter->fetchRow($sql, Array(':id' => $id));
       
      if (is_null($results))
          return $results;
      else
        return $this->convertRowToObject($results);
   }   
 

   //
   // HELPERS
   //
   
   /*
    * Subclasses can override this if they need a non-standard SELECT
    */
   protected function getSelectStatement()
   {
      $className = $this->getDomainObjectClassName();
      return "SELECT " . $className::fieldNameList() . " FROM " . $this->getTableName();
   }   
   /*
      Converts the array of record data that comes from the database adapter into
      an object of the appropriate Domain Object subclass type
   */
   protected function convertRowToObject($result) 
   {
      $className = $this->getDomainObjectClassName();
 
      return new $className($result,false);
   }   
   /*
      Converts the array of records that comes from the database adapter into
      an array of object of the appropriate Domain Object subclass type
   */   
   protected function convertRecordsToObjects($results) 
   {
      $className = $this->getDomainObjectClassName();
      $rows = Array();
      foreach ($results as $row)
      { 
         $instance = new $className($row, false);         
         $rows[] = $instance;
      }
      return $rows;
   }   
   
}

?>