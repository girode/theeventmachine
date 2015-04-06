<?php

/**
 * LoginForm for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class LoginForm extends sfGuardFormSignin {

    public function minimize() {
        $this->widgetSchema->addFormFormatter('mini', new sfWidgetFormSchemaFormatterMiniSignIn($this->widgetSchema));
        $this->widgetSchema->setFormFormatterName('mini');
        
//        $this->getWidgetSchema()->getFormFormatter()->setRowFormat(
//            "%error%%field%%help%%hidden_fields%\n"
//        );
    }
    
    public function normalize() {
        $this->widgetSchema->addFormFormatter('normal', new sfWidgetFormSchemaFormatterTwitterBootstrap($this->widgetSchema));
        $this->widgetSchema->setFormFormatterName('normal');
        
//        $this->getWidgetSchema()->getFormFormatter()->setRowFormat(
//            "%error%%field%%help%%hidden_fields%\n"
//        );
    }
    
    
    public function configure() {
        parent::configure();
        
        $this->widgetSchema['username']->setAttribute("placeholder" ,"Username or E-Mail");
        $this->widgetSchema['password']->setAttribute("placeholder" ,"Password");     
        
        $this->normalize();
        
    }
    

}
