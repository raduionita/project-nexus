<?php
  
  namespace Main\Table;
  
  use Nexus\ORM\Table as Table;
  
  class Lang extends Table
  {
    public $type  = Table::TYPE_PARENT;
    public $table = 'lang';
  }