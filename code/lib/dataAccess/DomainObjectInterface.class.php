<?php
/*
  Specifies the functionality of any domain object class 
 */
interface DomainObjectInterface
{
   static function getFieldNames();
   function getXML();
}

?>