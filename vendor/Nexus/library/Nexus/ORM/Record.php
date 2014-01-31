<?php

  class Record extends StdClass
  {
  # protected $data = array();
  # public function __construct(array $data = null) { $this->data = array_merge($this->data, (array) $data); }
    
    public function __construct(array $data = null) { $this->fromArray($data); }
    
    public function isEmpty() { return !!count($this); }
    public function hasProperty($param) { return isset($this->$param); }
    
    public function fromArray(array $data = null)
    {
      if(!is_null($data)) 
        foreach($data as $key => $value) 
          $this->$key = $value;
      return $this;
    }
    
    public function toArray()
    {
      $data = get_object_vars($this);
      foreach($data as $k1 => &$v1)
        if($v1 instanceof self)
          $data[$k1] = $v1->toArray();
        elseif(is_array($v1))
          foreach($v1 as $k2 => &$v2)
            if($v2 instanceof self)
              $data[$k1][$k2] = $v2->toArray();
      return $data;
    }
    
  # public function __get($param) { return $this->data[$param]; }
  # public function __set($param, $value = null) { $this->data[$param] = $value; }
  
  # public function get($param) { return isset($this->data[$param]) ? $this->data[$param] : null; }
  # public function set($param, $value = null) { $this->data[$param] = $value; }
    
  # @TODO: serialize | unserialize
    
  # @TODO: __toString()
  # @TODO: __toArray()
  # @TODO: __toXML()
  # @TODO: __toJSON()
  }