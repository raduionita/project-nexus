<?php

  ini_set("zlib.output_compression", 'on');
  
  // relative to this folder
  chdir(dirname(__DIR__));

  // Setup autoloading 
  require 'autoloader.php';

  // Run the application!
  Nexus\Kernel\Application::run(require 'config/application.php');
  
  