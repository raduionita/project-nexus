<?php

  namespace Nexus\Kernel;
  
  use Nexus\Kernel\Core;
  
  class Application extends Core
  {
    
    protected $intstance;
  
    public static function run(array $config)
    {
      include 'functions.php';
      
      // event manager
      
      // service manager
      
      // set request object
      // set response object
      // set session object
      // set cookie object
    
      return new static($config);
    }
    
    protected function __construct(array $config)
    {
      print_r($config);
      
      die;
    }
    
  }
  