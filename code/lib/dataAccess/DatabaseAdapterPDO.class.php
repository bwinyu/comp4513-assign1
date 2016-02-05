<?php
/*
  Acts as an adapter for our database API so that all database api specific code
  will reside here in this class. In this example, we will use the PDO API. 
 
  Code inspired from:
     https://github.com/codeinthehole/domain-model-mapper
     http://www.devshed.com/c/a/PHP/PHP-Service-Layers-Database-Adapters/
 */
class DatabaseAdapterPDO implements DatabaseAdapterInterface
{
   private $pdo;
   private $lastStatement = null;   


   public function __construct($values)
   {
      $this->setConnectionInfo($values);
   }
   
   function setConnectionInfo($values=array()) {
      $connString = $values[0];
      $user = $values[1]; 
      $password = $values[2];

      $pdo = new PDO($connString,$user,$password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo = $pdo;      
   }
   
   function closeConnection()   
   {
      $pdo = null;
   }

    /**
     * Executes an SQL query and returns the PDO statement object
     */
    public function runQuery($sql, $parameters=array())
    {
        // Ensure parameters are in an array
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }
        
        $this->lastStatement = null;
        if (count($parameters) > 0) {
            // Use a prepared statement if parameters 
            $this->lastStatement = $this->pdo->prepare($sql);
            $executedOk = $this->lastStatement->execute($parameters);
            if (! $executedOk) {
                throw new PDOException;
            }
        } else {
            // Execute a normal query     
            $this->lastStatement = $this->pdo->query($sql); 
            if (!$this->lastStatement) {
                throw new PDOException;
            }
        }
        return $this->lastStatement;
    }

    /**
     * Wraps single quotes around a table or fieldname identifier
     */
    private function quoteIdentifier($identifier)
    {
        return sprintf("'%s'", $identifier);
    }


    /**
     * Returns a single field value
     *
     * @param string $sql The query to run
     * @param array $Parameters Parameter values to bind into query
     * @return string
     */
    public function fetchField($sql, $parameters=array())
    {
        $row = $this->fetchRow($sql, $parameters); 
        return ($row && count($row) > 0) ? array_shift($row) : null;
    }

    /**
     * Returns a row
     *
     * @param string $sql The query to run
     * @param array $Parameters Parameter values to bind into query
     * @return array
     */
    public function fetchRow($sql, $parameters=array())
    {
        $statement = $this->runQuery($sql, $parameters);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row ? $row : null;
    }

    /**
     * Returns an array of rows
     *
     * @param string $sql The query to run
     * @param array $Parameters Parameter values to bind into query
     * @return array
     */
    public function fetchAsArray($sql, $parameters=array())
    {
        $statement = $this->runQuery($sql, $parameters);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Inserts data into a table
     *
     * @param string $tableName
     * @param array $Parameters A Hash of field name to value
     * @return PDOStatement
     */
    public function insert($tableName, $parameters=array())
    {
        // Extract fields and values from parameters
        $fields = array();
        $values = array();
        foreach ($parameters as $field => $value) {
            $fields[] = $this->quoteIdentifier($field);
            $values[] = '?';
        }
        // Construct SQL and execute
        $escapedTableName = $this->quoteIdentifier($tableName);
        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $escapedTableName, implode(', ', $fields), implode(', ', $values));
        return $this->runQuery($sql, array_values($parameters));
    }

    /**
     * Returns the last insert id
     */
    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Executes an UPDATE statement
     *
     * @param string $tableName
     * @param array $updateParameters
     * @param string $whereCondition
     * @param array $whereParameters
     * @return int The number of rows affected
     */
    public function update($tableName, $updateParameters=array(), $whereCondition='', $whereParameters=array())
    {
        // Determine field assignments
        $assignments = array();
        $parameters = array();
        foreach ($updateParameters as $field => $value) {
            $placeHolder = strtolower($field);
            $assignments[] = sprintf("%s = %s", $this->quoteIdentifier($field), ":$placeHolder");
            $Parameters[$placeHolder] = $value;
        }
        // Construct SQL
        $escapedTableName = $this->quoteIdentifier($tableName);
        $sql = sprintf("UPDATE %s SET %s", $escapedTableName, implode(', ', $assignments));
        if ($whereCondition) {
            $sql .= " WHERE $whereCondition";
            $parameters = array_merge($parameters, $whereParameters);
        }
        $statement = $this->runQuery($sql, $parameters);
        
        // Return the number of rows affected
        return $statement->rowCount();
    }

    /**
     * Executes a DELETE statement
     *
     * Returns the number of rows deleted
     */
    public function delete($tableName, $whereCondition=null, $whereParameters=array())
    {
        $sql = sprintf("DELETE FROM %s ", $this->quoteIdentifier($tableName));
        $parameters = array(); 
        if ($whereCondition) {
            $sql .= "WHERE $whereCondition";
            $parameters = $whereParameters;
        }
        $statement = $this->runQuery($sql, $parameters);
        
        // Return the number of rows affected
        return $statement->rowCount();
    }

    /**
     * Begins a transaction
     */
    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
        return $this;
    }
    
    /**
     * Commits current transaction
     */
    public function commit()
    {
        $this->pdo->commit();
        return $this;
    }
    
    /**
     * Rolls back current transaction
     */
    public function rollBack()
    {
        $this->pdo->rollBack();
        return $this;
    }
    
    /**
     *  Returns the number of rows affected by the last SQL statement
     */
    public function getNumRowsAffected()
    {
        if (!$this->lastStatement) {
            return null;
        }
        return $this->lastStatement->rowCount();
    }



}

?>