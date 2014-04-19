<?php namespace Core\Database;
 
class DataMapper
{
    protected $adapter;
    protected $entityTable;
    protected $attributes = array();
 
    public function __construct(DatabaseAdapterInterface $adapter) {
        $this->adapter = $adapter;
    }
 
    public function getAdapter() {
        return $this->adapter;
    }
 
    public function findById($id)
    {
        $this->adapter->select($this->entityTable,
            array('id' => $id));
 
        if (!$row = $this->adapter->fetch()) {
            return null;
        }
 
        $this->populateAttributes($row);

        return $this;
    }
 
    public function findAll(array $conditions = array())
    {
        $entities = array();
        $this->adapter->select($this->entityTable, $conditions);
        $rows = $this->adapter->fetchAll();

        if ($rows) {
            foreach ($rows as $row) {
                //create a new object for each row
                $adapter = $this->getAdapter();

                //get calling class and instantiate it
                $class = get_called_class();
                $obj = new $class($adapter);

                // populate attributes with data
                $entities[] = $obj->populateAttributes($row);
            }
        }
 
        return $entities;
    }
    
    public function update()
    {
        $attributes = $this->attributes;
        $id = $attributes['id'];

        unset($attributes['id']);

        $this->adapter->update($this->entityTable, $attributes, 'id = ' . $id);
    }

    public function save()
    {
        $this->update();
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

    public function populateAttributes(array $row)
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