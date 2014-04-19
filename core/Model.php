<?php namespace Core;

use Core\Database\DataMapper;
use Core\Database\DatabaseAdapterInterface;

class Model extends DataMapper
{ 
    public function __construct(DatabaseAdapterInterface $adapter) {
        parent::__construct($adapter);
    }
}