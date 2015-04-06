<?php

/**
 * LoginForm for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class BackendLoginForm extends sfGuardFormSignin {

    public function configure() {
        parent::configure();
        
        $this->widgetSchema['username']->setAttribute("placeholder" ,"Usuario or E-Mail");
        $this->widgetSchema['password']->setAttribute("placeholder" ,"Password");
    
        $this->widgetSchema->addFormFormatter('btsp', new sfWidgetFormSchemaFormatterTwitterBootstrap($this->widgetSchema));
        $this->widgetSchema->setFormFormatterName('btsp');
    }
    

}
