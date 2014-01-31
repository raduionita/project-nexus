<?php

/**
 * This autoloading setup is really more complicated than it needs to be for most
 * applications. The added complexity is simply to reduce the time it takes for
 * new developers to be productive with a fresh skeleton. It allows autoloading
 * to be correctly configured, regardless of the installation method and keeps
 * the use of composer completely optional. This setup should work fine for
 * most users, however, feel free to configure autoloading however you'd like.
 */

  // Composer autoloading
  $loader = include 'vendor/autoload.php';
  
  $loader->add('Zend', 'vendor/ZF2/library') // || getenv('ZF2_PATH') || get_cfg_var('zf2_path')
         ->add('Nexus', 'vendor/Nexus/library');