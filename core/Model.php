<?php namespace Core;

use Core\Database\AbstractDataMapper;
use Core\Database\DatabaseAdapterInterface;

class Model extends AbstractDataMapper
{ 
    public function __construct(DatabaseAdapterInterface $adapter) {
        parent::__construct($adapter);
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->attributes))
        {
            return $this->attributes[$name];
        }

        trigger_error('Accessing undefined property.');
    }

    protected function populateAttributes(array $row)
    {
        if (count($row))
        {
            foreach($row as $name => $value)
            {
                $this->attributes[$name] = $value;
            }
        }

        return $this;
    }
}