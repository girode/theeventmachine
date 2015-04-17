<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins(array(
        'sfDoctrinePlugin',
        'sfDoctrineGuardPlugin'
    ));
    
  }
  
  public function configureDoctrine(Doctrine_Manager $manager)
  {
    $manager->registerHydrator('json_event_object', 'JSONEventObjectHydrator');
  }
  
}
