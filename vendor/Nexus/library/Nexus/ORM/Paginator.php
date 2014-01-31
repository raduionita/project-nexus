<?php

  namespace Nexus\ORM;

  class Paginator
  {
    protected $table = null;
    
    protected $page  = 1;
    protected $items = 10;
    protected $count = 0;
  
    public function __construct(\Table $table)
    {
      $this->table = $table;
      $this->count = $table->count();
    }
    
    public function config(array $config)
    {
      foreach($config as $key => $value)
        if(isset($this->$key) && $key !== 'table')
          $this->$key = (int) $value;
      return $this;
    }
    
    public function meta() { return array('page' => $this->page, 'items' => $this->items, 'count' => $this->count); }
    
    public function get()
    {
      $start = ($this->page - 1) * $this->items;

      return $this->table->limit($start, $this->items)->get();
    }
  }