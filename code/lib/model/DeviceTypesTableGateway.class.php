<?php
/*
  Table Data Gateway for the device_types table.
 */
class DeviceTypesTableGateway extends TableDataGateway
{
    public function __construct($dbAdapter)
    {
        parent::__construct($dbAdapter);
    }

    protected function getDomainObjectClassName()
    {
        return "DeviceTypes";
    }
    protected function getTableName()
    {
        return "device_types";
    }
    protected function getOrderFields()
    {
        return 'name';
    }

    protected function getPrimaryKeyName() {
        return "id";
    }


}

?>