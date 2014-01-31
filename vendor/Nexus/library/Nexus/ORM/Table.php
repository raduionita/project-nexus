<?php

  namespace Nexus\ORM;

  class Table
  {
    const TYPE_PARENT = 1;
    const TYPE_CHILD  = 2;
    protected $type   = \Table::TYPE_CHILD;
  
    public static $cache = array();
  
    protected $prototype = null;
    
    public $identifiers = array();
    
    protected $table     = '';
    protected $parent    = null;
    protected $columns   = array();
    protected $links     = array();
    protected $structure = array();

    private $_joins  = array();
    private $_where  = array();
    private $_order  = array();
    private $_limit  = array();
    private $_sql    = array('joins' => '', 'where' => '', 'order' => '', 'limit' => '');
  
    public function __construct(\Record $prototype = null)
    {
      # $conn = mysqli_connect('localhost', 'root','', 'nexus'); #
      global $conn;
      # @TODO: replace $conn with DB #
      
      $this->prototype = is_null($prototype) ? new \Record() : $prototype;
      
      $result = mysqli_query($conn, "DESCRIBE `{$this->table}`");
      while($row = mysqli_fetch_assoc($result))
        $this->structure[$row['Field']] = $row;  
      foreach($this->links as $key => $class)
      {
        $this->links[$key] = new $class();
        $this->links[$key]->parent = &$this;
      }
    }
    
    public function __destruct()
    {
      \Table::$cache = null;
    }
    
    # @TODO refeactor to _cycle($table, $identifiers, $callback);
     
    private function _joins(&$table, array $identifiers) 
    {
      if(empty($this->_sql['joins'])) $this->_sql['joins'] = '';
    
      foreach($identifiers as $identifier)
        if(!isset($this->_joins[$table->table]))
        {
          if(!$table->hasField($identifier))
          {
            foreach($table->links as $key => &$object)
              $this->_joins($object, array($identifier));
          }
          else if(/* has field && */ $table !== $this->table && !is_null($table->parent))
          {
            $identifier = $table->parent->getIdentifier();
            $this->_joins[$table->table] = $table->parent->getIdentifier();
            $this->_sql['joins'] .= ' LEFT JOIN `'. $table->table .'` USING(`'. $identifier .'`)';
          }
        }
    }
    
    # @TODO refeactor to _cycle($table, $identifiers, $callback);
    
    private function _where(&$table, array $identifiers)  
    {
      foreach($identifiers as $identifier => $value)
        if(!$table->hasField($identifier))
          foreach($table->links as $key => &$object)
            $this->_where($object, array($identifier => $value));
        else
          $this->_where['`'. $table->table .'`.`'. $identifier .'`'] = $value;
    }

    # @TODO refeactor to _cycle($table, $identifiers, $callback);
    
    private function _order(&$table, array $identifiers)  
    {
      foreach($identifiers as $identifier => $dir)
        if(!$table->hasField($identifier))
          foreach($table->links as $key => &$object)
            $this->_order($object, array($identifier => $dir));
        else
          $this->_order['`'. $table->table .'`.`'. $identifier . '`'] = strtoupper($dir);
    }

    public function where(array $search)
    {
      $this->_joins($this, array_keys($search));
      $this->_where($this, $search);
      
      $where = array();
      foreach($this->_where as $identifier => $value)
        $where[] = $identifier .' = \'' . $value .  '\'';
      $this->_sql['where'] = !empty($where) ? ' WHERE ' . implode(' AND ', $where) : null;
      
      return $this;
    }
    
    public function limit($start = null, $count = null)
    {
      $limit = '';
      if(!empty($start) && empty($count))
        $limit = 'LIMIT '. ((int) $start);
      elseif(!empty($start) && !empty($count))
        $limit = 'LIMIT '. ((int) $start) .', '. ((int) $count);        
      else
        $limit = '';
      $this->_sql['limit'] = $limit;
      
      return $this;
    }
    
    public function columns(array $columns)
    {
      $this->columns = (array) $columns;
      return $this;
    }
    
    public function order(array $order)
    {
      $this->_joins($this, array_keys($order));
      $this->_order($this, $order);
      
      $order = array();
      foreach($this->_order as $field => $dir)
        $order[] = $field .' '. $dir;
      $this->_sql['order'] = !empty($order) ? ' ORDER BY '. implode(', ', $order) : null;

      return $this;
    }

    # @TODO: NOT finished
    
    public function save(array $data)                       
    {
      # @TODO: should I use transactions? #
      global $conn;

      $array = array();    
      foreach($data as $field => $value)
        if($this->hasField($field))
          $array[$field] = $value;
      
      # @TODO: finish insert/update....
      
      $identifier = $this->getIdentifier();
      if(isset($array[$identifier]))   // update
      {
        $where = array($identifier => $array[$identifier]);
        unset($array[$identifier]);
        echo 'UPDATE '. $this->table .' SET ... WHERE '. $identifier .' => '. $where[$identifier] ." \n";
      }
      else                             // insert
      {
        echo 'INSERT INTO '. $this->table .' VALUES (...) '."\n";
      }
      print_r($array);
      
        
      foreach($data as $field => $value)
        foreach($this->links as $key => $table)
          if($key === $field && is_array($value) && (is_null($table->parent) || $table->type !== \Table::TYPE_PARENT))
            foreach($value as $i => $d)
              $table->save($d);
      
      return true;
    }
    
    public function count()
    {
      global $conn;

      $table      = $this->table;
      $identifier = $this->getIdentifier();
      $sql        = 'SELECT COUNT(`'.$table.'`.`'. $identifier .'`) AS count FROM `'. $table .'` ' . $this->_sql['joins'] .' '. $this->_sql['where'] .' '. $this->_sql['order'] .' '. $this->_sql['limit'];
      
      $result = mysqli_query($conn, $sql);
      $row    = mysqli_fetch_assoc($result);
      return isset($row['count']) ? $row['count'] : 0;
    }
    
    public function get()
    {
      global $conn;
      
      $table      = $this->table;
      $identifier = $this->getIdentifier();
      $sql        = 'SELECT `'. $table .'`.`'.$identifier.'` FROM `'. $table .'` '. $this->_sql['joins'] .' '. $this->_sql['where'] .' GROUP BY `'. $table .'`.`'. $identifier .'` '. $this->_sql['order'] .' '. $this->_sql['limit'];
      
      $rows = array();
      $result = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_assoc($result))
        $rows[] = $row;
      
      $records = array();
      foreach($rows as $i => $row)
      {
        $result = &$this->_get($row);
        if(is_array($result))
          $records = array_merge($records, $result);
        else
          $records[] = $result;
      }
      
      return $records;
    }

    public function &_get(array $identifiers)
    {
      global $conn;
    
      if(empty($this->columns))
        foreach($this->structure as $i => $row)
          $this->columns[] = $row['Field'];

      $where = array();
      $table = $this->table;
      foreach($identifiers as $identifier => $value)
        if($value !== null && $this->hasField($identifier))
          $where[] = '`'.$table.'`.`'.$identifier.'` = '. $value;
      
      $sql = 'SELECT `'.$table.'`.`'. implode('`, `'.$table.'`.`', $this->columns) .'` FROM `'. $table .'` WHERE '. implode(' AND ', $where);
      
      $cachekey = md5($sql);

      if(!empty(self::$cache[$cachekey]))
        return self::$cache[$cachekey];
        
      // echo $sql;
      // echo "\n";
      
      self::$cache[$cachekey] = array();
      $records = &self::$cache[$cachekey];

      $result = mysqli_query($conn, $sql);
      while($row =  mysqli_fetch_assoc($result))
      {
        $record = clone $this->prototype;
        $record->fromArray($row);

        foreach($this->links as $key => $table)
        { 
          foreach($row as $field => $value)
            if($table->hasIdentifier($field))
              $identifiers[$field] = $value;
          
          $record->$key = &$table->_get($identifiers);
        }
        
        $records[] = $record;
      }
      
      if((!is_null($this->parent) && $this->type === \Table::TYPE_PARENT) || (is_null($this->parent)))  # called by a child
        return $records[0];
      
      return $records;
    }
    
    public function fetch()
    {
      static $i = 0;
      if(!empty($this->identifiers[$i]))
        return $this->_get($this->identifiers[$i++]);
      return null;
    }
    
    public function execute()
    {
      global $conn;
      
      $table      = $this->table;
      $identifier = $this->getIdentifier();
      $sql        = 'SELECT `'. $table .'`.`'. $identifier .'` FROM `'. $table .'` '. $this->_sql['joins'] .' '. $this->_sql['where'] .' GROUP BY `'. $table .'`.`'. $identifier .'` '. $this->_sql['order'] .' '. $this->_sql['limit'];

      $result = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_assoc($result))
        $this->identifiers[] = $row;

      return $this;
    }
    
    public function getIdentifier()
    {
      static $identifier = null;
      
      if($identifier === null)
        foreach($this->structure as $i => $row)
          if($row['Key'] === 'PRI')
            $identifier = $row['Field'];
      return $identifier;
    }
    
    public function hasIdentifier($identifier)
    {
      foreach($this->structure as $i => $row)
        if($row['Field'] === $identifier && $row['Key'] === 'PRI')
          return true;
      return false;
    }
   
    public function hasField($field)
    {
      foreach($this->structure as $i => $row)
        if($field === $row['Field'])
          return true;
      return false;
    }
  }