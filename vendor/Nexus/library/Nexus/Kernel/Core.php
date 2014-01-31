<?php

  namespace Nexus\Kernel;

  class Core
  {
    protected static $application;
    
    public function getApplication()
    {
      return Application::instance();
    }
  }
  